<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    // لیست کردن محصولات
    public function index()
    {
        $products = Product::query()->with(['variants', 'galleries', 'attributes'])->get();
        return response()->json($products);
    }

    // ذخیره محصول به همراه تنوع‌ها، ویژگی‌ها و مقادیر ویژگی‌ها
    public function store(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'fa_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'stock_status' => 'required|boolean',
            'minimum_order_q' => 'required|integer',
            'maximum_order_q' => 'required|integer',
            'is_spacial_offer' => 'required|boolean',
            'spacial_offer_date' => 'required|date',
            'attributes' => 'nullable|array', // ویژگی‌های ارسالی
            'variants' => 'nullable|array', // تنوع‌ها
            'galleries' => 'nullable|array', // تصاویر گالری
        ]);

        // ذخیره محصول
        $product = Product::create([
            'fa_title' => $request->fa_title,
            'en_title' => $request->en_title,
            'stock_status' => $request->stock_status,
            'minimum_order_q' => $request->minimum_order_q,
            'maximum_order_q' => $request->maximum_order_q,
            'is_spacial_offer' => $request->is_spacial_offer,
            'spacial_offer_date' => $request->spacial_offer_date,
            'review' => $request->review,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
        ]);

        // ذخیره مشخصات
        if($request->has('specifications') && count($request->specifications) > 0) {
            foreach ($request->specifications as $specification) {
                $product->specifications()->create([
                    'title' => $specification['title'],
                    'value' => $specification['value'],
                ]);
            }
        }


        // ذخیره ویژگی‌ها و مقادیر ویژگی‌ها
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeData) {
                // ذخیره ProductAttribute
                $attribute = ProductAttribute::firstOrCreate([
                    'name' => $attributeData['name']
                ]);

                // ذخیره مقادیر ویژگی (ProductAttributeValue)
                foreach ($attributeData['values'] as $value) {
                    ProductAttributeValue::firstOrCreate([
                        'product_attribute_id' => $attribute->id,
                        'value' => $value
                    ]);
                }
            }
        }


        // ذخیره تنوع‌ها
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                // ایجاد ProductVariant
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'image' => $variantData['image'] ? $this->uploadImage($variantData['image']) : null, // ذخیره تصویر
                    // سایر فیلدهای مربوط به ProductVariant
                ]);

                // ذخیره ProductVariantValue برای هر تنوع
                if (isset($variantData['values'])) {
                    foreach ($variantData['values'] as $attribute_id => $value_id) {
                        ProductVariantValue::create([
                            'product_variant_id' => $variant->id,
                            'product_attribute_id' => $attribute_id,
                            'product_attribute_value_id' => $value_id,
                        ]);
                    }
                }
            }
        }

        // ذخیره تصاویر گالری
        if ($request->has('galleries')) {
            foreach ($request->galleries as $image) {
                Gallery::create([
                    'product_id' => $product->id,
                    'image' => $this->uploadImage($image), // ذخیره تصویر گالری
                ]);
            }
        }

        return response()->json(['message' => 'محصول با موفقیت اضافه شد.'], 201);
    }

    // بروزرسانی محصول
    public function update(Request $request, $id)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'fa_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'stock_status' => 'required|boolean',
            'minimum_order_q' => 'required|integer',
            'maximum_order_q' => 'required|integer',
            'attributes' => 'nullable|array', // ویژگی‌های ارسالی
            'variants' => 'nullable|array', // تنوع‌ها
            'galleries' => 'nullable|array', // تصاویر گالری
        ]);

        // پیدا کردن محصول
        $product = Product::findOrFail($id);

        // بروزرسانی محصول
        $product->update([
            'fa_title' => $request->fa_title,
            'en_title' => $request->en_title,
            'stock_status' => $request->stock_status,
            'minimum_order_q' => $request->minimum_order_q,
            'maximum_order_q' => $request->maximum_order_q,
            'is_spacial_offer' => $request->is_spacial_offer,
            'spacial_offer_date' => $request->spacial_offer_date,
            'review' => $request->review,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
        ]);

        // بروزرسانی ویژگی‌ها
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeData) {
                // ذخیره یا بروزرسانی ProductAttribute
                $attribute = ProductAttribute::updateOrCreate(
                    ['name' => $attributeData['name']]
                );

                // ذخیره یا بروزرسانی مقادیر ویژگی (ProductAttributeValue)
                foreach ($attributeData['values'] as $value) {
                    ProductAttributeValue::updateOrCreate(
                        [
                            'product_attribute_id' => $attribute->id,
                            'value' => $value
                        ]
                    );
                }
            }
        }

        // بروزرسانی تنوع‌ها
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                // پیدا کردن یا ایجاد ProductVariant
                $variant = ProductVariant::updateOrCreate(
                    ['product_id' => $product->id, 'id' => $variantData['id'] ?? null],
                    ['image' => $variantData['image'] ? $this->uploadImage($variantData['image']) : null] // ذخیره تصویر
                );

                // ذخیره یا بروزرسانی ProductVariantValue برای هر تنوع
                if (isset($variantData['values'])) {
                    foreach ($variantData['values'] as $attribute_id => $value_id) {
                        ProductVariantValue::updateOrCreate([
                            'product_variant_id' => $variant->id,
                            'product_attribute_id' => $attribute_id
                        ], ['product_attribute_value_id' => $value_id]);
                    }
                }
            }
        }

        // بروزرسانی تصاویر گالری
        if ($request->has('galleries')) {
            foreach ($request->galleries as $image) {
                Gallery::create([
                    'product_id' => $product->id,
                    'image' => $this->uploadImage($image),
                ]);
            }
        }

        return response()->json(['message' => 'محصول با موفقیت بروزرسانی شد.']);
    }

    // حذف محصول
    public function destroy($id)
    {
        // پیدا کردن محصول
        $product = Product::findOrFail($id);

        // حذف گالری‌ها
        $product->galleries()->delete();

        // حذف ویژگی‌ها و مقادیر آن‌ها
        $product->variants()->each(function ($variant) {
            $variant->values()->delete();
            $variant->delete();
        });

        // حذف خود محصول
        $product->delete();

        return response()->json(['message' => 'محصول با موفقیت حذف شد.']);
    }

    // متد برای آپلود تصویر
    private function uploadImage($image)
    {
        // ذخیره تصویر در دایرکتوری public/images
        $path = $image->store('public/images');
        return Storage::url($path); // بازگرداندن آدرس تصویر
    }


    public function getAttributes(Request $request) {
        return response()->json(
            Attribute::orderBy('id' , 'DESC')->get(),
            Response::HTTP_OK);
    }

    public function saveAttribute(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute = Attribute::create([
            'name' => $request->name,
        ]);


        return response()->json([
            'message' => 'ویژگی با موفقیت ذخیره شد.'
        ], Response::HTTP_CREATED);
    }
}
