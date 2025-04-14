<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Variation;

class VariationSeeder extends Seeder
{
    public function run()
    {
        $product = Product::first();

        $variations = [
            [
                'attributes' => ['color' => 'red', 'size' => 'M'],
                'price' => 199000,
                'price_before_discount' => 249000,
                'stock' => 10,
                'weight' => 250,
                'sku' => 'TSH-RED-M',
                'image' => 'https://example.com/images/tshirt-red-m.jpg',
            ],
            [
                'attributes' => ['color' => 'blue', 'size' => 'L'],
                'price' => 199000,
                'price_before_discount' => null,
                'stock' => 5,
                'weight' => 250,
                'sku' => 'TSH-BLU-L',
                'image' => 'https://example.com/images/tshirt-blue-l.jpg',
            ]
        ];

        foreach ($variations as $var) {
            $var['product_id'] = $product->_id;
            Variation::create($var);
        }

        // تنظیم یکی از تنوع‌ها به عنوان پیش‌فرض
        $product->update(['default_variation_id' => Variation::first()->_id]);
    }
}
