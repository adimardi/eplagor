<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pagu;
use App\Anggaran;
use App\AnggaranDakung;
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


class PaguIndikatifController extends Controller
{
    protected $session;
    private $title = 'Pagu Anggaran';

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

        return view('pagu.indikatif.index', $data);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $data = [
                    'config' => $this->config,
                    'unik' => Crypt::decrypt($id)
                ];

        return view('pagu.indikatif.show', $data);   
    }

    public function dakung($id)
    {
        $data = [
                    'config' => $this->config,
                    'unik' => Crypt::decrypt($id)
                ];

        return view('pagu.indikatif.dakung', $data);   
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
        AnggaranDakung::updateOrCreate(
            [
                'id' => $request->id,
                'thang' => 2023,
            ],
            [
                'reffsatker_id' => $request->kodeSatker,
                'kdprogram' => $request->kodeProgram,
                'kdgiat' => $request->kodeKegiatan,
                'kdoutput' => $request->kodeOutput,
                'kdsoutput' => $request->kodeSubOutput,
                'kdkmpnen' => $request->kodeKomponen,
                'total' => $request->total,
            ]
        );

        if(!empty($request->file('tor')))
        {
            $file = $request->file('tor');
            $file_dir = 'storage/Dokumen_anggaran/';

            // menyimpan data file yang diupload ke variabel $file
            $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
            $dokumen = 'Tor';
            $nama_file = $dokumen."_".$generate."_".$request->id.".".$file->getClientOriginalExtension();

            // isi dengan nama folder tempat kemana file diupload
            //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
            $tujuan_upload = $file_dir;

            if (!file_exists($file_dir)) {
                mkdir($file_dir, 0777, true);
            }

            $file->move($tujuan_upload, $nama_file);

            AnggaranDakung::updateOrCreate(
                [
                    'id' => $request->id,
                    'thang' => 2023,
                ],
                [
                    'fileTor' => $nama_file
                ]
            );

            echo 'Tor Tersimpan';
        }

        if(!empty($request->file('rab')))
        {
            $file = $request->file('rab');
            $file_dir = 'storage/Dokumen_anggaran/';

            // menyimpan data file yang diupload ke variabel $file
            $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
            $dokumen = 'Rab';
            $nama_file = $dokumen."_".$generate."_".$request->id.".".$file->getClientOriginalExtension();

            // isi dengan nama folder tempat kemana file diupload
            //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
            $tujuan_upload = $file_dir;

            if (!file_exists($file_dir)) {
                mkdir($file_dir, 0777, true);
            }

            $file->move($tujuan_upload, $nama_file);

            AnggaranDakung::updateOrCreate(
                [
                    'id' => $request->id,
                    'thang' => 2023,
                ],
                [
                    'fileRab' => $nama_file
                ]
            );

            echo 'Rab Tersimpan';
        }

        if(!empty($request->file('lainnya')))
        {
            $file = $request->file('lainnya');
            $file_dir = 'storage/Dokumen_anggaran/';

            // menyimpan data file yang diupload ke variabel $file
            $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
            $dokumen = 'Lainnya';
            $nama_file = $dokumen."_".$generate."_".$request->id.".".$file->getClientOriginalExtension();

            // isi dengan nama folder tempat kemana file diupload
            //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
            $tujuan_upload = $file_dir;

            if (!file_exists($file_dir)) {
                mkdir($file_dir, 0777, true);
            }

            $file->move($tujuan_upload, $nama_file);

            AnggaranDakung::updateOrCreate(
                [
                    'id' => $request->id,
                    'thang' => 2023,
                ],
                [
                    'fileLainnya' => $nama_file
                ]
            );

            echo 'Lainnya Tersimpan';
        }

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('paguindikatif.dakung', Crypt::encrypt($request->kodeSatker));
    }

}
