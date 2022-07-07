<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BaselineDakung;
use App\reffbagian;
use App\reffsatker;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Cache;


class DataDukungBaselineController extends Controller
{
    protected $session;
    private $title = 'Data Dukung Baseline';

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
        return view('pagu\baseline\datadukung\index', $data);
    }

    public function show($id)
    {
        $data['config'] = $this->config;
        $pagu = baseline::find(Crypt::decrypt($id));
        $data['pagu'] = baseline::find(Crypt::decrypt($id));
        $data['satker'] = reffsatker::find($pagu->reffsatker_id);
        return view('pagu\baseline\datadukung\show', $data);
    }

    public function create()
    {

    }

    public function upload(Request $request)
    {
        //echo $request->id;  
        return redirect('datadukungbaseline')->with('msg', 'Dokumen '.$request->id.' berhasil di upload.');  
    }

    public function store(Request $request)
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

        return redirect('datadukungbaseline')->with('msg', 'Dokumen '.$request->id.' berhasil di upload.');  
    }

}