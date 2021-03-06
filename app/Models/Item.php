<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Vinelab\NeoEloquent\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $label = 'Item';
    protected $fillable = [
        'name',
        'price',
        'description',
        'image'
    ];
    // saves price as an integer in database
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = intval($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'BELONGS_TO');
    }
}
