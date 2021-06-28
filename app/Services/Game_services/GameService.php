<?php


namespace App\Services\Game_services;


use App\Models\Field;
use App\Models\Game;
use Ramsey\Collection\Collection;

class GameService
{
    protected $game;

    /**Generates random fields with given table size
     * @param int $sizeX
     * @param int $sizeY
     *
     */
    public function generateGame($sizeX, $sizeY)
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
            $field = Field::create(['field_number' => $y . ($i + 1)]);
            $fields->push($field);
            $this->game->fields()->save($field);
            if($i !== 0) {
                $field->neighbors()->save($fields->get($i - 1));
            }
        }
        return $fields;
    }
}
