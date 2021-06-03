<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Vinelab\NeoEloquent\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'name';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $label = 'Item';
    protected $fillable = [
        'name',
        'price'
    ];

    public function Category()
    {
        return $this->belongsTo('Category', 'BELONGS_TO');
    }
}
