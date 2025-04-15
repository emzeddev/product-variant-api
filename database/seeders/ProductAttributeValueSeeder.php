<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductAttributeValue;

class ProductAttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::first();
        
        $values = [
            'رنگ' => ['قرمز', 'آبی', 'سبز'],
            'سایز' => ['S', 'M', 'L'],
            'جنس' => ['کتان', 'پلی‌استر'],
        ];

        foreach ($values as $attrName => $valArr) {
            $attribute = Attribute::where('name', $attrName)->first();
            foreach ($valArr as $value) {
                ProductAttributeValue::create([
                    'product_attribute_id' => $attribute->id,
                    'value' => $value,
                ]);
            }
        }
    }
}
