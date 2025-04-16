<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'galleries';

    protected $fillable = ['product_id', 'image', 'is_main'];
    protected $casts = [
        'is_main' => 'boolean',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }
}
