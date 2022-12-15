<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryBlog = Blogs::select(['id', 'name', 'detail', 'status'])->limit(10)->get();
        return view('admin.blogs.list', compact('aryBlog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/blogs/create');
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
            $request->all(),[
                'name' => 'required|max:255|min:3',
                'detail' => 'required|min:3',
            ],[
                'required' => 'Must be filled!',
                'min' => 'At least :min characters!',
            ]
        );

        if ($validator->fails()) {
            return redirect(route('create.blogs'))->withErrors($validator)->withInput($request->all());
        }

        Blogs::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'detail' => $request->detail,
            'status' => $request->status,
        ]);
        session()->flash('create_complete', 'success');
        return redirect(route('list.blogs'));
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
        $blog = Blogs::find($id);
        return view('admin.blogs.edit', compact('blog'));
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
        $blog = Blogs::find($id);
        if($blog){
            $blog->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'detail' => $request->detail,
                'status'=> $request->status
            ]);
            session()->flash('edit_complete', 'success');
            return redirect(route('list.blogs'));
        }
        session()->flash('blogs_not_exist', 'fail');
        return redirect(route('list.blogs'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blogs::find($id);
        if($blog){
            $blog->delete();
            session()->flash('delete_complete', 'success');
            return redirect(route('list.blogs'));
        }
        session()->flash('blogs_not_exist', 'fail');
        return redirect(route('list.blogs'));
    }
}
