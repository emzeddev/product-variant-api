<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttributeValue extends Model
{
    protected $fillable = ['product_attribute_id', 'value'];
    protected $collection = 'product_attribute_values';

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}

