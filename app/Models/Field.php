<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Vinelab\NeoEloquent\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $label = 'Field';
    protected $fillable = [
        'fieldNumber',
        'is_open'
    ];
    protected $guarded = [
        'contains'
    ];
    protected $attributes = [
        'contains' => 0
    ];

    /** return the game that this field is connected to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo
     */
    public function game() {
        return $this->belongsTo(Game::class,'PLAYER');
    }

    /** returns all sibling fields of this field
     *
     * @return \Vinelab\NeoEloquent\Eloquent\Relations\HasMany
     */
    public function neighbors()
    {
        return $this->hasMany(Field::class, 'NEIGHBORS');
    }

    //sets this field with a bomb if the generator returns true and notifies siblings
    public function hasBomb($generator)
    {
        if($generator) {
            $this->contains = 'bomb';
            $this->save();
            $this->notifyNeighbors();
        }
    }


    // notifies all the neigbors of this field that this field has a bomb
    protected function notifyNeighbors()
    {
        $siblings = $this->neighbors()->get();
        $siblings->each(function($sibling) {
            /* @var $sibling Field */
            $sibling->neighborHasBomb();
        });
    }

    /* TODO make the exception handling mechanism when the bomb update fails*/
    // increment the contains attribute if the neighbor alerts the bomb presence
    protected function neighborHasBomb()
    {
        if(is_int($this->contains)){
            $this->contains++;
            $this->save();
        }
    }

}
