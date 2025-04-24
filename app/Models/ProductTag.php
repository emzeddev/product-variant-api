<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tag';
    protected $fillable = ['tag_id', 'product_id'];
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $hidden = ['created_at', 'updated_at'];
}
