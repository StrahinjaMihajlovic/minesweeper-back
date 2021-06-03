<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Vinelab\NeoEloquent\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'name';
    public $incrementing = false;

    protected $label = 'Category';
    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany('Item', 'BELONGS_TO');
    }
}
