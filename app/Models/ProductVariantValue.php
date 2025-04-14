<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class ProductVariantValue extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'product_variant_values';

    protected $fillable = ['variant_id', 'attribute_id', 'value_id'];

    public function variant()
    {
        return $this->belongsTo(Variation::class, 'variant_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Variation::class, 'attribute_id');
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'value_id');
    }
}
