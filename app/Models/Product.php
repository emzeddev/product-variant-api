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
        'attributes',
        'default_variation_id'
    ];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function defaultVariation()
    {
        return $this->belongsTo(Variation::class, 'default_variation_id');
    }
}
