<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeTypes;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryProduct = Products::with('categories')->paginate(5);
        return view('admin.products.list', compact('aryProduct'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aryAttributeType = AttributeTypes::with('attributesValue')->get();
        $aryCategory = Categories::all();
        return view('admin.products.create', compact('aryCategory', 'aryAttributeType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $destination_path = 'public/images/products';
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path, $imageName);
        }

        DB::beginTransaction();
        try {
            $product = Products::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'slug' => Str::slug($request->name, '-'),
                'price' => $request->price,
                'is_new' => $request->is_new ?? 0,
                'is_sale' => $request->is_sale ?? 0,
                'highlight' => $request->highlight ?? 0,
                'status' => $request->status,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'details' => $request->details,
                'image' => $imageName

            ]);


            // Attach Category
            $product->categories()->attach($request->category);

            // Attach Value
            $arrayValue = [];
            foreach ($request->attribute_value as  $aryValue) {
                foreach ($aryValue as $valueItem) {
                    $arrayValue[] = $valueItem;
                }
            }
            $product->attribute_value()->attach($arrayValue);

            // Create variant
            $aryVariant = generateVariant($request->attribute_value);
            foreach ($aryVariant as $key => $var) {
                $variant = Variant::create([
                    'product_id' => $product->id,
                    'price' => $product->price
                ]);
                $variant->values()->attach($var);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->route('dashboard');
        }

        return redirect()->route('create.products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
