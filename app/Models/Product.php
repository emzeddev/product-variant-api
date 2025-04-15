<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'title',
        'description',
        'default_variation_id'
    ];



    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function defaultVariation()
    {
        return $this->belongsTo(ProductVariant::class, 'default_variation_id');
    }
}
