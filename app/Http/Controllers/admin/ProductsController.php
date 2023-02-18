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
        $aryProduct = Products::select('id', 'name')->get();
        return view('admin.products.create', compact('aryCategory', 'aryAttributeType', 'aryProduct'));
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

        try {
            DB::beginTransaction();
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
                'image' => $imageName,
                'related_product_id' => $request->has('related_product_id') ? implode(',', $request->related_product_id) : null,
            ]);

            // Attach Category
            $product->categories()->attach($request->category);

            // Attach Value
            $arrayValue = $this->adjustAttributeValue($request->attribute_value);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $aryProduct = Products::select('id', 'name')->get();
        $aryAttributeType = AttributeTypes::with('attributesValue')->get();
        $aryCategory = Categories::all();
        return view('admin.products.edit', compact('aryAttributeType', 'aryCategory', 'product', 'aryProduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Products::findOrFail($request->id);
        try {
            DB::beginTransaction();
            $product->update([
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
                // 'image' => $imageName,
                // 'related_product_id' => implode(',', $request->related_product_id),
            ]);
            //Category
            $product->categories()->sync($request->category);

            //AttributeValue
            $arrayValue = $this->adjustAttributeValue($request->attribute_value);
            $product->attribute_value()->sync($arrayValue);
            
            //Variant
            $aryVariant = Variant::where('product_id', $request->id)->get()->each(function($variant) {
                $variant->values()->detach();
                $variant->delete();
            });
            
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

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $product->update([
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Products::findOrFail($request->product_id);
        try {
            DB::beginTransaction();
            //Category
            $aryCategoryID = [];
            foreach ($product->categories as $key => $cate) {
                $aryCategoryID[] = $cate->id;
            }
            $product->categories()->detach($aryCategoryID);

            //Value
            $aryValueID = [];
            foreach ($product->attribute_value as $key => $value) {
                $aryValueID[] = $value->id;
            }
            $product->attribute_value()->detach($aryValueID);

            //Variant
            $aryVariant = Variant::where('product_id', $request->product_id)->get();
            foreach ($aryVariant as $key => $variant) {
                $aryValue =[];
                foreach ($variant->values as $key => $value) {
                    $aryValue[] = $value->id;
                }
                $variant->values()->detach($aryValue);
                $variant->delete();
            }
        $product->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(['message' => 'success'], 200);
    }

    private function adjustAttributeValue($data = []){
        $arrayValue = [];

        foreach ($data as  $aryValue) {
            if(!empty($aryValue)){
                foreach ($aryValue as $valueItem) {
                    $arrayValue[] = $valueItem;
                }
            }
        }

        return $arrayValue;
    }

    private function createVariant($dataAttribute = [], $product){
        $aryVariant = generateVariant($dataAttribute);

        foreach ($aryVariant as $key => $var) {
            $variant = Variant::create([
                'product_id' => $product->id,
                'price' => $product->price
            ]);
            $variant->values()->attach($var);
        }

        return true;
    }
}

