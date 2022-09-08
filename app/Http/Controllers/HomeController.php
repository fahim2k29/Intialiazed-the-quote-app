<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**web
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $responses = Http::get('https://raw.githubusercontent.com/ajzbc/kanye.rest/master/quotes.json');
        $data = $responses->collect()->random(5);
        return view('home',compact('data'));
    }
}
