<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Attribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;


class ProductVarientValueSeeder extends Seeder
{
    public function run(): void
    {
        // ویژگی‌ها
        $color = Attribute::where('name', 'رنگ')->first();
        $size = Attribute::where('name', 'سایز')->first();

        // مقادیر ویژگی‌ها
        $red = ProductAttributeValue::where('value', 'قرمز')->where('product_attribute_id', $color->id)->first();
        $blue = ProductAttributeValue::where('value', 'آبی')->where('product_attribute_id', $color->id)->first();
        $green = ProductAttributeValue::where('value', 'سبز')->where('product_attribute_id', $color->id)->first();

        $small = ProductAttributeValue::where('value', 'S')->where('product_attribute_id', $size->id)->first();
        $medium = ProductAttributeValue::where('value', 'M')->where('product_attribute_id', $size->id)->first();
        $large = ProductAttributeValue::where('value', 'L')->where('product_attribute_id', $size->id)->first();

        // تنوع‌ها
        $variant1 = ProductVariant::where('sku', 'TSHIRT-RED-M')->first();
        $variant2 = ProductVariant::where('sku', 'TSHIRT-BLUE-L')->first();
        $variant3 = ProductVariant::where('sku', 'TSHIRT-GREEN-S')->first();

        // اتصال ویژگی‌ها به تنوع‌ها
        ProductVariantValue::create([
            'product_variant_id' => $variant1->id,
            'product_attribute_id' => $color->id,
            'product_attribute_value_id' => $red->id,
        ]);

        ProductVariantValue::create([
            'product_variant_id' => $variant1->id,
            'product_attribute_id' => $size->id,
            'product_attribute_value_id' => $medium->id,
        ]);

        ProductVariantValue::create([
            'product_variant_id' => $variant2->id,
            'product_attribute_id' => $color->id,
            'product_attribute_value_id' => $blue->id,
        ]);

        ProductVariantValue::create([
            'product_variant_id' => $variant2->id,
            'product_attribute_id' => $size->id,
            'product_attribute_value_id' => $large->id,
        ]);

        ProductVariantValue::create([
            'product_variant_id' => $variant3->id,
            'product_attribute_id' => $color->id,
            'product_attribute_value_id' => $green->id,
        ]);

        ProductVariantValue::create([
            'product_variant_id' => $variant3->id,
            'product_attribute_id' => $size->id,
            'product_attribute_value_id' => $small->id,
        ]);
    }
}
