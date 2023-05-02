<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeTypes;
use App\Models\AttributeValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryAttributeValues = AttributeValues::with('attributesType')->paginate(5);
        $aryAttributeTypes = AttributeTypes::all();
        return view('admin.attributes.value.list', compact('aryAttributeValues', 'aryAttributeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ],
            [
                'required' => ':attribute must be filled',
            ]
        );
        if ($validator->fails()) {
            return redirect(route('list.attributeValues'))->withErrors($validator)->withInput();
        }

        AttributeValues::create([
            'name' => $request->name,
            'attribute_id' => $request->attribute_id,
            'color_id' => $request->color_id,
        ]);

        session()->flash('create_success', 'success');
        return redirect(route('list.attributeValues'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $value = AttributeValues::findOrFail($id);
        return view('admin.attributes.value.edit', compact('value'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ],
            [
                'required' => ':attribute must be filled',
            ]
        );
        if ($validator->fails()) {
            return redirect(route('edit.attributeValues', $id))->withErrors($validator)->withInput();
        }

        $value = AttributeValues::findOrFail($id);
        $value->update([
            'name' => $request->name,
            'attribute_id' => $request->attribute_id,
            'color_id' => $request->color_id,
        ]);

        session()->flash('update_success', 'success');
        return redirect(route('list.attributeValues'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attributeValue = AttributeValues::findOrFail($id);
        $attributeValue->delete();

        session()->flash('delete_success', 'success');
        return redirect(route('list.attributeValues'));
    }
}
