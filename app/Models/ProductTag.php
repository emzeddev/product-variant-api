<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tag';
    protected $fillable = ['tag_id', 'product_id'];
    public $timestamps = false;
}
