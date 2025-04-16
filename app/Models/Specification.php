<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Specification extends Model
{
    protected $collection = 'specifications';
    protected $connection = 'mongodb';

    protected $fillable = [
        'product_id',
        'title',
        'value',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
