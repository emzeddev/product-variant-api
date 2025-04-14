<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeValue extends Model
{
    protected $fillable = ['attribute_id', 'value'];
    protected $collection = 'product_attribute_values';

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}

