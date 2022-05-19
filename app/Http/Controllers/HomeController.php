<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Auth;
use Request;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if(!Auth::guest())
        {
            return redirect()->action('DashboardController@index');
        }
        else
        {
            return view('home');
        }
    }
    
    
}
