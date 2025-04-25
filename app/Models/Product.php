<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'fa_title',
        'fa_slug',
        'en_title',
        'en_slug',
        'stock',
        'stock_status',
        'minimum_order_q',
        'maximum_order_q',
        'is_spacial_offer',
        'spacial_offer_date',
        'has_variantion',
        'default_variation_id',
        'is_active',
        'price_before_offer',
        'price',
        'review',
        'description',
        'seo_title',
        'seo_description',
        'primary_category_id',
        'sku_number',
        'guarantee',
        'brand_id',
        'is_draft',
    ];

    public function specifications() {
        return $this->hasMany(Specification::class);
    }


    public function galleries() {
        return $this->hasMany(Gallery::class);
    }

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

    public function primaryCategory()
    {
        return $this->belongsTo(Category::class, 'primary_category_id');
    }

    public function categories()
    {
        $categoryIds = CategoryProduct::where('product_id', $this->id)
        ->pluck('category_id')
        ->toArray();


        return Category::whereIn('id', $categoryIds)->get();
    }

    public function tags()
    {
        $tagIds = ProductTag::where('product_id', $this->id)
        ->pluck('tag_id')
        ->toArray();


        return Tag::whereIn('id', $tagIds)->get();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
