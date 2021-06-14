<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
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

    public function Category()
    {
        return $this->belongsTo('Category', 'BELONGS_TO');
    }
}
