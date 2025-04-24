<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'category_product';
    protected $fillable = ['category_id', 'product_id'];
    public $timestamps = false;
}
