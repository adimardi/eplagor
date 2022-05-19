<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Cache;
use Session;


class DashboardController extends Controller
{
    private $title = 'Home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->config = [
            'title'     => $this->title,
            'pageTitle' => $this->title,
        ];

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['config'] = $this->config;

        if(strpos($_SERVER['HTTP_USER_AGENT'],'wv') !== false)
        {
            return '';
        }

        return view('index', $data);
    }

}
