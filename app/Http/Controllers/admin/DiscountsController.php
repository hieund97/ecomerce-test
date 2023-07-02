<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Products;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryDiscount = Discount::paginate(config('handle.admin_paginate'));
        return view('admin.discount.list', compact('aryDiscount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aryProduct = Products::all();
        return view('admin.discount.create', compact('aryProduct'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        Discount::create([
            'name'          => $request->name,
            'code'          => $request->code,
            'related_id'    => $request->related_id,
            'value'         => $request->value,
            'type_discount' => $request->type,
            'start'         => $request->start,
            'end'           => $request->end
        ]);

        return response()->json('success', 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aryProduct = Products::all();
        $discount = Discount::findOrFail($id);
        return view('admin.discount.edit', compact('aryProduct', 'discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request)
    {
        $discount = Discount::findOrFail($request->id);
        $discount->update([
            'name'          => $request->name,
            'code'          => $request->code,
            'related_id'    => $request->related_id,
            'type_discount' => $request->type,
            'value'         => $request->value,
            'start'         => $request->start,
            'end'           => $request->end,
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
        $discount = Discount::findOrFail($id);
        $discount->delete();
    }
}
