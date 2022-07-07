<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pagu;
use App\Baseline;
use App\reffbagian;
use App\reffsatker;
use App\temuanbpk_tindaklanjut;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Cache;


class PaguController extends Controller
{
    protected $session;
    private $title = 'Pagu Awal';

    public function __construct()
    {
        $this->config = [
            'title'     => $this->title,
            'pageTitle' => $this->title,
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['config'] = $this->config;

        return view('pagu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function hapus(Request $request) 
    {

    }

    // Detail Pagu
    public function getpagu(Request $request)
    {
        $pagu = pagu::find($request->unik);
        return response()->json($pagu);
    }

    // Indikatif
    public function indikatif() 
    {
        $this->config = [
            'title'     => 'Pagu Indikatif',
            'pageTitle' => 'Pagu Indikatif',
        ];

        $data = [
                    'config' => $this->config,
                ];

        return view('pagu.indikatif', $data);
    } 

    // Anggaran
    public function anggaran() 
    {
        $this->config = [
            'title'     => 'Pagu Anggaran',
            'pageTitle' => 'Pagu Anggaran',
        ];

        $data = [
                    'config' => $this->config,
                ];

        return view('pagu.indikatif', $data);
    } 

    // Alokasi
    public function alokasi() 
    {
        $this->config = [
            'title'     => 'Pagu Alokasi',
            'pageTitle' => 'Pagu Alokasi',
        ];

        $data = [
                    'config' => $this->config,
                ];

        return view('pagu.indikatif', $data);
    } 

    // Revisi
    public function revisi() 
    {
        $this->config = [
            'title'     => 'Pagu Revisi',
            'pageTitle' => 'Pagu Revisi',
        ];

        $data = [
                    'config' => $this->config,
                ];

        return view('pagu.indikatif', $data);
    } 

    // Definitif
    public function definitif() 
    {
        $this->config = [
            'title'     => 'Pagu Definitif',
            'pageTitle' => 'Pagu Definitif',
        ];

        $data = [
                    'config' => $this->config,
                ];

        return view('pagu.definitif', $data);
    }  

    // Skala Prioritas
    public function prioritas() 
    {
        $this->config = [
            'title'     => 'Skala Prioritas',
            'pageTitle' => 'Skala Prioritas',
        ];

        $data = [
                    'config' => $this->config,
                ];

        return view('pagu.prioritas', $data);
    }  

    public function hapus_prioritas(Request $request) 
    {
        //echo $request->idnya;
        $hapus = Baseline::where('unik', $request->idnya);
        $hapus->forceDelete();

        $data = [
            'status' => true,
            'message' => 'Data Berhasil di hapus'
        ];
        return json_encode($data);
    } 

}
