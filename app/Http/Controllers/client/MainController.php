<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arySlider = Slider::where('status', 1)->limit(config('handle.show_slider'))->get();
        return view('client.index', compact('arySlider'));
    }
}
