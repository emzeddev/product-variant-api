<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';
    protected $fillable = [
        "category_id",
        "title",
        "parent_id",
        "meta_title",
        "meta_description",
        "is_published",
        "slug",
        "cat_image",
        "cat_icon",
        "header_image",
    ];

    protected $with = ['childs'];

    public function childs(){
        return $this->hasMany(self::class, 'parent_id' , 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public function primaryProducts()
    {
        return $this->hasMany(Product::class, 'primary_category_id');
    }
}
