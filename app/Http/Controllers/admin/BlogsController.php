<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Categories;
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
        
        // $aryBlog = Blogs::join('categories', 'blogs.category_id', 'categories.id')->select('blogs.*', 'categories.id as cate_id', 'categories.name as cate_name')->get();
        $aryBlog = Blogs::with('categories')->paginate(5);
        return view('admin.blogs.list', compact('aryBlog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aryCategories = Categories::where('type', config('handle.category_type.blog'))->get();
        return view('admin/blogs/create', compact('aryCategories'));
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
                'name' => 'required|max:255|min:3',
                'detail' => 'required|min:3',
                'description' => 'required|min:3|max:255',
            ],
            [
                'required' => 'Must be filled!',
                'min' => 'At least :min characters!',
                'max' => 'Too long!'
            ]
        );

        if ($validator->fails()) {
            return redirect(route('create.blogs'))->withErrors($validator)->withInput($request->all());
        }

        $aryImage = [];
        foreach ($request->file('blog-image') as $key => $value) {
            $aryImage[] = $value;
        }
        $aryImage['primary'] = $request->file('image');

        $blog = Blogs::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'detail' => $request->detail,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
        processImage($aryImage, $blog->id, config('handle.type_image_path.blog'));

        session()->flash('create_complete', 'success');
        return redirect(route('list.blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aryCategories = Categories::where('type', 1)->get();
        $blog = Blogs::find($id);
        return view('admin.blogs.edit', compact('blog', 'aryCategories'));
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
                'name' => 'required|max:255|min:3',
                'detail' => 'required|min:3',
                'description' => 'required|min:3|max:255',
                'slug' => 'required|min:3|max:255',
            ],
            [
                'required' => 'Must be filled!',
                'min' => 'At least :min characters!',
                'max' => 'Too long!'
            ]
        );

        if ($validator->fails()) {
            return redirect(route('edit.blogs', $id))->withErrors($validator)->withInput();
        }

        $blog = Blogs::find($id);
        if ($blog) {
            $blog->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'detail' => $request->detail,
                'status' => $request->status
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
        if ($blog) {
            $blog->delete();
            session()->flash('delete_complete', 'success');
            return redirect(route('list.blogs'));
        }
        session()->flash('blogs_not_exist', 'fail');
        return redirect(route('list.blogs'));
    }
}
