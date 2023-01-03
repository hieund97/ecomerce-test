<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryAttributes = AttributeTypes::paginate(5);
        return view('admin.attributes.type.list', compact('aryAttributes'));
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
            return redirect(route('list.attributeTypes'))->withErrors($validator)->withInput();
        }

        AttributeTypes::create([
            'name' => $request->name
        ]);

        session()->flash('add_success', 'success');
        return redirect(route('list.attributeTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aryAttributes = AttributeTypes::all();
        $type = AttributeTypes::findOrFail($id);
        return view('admin.attributes.type.edit', compact('type'));
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
            return redirect(route('edit.attributeTypes', $id))->withErrors($validator)->withInput();
        }

        $type = AttributeTypes::findOrFail($id);
        $type->update([
            'name' => $request->name
        ]);

        session()->flash('update_success', 'success');
        return redirect(route('list.attributeTypes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = AttributeTypes::findOrFail($id);
        $type->delete();
        
        session()->flash('delete_complete', 'success');
        return redirect(route('list.attributeTypes'));
    }
}
