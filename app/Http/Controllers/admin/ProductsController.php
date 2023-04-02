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
use App\Models\ImageValues;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryProduct = Products::with('categories', 'image')->paginate(5);
        $aryImage = ImageValues::where('is_primary', 1)->get();
        return view('admin.products.list', compact('aryProduct', 'aryImage'));
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
    public function store(Request $request)
    {
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
                'related_product_id' => $request->has('related_product_id') ? implode(',', $request->related_product_id) : null,
            ]);

            $image = $this->processImage($request, $product);
            
            // Attach Category
            $product->categories()->attach($request->category);
            
            // Attach Value
            $arrayValue = $this->adjustAttributeValue($request->attribute_value);
            $product->attribute_value()->attach($arrayValue);
            
            // Create variant
            $this->createVariant($request->attribute_value, $product);
            
            //Create image
            ImageValues::insert($image);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            // return redirect()->route('dashboard');
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
    public function update(ProductRequest $request)
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
                'related_product_id' => !empty($request->related_product_id) ? implode(',', $request->related_product_id) : null,
            ]);
            $imageName = $this->processImage($request, $product);


            //Category
            $product->categories()->sync(json_decode($request->category, true));
            
            //AttributeValue
            $arrayValue = $this->adjustAttributeValue(json_decode($request->attribute_value, true));
            $product->attribute_value()->sync($arrayValue);
            
            //Variant
            $aryVariant = Variant::where('product_id', $request->id)->get()->each(function($variant) {
                $variant->values()->detach();
                $variant->delete();
            });
            
            $aryVariant = generateVariant(json_decode($request->attribute_value, true));
            foreach ($aryVariant as $key => $var) {
                $variant = Variant::create([
                    'product_id' => $product->id,
                    'price' => $product->price
                ]);
                $variant->values()->attach($var);
            }

            //Create image
            ImageValues::where('related_id', $product->id)->get()->each(function($image){
                $image->delete();
            });
            ImageValues::insert($imageName);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 200);

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
        $product = Products::findOrFail($request->id);
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
            $aryVariant = Variant::where('product_id', $request->id)->get()->each(function($variant) {
                $variant->values()->detach();
                $variant->delete();
            });
            
            //Product
            $product->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 400);
        }
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Function handle attribute value
     *
     * @param array $data
     * @return array
     */
    private function adjustAttributeValue($data = []){
        $arrayValue = [];

        foreach ($data as $aryValue) {
            if(!empty($aryValue)){
                foreach ($aryValue as $valueItem) {
                    $arrayValue[] = $valueItem;
                }
            }
        }

        return $arrayValue;
    }

    /**
     * Function create new variant
     *
     * @param array $dataAttribute
     * @param [type] $product
     * @return void
     */
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

    /**
     * Function to find and save image
     *
     * @param [type] $request
     * @return void
     */
    private function processImage($request, $product){
        $aryImage = [];
        $destination_path = config('handle.destination_path');
        $image = $request->file('image');
        $primaryImage = 'products/'.$image->getClientOriginalName();
        $request->file('image')->storeAs($destination_path, $primaryImage);

        $aryPrimaryImage = [
            'name' => $primaryImage,
            'is_primary' => config('handle.primary_image.primary'),
            'related_id' => $product->id,
            'image_type' => config('handle.image_type.product'),
        ];
        array_push($aryImage, $aryPrimaryImage);
        
        $aryRelatedImageName = [];
        foreach ($request->file('image-prod') as $key => $image) {
            $destination_path = config('handle.destination_path');
            $imageName = 'products/'.$image->getClientOriginalName();
            $request->file('image')->storeAs($destination_path, $imageName);
            $aryRelatedImageName[] = $imageName;
        }

        foreach ($aryRelatedImageName as $key => $image) {
            $aryRelatedImage = [
                'name' => $image,
                'is_primary' => config('handle.primary_image.not_primary'),
                'related_id' => $product->id,
                'image_type' => config('handle.image_type.product'),
            ];
            array_push($aryImage, $aryRelatedImage);
        }

        return $aryImage;
    }
}

