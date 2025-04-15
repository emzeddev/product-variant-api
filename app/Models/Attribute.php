<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Attribute extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'attributes';
    protected $fillable = ['name'];
}
