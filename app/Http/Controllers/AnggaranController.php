<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Anggaran;
use App\UraianAnggaran;
use App\reffsatker;
use App\reff_bas;
use App\Users;

use Carbon\Carbon;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\filter;

use Cache;
use Auth;
use PDF;

class AnggaranController extends Controller
{
    use filter;

    protected $session;
    private $title = 'Anggaran 2023';

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->config = [
            'title'     => $this->title,
            'pageTitle' => $this->title,
        ];
    }

    public function index()
    {
        $data['config'] = $this->config;

        return view('pagu.anggaran.index', $data);
    }

    public function dokumen($id)
    {
        $data = [
                    'config' => $this->config,
                    'unik' => Crypt::decrypt($id)
                ];

        return view('pagu.anggaran.dokumen', $data); 
    }

    public function show($id)
    {
        $data ['config'] = $this->config;
        $data['id'] = Crypt::decrypt($id);
        $data['satker'] = reffsatker::where('id',$data['id'])->first();

        return view('pagu.anggaran.show', $data); 
    }

    public function cetak($id)
    {
        $data['id'] = Crypt::decrypt($id);

        $pdf = PDF::loadview('pagu.anggaran.cetak',$data)->setPaper('a4', 'potrait');
        return $pdf->download('cetak-pdf');

        //return view('pagu.anggaran.show', $data); 
    }

    public function create()
    {

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

    public function uploads(Request $request)
    {

    }

}
