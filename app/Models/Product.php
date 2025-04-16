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
        'stock_status',
        'minimum_order_q',
        'maximum_order_q',
        'is_spacial_offer',
        'spacial_offer_date',
        'is_product_variantion',
        'default_variation_id',
        'is_active',
        'price_before_offer',
        'price',
        'review',
        'description',
        'seo_title',
        'seo_description',
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
}
