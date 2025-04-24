<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariantValue;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Tag;
use App\Models\CategoryProduct;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->with(['variants', 'galleries' , 'primaryCategory' , 'brand'])->get();
        return response()->json($products);
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


    public function uploadTinyFile(Request $request)
    {
        // اعتبارسنجی فایل
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048'
        ]);

        // ذخیره فایل
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('tiny', $filename, 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
        ], 201);
    }

    public function getCategories(Request $request) {
        return response()->json(
            Category::orderBy('id' , 'DESC')->get(),
            Response::HTTP_OK);
    }

    public function getBrands(Request $request) {
        return response()->json(
            Brand::orderBy('id' , 'DESC')->get(),
            Response::HTTP_OK);
    }

    public function getTags(Request $request) {
        return response()->json(
            Tag::orderBy('id' , 'DESC')->get(),
            Response::HTTP_OK);
    }

    public function saveCategory(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category = Category::create([
            "category_id" => count(Category::all()) + 1,
            "title" => $request->title,
            "parent_id" => "0",
            "meta_title" => null,
            "meta_description" => null,
            "is_published" => true,
            "slug" => Str::slug($request->title),
            "cat_image" => null,
            "cat_icon" => null,
            "header_image" =>  null,
        ]);

        return response()->json([
            'message' => 'دسته بندی با موفقیت ذخیره شد.',
            'category' => $category
        ], Response::HTTP_CREATED); 
    }


    public function saveBrand(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $brand = Brand::create([
            "title" => $request->title,
            'brand_id' => count(Brand::all()) + 1,
            'short_name' => null,
            'image' => null,
        ]);

        return response()->json([
            'message' => 'برند با موفقیت ذخیره شد.',
            'brand' => $brand
        ], Response::HTTP_CREATED); 
    }

    public function saveTag(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $tag = Tag::create([
            "title" => $request->title,
            "slug" => Str::slug($request->title),
        ]);

        return response()->json([
            'message' => 'برچسب با موفقیت ذخیره شد.',
            'tag' => $tag
        ], Response::HTTP_CREATED); 
    }

    public function store(Request $request) {


        $request->validate([
            'primary_category_id' => 'required|exists:categories,_id',
        ], [
            'primary_category_id.required' => 'شناسه دسته‌بندی اصلی الزامی است.',
            'primary_category_id.exists' => 'شناسه دسته‌بندی اصلی معتبر نیست.',
        ]);

        $requestData = $request->all();

        $product = Product::create([
            'fa_title' => $requestData['fa_title'],
            'fa_slug' => $requestData['fa_slug'],
            'en_title' => $requestData['en_title'],
            'en_slug' => $requestData['en_slug'],
            'stock' => $requestData['stock'],
            'is_draft' => $requestData['is_draft'],
            'stock_status' => $requestData['stock_status'],
            'minimum_order_q' => $requestData['minimum_order_q'],
            'maximum_order_q' => $requestData['maximum_order_q'],
            'is_spacial_offer' => $requestData['is_spacial_offer'],
            'spacial_offer_date' => $requestData['spacial_offer_date'],
            'has_variantion' => $requestData['has_variantion'],
            'default_variation_id' => $requestData['default_variation_id'],
            'is_active' => $requestData['is_active'],
            'price_before_offer' => $requestData['price_before_offer'],
            'price' => $requestData['price'],
            'review' => $requestData['review'],
            'description' => $requestData['description'],
            'seo_title' => $requestData['seo_title'],
            'seo_description' => $requestData['seo_description'],
            'primary_category_id' => $requestData['primary_category_id'],
            'sku_number' => $requestData['sku_number'],
            'guarantee' => $requestData['guarantee'],
            'brand_id' => $requestData['brand_id'],
        ]);

        if (!empty($requestData['other_category_ids'])) {
            foreach(json_decode($requestData['other_category_ids'] , true) as $key => $value) {
                CategoryProduct::firstOrCreate([
                    'category_id' => $value,
                    'product_id' => $product->id
                ]);
            }
        }

        if (!empty($requestData['tags'])) {
            foreach(json_decode($requestData['tags'] , true) as $key => $value) {
                ProductTag::firstOrCreate([
                    'tag_id' => $value,
                    'product_id' => $product->id
                ]);
            }
        }

        if (!empty($requestData['galleries'])) {

          
            $mainGalleryIndex = collect($requestData['galleries'])->search(function ($item) {
                return !empty($item['isMain']) && $item['isMain'] == 'true';
            });

           
            if ($mainGalleryIndex === false) {
                $mainGalleryIndex = 0;
            }


            foreach ($requestData['galleries'] as $index => $gallery) {
                $filePath = null;
                if (!empty($gallery['file'])) {
                    $filePath = $gallery['file']->store('public/galleries');
                }

                $product->galleries()->create([
                    'product_id' => $product->id,
                    'file' => $filePath ?? 'null',
                    'alt' => $gallery['alt'],
                    'is_main' => $index === $mainGalleryIndex ? 'yes' : 'no',
                ]);
            }
        }

        if (!empty($requestData['specifications'])) {
            foreach (json_decode($requestData['specifications'], true) as $specification) {
                $product->specifications()->create([
                    'product_id' => $product->id,
                    'title' => $specification['feature'],
                    'value' => $specification['value'],
                ]);
            }
        }

        if (!empty($requestData['attributes'])) {
            foreach (json_decode($requestData['attributes'], true) as $attributeData) {
            $findAttrByName = Attribute::where('name', $attributeData['feature'])->first();
                if ($findAttrByName instanceof Attribute) {
                    $attribute = ProductAttribute::firstOrCreate([
                    'attribute_id' => $findAttrByName->id,
                    'product_id' => $product->id,
                    ]);
                    foreach ($attributeData['values'] as $value) {
                        ProductAttributeValue::firstOrCreate([
                            'product_attribute_id' => $attribute->id,
                            'value' => $value
                        ]);
                    }
                }
            }
        }


        if (!empty($requestData['variants'])) {
            foreach ($requestData['variants'] as $index => $variantData) {
                $imagePath = null;
                
                if ($variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $variantData['image']->store('public/variants');
                }

                $isDefaultIndex = collect($requestData['variants'])->search(function ($item) {
                    return !empty($item['is_default']) && $item['is_default'] == 'true';
                });
    
               
                if ($isDefaultIndex === false) {
                    $isDefaultIndex = 0;
                }

                $variant = $product->variants()->create([
                    'product_id' => $product->id,
                    'height' => $variantData['height'] ?? null,
                    'image' => $imagePath ? $imagePath : 'null',
                    'is_default' => $index === $isDefaultIndex ? 'yes' : 'no',
                    'length' => $variantData['length'] ?? null,
                    'preparation_time' => $variantData['preparation_time'] ?? 0,
                    'price' => $variantData['price'] ?? 0,
                    'price_before_discount' => $variantData['price_before_discount'] ?? 0,
                    'sku' => $variantData['sku'] ?? null,
                    'sku_number' => $variantData['sku_number'] ?? null,
                    'stock' => $variantData['stock'] ?? 0,
                    'weight' => $variantData['weight'] ?? 0,
                    'width' => $variantData['width'] ?? null,
                ]);


                if (!empty($variantData['properties'])) {
                    foreach (json_decode($variantData['properties']) as $key => $value) {
                        $attribute = Attribute::where('name', $key)->first();
                        if ($attribute) {
                            ProductVariantValue::create([
                                'product_variant_id' => $variant->id,
                                'product_attribute_id' => $attribute->id
                            ]);
                        }
                    }
                }
            }
        }

        return response()->json([
            'message' => 'محصول به پیش‌نویس منتقل شد.'
        ], Response::HTTP_CREATED);
    }


}
