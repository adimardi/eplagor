<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pagu;
use App\baseline;
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


class BaselineController extends Controller
{
    protected $session;
    private $title = 'Baseline';

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
        return view('pagu.baseline', $data);
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
        baseline::updateOrCreate([
            'id' => $request->idPagu
        ],
        [
            'thang' => Session::get('thang'),
            'reffsatker_id' => $request->kodeSatker,
            'kddept' => $request->kodeDepartemen,
            'kdunit' => $request->kodeUnit,
            'kdprogram' => $request->kodeProgram,
            'kdgiat' => $request->kodeKegiatan,
            'kdoutput' => $request->kodeOutput,
            'kdlokasi' => $request->kodeLokasi,
            'kdkabkota' => $request->kodeKabKot,
            'kddekon' => $request->kodeDekon,
            'kdsoutput' => $request->kodeSubOutput,
            'kdkmpnen' => $request->kodeKomponen,
            'kdskmpnen' => $request->kodeSubKomponen,
            'kdakun' => $request->kodeAkun,
            'kdkppn' => $request->kodeKppn,
            'noitem' => $request->nomorItem,
            'nmitem' => $request->namaItem,
            'vol1' => $request->volume1,
            'sat1' => $request->satuan1,
            'vol2' => $request->volume2,
            'sat2' => $request->satuan2,
            'vol4' => $request->volume3,
            'sat3' => $request->satuan3,
            'vol4' => $request->volume4,
            'sat4' => $request->satuan4,
            'volkeg' => $request->volumeKegiatan,
            'satkeg' => $request->satuanKegiatan,
            'hargasat' => $request->hargaSatuan,
            'operasional' => $request->operasional,
            'prioritas' => $request->prioritas,
        ]);

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('baseline.index');
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

    public function getPagu(Request $request)
    {
        $pagu = pagu::find($request->unik);
        return response()->json($pagu);
    }

    public function hapus(Request $request)
    {
        $hapus = baseline::where('id', $request->idnya);
        $hapus->forceDelete();

        $data = [
            'status' => true,
            'message' => 'Data Berhasil di hapus'
        ];
        return json_encode($data);
    }

}
