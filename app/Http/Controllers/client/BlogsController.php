<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aryBlog = Blogs::with(['image' => function($q){ $q->where('image_type', config('handle.image_type.blog'))
                                                           ->where('is_primary', config('handle.primary_image.primary')); 
                                                        }])
            ->where('status', config('handle.blog_status.approved'))
            ->get();
        // dd($aryBlog);
        return view('client.blog.index', compact('aryBlog'));
    }

    public function detail($slug)
    {
        $blog = Blogs::with(['image' => function($q){ $q->where('image_type', config('handle.image_type.blog')); }])
            ->where('slug', $slug)
            ->firstOrFail();
        return view('client.blog.detail', compact('blog'));
    }

}
