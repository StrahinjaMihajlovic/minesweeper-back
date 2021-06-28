<?php


namespace App\Services\Game_services;


use App\Models\Field;

class BombLogic
{
    /**
     * @var $field Field
     */
    public $field;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    //sets this field with a bomb if the generator returns true and notifies siblings
    public function hasBomb($generator)
    {
        if($generator) {
            $this->field->contains = 'bomb';
            $this->field->save();
            $this->notifyNeighbors();
        }
    }


    // notifies all the neighbors of this field that this field has a bomb
    protected function notifyNeighbors()
    {
        $neighbors = $this->field->neighbors()->get();
        $neighbors->each(function($neighbor) {
            $alertNeighbor = new BombLogic($neighbor);
            $alertNeighbor->neighborHasBomb();
        });
    }

    /* TODO make the exception handling mechanism when the bomb update fails*/
    // increment the contains attribute if the neighbor alerts the bomb presence
    protected function neighborHasBomb()
    {
        if(is_int($this->field->contains)){
            $this->field->contains++;
            $this->field->save();
        }
    }

}
