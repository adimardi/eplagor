<?php

namespace App\Http\Controllers\Usulan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\reffbagian;
use App\reffsatker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Cache;
use Session;
use Auth;

class KenaikanKelasPnController extends Controller
{
    protected $session;
    private $title = 'Usulan Kenaikan Kelas Peradilan Umum';

    public function __construct()
    {
        $this->config = [
            'title'     => $this->title,
            'pageTitle' => $this->title,
        ];
    }

    public function index()
    {
        $data['config'] = $this->config;
        return view('usulan/kenaikankelaspn.index', $data);
    }

    public function create()
    {
    	$data['config'] = $this->config;
        return view('usulan/kenaikankelaspn.create', $data);
    }

    public function show($id)
    {
      	$data['config'] = $this->config;
        return view('usulan/kenaikankelaspn.show', $data);  
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

}
