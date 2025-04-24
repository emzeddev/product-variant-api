<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Gallery extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'galleries';

    protected $fillable = ['product_id', 'file', 'is_main', 'alt'];

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }
}
