<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Logs;
use App\Users;
use Auth;




class LogsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
            if(!(Auth::user()->level == 'root'))
            {
                return redirect()->route('home');
            } 
            else
            {
                $logs = logs::with('users')->get();
                return view('logs',  compact('logs'));
            }
    }

    public function hapussemua()
    {
        $logs = logs::all();
        foreach ($logs as $log)
        $log->delete();
        return redirect()->route('logs.index');
    }
}