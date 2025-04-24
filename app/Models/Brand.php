<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Brand extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'brands';

    protected $fillable = [
        'brand_id',
        'title',
        'short_name',
        'image',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
