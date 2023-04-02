<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\AttributeTypes;
use App\Models\AttributeValues;
use App\Models\Categories;
use App\Models\Products;
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
        // dd($aryCategory);
        $aryProduct = Products::where('status', 1)->limit(config('handle.show_product'))->get();
        return view('client.product', compact('aryCategory', 'aryProduct'));
    }

    public function detail($slug)
    {
        $product = Products::with(['categories', 'attribute_value'])->where('slug', $slug)->firstOrFail();
        $aryType = AttributeTypes::select('id', 'name')->get();
        // dd($product);
        // $aryRelatedProduct = getRelatedProduct($product);
        $aryRelatedProduct = explode(',',$product->related_product_id);

        $relatedProduct = Products::whereIn('id', $aryRelatedProduct)->get();
        

        // $aryProductDetail = collect();
        // foreach ($aryRelatedProduct as $key => $relatedProduct) {
        //     $aryProductDetail->push(Products::where('id', $relatedProduct)->get());
        //     // $detail = Products::where('id', $relatedProduct)->get();
        //     // $detail->push($detail);
        //     // array_push($aryProductDetail, $detail);
        // }

        return view('client.productDetail', compact('product', 'relatedProduct', 'aryType'));
    }
    
    public function getRelatedProduct($product)
    {

        // return $aryProductDetail;
    }
}

    