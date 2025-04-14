<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'product_attributes';

    protected $fillable = ['name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

}
