<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'category_products';
    protected $fillable = ['category_id', 'product_id'];
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = [
        'category_id' => 'integer',
        'product_id' => 'integer',
    ];


}
