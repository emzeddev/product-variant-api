<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Tag extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tags';

    protected $fillable = [
        'title',
        'slug',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag');
    }
}
