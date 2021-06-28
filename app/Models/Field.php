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
        'field_number',
        'is_open'
    ];
    protected $guarded = [
        'contains'
    ];
    protected $attributes = [
        'contains' => 0,
        'is_open' => false
    ];

    /** return the game that this field is connected to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Vinelab\NeoEloquent\Eloquent\Relations\BelongsTo
     */
    public function game() {
        return $this->belongsTo(Game::class,'BELONGS_TO');
    }

    /** returns all sibling fields of this field
     *
     * @return \Vinelab\NeoEloquent\Eloquent\Relations\HasMany
     */
    public function neighbors()
    {
        return $this->hasMany(Field::class, 'NEIGHBORS');
    }
}
