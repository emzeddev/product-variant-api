<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class ProductVariantValue extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'product_variant_values';

    protected $fillable = ['product_variant_id', 'product_attribute_id', 'product_attribute_value_id'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    public function value()
    {
        return $this->belongsTo(ProductAttributeValue::class, 'product_attribute_value_id');
    }
}
