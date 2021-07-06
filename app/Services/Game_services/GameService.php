<?php


namespace App\Services\Game_services;


use App\Game\Generators\BoolGenerator;
use App\Models\Field;
use App\Models\Game;
use Ramsey\Collection\Collection;

class GameService
{
    protected $game;
    protected $bombLogic;

    public function __construct(BombLogic $bombLogic)
    {
        $this->bombLogic = $bombLogic;
    }

    public function setGame(Game $game)
    {
        $this->game = $game;
    }

    /**Marks that the player played this game if not already
     *
     */
    public function markThePlayer()
    {
        if(!auth()->user()->hasPlayedTheGame($this->game)){
            auth()->user()->gamesPlayed()->save($this->game);
        }
    }

    /** Marks field as open
     * @param Field $field
     */
    public function openField(Field $field)
    {
        if(!auth()->user()->didPlayerOpenTheField($field)){
            return auth()->user()->fieldsOpened()->save($field);
        }
        return false;
    }

    /**Generates random fields with given table size
     * @param int $sizeX
     * @param int $sizeY
     *
     */
    public function generateGame($sizeX, $sizeY, $bombs = [])
    {
        $this->game = Game::create([
            'size_x' => $sizeX,
            'size_y' => $sizeY
        ]);

        $rows = collect();
        for($i = 0; $i < $sizeY; $i++) {
            $row = $this->generateRows($sizeX, $i + 1);
            $rows->push($row);
            if($i > 0){
                $row->each(function($field, $key) use($rows, $i, $sizeX) {
                    $rowBefore = $rows->get($i - 1);
                    $field->neighbors()->save($rowBefore->get($key));
                    $this->associateDiagonalRows($field, $rowBefore, $sizeX, $key);
                });
            }

        }
        $this->bombLogic->setGenerator(new BoolGenerator());
        $this->bombLogic->setFields($rows->collapse());
        $this->bombLogic->setBombs($bombs);
        return $rows;
    }

    /** Builds the relationship with diagonal neighbours of the field
     * @param Field $field
     * @param Collection $rowBefore
     * @param int $sizeX
     * @param int $currPos
     */
    protected function associateDiagonalRows(&$field, &$rowBefore, $sizeX, $currPos)
    {
        if($currPos !== 0) {
            $left = $rowBefore[$currPos - 1];
            $field->neighbors()->save($left);
        }
        if($currPos !== ($sizeX - 1)) {
            $right = $rowBefore[$currPos + 1];
            $field->neighbors()->save($right);
        }

    }

    /** collects the fields into rows
     * @param $sizeX
     * @param $y
     * @return \Illuminate\Support\Collection
     */
    protected function generateRows($sizeX, $y)
    {
        $fields = collect();
        for($i = 0; $i < $sizeX; $i++) {
            $field = Field::create(['field_number_display' => $y . ($i + 1), 'field_number' => ($y * 10) + $i + 1]);
            $fields->push($field);
            $this->game->fields()->save($field);
            if($i !== 0) {
                $field->neighbors()->save($fields->get($i - 1));
            }
        }
        return $fields;
    }
}
