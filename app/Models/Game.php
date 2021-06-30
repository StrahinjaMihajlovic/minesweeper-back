<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Vinelab\NeoEloquent\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $label = 'Game';

    protected $fillable = [
        'size_x',
        'size_y'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',

    ];
    /** returns the relationship with the users that have played this game
     *
     * @return \Vinelab\NeoEloquent\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany(User::class,'PLAYER');
    }

    public function fields()
    {
        return $this->hasMany(Field::class, 'BELONGS_TO');
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'OWNER');
    }
}
