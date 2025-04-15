<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ProductVariant extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'product_variants';

    protected $fillable = ['product_id', 'sku', 'price', 'stock', 'weight' , 'image'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->hasMany(ProductVariantValue::class, 'variant_id');
    }
}
