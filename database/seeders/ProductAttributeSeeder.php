<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductAttribute;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::first();
        $attributes = Attribute::all();

        foreach ($attributes as $attribute) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_id' => $attribute->id,
            ]);
        }
    }
}
