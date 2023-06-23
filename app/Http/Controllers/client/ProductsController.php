<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\AttributeTypes;
use App\Models\AttributeValues;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Tag;
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
        $aryCategory = Categories::where('status', 1)->limit(config('handle.show_on_product_page.category'))->get();
        $arySize = AttributeValues::where('attribute_id', config('handle.attribute_type.size'))->get();
        $aryColor = AttributeValues::where('attribute_id', config('handle.attribute_type.color'))->get();
        $aryTag = Tag::where('status', 1)->limit(config('handle.show_on_product_page.tag'))->get();
        
        return view('client.product', compact('aryCategory', 'aryColor', 'arySize', 'aryTag'));
    }
    /**
     * Get all the product to FE
     *
     * @return void
     */
    public function getAllProduct()
    {
        $aryProduct = Products::with(['image' => function ($q) {
            $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
        }])
            ->where('status', config('handle.status.on'))
            ->paginate(config('handle.show_product'));
            
        return response()->json($aryProduct, 200);
    }

    /**
     * Show detail of a product
     *
     * @param [type] $slug
     * @return void
     */
    public function detail($slug)
    {
        $product = Products::with(['categories', 'attribute_value', 'image' => function ($q) {
            $q->where('image_type', config('handle.image_type.product'));
        }])
            ->where('slug', $slug)
            ->firstOrFail();
        $aryType = AttributeTypes::select('id', 'name')->get();

        $aryRelatedProduct = explode(',', $product->related_product_id);
        $relatedProducts = Products::whereIn('id', $aryRelatedProduct)
            ->with(['image' => function ($q) {
                $q->where('image_type', config('handle.image_type.product'))
                    ->where('is_primary', config('handle.primary_image.primary'));
            }])
            ->get();

        return view('client.productDetail', compact('product', 'relatedProducts', 'aryType'));
    }

    /**
     * get the variant of the product on detail
     *
     * @param Request $request
     * @return void
     */
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
    /**
     * select filter
     *
     * @param Request $request
     * @return void
     */
    public function filter(Request $request)
    {
        // dd(config('handle.sort_option.low_to_high'));
        switch ($request->type) {
            case config('handle.filter.type.price'):
                return $this->filterPrice($request);
                break;
            case config('handle.filter.type.color'):
                return $this->filterColor($request);
                break;
            case config('handle.filter.type.size'):
                return $this->filterSize($request);
                break;
            case config('handle.filter.type.tag'):
                return $this->filterTag($request);
                break;
            case config('handle.filter.type.category'):
                return $this->filterCategory($request);
                break;
            case config('handle.filter.type.search'):
                return $this->search($request);
                break;
            default:
                return $this->getAllProduct();
                break;
        }
    }

    /**
     * finding product with color filter
     *
     * @param Request $request
     * @return void
     */
    protected function filterColor(Request $request)
    {
        $aryProduct = Products::with([
            'image' => function ($q) {
                $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
            },
            'attribute_value'
        ])
            ->whereHas('attribute_value', function ($query) use ($request) {
                $query->where('attribute_values.id', $request->color);
            })
            ->paginate(config('handle.show_product'));


        return response()->json($aryProduct, 200);
    }

    /**
     * finding product with size filter
     *
     * @param Request $request
     * @return void
     */
    protected function filterSize(Request $request)
    {
        $aryProduct = Products::with([
            'image' => function ($q) {
                $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
            },
            'attribute_value'
        ])
            ->whereHas('attribute_value', function ($query) use ($request) {
                $query->where('attribute_values.id', $request->size);
            })
            ->paginate(config('handle.show_product'));

        return response()->json($aryProduct, 200);
    }

    /**
     * finding product with tag filter
     *
     * @param Request $request
     * @return void
     */
    protected function filterTag(Request $request)
    {
        $aryProduct = Products::with([
            'image' => function ($q) {
                $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
            },
            'tag'
        ])
            ->whereHas('tag', function ($query) use ($request) {
                $query->where('tags.id', $request->tag);
            })
            ->paginate(config('handle.show_product'));

        return response()->json($aryProduct, 200);
    }

    /**
     * finding product with category filter
     *
     * @param Request $request
     * @return void
     */
    protected function filterCategory(Request $request)
    {
        $aryProduct = Products::with([
            'image' => function ($q) {
                $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
            },
            'categories'
        ])
            ->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->cate);
            })
            ->paginate(config('handle.show_product'));

        return response()->json($aryProduct, 200);
    }

    /**
     * finding product with price filter
     *
     * @param Request $request
     * @return void
     */
    protected function filterPrice(Request $request)
    {
        if ($request->has('end') && !empty($request->end))
            $aryProduct = Products::with(['image' => function ($q) {
                $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
            }])
                ->whereBetween('price', [$request->start, $request->end])
                ->paginate(config('handle.show_product'));
        else
            $aryProduct = Products::with(['image' => function ($q) {
                $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
            }])
                ->where('price', '>=', $request->start)
                ->paginate(config('handle.show_product'));

        return response()->json($aryProduct, 200);
    }

    public function search(Request $request)
    {
        $aryProduct = Products::with([
            'image' => function ($q) {
                $q->where('is_primary', config('handle.primary_image.primary'))->where('image_type', config('handle.image_type.product'));
            },
        ])
            ->where('name', 'like', "%{$request->search}%")
            ->paginate(config('handle.show_product'));

        return response()->json($aryProduct, 200);
    }
}
