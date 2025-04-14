<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'title' => 'Basic T-Shirt',
            'description' => 'A comfortable cotton t-shirt available in multiple colors and sizes.',
            'attributes' => ['color', 'size']
        ]);
    }
}

