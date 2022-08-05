<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Cache;
use Session;
use DB;

use App\reffbagian;
use App\reffsatker;
use App\Users;

use App\Traits\filter;

use App\pagu;
use App\Worksheet;


class DashboardController extends Controller
{
    use filter;

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
        $config = $this->config;
        //$session_id = Auth::user()->reffsatker_id;

        if(strpos($_SERVER['HTTP_USER_AGENT'],'wv') !== false)
        {
            return '';
        }

        $tpegawai = pagu::where('thang', Session::get('thang'))
                    ->where('kdakun','LIKE','51%');
        $tpegawai = $this->filterUser($tpegawai)->sum('jumlah');

        $tbarang = pagu::where('thang', Session::get('thang'))
                    ->where('kdakun','LIKE','52%');
        $tbarang = $this->filterUser($tbarang)->sum('jumlah');

        $tmodal = pagu::where('thang', Session::get('thang'))
                    ->where('kdakun','LIKE','53%');
        $tmodal = $this->filterUser($tmodal)->sum('jumlah');

        $total = pagu::where('thang', Session::get('thang'));
        $total = $this->filterUser($total)->sum('jumlah');

        $pegawai = Worksheet::selectRaw('thang, SUM(belanja_pegawai) as total')
                        ->orderBy('thang', 'desc');
        $pegawai = $this->filterUser($pegawai)->groupBy('thang')->get();

        $barang = Worksheet::selectRaw('thang, SUM(belanja_barang) as total')
                        ->orderBy('thang', 'desc');
        $barang = $this->filterUser($barang)->groupBy('thang')->get();

        $modal = Worksheet::selectRaw('thang, SUM(belanja_modal) as total')
                        ->orderBy('thang', 'desc');
        $modal = $this->filterUser($modal)->groupBy('thang')->get();

        return view('index', compact('config', 'tpegawai', 'tbarang', 'tmodal', 'total', 'pegawai', 'barang', 'modal'));
    }

}
