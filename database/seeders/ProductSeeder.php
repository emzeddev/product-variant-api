<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'fa_title' => 'تی‌شرت مردانه ورزشی',
            'fa_slug' => Str::slug('تی‌شرت مردانه ورزشی', '-'),
            'en_title' => 'Men\'s Sports T-Shirt',
            'en_slug' => 'mens-sports-tshirt',
            'stock_status' => 'in_stock', // یا مثلاً: 'out_of_stock'
            'minimum_order_q' => 1,
            'maximum_order_q' => 5,
            'is_spacial_offer' => true,
            'spacial_offer_date' => Carbon::now()->addDays(10),
            'review' => 'این تی‌شرت بسیار راحت و مناسب برای فعالیت‌های ورزشی است.',
            'description' => 'تی‌شرتی با طراحی مدرن و پارچه تنفس‌پذیر برای استفاده روزمره و ورزش.',
            'seo_title' => 'خرید تی‌شرت ورزشی مردانه با قیمت مناسب',
            'seo_description' => 'تی‌شرت ورزشی مردانه با کیفیت بالا و قیمت عالی، مناسب ورزشکاران حرفه‌ای و علاقه‌مندان به ورزش.',
        ]);
    }
}

