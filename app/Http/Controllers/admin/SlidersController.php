<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ImageValues;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arySlider = Slider::with(['image'=>function($q){$q->where('image_type', config('handle.image_type.slider'));}])->paginate(5);
        return view('admin.slider.list', compact('arySlider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->file('related_image'));
        $slider = Slider::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'type_slider' => $request->type_slider,
            'related_id' => $request->related_id,
            'status' => $request->status,
        ]);
        if(!processImage($request->file('related_image'), $slider->id, config('handle.type_image_path.slider'))){
            return response()->json(['message' => 'fail'], 400);
        };
       

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request)
    {
        $slider = Slider::findOrFail($request->id);

        if ($request->hasFile('image')) {
            $imageName = $this->processImage($request->files, $slider);

            $slider->update([
                'image' => $imageName,
            ]);
        }
        // dd($imageName);
        $slider->update([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'type_slider' => $request->type_slider,
            'related_id' => $request->related_id,
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
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        $image = ImageValues::where('related_id', $id);
        $image->delete();
    }

    public function getRelatedID(Request $request)
    {
        // Tao 1 file config rieng cua minh, xong dua cac gia tri cua minh, (VD: cacs loai status)
        // config('filename.key')
        $type = $request->has('type_slider') ? $request->type_slider : 0;

        if ($type == 0) {
            $aryRelatedID = Categories::select('id', 'name')->limit(20)->orderBy('id', 'DESC')->get();
        } else {
            $aryRelatedID = Products::select('id', 'name')->limit(20)->orderBy('id', 'DESC')->get();
        }

        return response()->json($aryRelatedID, 200);
    }

    
    
}
