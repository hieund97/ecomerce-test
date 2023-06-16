<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Slider;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeCategory = Categories::whereIn('id', config('handle.home_category'))
            ->get();

        $arySlider = Slider::with(['image' => function($q){ $q->where('is_primary', config('handle.primary_image.primary'))
            ->where('image_type', config('handle.image_type.slider')); }] )
            ->where('status', config('handle.status.on'))
            ->limit(config('handle.show_slider'))
            ->get();

        $aryCategory = Categories::with(['image' => function($q){ $q->where('is_primary', config('handle.primary_image.primary'))
            ->where('image_type', config('handle.image_type.category')); 
        }] )
            ->where('status', config('handle.status.on'))
            ->limit(config('handle.show_cate_index'))
            ->get()
            ->toArray();

        return view('client.index', compact('arySlider', 'aryCategory', 'homeCategory'));
    }

    public function getProductByCategory(Request $request)
    {
        $aryProduct = Products::with([
            'image' => function($q){ 
                $q->where('is_primary', config('handle.primary_image.primary'))
                ->where('image_type', config('handle.image_type.product')); 
                },
            'categories' 
            ])
            ->whereHas('categories', function($query) use($request) {
                $query->where('categories.id', $request->cateID);
            })
            ->where('status', config('handle.status.on'))
            ->limit(config('handle.show_prod_index'))
            ->get()
            ;
            
        return response()->json($aryProduct, 200);
    }
}
