<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ImageValues;
use Cart;
use App\Models\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CartsController extends Controller
{
    public function index()
    {
        $aryProduct = [];
        $cartItems = Cart::content();
        foreach ($cartItems as $key => $value) {
            $primaryImage = ImageValues::where('related_id', $value->id)
                                        ->where('is_primary', config('handle.primary_image.primary'))
                                        ->where('image_type', config('handle.image_type.product'))
                                        ->first();
            $value->image = $primaryImage->name;
            $aryProduct[] = $value;
        }

        return view('client.cart.cart', compact('cartItems', 'aryProduct'));
    }

    public function addProduct(Request $request)
    {
        Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'weight' => $request->weight,
            'option' => $request->option,
        ]);

        return response()->json(200);
    }

    public function qtyChange(Request $request){
        $qtyProduct = $request->qty;
        Cart::update($request->rowId, (int)$qtyProduct);
        $total = Cart::total();
        $count = Cart::count();
        return response()
        ->json([
            'qty' => $qtyProduct,
            'total' => $total, 
            'count' => $count,
        ], 200);
    }

    public function deleteItem(Request $request) {
        Cart::remove($request->rowId);

        $total = Cart::total();
        $count = Cart::count();
        return response()
        ->json([
            'rowId' => $request->rowId,
            'total' => $total, 
            'count' => $count,
        ], 200);
    }
}
