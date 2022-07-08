<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pagu;
use App\Baseline;
use App\BaselineDakung;
use App\reffbagian;
use App\reffsatker;
use App\UraianAnggaran;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Cache;


class Baseline1Controller extends Controller
{
    protected $session;
    private $title = 'Data Baseline 1';

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
        return view('baseline1.index', $data);
    }

    public function dakung($param)
    {
        $this->config = [
            'title'     => 'Data Dukung Baseline 1',
            'pageTitle' => 'Data Dukung Baseline 1',
        ];

        $data = [
                    'config' => $this->config,
                ];

        return view('baseline1.dakung', $data);
    }

    public function pagu(Request $request)
    {
        $pagu = pagu::find($request->unik);
        return response()->json($pagu);
    }

    public function create()
    {
        $data['config'] = $this->config;
        $data['kdprogram'] = UraianAnggaran::select('kode')->where('jenis', 'program')->orderBy('id', 'ASC')->get();
        $data['kdkegiatan'] = UraianAnggaran::select('kode')->where('jenis', 'kegiatan')->orderBy('id', 'ASC')->get();
        $data['kdoutput'] = UraianAnggaran::select('kode')->where('jenis', 'output')->orderBy('id', 'ASC')->get();
        $data['kdsuboutput'] = UraianAnggaran::select('kode')->where('jenis', 'suboutput')->orderBy('id', 'ASC')->get();
        return view('baseline1.create', $data); 
    }

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
            'vol1' => $request->volume1x,
            'sat1' => $request->satuan1,
            'vol2' => $request->volume2x,
            'sat2' => $request->satuan2,
            'vol3' => $request->volume3x,
            'sat3' => $request->satuan3,
            'vol4' => $request->volume4x,
            'sat4' => $request->satuan4,
            'volkeg' => $request->volumeKegiatan,
            'satkeg' => $request->satuanKegiatan,
            'hargasat' => $request->hargaSatuan,
            'jumlah' => $request->jumlah,
            'operasional' => $request->operasional,
            'prioritas' => $request->prioritas,
        ]);

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('baseline1.index');
    }

    public function uploads(Request $request)
    {
        BaselineDakung::updateOrCreate(
            [
                'id' => $request->id,
                'thang' => Session::get('thang'),
            ],
            [
                'reffsatker_id' => $request->kodeSatker,
                'kdunit' => $request->kodeUnit,
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
            $file_dir = 'storage/Dokumen_baseline/';

            // menyimpan data file yang diupload ke variabel $file
            $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
            $dokumen = 'Tor';
            $nama_file = $dokumen."_".$generate."_".$request->id.".".$file->getClientOriginalExtension();

            // isi dengan nama folder tempat kemana file diupload
            //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
            $tujuan_upload = $file_dir.$request->id;

            if (!file_exists($file_dir)) {
                mkdir($file_dir, 0777, true);
            }

            $file->move($tujuan_upload, $nama_file);

            BaselineDakung::updateOrCreate(
                [
                    'id' => $request->id,
                    'thang' => Session::get('thang'),
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
            $file_dir = 'storage/Dokumen_baseline/';

            // menyimpan data file yang diupload ke variabel $file
            $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
            $dokumen = 'Rab';
            $nama_file = $dokumen."_".$generate."_".$request->id.".".$file->getClientOriginalExtension();

            // isi dengan nama folder tempat kemana file diupload
            //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
            $tujuan_upload = $file_dir.$request->id;

            if (!file_exists($file_dir)) {
                mkdir($file_dir, 0777, true);
            }

            $file->move($tujuan_upload, $nama_file);

            BaselineDakung::updateOrCreate(
                [
                    'id' => $request->id,
                    'thang' => Session::get('thang'),
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
            $file_dir = 'storage/Dokumen_baseline/';

            // menyimpan data file yang diupload ke variabel $file
            $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
            $dokumen = 'Lainnya';
            $nama_file = $dokumen."_".$generate."_".$request->id.".".$file->getClientOriginalExtension();

            // isi dengan nama folder tempat kemana file diupload
            //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
            $tujuan_upload = $file_dir.$request->id;

            if (!file_exists($file_dir)) {
                mkdir($file_dir, 0777, true);
            }

            $file->move($tujuan_upload, $nama_file);

            BaselineDakung::updateOrCreate(
                [
                    'id' => $request->id,
                    'thang' => Session::get('thang'),
                ],
                [
                    'fileLainnya' => $nama_file
                ]
            );

            echo 'Lainnya Tersimpan';
        }

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('baseline1.index');
    }
}