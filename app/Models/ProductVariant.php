<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ProductVariant extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'is_default',
        'image',
        'price',
        'price_before_discount',
        'stock',
        'weight',
        'preparation_time',
        'length',
        'width',
        'height',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->hasMany(ProductVariantValue::class, 'variant_id');
    }
}
