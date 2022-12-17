<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Pagination
        $perPage = 5;
        $page = $request->has('page') ? $request->page : 1;
        $startAt = $perPage * ($page - 1);

        $aryCategories = Categories::limit($perPage)->offset($startAt)->get();

        $totalPages = ceil(Categories::all()->count() / $perPage);
        return view('admin.categories.list', compact('aryCategories','perPage','page','startAt','totalPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aryCategories = Categories::all();
        return view('admin.categories.create', compact('aryCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valiadator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255'
        ], 
        [
            'required' => 'Must be filled!',
            'min' => 'At least :min characters!',
            'max' => 'Too long!'
        ]);
        if($valiadator->fails()){
            return redirect(route('create.categories'))->withErrors($valiadator)->withInput();
        }

        Categories::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'type' => $request->type,
        ]);
        

        session()->flash('edit_success', 'success');
        return redirect(route('list.categories'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aryCategories = Categories::all();
        $category = Categories::findOrFail($id);
        return view('admin.categories.edit', compact('category', 'aryCategories'));
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
        $category = Categories::findOrFail($id);
        $valiadator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255'
        ], 
        [
            'required' => 'Must be filled!',
            'min' => 'At least :min characters!',
            'max' => 'Too long!'
        ]);

        if($valiadator->fails()){
            return redirect(route('edit.categories', $id))->withErrors($valiadator)->withInput();
        }

        if ($category) {
            $category->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'status' => $request->status,
                'type' => $request->type,
            ]);
            session()->flash('edit_success', 'success');
            return redirect(route('list.categories'));
        }
        session()->flash('category_not_exist', 'fail');
        return redirect(route('list.categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();
        session()->flash('delete_success', 'success');
        return redirect(route('list.categories'));
    }
}
