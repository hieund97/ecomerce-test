<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/dashboard');
    }

    public function products()
    {
        return view('admin/products');
    }

    public function users()
    {
        return view('admin/users');
    }

    public function categories()
    {
        return view('admin/categories');
    }
}
