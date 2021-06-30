<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Vinelab\NeoEloquent\Eloquent\Model;
use Vinelab\NeoEloquent\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $label = 'Field';
    protected $fillable = [
        'field_number',
    ];
    protected $guarded = [
        'contains'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'id'
    ];
    protected $attributes = [
        'contains' => 0,
    ];

    /** return the game that this field is connected to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class,'BELONGS_TO');
    }

    /** returns all sibling fields of this field
     * @return HasMany
     */
    public function neighbors()
    {
        return $this->hasMany(Field::class, 'NEIGHBORS');
    }

    /** Workaround when we need unidirectional relationship in neo4j
     * @return \Illuminate\Support\Collection
     */
    public function neighborsUniDirectional()
    {
        return $this->hasMany(Field::class, 'NEIGHBORS')->get()
            ->merge($this->belongsToMany(Field::class, 'NEIGHBORS')->get());
    }

    public function usersOpened()
    {
        return $this->belongsToMany(User::class, 'PLAYER_OPENED');
    }


}
