<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVarientSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::first(); // یا Product::find(1) برای محصول خاص

        $varients = [
            [
                'sku' => 'TSHIRT-RED-M',
                'is_default' => true,
                'image' => 'https://source.unsplash.com/300x300/?tshirt,red',
                'price' => 290000,
                'price_before_discount' => 310000,
                'stock' => 25,
                'weight' => 350,
                'preparation_time' => 2,
                'length' => 30,
                'width' => 25,
                'height' => 5,
            ],
            [
                'sku' => 'TSHIRT-BLUE-L',
                'is_default' => false,
                'image' => 'https://source.unsplash.com/300x300/?tshirt,blue',
                'price' => 300000,
                'price_before_discount' => 330000,
                'stock' => 15,
                'weight' => 360,
                'preparation_time' => 3,
                'length' => 32,
                'width' => 26,
                'height' => 6,
            ],
            [
                'sku' => 'TSHIRT-GREEN-S',
                'is_default' => false,
                'image' => 'https://source.unsplash.com/300x300/?tshirt,green',
                'price' => 280000,
                'price_before_discount' => 300000,
                'stock' => 10,
                'weight' => 340,
                'preparation_time' => 1,
                'length' => 29,
                'width' => 24,
                'height' => 4,
            ],
        ];

        foreach ($varients as $varient) {
            ProductVariant::create(array_merge($varient, ['product_id' => $product->id]));
        }
    }
}
