<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\ImageValues;
use Cart;
use App\Models\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    public function qtyChange(Request $request)
    {
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

    public function deleteItem(Request $request)
    {
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

    public function checkDiscount(Request $request)
    {
        $code = Discount::where('code', $request->code)->first();

        if (checkValidDay($code)) {
            $aryProdDiscount = explode(',', $code->related_id);
            $aryCartItem = Cart::content();

            //count number of products have discount (for cash discount)
            $count = 0;
            //total price of products have discount (for percent discount)
            $price = 0;

            foreach ($aryCartItem as $item) {
                foreach ($aryProdDiscount as $prod) {
                    if ($prod == $item->id) {
                        if ($item->qty > 1) {
                            $count = $count + $item->qty;
                            $price = $price + ($item->qty * $item->price);
                        } else {
                            $count++;
                            $price = $price + $item->price;
                        }
                    }
                }
            }

            $total = str_replace(',', '', Cart::total());

            if ($code->type_discount == 0) {
                $discount = $count * $code->value;
                $total = (float)$total - $discount;
                return response()
                    ->json([
                        'discount' => $discount,
                        'total'    => $total,
                    ], 200);
            } else {
                $discount = ($price * $code->value) / 100;
                $total = (float)$total - $discount;
                return response()
                    ->json([
                        'discount' => $discount,
                        'total'    => $total,
                    ], 200);
            }
        }
        else{
            return response()->json(['message' => 'Code is invalid!'], 400);
        }
    }
}
