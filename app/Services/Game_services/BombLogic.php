<?php


namespace App\Services\Game_services;


use App\Models\Field;

class BombLogic
{
    /**
     * @var $field Field
     */
    public $fields;
    protected $generator;
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function setGenerator($generator)
    {
        $this->generator = $generator;
    }
    //sets this field with a bomb if the generator returns true and notifies neighbors
    public function setBombs()
    {
        $this->fields->each(function($field) {
            if($this->generator->generate()) {
                $field->contains = 'bomb';
                $field->save();
                $this->notifyNeighbors($field);
            }
        });

    }


    // notifies all the neighbors of this field that this field has a bomb
    protected function notifyNeighbors($field)
    {
        $field->neighborsUniDirectional()->each(function($neighbor) {
            $this->neighborHasBomb($neighbor);
        });
    }

    /* TODO make the exception handling mechanism when the bomb update fails*/
    // increment the contains attribute if the neighbor alerts the bomb presence
    protected function neighborHasBomb($field)
    {
        if(is_int($field->contains)){
            $field->contains++;
            $field->save();
        }
    }

}
