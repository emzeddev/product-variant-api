<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = ['رنگ', 'سایز', 'جنس'];

        foreach ($attributes as $name) {
            Attribute::create(['name' => $name]);
        }
    }
}

