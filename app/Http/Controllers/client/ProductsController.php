<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\AttributeTypes;
use App\Models\AttributeValues;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Variant;
use Dotenv\Parser\Value;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryCategory = Categories::where('status', 1)->limit(config('handle.show_category'))->get();
        $aryProduct = Products::with(['image' => function($q){ $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product')); }])
            ->where('status', config('handle.status.on'))
            ->limit(config('handle.show_product'))
            ->get();
        return view('client.product', compact('aryCategory', 'aryProduct'));
    }
   
    public function detail($slug)
    {
        $product = Products::with(['categories', 'attribute_value', 'image' => function($q){ $q->where('image_type', config('handle.image_type.product')); }])
            ->where('slug', $slug)
            ->firstOrFail();
        $aryType = AttributeTypes::select('id', 'name')->get();

        $aryRelatedProduct = explode(',',$product->related_product_id);
        $relatedProducts = Products::whereIn('id', $aryRelatedProduct)
            ->with(['image' => function($q){ $q->where('image_type', config('handle.image_type.product'))
                                               ->where('is_primary', config('handle.primary_image.primary')); 
                                            }])
            ->get();

        return view('client.productDetail', compact('product', 'relatedProducts', 'aryType'));
    }

    public function getVariant(Request $request)
    {
        $aryVar = [];
        $valueColor = AttributeValues::find($request->color)->variants()->get()->toArray();
        $valueSize = AttributeValues::find($request->size)->variants()->get()->toArray();

        foreach ($valueColor as $key => $variantColor) {
            foreach ($valueSize as $key => $variantSize) {
                if ($variantColor['id'] == $variantSize['id'] && $variantColor['product_id'] == $request->productID) {
                    $aryVar = $variantColor;
                }
            }
        }

        return response()->json($aryVar, 200);
    }
}

    