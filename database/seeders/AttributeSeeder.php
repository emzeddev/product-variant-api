<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
            'color' => ['red', 'blue', 'green', 'black'],
            'size' => ['S', 'M', 'L', 'XL', 'XXL']
        ];

        foreach ($attributes as $name => $values) {
            $attribute = Attribute::create(['name' => $name]);

            foreach ($values as $value) {
                AttributeValue::create([
                    'attribute_id' => $attribute->_id,
                    'value' => $value
                ]);
            }
        }
    }
}

