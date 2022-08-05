<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
 
// panggil model
use App\reffsatker;
use App\Users;
use App\reff_bas;

use App\penghapusan;
use App\penghapusanrevisi;
use App\transaksibmn;

use App\pemeriksaankeuperkara;
use App\pemeriksaanKasModel;

use App\pagu;
use App\pagu_revisi;
use App\databelanjabarang;
use App\dataspan_pagu;
use App\dataspan_realisasi;
use App\dataspan_estimasipnbp;
use App\dataspan_realisasipnbp;

use App\capaiankinerja;
use App\prepaid;
use App\kontrak;

use App\asiap;
use App\asiap_aset;

use App\pipk;
use App\pipk_penilaian;

use App\jurnal_keuangan;

use Auth;
use DB;
use File;
use DataTables;
use Cache;

// menggunakan PDF
use PDF;
use Session;

use App\Traits\filter;

// Baseline
use App\Baseline;
use App\BaselineDakung;
use App\UraianAnggaran;

// usulan kenaikan kelas
use App\UsulanKelasPa;
//use App\UsulanKelasPn;
use App\AnggaranDakung;


use App\Worksheet;
use App\Anggaran;

// ABT
use App\abt_usulan;
use App\abt_items;

class ApiController extends Controller
{
    use filter;

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function apiUser()
    {
        $user = Users::select('id','username', 'name','email','reffsatker_id','jabatan','kantor','level','last_seen')->with([
            'reffsatker' => function($query) {
                $query->select('id','kode_satker_lengkap','nama_satker_lengkap')->orderBy('kode_satker_lengkap', 'asc');
            }])->where('deleted_at', NULL);
            $this->filterUser($user);
            $this->filterKatagori($user);
            $user->when(request('filter_status'), function ($status) {
                
                $colect = [];
                foreach (Users::select('id')->get() as $user)
                {
                    if (Cache::has('user-is-online-'.$user->id)){
                        $colect[] = $user->id;
                    }
                }
            
                return $status->whereIn('id', $colect);
                });
    
            $user->when(request('filter_periode'), function ($periode) {
                $filter_periode = now()->subDays(request ('filter_periode'))->toDateString();                    
                return $periode->where('last_seen','>=', $filter_periode);
                });
    

        return Datatables::eloquent($user)
                            ->addColumn('action', function($user){
                                        $btn =   '
                                                <a href="' .route('user.edit', Crypt::encrypt($user->id)).'" type="button" class="btn btn-sm btn-outline-success btn-tooltip" data-bs-toggle="Detail" data-bs-placement="top" title="Detail" data-container="body" data-animation="true"><span><i class="fas fa-cogs"></i></span></a>
                                                <a href="javascript:void(0)" onclick="deleteData('. $user->id .')" type="button" class="btn btn-sm btn-outline-danger"><span><i class="fas fa-trash-alt"></i></span></a>
                                                    ';
                                        return $btn;
                                        })
                            ->addColumn('status', function($user) {

                                    if (Cache::has('user-is-online-'.$user->id)){
                                        $btn =   '<span style="color: blue;">
                                                    <i class="fa fa-circle"> Online</i>
                                                  </span>';
                                    }else{
                                        if(!empty($user->last_seen)){
                                            $btn =   '<span style="color: red;">
                                                            <i class="fa fa-circle"> 
                                                                Offline <br><br>
                                                                terakhir login '.$user->last_seen.'
                                                            </i>
                                                        </span>';
                                        }else{
                                            $btn =   '<span style="color: red;">
                                                        <i class="fa fa-circle"> 
                                                            Offline
                                                        </i>
                                                    </span>';
                                        }
                                    }
                                    return $btn;
                                    })
                            ->rawColumns(['action','status'])
                            ->toJson();

    }

    public function apiSatker()
    {
        $satker = reffsatker::orderBy('kode_satker_lengkap');
        $this->filterUserReffSatker($satker);
        $this->filterKatagoriReffSatker($satker);

        return Datatables::eloquent($satker)
                            ->addColumn('action', function($satker){
                                        $btn =   '
                                                <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                
                                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 10px, 0px);">
                                                    <a class="dropdown-item" href="'.route('satker.show', Crypt::encrypt($satker->id)).'"> Edit </a>
                                        
                                    
                                                </div>  
                                                    ';
                                        return $btn;
                                        })
                            ->rawColumns(['action'])
                            ->toJson();

    }


    public function apiPagu()
    {
        $pagu = pagu::where('thang', Session::get('thang'));

        $pagu = $pagu->with(['reffsatker']);
        $this->filterUser($pagu);
        $this->filterKatagori($pagu);

        return Datatables::eloquent($pagu)
            ->addColumn('action', function($pagu){
                $btn =   '<button type="button" class="btn btn-info btn-round ml-0 mb-0" type="button" title="Take" onclick="take(\''.$pagu->id.'\')"><i class="fa fa-edit"></i></button>';         
            return $btn;
            })

        ->rawColumns(['action'])
        ->toJson();
    }

    // PRIORITAS
    public function apiPrioritas()
    {
        $base = baseline::where('thang', Session::get('thang'))
                                ->where('prioritas', 'Y');

        $base = $base->with(['reffsatker']);
        $this->filterUser($base);
        $this->filterKatagori($base);

        return Datatables::eloquent($base)
            ->addColumn('action', function($base){
                $btn =   '<button type="button" class="btn btn-danger ml-0 mb-0" type="button" title="Hapus Data" onclick="deleteData('.$base->unik.')" style="padding: 8px 13px;"><i class="fas fa-trash"></i></button>';  

                return $btn;
            })

        ->rawColumns(['action'])
        ->toJson();
    }


    // -- START BASELINE 1
    public function apiBaseline1()
    {
        $base = Baseline::where('thang', Session::get('thang'));

        $base = $base->with(['reffsatker']);
        $this->filterUser($base);
        $this->filterKatagori($base);

        return Datatables::eloquent($base)->toJson();
    }

    public function apiPaguBaseline1()
    {
        $pagu = pagu::where('thang', Session::get('thang'));

        $pagu = $pagu->with(['reffsatker']);
        $this->filterUser($pagu);
        $this->filterKatagori($pagu);

        return Datatables::eloquent($pagu)
            ->addColumn('action', function($pagu){
                $btn =   '<button type="button" class="btn btn-info ml-0 mb-0" type="button" title="Gunakan Data" onclick="use(\''.$pagu->id.'\')" style="padding: 8px 13px;"><i class="fas fa-arrow-down"></i></button>';  

                return $btn;
            })

        ->rawColumns(['action'])
        ->toJson();
    }

    public function apiDakungBaseline1()
    {
        $base = Baseline::select(
                                    'reffsatker_id',
                                    'kdunit',
                                    'kdprogram',
                                    'kdgiat',
                                    'kdoutput',
                                    'kdsoutput',
                                    'kdkmpnen',
                                    DB::raw('SUM(jumlah) as total') 
                                )
                        ->where('thang', Session::get('thang'))
                        ->groupBy('reffsatker_id', 'kdunit', 'kdprogram', 'kdgiat', 'kdoutput', 'kdsoutput', 'kdkmpnen');

        $base = $base->with(['reffsatker']);
        $this->filterUser($base);
        $this->filterKatagori($base);

        return Datatables::eloquent($base)
            ->addColumn('file', function($base){
                $unik = $base->reffsatker_id.$base->kdunit.$base->kdprogram.$base->kdgiat.$base->kdoutput.$base->kdsoutput.$base->kdkmpnen;
                $files = BaselineDakung::where('id', $unik)->first();

                if(!empty($files)){
                    $btn =  '
                                <a href="'.asset('storage/Dokumen_baseline/'.$unik.'/'.$files->fileTor).'" data-toggle="tooltip" data-placement="top" title="File TOR" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_baseline/'.$unik.'/'.$files->fileRab).'" data-toggle="tooltip" data-placement="top" title="File RAB" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_baseline/'.$unik.'/'.$files->fileLainnya).'" data-toggle="tooltip" data-placement="top" title="File Lainnya" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                            ';
                } else {
                    $btn =  '
                                <a href="javascript:void(0)" class="btn btn-danger btn-upload ms-0 mb-0" style="padding: 8px 13px;" data-toggle="tooltip" data-placement="top" title="Upload dokumen" ><i class="fa fa-upload" aria-hidden="true"></i></a>
                            ';   
                }

                return $btn;
            })

            ->addColumn('coa', function($base){
                $kode = $base->kdgiat.'.'.$base->kdoutput.'.'.$base->kdsoutput.'.'.$base->kdkmpnen;
                return ($kode);
            })

            ->addColumn('deskripsi', function($base){
                $kode = $base->kdgiat.'.'.$base->kdoutput.'.'.$base->kdsoutput.'.'.$base->kdkmpnen;
                $desk = UraianAnggaran::where('kode', $base->kdgiat.'.'.$base->kdoutput.'.'.$base->kdsoutput.'.'.$base->kdkmpnen)->first();
                if(!empty($desk)){
                    return ($desk->deskripsi);
                } else {
                    return ('-');
                }
            })

        ->rawColumns(['coa', 'deskripsi', 'file'])
        ->toJson();
    }
    // -- END BASELINE 1

    // Pagu Anggaran 2023
    public function apiAnggaran()
    {
        $anggaran = Anggaran::selectRaw('reffsatker_id, thang, SUM(total) as total')
                            ->where('thang', 2023)
                            ->groupBy('reffsatker_id', 'thang');

        $anggaran = $anggaran->with(['reffsatker']);
        $this->filterUser($anggaran);
        $this->filterKatagori($anggaran);

        return Datatables::eloquent($anggaran)
            ->addColumn('satker', function($anggaran){
                $btn =  '
                            <a href="'.route('paguindikatif.show', Crypt::encrypt($anggaran->reffsatker_id)).'" style="padding: 8px 13px;" title="Detail">
                                '.$anggaran->reffsatker->nama_satker_lengkap.'
                            </a>
                        ';

                return $btn;
            })
            ->addColumn('total_belanja_pegawai', function($anggaran){
                $totals = Anggaran::where('thang', 2023)
                                  ->where('reffsatker_id', $anggaran->reffsatker_id)
                                  ->where('kode_akun','LIKE','51%')
                                  ->sum('total');
                return($totals);
            })
            ->addColumn('total_belanja_barang', function($anggaran){
                $totals = Anggaran::where('thang', 2023)
                                  ->where('reffsatker_id', $anggaran->reffsatker_id)
                                  ->where('kode_akun','LIKE','52%')
                                  ->sum('total');
                return($totals);
            })
            ->addColumn('total_belanja_modal', function($anggaran){
                $totals = Anggaran::where('thang', 2023)
                                  ->where('reffsatker_id', $anggaran->reffsatker_id)
                                  ->where('kode_akun','LIKE','53%')
                                  ->sum('total');
                return($totals);
            })
            ->addColumn('file', function($anggaran){
                $btn =  '
                            <a href="' . route('anggaran.dokumen', Crypt::encrypt($anggaran->reffsatker_id)) .'" class="text-info" title="Lihat Dokumen" >
                                Lihat Dokumen
                            </a>
                        ';

                return $btn;
            })
            ->addColumn('action', function($anggaran){
                $btn =   '
                            <a href="' . route('anggaran.cetak', Crypt::encrypt($anggaran->reffsatker_id)) .'" class="text-warning" title="Preview" target="_blank">Preview</a>
                         ';  

                return $btn;
            })

        ->rawColumns(['satker', 'total_belanja_pegawai', 'total_belanja_barang', 'total_belanja_modal', 'file', 'action',])
        ->toJson();
    }

    // Dokumen Pagu Anggaran 2023
    public function apiDokumenAnggaran()
    {
        $dakung = Anggaran::select(
                                    'reffsatker_id',
                                    'kode_program',
                                    'kode_kegiatan',
                                    'kode_output',
                                    'kode_suboutput',
                                    'kode_komponen',
                                    'kode_subkomponen',
                                    'uraian_subkomponen',
                                    DB::raw('SUM(total) as total')
                                )
                        ->where('reffsatker_id', request('unik'))
                        ->where('thang', 2023)
                        ->groupBy(  'reffsatker_id', 
                                    'kode_kegiatan', 
                                    'kode_program',
                                    'kode_output',
                                    'kode_suboutput',
                                    'kode_komponen',
                                    'kode_subkomponen',
                                    'uraian_subkomponen');

        $dakung = $dakung->with(['reffsatker']);
        $this->filterUser($dakung);
        $this->filterKatagori($dakung);

        return Datatables::eloquent($dakung)
            ->addColumn('file', function($dakung){
                $unik = $dakung->reffsatker_id.$dakung->kode_program.$dakung->kode_kegiatan.$dakung->kode_output.$dakung->kode_suboutput.$dakung->kode_komponen.$dakung->kode_subkomponen;
                $files = AnggaranDakung::where('id', $unik)->first();

                if(!empty($files)){
                    $btn =  '
                                <a href="'.asset('storage/Dokumen_anggaran/'.$unik.'/'.$files->fileTor).'" data-toggle="tooltip" data-placement="top" title="File TOR" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_anggaran/'.$unik.'/'.$files->fileRab).'" data-toggle="tooltip" data-placement="top" title="File RAB" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_anggaran/'.$unik.'/'.$files->fileLainnya).'" data-toggle="tooltip" data-placement="top" title="File Lainnya" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                            ';
                } else {
                    $btn =  '
                                <a href="javascript:void(0)" class="btn btn-danger btn-upload ms-0 mb-0" style="padding: 8px 13px;" data-toggle="tooltip" data-placement="top" title="Upload dokumen" ><i class="fa fa-upload" aria-hidden="true"></i></a>
                            ';   
                }

                return $btn;
            })

            ->addColumn('coa', function($dakung){
                $kode = $dakung->kode_kegiatan.'.'.$dakung->kode_output.'.'.$dakung->kode_suboutput.'.'.$dakung->kode_komponen;
                return ($kode);
            })

        ->rawColumns(['coa', 'file'])
        ->toJson();
    }

    // Daftar Akun
    public function apiAkun()
    {
        $akun = Anggaran::selectRaw('kode_akun, SUM(total) as total')
                        ->where('thang', 2023)
                        ->groupBy('kode_akun')
                        ->orderBy('kode_akun','asc');

        $akun = $akun->with(['reff_bas']);

        return Datatables::eloquent($akun)
            ->addColumn('kode', function($akun){
                $btn =   '
                            <a href="' . route('akun.rincian', Crypt::encrypt($akun->kode_akun)) .'" class="text-warning" title="Lihat Data">'.$akun->kode_akun.'</a>
                         ';  

                return $btn;
            })

        ->rawColumns(['kode'])
        ->toJson();
    }

    // Daftar Rincian Akun
    public function apiRincianAkun()
    {
        $akun = Anggaran::where('kode_akun', request('akun'))
                        ->where('thang', 2023);

        $akun = $akun->with(['reffsatker']);

        return Datatables::eloquent($akun)
            ->addColumn('kode', function($akun){
                $btn =   '
                            <a href="' . route('akun.rincian', Crypt::encrypt($akun->kode_akun)) .'" class="text-warning" title="Lihat Data">'.$akun->kode_akun.'</a>
                         ';  

                return $btn;
            })

        ->rawColumns(['kode'])
        ->toJson();
    }

    // Pagu Indikatif
    public function apiIndikatif()
    {
        $anggaran = Anggaran::select(
                                        'reffsatker_id',
                                        DB::raw('SUM(total) as total') 
                                    )
                        ->where('thang', 2023)
                        ->groupBy('reffsatker_id');

        $anggaran = $anggaran->with(['reffsatker']);
        $this->filterUser($anggaran);
        $this->filterKatagori($anggaran);

        return Datatables::eloquent($anggaran)
            ->addColumn('satker', function($anggaran){
                $btn =  '
                            <a href="'.route('paguindikatif.show', Crypt::encrypt($anggaran->reffsatker_id)).'" style="padding: 8px 13px;" title="Detail">
                                '.$anggaran->reffsatker->nama_satker_lengkap.'
                            </a>
                        ';

                return $btn;
            })
            ->addColumn('total_belanja_pegawai', function($anggaran){
                $totals = Anggaran::where('thang', 2023)
                                    ->where('reffsatker_id', $anggaran->reffsatker_id)
                                    ->where('kode_akun','LIKE','51%')
                                    ->sum('total');
                return($totals);
            })
            ->addColumn('total_belanja_barang', function($anggaran){
                $totals = Anggaran::where('thang', 2023)
                                    ->where('reffsatker_id', $anggaran->reffsatker_id)
                                    ->where('kode_akun','LIKE', '52%')
                                    ->sum('total');
                return($totals);
            })
            ->addColumn('total_belanja_modal', function($anggaran){
                $totals = Anggaran::where('thang', 2023)
                                    ->where('reffsatker_id', $anggaran->reffsatker_id)
                                    ->where('kode_akun','LIKE', '53%')
                                    ->sum('total');
                return($totals);
            })
            ->addColumn('file', function($anggaran){
                $btn =  '
                            <a href="' . route('paguindikatif.dakung', Crypt::encrypt($anggaran->reffsatker_id)) .'" title="Detail">
                                Lihat File
                            </a>
                        ';

                return $btn;
            })

        ->rawColumns(['satker', 'total_belanja_pegawai', 'total_belanja_barang', 'total_belanja_modal', 'file'])
        ->toJson();
    }

    public function apiRincianIndikatif()
    {
        $indikatif = Anggaran::where('reffsatker_id', request('unik'))
                             ->where('thang', 2023);

        $indikatif = $indikatif->with(['reffsatker']);
        $this->filterUser($indikatif);
        $this->filterKatagori($indikatif);

        return Datatables::eloquent($indikatif)

        ->rawColumns([])
        ->toJson();
    }

    public function apiDakungIndikatif()
    {
        $dakung = Anggaran::select(
                                    'pagu_id',
                                    'reffsatker_id',
                                    'kode_program',
                                    'kode_kegiatan',
                                    'kode_output',
                                    'kode_suboutput',
                                    'kode_komponen',
                                    'kode_subkomponen',
                                    'uraian_subkomponen',
                                    DB::raw('SUM(total) as total') 
                                  )
                            ->where('thang', 2023)
                            ->groupBy('pagu_id', 
                                      'reffsatker_id',
                                      'kode_program', 
                                      'kode_kegiatan', 
                                      'kode_output', 
                                      'kode_suboutput', 
                                      'kode_komponen',
                                      'kode_subkomponen',
                                      'uraian_subkomponen'
                                     );

        $dakung = $dakung->with(['reffsatker']);
        $this->filterUser($dakung);
        $this->filterKatagori($dakung);

        return Datatables::eloquent($dakung)
            ->addColumn('file', function($dakung){
                $unik = $dakung->reffsatker_id.$dakung->kode_program.$dakung->kode_kegiatan.$dakung->kode_output.$dakung->kode_suboutput.$dakung->kode_komponen;
                $files = AnggaranDakung::where('id', $dakung->pagu_id)->first();

                if(!empty($files)){
                    $btn =  '
                                <a href="'.asset('storage/Dokumen_anggaran/'.$unik.'/'.$files->fileTor).'" data-toggle="tooltip" data-placement="top" title="File TOR" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_anggaran/'.$unik.'/'.$files->fileRab).'" data-toggle="tooltip" data-placement="top" title="File RAB" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_anggaran/'.$unik.'/'.$files->fileLainnya).'" data-toggle="tooltip" data-placement="top" title="File Lainnya" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                            ';
                } else {
                    $btn =  '
                                <a href="javascript:void(0)" class="btn btn-danger btn-upload ms-0 mb-0" style="padding: 8px 13px;" data-toggle="tooltip" data-placement="top" title="Upload dokumen" ><i class="fa fa-upload" aria-hidden="true"></i></a>
                            ';   
                }

                return $btn;
            })

            ->addColumn('coa', function($dakung){
                $kode = $dakung->kode_kegiatan.'.'.$dakung->kode_output.'.'.$dakung->kode_suboutput.'.'.$dakung->kode_komponen;
                return ($kode);
            })

        ->rawColumns(['coa', 'file'])
        ->toJson();
    }

    // -- START BASELINE 3
    public function apiBaseline3()
    {
        $base = Baseline::select(
                                    'reffsatker_id',
                                    DB::raw('SUM(jumlah) as total')
                                )
                        ->where('thang', Session::get('thang'))
                        ->groupBy('reffsatker_id');

        $base = $base->with(['reffsatker']);
        $this->filterUser($base);
        $this->filterKatagori($base);

        return Datatables::eloquent($base)
            ->addColumn('satker', function($base){
                $btn =  '
                            <a href="'.route('baseline3.rincian', Crypt::encrypt($base->reffsatker_id)).'" style="padding: 8px 13px;" title="Detail">
                                '.$base->reffsatker->nama_satker_lengkap.'
                            </a>
                        ';

                return $btn;
            })

            ->addColumn('total_belanja_pegawai', function($base){
                $totals = Baseline::where('thang', Session::get('thang'))
                                    ->where('reffsatker_id', $base->reffsatker_id)
                                    ->where('kdakun','LIKE','51%')
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('total_belanja_barang_operasional', function($base){
                $totals = Baseline::where('thang', Session::get('thang'))
                                    ->where('reffsatker_id', $base->reffsatker_id)
                                    ->where('kdakun','LIKE', '52%')
                                    ->where('operasional', 'Y')
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('total_belanja_barang_nonoperasional', function($base){
                $totals = Baseline::where('thang', Session::get('thang'))
                                    ->where('reffsatker_id', $base->reffsatker_id)
                                    ->where('kdakun','LIKE', '52%')
                                    ->where('operasional', 'T')
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('total_belanja_modal_tanah', function($base){
                $totals = Baseline::where('thang', Session::get('thang'))
                                    ->where('reffsatker_id', $base->reffsatker_id)
                                    ->where(\DB::raw('substr(kdakun, 1, 3)'), '=' , 531)
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('total_belanja_modal_mesin', function($base){
                $totals = Baseline::where('thang', Session::get('thang'))
                                    ->where('reffsatker_id', $base->reffsatker_id)
                                    ->where(\DB::raw('substr(kdakun, 1, 3)'), '=' , 532)
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('total_belanja_modal_gedung', function($base){
                $totals = Baseline::where('thang', Session::get('thang'))
                                    ->where('reffsatker_id', $base->reffsatker_id)
                                    ->where(\DB::raw('substr(kdakun, 1, 3)'), '=' , 533)
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('aksi', function($base){
                $btn =  '
                            <a href="' . route('baseline3.dakung', Crypt::encrypt($base->reffsatker_id)) .'" title="Detail">
                                Lihat File
                            </a>
                        ';

                return $btn;
            })

        ->rawColumns([
                        'satker', 
                        'total_belanja_pegawai', 
                        'total_belanja_barang_operasional', 
                        'total_belanja_barang_nonoperasional', 
                        'total_belanja_modal_tanah', 
                        'total_belanja_modal_mesin', 
                        'total_belanja_modal_gedung', 
                        'aksi'
                    ])
        ->toJson();
    }

    public function apiDataBaseline3()
    {
        $base = Baseline::where('thang', Session::get('thang'))
                        ->where('reffsatker_id', request('unik'));

        $base = $base->with(['reffsatker']);
        $this->filterUser($base);
        $this->filterKatagori($base);

        return Datatables::eloquent($base)->toJson();
    }

    public function apiPaguBaseline3()
    {
        $pagu = pagu::where('thang', Session::get('thang'))
                    ->where('reffsatker_id', request('unik'));

        $pagu = $pagu->with(['reffsatker']);
        $this->filterUser($pagu);
        $this->filterKatagori($pagu);

        return Datatables::eloquent($pagu)
            ->addColumn('action', function($pagu){
                $btn =   '<button type="button" class="btn btn-info ml-0 mb-0" type="button" title="Gunakan Data" onclick="use(\''.$pagu->id.'\')" style="padding: 8px 13px;"><i class="fas fa-arrow-down"></i></button>';  

                return $btn;
            })

        ->rawColumns(['action'])
        ->toJson();
    }

    public function apiDakungBaseline3()
    {
        $base = Baseline::select(
                                    'reffsatker_id',
                                    'kdunit',
                                    'kdprogram',
                                    'kdgiat',
                                    'kdoutput',
                                    'kdsoutput',
                                    'kdkmpnen',
                                    DB::raw('SUM(jumlah) as total') 
                                )
                        ->where('thang', Session::get('thang'))
                        ->where('reffsatker_id', request('unik'))
                        ->groupBy('reffsatker_id', 'kdunit', 'kdprogram', 'kdgiat', 'kdoutput', 'kdsoutput', 'kdkmpnen');

        $base = $base->with(['reffsatker']);
        $this->filterUser($base);
        $this->filterKatagori($base);

        return Datatables::eloquent($base)
            ->addColumn('file', function($base){
                $unik = $base->reffsatker_id.$base->kdunit.$base->kdprogram.$base->kdgiat.$base->kdoutput.$base->kdsoutput.$base->kdkmpnen;
                $files = BaselineDakung::where('id', $unik)->first();

                if(!empty($files)){
                    $btn =  '
                                <a href="'.asset('storage/Dokumen_baseline/'.$unik.'/'.$files->fileTor).'" data-toggle="tooltip" data-placement="top" title="File TOR" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_baseline/'.$unik.'/'.$files->fileRab).'" data-toggle="tooltip" data-placement="top" title="File RAB" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                                <a href="'.asset('storage/Dokumen_baseline/'.$unik.'/'.$files->fileLainnya).'" data-toggle="tooltip" data-placement="top" title="File Lainnya" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                                </a>
                            ';
                } else {
                    $btn =  '
                                <a href="javascript:void(0)" class="btn btn-danger btn-upload ms-0 mb-0" style="padding: 8px 13px;" data-toggle="tooltip" data-placement="top" title="Upload dokumen" ><i class="fa fa-upload" aria-hidden="true"></i></a>
                            ';   
                }

                return $btn;
            })

            ->addColumn('coa', function($base){
                $kode = $base->kdgiat.'.'.$base->kdoutput.'.'.$base->kdsoutput.'.'.$base->kdkmpnen;
                return ($kode);
            })

            ->addColumn('deskripsi', function($base){
                $kode = $base->kdgiat.'.'.$base->kdoutput.'.'.$base->kdsoutput.'.'.$base->kdkmpnen;
                $desk = UraianAnggaran::where('kode', $base->kdgiat.'.'.$base->kdoutput.'.'.$base->kdsoutput.'.'.$base->kdkmpnen)->first();
                if(!empty($desk)){
                    return ($desk->deskripsi);
                } else {
                    return ('-');
                }
            })

        ->rawColumns(['coa', 'deskripsi', 'file'])
        ->toJson();
    }
    // -- END BASELINE 3

// START USULAN KENAIKAN KELAS



// -- START KENAIKAN KELAS PERADILAN AGAMA
    public function apiUsulanKenaikanKelasPa()
    {
        $pa = UsulanKelasPa::orderBy('id', 'desc');

        $pa = $pa->with(['reffsatker']);
        $this->filterUser($pa);
        $this->filterKatagori($pa);

        return Datatables::eloquent($pa)
            ->addColumn('usulan', function($pa){
                return($pa->usul_peningkatan_ke);
            })

            ->addColumn('usulan_ke', function($pa){
                return('Usulan ke '.$pa->usulan_ke);
            })

            ->addColumn('total_cg', function($pa){
                return($pa->jumlah_cg_tahun1+$pa->jumlah_cg_tahun2+$pa->jumlah_cg_tahun3);
            })

            ->addColumn('rata_cg', function($pa){
                $totalcg = $pa->jumlah_cg_tahun1+$pa->jumlah_cg_tahun2+$pa->jumlah_cg_tahun3;
                $rata = $totalcg/3;
                return(round($rata));
            })

            ->addColumn('total_ct', function($pa){
                return($pa->jumlah_cg_tahun1+$pa->jumlah_cg_tahun2+$pa->jumlah_cg_tahun3);
            })

            ->addColumn('rata_ct', function($pa){
                $totalct = $pa->jumlah_ct_tahun1+$pa->jumlah_ct_tahun2+$pa->jumlah_ct_tahun3;
                $rata = $totalct/3;
                return(round($rata));
            })

            ->addColumn('total_p', function($pa){
                return($pa->jumlah_p_tahun1+$pa->jumlah_p_tahun2+$pa->jumlah_p_tahun3);
            })

            ->addColumn('rata_p', function($pa){
                $totalp = $pa->jumlah_p_tahun1+$pa->jumlah_p_tahun2+$pa->jumlah_p_tahun3;
                $rata = $totalp/3;
                return(round($rata));
            })
            
            ->addColumn('aksi', function($pa){
                $btn =  '   <a href="'.route('usulan.kenaikankelaspa.show', Crypt::encrypt($pa->id)).'" class="btn btn-sm btn-info ms-0 mb-0" title="Detail">
                                <i class="fa fa-eye" style="font-size: 12px; line-height: 12px;"></i>
                            </a>
                            <!--
                            <button type="button" rel="tooltip" class="btn btn-sm btn-danger ms-0 mb-0" data-original-title="Hapus" title="Hapus" onclick="deleteData(\''.$pa->id.'\')">
                                <i class="fa fa-trash" style="font-size: 12px; line-height: 12px;"></i>
                            </button>
                            -->
                        '; 

                return $btn;
            })

        ->rawColumns([
                        'usulan',
                        'usulan_ke',
                        'total_cg',
                        'rata_cg',
                        'total_ct',
                        'rata_ct',
                        'total_p',
                        'rata_p',
                    ])
        ->toJson();
    }
// -- END KENAIKAN KELAS PERADILAN AGAMA

// -- START KENAIKAN KELAS PERADILAN UMUM

// -- END KENAIKAN KELAS PERADILAN UMUM


// -- ABT START
    public function apiUsulanAbt()
    {
        $abt = abt_usulan::whereYear('tanggal_surat', '=', date('Y'));

        $abt = $abt->with(['reffsatker']);
        $this->filterUser($abt);
        $this->filterKatagori($abt);

        return Datatables::eloquent($abt)
            ->addColumn('tpegawai', function($abt){
                $totals = abt_items::where('unik', $abt->unik)
                                    ->where('kdakun','LIKE','51%')
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('tbarang', function($abt){
                $totals = abt_items::where('unik', $abt->unik)
                                    ->where('kdakun','LIKE','52%')
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('tmodal', function($abt){
                $totals = abt_items::where('unik', $abt->unik)
                                    ->where('kdakun','LIKE','53%')
                                    ->sum('jumlah');
                return($totals);
            })

            ->addColumn('file', function($abt){
                $btn =  '
                            <a href="" data-toggle="tooltip" data-placement="top" title="File TOR" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                            </a>
                            <a href="" data-toggle="tooltip" data-placement="top" title="File RAB" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                            </a>
                            <a href="" data-toggle="tooltip" data-placement="top" title="Lampiran" style="margin-left: 5px;" target="_blank"><i class="fa fa-file-pdf-o fa-2x text-success" aria-hidden="true"></i>
                            </a>
                        ';
                return $btn;
            })

            ->addColumn('aksi', function($abt){
                $btn =   '<a href="'.route('abt.show', $abt->unik).'" class="btn bg-gradient-info ml-0 mb-0" title="Lihat Data" style="padding: 5px 8px;"><i class="fas fa-eye"></i></a>';
                return $btn;
            })

        ->rawColumns(['tpegawai', 'tbarang', 'tmodal', 'file', 'aksi'])
        ->toJson();
    }

    public function apiPaguAbt()
    {
        $pagu = pagu::where('thang', Session::get('thang'));

        $pagu = $pagu->with(['reffsatker']);
        $this->filterUser($pagu);
        $this->filterKatagori($pagu);

        return Datatables::eloquent($pagu)
            ->addColumn('action', function($pagu){
                $btn =   '<button type="button" class="btn btn-info ml-0 mb-0" type="button" title="Gunakan Data" onclick="use(\''.$pagu->id.'\')" style="padding: 8px 13px;"><i class="fas fa-plus"></i></button>';  

                return $btn;
            })

        ->rawColumns(['action'])
        ->toJson();
    }

    public function apiItemsAbt($unik)
    {
        $abt = abt_items::where('unik', $unik);

        $abt = $abt->with(['reffsatker']);
        $this->filterUser($abt);
        $this->filterKatagori($abt);

        return Datatables::eloquent($abt)
            ->addColumn('action', function($abt){
                $btn =   '<button type="button" class="btn btn-info ml-0 mb-0" type="button" title="Gunakan Data" onclick="use(\''.$abt->id.'\')" style="padding: 8px 13px;"><i class="fas fa-arrow-down"></i></button>';  

                return $btn;
            })

        ->rawColumns(['action'])
        ->toJson();
    }
// -- ABT END

    public function apiBelanjaBarang()
    {
        $belanjabarangs = pagu::where('thang', Session::get('thang'));

        $belanjabarangs = $belanjabarangs->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'reff_bas'])->where('kdakun','LIKE','52%');
        $this->filterUser($belanjabarangs);
        $this->filterKatagori($belanjabarangs);

        return Datatables::eloquent($belanjabarangs)
                         ->addColumn('rincian', function ($belanjabarangs) {
                            return ($belanjabarangs->kdprogram.'.'.$belanjabarangs->kdgiat.'.'.$belanjabarangs->kdoutput.'.'.$belanjabarangs->kdsoutput.'.'.$belanjabarangs->kdkmpnen.'.'.$belanjabarangs->kdskmpnen.'.'.$belanjabarangs->kdakun.'.'.$belanjabarangs->noitem);
                         })
                        ->addColumn('action', function($belanjabarangs){
       
                           $btn =   '<a href="' . route('belanjabarang.show', Crypt::encrypt($belanjabarangs->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                        //    $btn = $btn.'<a href="' . route('belanjabarang.edit', Crypt::encrypt($belanjabarangs->id)) .'" class="btn btn-success btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-edit fa-xs"></i></a>';
                        //    $btn = $btn.'<a href="' . route('belanjabarang.destroy', Crypt::encrypt($belanjabarangs->id)) .'" class="btn btn-danger btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:void(0);"><i class="fa fa-trash fa-xs"></i></a>';             
                            return $btn;
                        })
                        ->rawColumns(['action','kdsirup','metodesirup','kdlpse','koderup'])
                        ->toJson();
        
    }

    public function apiBelanjaPegawai()
    {
        $belanjapegawais = pagu::where('thang', Session::get('thang'));

        $belanjapegawais = $belanjapegawais->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'reff_bas'])->where('kdakun','LIKE','51%');
        $this->filterUser($belanjapegawais);
        $this->filterKatagori($belanjapegawais);

        return Datatables::eloquent($belanjapegawais)
                         ->addColumn('rincian', function ($belanjapegawais) {
                            return ($belanjapegawais->kdprogram.'.'.$belanjapegawais->kdgiat.'.'.$belanjapegawais->kdoutput.'.'.$belanjapegawais->kdsoutput.'.'.$belanjapegawais->kdkmpnen.'.'.$belanjapegawais->kdskmpnen.'.'.$belanjapegawais->kdakun.'.'.$belanjapegawais->noitem);
                         })
                        ->addColumn('action', function($belanjapegawais){
       
                           $btn =   '<a href="' . route('belanjapegawai.show', Crypt::encrypt($belanjapegawais->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                        //    $btn = $btn.'<a href="' . route('belanjapegawai.edit', Crypt::encrypt($belanjapegawais->id)) .'" class="btn btn-success btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-edit fa-xs"></i></a>';
                        //    $btn = $btn.'<a href="' . route('belanjapegawai.destroy', Crypt::encrypt($belanjapegawais->id)) .'" class="btn btn-danger btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:void(0);"><i class="fa fa-trash fa-xs"></i></a>';             
                            return $btn;
                        })
                        ->rawColumns(['action','rincian'])
                        ->toJson();
        
    }

    public function apiPaguRevisi()
    {
        $paguRevisi = pagu_revisi::where('thang', Session::get('thang'));

        $paguRevisi = $paguRevisi->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'reff_bas']);
        $this->filterUser($paguRevisi);
        $this->filterKatagori($paguRevisi);

        $paguRevisi->when(request('filter_akun'), function ($akun) {
            return $akun->where('kdakun','LIKE',request('filter_akun')."%");
        });

        return Datatables::eloquent($paguRevisi)
                         ->addColumn('rincian', function ($paguRevisi) {
                            return ($paguRevisi->kdprogram.'.'.$paguRevisi->kdgiat.'.'.$paguRevisi->kdoutput.'.'.$paguRevisi->kdsoutput.'.'.$paguRevisi->kdkmpnen.'.'.$paguRevisi->kdskmpnen.'.'.$paguRevisi->kdakun.'.'.$paguRevisi->noitem);
                         })
                        ->toJson();
    }


    public function apiDataBelanjaBarang()
    {
        $databelanjabarangs = databelanjabarang::whereYear('tanggal_kwitansi', '=', Session::get('thang'));

        $databelanjabarangs = $databelanjabarangs->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'databelanjabarang_lampiran', 'reff_bas']);
        $this->filterUser($databelanjabarangs);
        $this->filterKatagori($databelanjabarangs);

        return Datatables::eloquent($databelanjabarangs)

                        ->addColumn('action', function($databelanjabarangs){
                            $btn =   '<a href="' . route('databelanjabarang.show', Crypt::encrypt($databelanjabarangs->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                            return $btn;
                        })
                        ->addColumn('lampiran', function($databelanjabarangs){
                            if ($databelanjabarangs->databelanjabarang_lampiran != null){
                                $btn =   '<a href="'.url('storage/Dokumen UP-TUP/'.Carbon::parse($databelanjabarangs->tanggal_kwitansi)->translatedFormat('Y')."/".$databelanjabarangs->reffsatker_id."-".$databelanjabarangs->reffsatker->nama_satker."/".Carbon::parse($databelanjabarangs->tanggal_kwitansi)->translatedFormat('m')."/".$databelanjabarangs->databelanjabarang_lampiran->lampiran).'" target="_blank">'. $databelanjabarangs->no_kwitansi .'</a>';
                            }else{
                                $btn = null;

                            }
                            return $btn;
                        })
                        ->rawColumns(['action','lampiran'])
                        ->toJson();
    }

    // rekap dengan withcount
    // public function apiRekapDataBelanjaBarang()
    // {
    //     $rekap = reffsatker::select('id','nama_satker_lengkap')
    //                                     // begin total data kuitansi yang di upload
    //                                     ->withCount(['databelanjabarang as unitJanuari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','01');
    //                                     }, 'databelanjabarang as unitFebruari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','02');
    //                                     }, 'databelanjabarang as unitMaret' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','03');
    //                                     }, 'databelanjabarang as unitApril' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','04');
    //                                     }, 'databelanjabarang as unitmei' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','05');
    //                                     }, 'databelanjabarang as unitJuni' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','06');
    //                                     }, 'databelanjabarang as unitJuli' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','07');
    //                                     }, 'databelanjabarang as unitAgustus' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','08');
    //                                     }, 'databelanjabarang as unitSeptember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','09');
    //                                     }, 'databelanjabarang as unitOktober' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','10');
    //                                     }, 'databelanjabarang as unitNovember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','11');
    //                                     }, 'databelanjabarang as unitDesember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','12');
    //                                     },
    //                                     // end total data kuitansi yang di upload
    //                                     // begin total nilai data kuitansi yang di upload
    //                                         'databelanjabarang as totalJanuari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','01')->select(DB::raw('sum(nilai) as totalJanuari'));
    //                                     }, 'databelanjabarang as totalFebruari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','02')->select(DB::raw('sum(nilai) as totalFebruari'));
    //                                     }, 'databelanjabarang as totalMaret' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','03')->select(DB::raw('sum(nilai) as totalMaret'));
    //                                     }, 'databelanjabarang as totalApril' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','04')->select(DB::raw('sum(nilai) as totalApril'));
    //                                     }, 'databelanjabarang as totalMei' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','05')->select(DB::raw('sum(nilai) as totalMei'));
    //                                     }, 'databelanjabarang as totalJuni' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','06')->select(DB::raw('sum(nilai) as totalJuni'));
    //                                     }, 'databelanjabarang as totalJuli' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','07')->select(DB::raw('sum(nilai) as totalJuli'));
    //                                     }, 'databelanjabarang as totalAgustus' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','08')->select(DB::raw('sum(nilai) as totalAgustus'));
    //                                     }, 'databelanjabarang as totalSeptember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','09')->select(DB::raw('sum(nilai) as totalSeptember'));
    //                                     }, 'databelanjabarang as totalOktober' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','10')->select(DB::raw('sum(nilai) as totalOktober'));
    //                                     }, 'databelanjabarang as totalNovember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','11')->select(DB::raw('sum(nilai) as totalNovember'));
    //                                     }, 'databelanjabarang as totalDesember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','12')->select(DB::raw('sum(nilai) as totalDesember'));
    //                                     }, 
    //                                     // end total nilai data kuitansi yang di upload
    //                                     // begin total data kuitansi yang di upload dan sudah memiliki lampiran
    //                                         'databelanjabarang as unitLampiranJanuari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','01')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranFebruari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','02')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranMaret' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','03')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranApril' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','04')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranmei' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','05')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranJuni' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','06')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranJuli' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','07')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranAgustus' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','08')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranSeptember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','09')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranOktober' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','10')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranNovember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','11')->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as unitLampiranDesember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','12')->whereHas('databelanjabarang_lampiran');
    //                                     },
    //                                     // end total data kuitansi yang di upload dan sudah memiliki lampiran
    //                                     // begin total nilai data kuitansi yang di upload dan sudah memiliki lampiran
    //                                         'databelanjabarang as totalLampiranJanuari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','01')->select(DB::raw('sum(nilai) as totalLampiranJanuari'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranFebruari' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','02')->select(DB::raw('sum(nilai) as totalLampiranFebruari'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranMaret' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','03')->select(DB::raw('sum(nilai) as totalLampiranMaret'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranApril' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','04')->select(DB::raw('sum(nilai) as totalLampiranApril'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranMei' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','05')->select(DB::raw('sum(nilai) as totalLampiranMei'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranJuni' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','06')->select(DB::raw('sum(nilai) as totalLampiranJuni'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranJuli' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','07')->select(DB::raw('sum(nilai) as totalLampiranJuli'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranAgustus' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','08')->select(DB::raw('sum(nilai) as totalLampiranAgustus'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranSeptember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','09')->select(DB::raw('sum(nilai) as totalLampiranSeptember'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranOktober' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','10')->select(DB::raw('sum(nilai) as totalLampiranOktober'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranNovember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','11')->select(DB::raw('sum(nilai) as totalLampiranNovember'))->whereHas('databelanjabarang_lampiran');
    //                                     }, 'databelanjabarang as totalLampiranDesember' => function($query){
    //                                         $query->whereMonth('tanggal_kwitansi','=','12')->select(DB::raw('sum(nilai) as totalLampiranDesember'))->whereHas('databelanjabarang_lampiran');
    //                                     }
    //                                     // end total nilai data kuitansi yang di upload dan sudah memiliki lampiran

    //                                 ]);

    //     $this->filterUserReffSatker($rekap);
    //     $this->filterKatagoriReffSatker($rekap);

    //     return Datatables::eloquent($rekap)

    //                     ->addColumn('januari', function($rekap){
    //                         $belumUnitLampiranJanuari = $rekap->unitJanuari - $rekap->unitLampiranJanuari;
    //                         $belumTotalLampiranJanuari = $rekap->totalJanuari - $rekap->totalLampiranJanuari;
                            
    //                         if($rekap->unitJanuari > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitJanuari.' Kuitansi, nilai Rp.'.number_format($rekap->totalJanuari).'&#013Upload Lampiran '.$rekap->unitLampiranJanuari.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranJanuari).'&#013Belum Upload Lampiran '.$belumUnitLampiranJanuari.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranJanuari).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('februari', function($rekap){
    //                         $belumUnitLampiranFebruari = $rekap->unitFebruari - $rekap->unitLampiranFebruari;
    //                         $belumTotalLampiranFebruari = $rekap->totalFebruari - $rekap->totalLampiranFebruari;
                            
    //                         if($rekap->unitFebruari > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitFebruari.' Kuitansi, nilai Rp.'.number_format($rekap->totalFebruari).'&#013Upload Lampiran '.$rekap->unitLampiranFebruari.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranFebruari).'&#013Belum Upload Lampiran '.$belumUnitLampiranFebruari.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranFebruari).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('maret', function($rekap){
    //                         $belumUnitLampiranMaret = $rekap->unitMaret - $rekap->unitLampiranMaret;
    //                         $belumTotalLampiranMaret = $rekap->totalMaret - $rekap->totalLampiranMaret;
                            
    //                         if($rekap->unitMaret > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitMaret.' Kuitansi, nilai Rp.'.number_format($rekap->totalMaret).'&#013Upload Lampiran '.$rekap->unitLampiranMaret.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranMaret).'&#013Belum Upload Lampiran '.$belumUnitLampiranMaret.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranMaret).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('april', function($rekap){
    //                         $belumUnitLampiranApril = $rekap->unitApril - $rekap->unitLampiranApril;
    //                         $belumTotalLampiranApril = $rekap->totalApril - $rekap->totalLampiranApril;
                            
    //                         if($rekap->unitApril > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitApril.' Kuitansi, nilai Rp.'.number_format($rekap->totalApril).'&#013Upload Lampiran '.$rekap->unitLampiranApril.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranApril).'&#013Belum Upload Lampiran '.$belumUnitLampiranApril.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranApril).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('mei', function($rekap){
    //                         $belumUnitLampiranMei = $rekap->unitMei - $rekap->unitLampiranMei;
    //                         $belumTotalLampiranMei = $rekap->totalMei - $rekap->totalLampiranMei;
                            
    //                         if($rekap->unitMei > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitMei.' Kuitansi, nilai Rp.'.number_format($rekap->totalMei).'&#013Upload Lampiran '.$rekap->unitLampiranMei.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranMei).'&#013Belum Upload Lampiran '.$belumUnitLampiranMei.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranMei).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('juni', function($rekap){
    //                         $belumUnitLampiranJuni = $rekap->unitJuni - $rekap->unitLampiranJuni;
    //                         $belumTotalLampiranJuni = $rekap->totalJuni - $rekap->totalLampiranJuni;
                            
    //                         if($rekap->unitJuni > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitJuni.' Kuitansi, nilai Rp.'.number_format($rekap->totalJuni).'&#013Upload Lampiran '.$rekap->unitLampiranJuni.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranJuni).'&#013Belum Upload Lampiran '.$belumUnitLampiranJuni.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranJuni).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('juli', function($rekap){
    //                         $belumUnitLampiranJuli = $rekap->unitJuli - $rekap->unitLampiranJuli;
    //                         $belumTotalLampiranJuli = $rekap->totalJuli - $rekap->totalLampiranJuli;
                            
    //                         if($rekap->unitJuli > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitJuli.' Kuitansi, nilai Rp.'.number_format($rekap->totalJuli).'&#013Upload Lampiran '.$rekap->unitLampiranJuli.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranJuli).'&#013Belum Upload Lampiran '.$belumUnitLampiranJuli.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranJuli).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('agustus', function($rekap){
    //                         $belumUnitLampiranAgustus = $rekap->unitAgustus - $rekap->unitLampiranAgustus;
    //                         $belumTotalLampiranAgustus = $rekap->totalAgustus - $rekap->totalLampiranAgustus;
                            
    //                         if($rekap->unitAgustus > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitAgustus.' Kuitansi, nilai Rp.'.number_format($rekap->totalAgustus).'&#013Upload Lampiran '.$rekap->unitLampiranAgustus.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranAgustus).'&#013Belum Upload Lampiran '.$belumUnitLampiranAgustus.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranAgustus).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('september', function($rekap){
    //                         $belumUnitLampiranSeptember = $rekap->unitSeptember - $rekap->unitLampiranSeptember;
    //                         $belumTotalLampiranSeptember = $rekap->totalSeptember - $rekap->totalLampiranSeptember;
                            
    //                         if($rekap->unitSeptember > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitSeptember.' Kuitansi, nilai Rp.'.number_format($rekap->totalSeptember).'&#013Upload Lampiran '.$rekap->unitLampiranSeptember.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranSeptember).'&#013Belum Upload Lampiran '.$belumUnitLampiranSeptember.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranSeptember).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('oktober', function($rekap){
    //                         $belumUnitLampiranOktober = $rekap->unitOktober - $rekap->unitLampiranOktober;
    //                         $belumTotalLampiranOktober = $rekap->totalOktober - $rekap->totalLampiranOktober;
                            
    //                         if($rekap->unitOktober > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitOktober.' Kuitansi, nilai Rp.'.number_format($rekap->totalOktober).'&#013Upload Lampiran '.$rekap->unitLampiranOktober.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranOktober).'&#013Belum Upload Lampiran '.$belumUnitLampiranOktober.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranOktober).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('november', function($rekap){
    //                         $belumUnitLampiranNovember = $rekap->unitNovember - $rekap->unitLampiranNovember;
    //                         $belumTotalLampiranNovember = $rekap->totalNovember - $rekap->totalLampiranNovember;
                            
    //                         if($rekap->unitNovember > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitNovember.' Kuitansi, nilai Rp.'.number_format($rekap->totalNovember).'&#013Upload Lampiran '.$rekap->unitLampiranNovember.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranNovember).'&#013Belum Upload Lampiran '.$belumUnitLampiranNovember.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranNovember).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })
    //                     ->addColumn('desember', function($rekap){
    //                         $belumUnitLampiranDesember = $rekap->unitDesember - $rekap->unitLampiranDesember;
    //                         $belumTotalLampiranDesember = $rekap->totalDesember - $rekap->totalLampiranDesember;
                            
    //                         if($rekap->unitDesember > 0  ){
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$rekap->unitDesember.' Kuitansi, nilai Rp.'.number_format($rekap->totalDesember).'&#013Upload Lampiran '.$rekap->unitLampiranDesember.' Kuitansi, nilai Rp.'.number_format($rekap->totalLampiranDesember).'&#013Belum Upload Lampiran '.$belumUnitLampiranDesember.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranDesember).'" ><i class="fa fa-check fa-sm"></i></a>';
    //                         }else{
    //                             $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
    //                         }
    //                         return $btn;
    //                     })


    //                     ->rawColumns(['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'])
    //                     ->toJson();
    // }

    public function apiRekapDataBelanjaBarang()
    {
        $rekap = reffsatker::with(['databelanjabarang' => function($query) {
                                                $query->select('id','reffsatker_id','tanggal_kwitansi','nilai')->whereYear('tanggal_kwitansi', '=', Session::get('thang'));
                                            },
                                    'databelanjabarang.databelanjabarang_lampiran' => function($query){
                                                $query->select('id','databelanjabarang_id');
                                            }
                                        ])->select('id','nama_satker_lengkap');

        $this->filterUserReffSatker($rekap);
        $this->filterKatagoriReffSatker($rekap);

        return Datatables::eloquent($rekap)

                        ->addColumn('januari', function($rekap){
                            $unitJanuari = 0;
                            $totalJanuari = 0;
                            $unitLampiranJanuari = 0;
                            $totalLampiranJanuari = 0;
                            $belumUnitLampiranJanuari = 0;
                            $belumTotalLampiranJanuari = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-01-01', ''.Session::get('thang').'-01-31')) as $databelanjabarang)
                            {
                                $unitJanuari += 1;
                                $totalJanuari += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranJanuari += 1;
                                    $totalLampiranJanuari += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranJanuari = $unitJanuari - $unitLampiranJanuari;
                                $belumTotalLampiranJanuari = $totalJanuari - $totalLampiranJanuari;

                            }
                            
                            if($unitJanuari > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitJanuari.' Kuitansi, nilai Rp.'.number_format($totalJanuari).'&#013Upload Lampiran '.$unitLampiranJanuari.' Kuitansi, nilai Rp.'.number_format($totalLampiranJanuari).'&#013Belum Upload Lampiran '.$belumUnitLampiranJanuari.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranJanuari).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('februari', function($rekap){
                            $unitFebruari = 0;
                            $totalFebruari = 0;
                            $unitLampiranFebruari = 0;
                            $totalLampiranFebruari = 0;
                            $belumUnitLampiranFebruari = 0;
                            $belumTotalLampiranFebruari = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-02-01', ''.Session::get('thang').'-02-31')) as $databelanjabarang)
                            {
                                $unitFebruari += 1;
                                $totalFebruari += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranFebruari += 1;
                                    $totalLampiranFebruari += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranFebruari = $unitFebruari - $unitLampiranFebruari;
                                $belumTotalLampiranFebruari = $totalFebruari - $totalLampiranFebruari;

                            }
                            
                            if($unitFebruari > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitFebruari.' Kuitansi, nilai Rp.'.number_format($totalFebruari).'&#013Upload Lampiran '.$unitLampiranFebruari.' Kuitansi, nilai Rp.'.number_format($totalLampiranFebruari).'&#013Belum Upload Lampiran '.$belumUnitLampiranFebruari.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranFebruari).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('maret', function($rekap){
                            $unitMaret = 0;
                            $totalMaret = 0;
                            $unitLampiranMaret = 0;
                            $totalLampiranMaret = 0;
                            $belumUnitLampiranMaret = 0;
                            $belumTotalLampiranMaret = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-03-01', ''.Session::get('thang').'-03-31')) as $databelanjabarang)
                            {
                                $unitMaret += 1;
                                $totalMaret += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranMaret += 1;
                                    $totalLampiranMaret += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranMaret = $unitMaret - $unitLampiranMaret;
                                $belumTotalLampiranMaret = $totalMaret - $totalLampiranMaret;

                            }
                            
                            if($unitMaret > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitMaret.' Kuitansi, nilai Rp.'.number_format($totalMaret).'&#013Upload Lampiran '.$unitLampiranMaret.' Kuitansi, nilai Rp.'.number_format($totalLampiranMaret).'&#013Belum Upload Lampiran '.$belumUnitLampiranMaret.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranMaret).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('april', function($rekap){
                            $unitApril = 0;
                            $totalApril = 0;
                            $unitLampiranApril = 0;
                            $totalLampiranApril = 0;
                            $belumUnitLampiranApril = 0;
                            $belumTotalLampiranApril = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-04-01', ''.Session::get('thang').'-04-31')) as $databelanjabarang)
                            {
                                $unitApril += 1;
                                $totalApril += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranApril += 1;
                                    $totalLampiranApril += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranApril = $unitApril - $unitLampiranApril;
                                $belumTotalLampiranApril = $totalApril - $totalLampiranApril;

                            }
                            
                            if($unitApril > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitApril.' Kuitansi, nilai Rp.'.number_format($totalApril).'&#013Upload Lampiran '.$unitLampiranApril.' Kuitansi, nilai Rp.'.number_format($totalLampiranApril).'&#013Belum Upload Lampiran '.$belumUnitLampiranApril.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranApril).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('mei', function($rekap){
                            $unitMei = 0;
                            $totalMei = 0;
                            $unitLampiranMei = 0;
                            $totalLampiranMei = 0;
                            $belumUnitLampiranMei = 0;
                            $belumTotalLampiranMei = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-05-01', ''.Session::get('thang').'-05-31')) as $databelanjabarang)
                            {
                                $unitMei += 1;
                                $totalMei += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranMei += 1;
                                    $totalLampiranMei += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranMei = $unitMei - $unitLampiranMei;
                                $belumTotalLampiranMei = $totalMei - $totalLampiranMei;

                            }
                            
                            if($unitMei > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitMei.' Kuitansi, nilai Rp.'.number_format($totalMei).'&#013Upload Lampiran '.$unitLampiranMei.' Kuitansi, nilai Rp.'.number_format($totalLampiranMei).'&#013Belum Upload Lampiran '.$belumUnitLampiranMei.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranMei).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('juni', function($rekap){
                            $unitJuni = 0;
                            $totalJuni = 0;
                            $unitLampiranJuni = 0;
                            $totalLampiranJuni = 0;
                            $belumUnitLampiranJuni = 0;
                            $belumTotalLampiranJuni = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-06-01', ''.Session::get('thang').'-06-31')) as $databelanjabarang)
                            {
                                $unitJuni += 1;
                                $totalJuni += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranJuni += 1;
                                    $totalLampiranJuni += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranJuni = $unitJuni - $unitLampiranJuni;
                                $belumTotalLampiranJuni = $totalJuni - $totalLampiranJuni;

                            }
                            
                            if($unitJuni > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitJuni.' Kuitansi, nilai Rp.'.number_format($totalJuni).'&#013Upload Lampiran '.$unitLampiranJuni.' Kuitansi, nilai Rp.'.number_format($totalLampiranJuni).'&#013Belum Upload Lampiran '.$belumUnitLampiranJuni.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranJuni).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('juli', function($rekap){
                            $unitJuli = 0;
                            $totalJuli = 0;
                            $unitLampiranJuli = 0;
                            $totalLampiranJuli = 0;
                            $belumUnitLampiranJuli = 0;
                            $belumTotalLampiranJuli = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-07-01', ''.Session::get('thang').'-07-31')) as $databelanjabarang)
                            {
                                $unitJuli += 1;
                                $totalJuli += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranJuli += 1;
                                    $totalLampiranJuli += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranJuli = $unitJuli - $unitLampiranJuli;
                                $belumTotalLampiranJuli = $totalJuli - $totalLampiranJuli;

                            }
                            
                            if($unitJuli > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitJuli.' Kuitansi, nilai Rp.'.number_format($totalJuli).'&#013Upload Lampiran '.$unitLampiranJuli.' Kuitansi, nilai Rp.'.number_format($totalLampiranJuli).'&#013Belum Upload Lampiran '.$belumUnitLampiranJuli.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranJuli).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('agustus', function($rekap){
                            $unitAgustus = 0;
                            $totalAgustus = 0;
                            $unitLampiranAgustus = 0;
                            $totalLampiranAgustus = 0;
                            $belumUnitLampiranAgustus = 0;
                            $belumTotalLampiranAgustus = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-08-01', ''.Session::get('thang').'-08-31')) as $databelanjabarang)
                            {
                                $unitAgustus += 1;
                                $totalAgustus += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranAgustus += 1;
                                    $totalLampiranAgustus += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranAgustus = $unitAgustus - $unitLampiranAgustus;
                                $belumTotalLampiranAgustus = $totalAgustus - $totalLampiranAgustus;

                            }
                            
                            if($unitAgustus > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitAgustus.' Kuitansi, nilai Rp.'.number_format($totalAgustus).'&#013Upload Lampiran '.$unitLampiranAgustus.' Kuitansi, nilai Rp.'.number_format($totalLampiranAgustus).'&#013Belum Upload Lampiran '.$belumUnitLampiranAgustus.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranAgustus).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('september', function($rekap){
                            $unitSeptember = 0;
                            $totalSeptember = 0;
                            $unitLampiranSeptember = 0;
                            $totalLampiranSeptember = 0;
                            $belumUnitLampiranSeptember = 0;
                            $belumTotalLampiranSeptember = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-09-01', ''.Session::get('thang').'-09-31')) as $databelanjabarang)
                            {
                                $unitSeptember += 1;
                                $totalSeptember += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranSeptember += 1;
                                    $totalLampiranSeptember += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranSeptember = $unitSeptember - $unitLampiranSeptember;
                                $belumTotalLampiranSeptember = $totalSeptember - $totalLampiranSeptember;

                            }
                            
                            if($unitSeptember > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitSeptember.' Kuitansi, nilai Rp.'.number_format($totalSeptember).'&#013Upload Lampiran '.$unitLampiranSeptember.' Kuitansi, nilai Rp.'.number_format($totalLampiranSeptember).'&#013Belum Upload Lampiran '.$belumUnitLampiranSeptember.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranSeptember).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('oktober', function($rekap){
                            $unitOktober = 0;
                            $totalOktober = 0;
                            $unitLampiranOktober = 0;
                            $totalLampiranOktober = 0;
                            $belumUnitLampiranOktober = 0;
                            $belumTotalLampiranOktober = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-10-01', ''.Session::get('thang').'-10-31')) as $databelanjabarang)
                            {
                                $unitOktober += 1;
                                $totalOktober += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranOktober += 1;
                                    $totalLampiranOktober += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranOktober = $unitOktober - $unitLampiranOktober;
                                $belumTotalLampiranOktober = $totalOktober - $totalLampiranOktober;

                            }
                            
                            if($unitOktober > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitOktober.' Kuitansi, nilai Rp.'.number_format($totalOktober).'&#013Upload Lampiran '.$unitLampiranOktober.' Kuitansi, nilai Rp.'.number_format($totalLampiranOktober).'&#013Belum Upload Lampiran '.$belumUnitLampiranOktober.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranOktober).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('november', function($rekap){
                            $unitNovember = 0;
                            $totalNovember = 0;
                            $unitLampiranNovember = 0;
                            $totalLampiranNovember = 0;
                            $belumUnitLampiranNovember = 0;
                            $belumTotalLampiranNovember = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-11-01', ''.Session::get('thang').'-11-31')) as $databelanjabarang)
                            {
                                $unitNovember += 1;
                                $totalNovember += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranNovember += 1;
                                    $totalLampiranNovember += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranNovember = $unitNovember - $unitLampiranNovember;
                                $belumTotalLampiranNovember = $totalNovember - $totalLampiranNovember;

                            }
                            
                            if($unitNovember > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitNovember.' Kuitansi, nilai Rp.'.number_format($totalNovember).'&#013Upload Lampiran '.$unitLampiranNovember.' Kuitansi, nilai Rp.'.number_format($totalLampiranNovember).'&#013Belum Upload Lampiran '.$belumUnitLampiranNovember.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranNovember).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })
                        ->addColumn('desember', function($rekap){
                            $unitDesember = 0;
                            $totalDesember = 0;
                            $unitLampiranDesember = 0;
                            $totalLampiranDesember = 0;
                            $belumUnitLampiranDesember = 0;
                            $belumTotalLampiranDesember = 0;

                            foreach($rekap->databelanjabarang->whereBetween('tanggal_kwitansi', array(''.Session::get('thang').'-12-01', ''.Session::get('thang').'-12-31')) as $databelanjabarang)
                            {
                                $unitDesember += 1;
                                $totalDesember += $databelanjabarang->nilai;
                                
                                if($databelanjabarang->databelanjabarang_lampiran)
                                {
                                    $unitLampiranDesember += 1;
                                    $totalLampiranDesember += $databelanjabarang->nilai;
                                }

                                $belumUnitLampiranDesember = $unitDesember - $unitLampiranDesember;
                                $belumTotalLampiranDesember = $totalDesember - $totalLampiranDesember;

                            }
                            
                            if($unitDesember > 0  ){
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: green;" title="Total '.$unitDesember.' Kuitansi, nilai Rp.'.number_format($totalDesember).'&#013Upload Lampiran '.$unitLampiranDesember.' Kuitansi, nilai Rp.'.number_format($totalLampiranDesember).'&#013Belum Upload Lampiran '.$belumUnitLampiranDesember.' Kuitansi, nilai Rp.'.number_format($belumTotalLampiranDesember).'" ><i class="fa fa-check fa-sm"></i></a>';
                            }else{
                                $btn =   '<a class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" style="color: red;" title="Belum Upload" ><i class="fa fa-close fa-sm"></i></a>';
                            }
                            return $btn;
                        })


                        ->rawColumns(['januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember'])
                        ->toJson();
    }


    public function apiDataSpan(Request $request)
    {
        $dataspanPagu = dataspan_pagu::where('thang', Session::get('thang'));
        $dataspanPagu = $dataspanPagu->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'reff_bas','dataspan_realisasi']);
        
        // $dataspanPagu->withSum(['dataspan_realisasi:amount' =>function($query){
        //     $query->where('budget_type', '!=', '7');
        // }]); //bikin server down

        $this->filterUser($dataspanPagu); //filter berdasarkan login
        $this->filterKatagori($dataspanPagu); //filter berdasarkan request katagori

        // Filter Pagu Minus (namun masih lambat untuk memproses nya)
        $dataspanPagu->when(request('filter_paguMinus'), function ($minus) {
            $minus->whereHas('dataspan_realisasi', function($query){
                $query->select(DB::raw('sum(amount) as total'))
                      ->from('dataspan_realisasi')
                      ->havingRaw('total > dataspan_pagu.amount');
            });
            return $minus;
        }); 

        return Datatables::eloquent($dataspanPagu)
                                ->addColumn('amountRealisasi', function($dataspanPagu){
                                    $btn =   '<a href="' . route('dataspan.show', Crypt::encrypt($dataspanPagu->id)) .'"  >'.number_format($dataspanPagu->dataspan_realisasi->whereNotIn('budget_type','7')->sum('amount')).'</a>';
                                    return $btn;
                                    })
                                ->addColumn('amountRealisasi', function($dataspanPagu){
                                    $btn =   '<a href="' . route('dataspan.show', Crypt::encrypt($dataspanPagu->id)) .'"  >'.number_format($dataspanPagu->dataspan_realisasi->whereNotIn('budget_type','7')->sum('amount')).'</a>';
                                    return $btn;
                                    })
                                ->addColumn('selisih', function($dataspanPagu) use ($request){
                                    $sisaPagu = $dataspanPagu->amount - $dataspanPagu->dataspan_realisasi->whereNotIn('budget_type','7')->sum('amount');
                                    return number_format($sisaPagu);
                                    })
                                ->addColumn('amountPengembalian', function($dataspanPagu){
                                    $btn =   '<a href="' . route('dataspan.show', Crypt::encrypt($dataspanPagu->id)) .'"  >'.number_format($dataspanPagu->dataspan_realisasi->where('budget_type', '7')->sum('amount')).'</a>';
                                    return $btn;
                                    })
                                ->filterColumn('selisih', function ($dataspanPagu) use ($request){
                                    if ($request->get('filter_paguMinus') == 'true'){
                                        // $sisaPagu = $dataspanPagu->amount - $dataspanPagu->dataspan_realisasi->whereNotIn('budget_type','7')->sum('amount');

                                        $dataspanPagu->where('amount','<','0');
                                        return $dataspanPagu;
                                    }
                                })
                                ->rawColumns(['amountRealisasi','amountPengembalian'])
                                ->toJson();
    }

    public function apiDataSpanBUA(Request $request)
    {
        $dataspanPagu = dataspan_pagu::where('thang', Session::get('thang'));

        $dataspanPagu = $dataspanPagu->with(['reffsatker','reff_bas','dataspan_realisasi'])->where('reffsatker_id','663157')->orderBy('kegiatan');
        
        $this->filterUser($dataspanPagu); //filter berdasarkan login
        $this->filterKatagori($dataspanPagu); //filter berdasarkan request katagori

        return Datatables::eloquent($dataspanPagu)
                                ->addColumn('amountRealisasi', function($dataspanPagu){
                                    $btn =   '<a href="' . route('dataspan.show', Crypt::encrypt($dataspanPagu->id)) .'"  >'.number_format($dataspanPagu->dataspan_realisasi->whereNotIn('budget_type','7')->sum('amount')).'</a>';
                                    return $btn;
                                    })
                                ->addColumn('selisih', function($dataspanPagu) use ($request){
                                    $sisaPagu = $dataspanPagu->amount - $dataspanPagu->dataspan_realisasi->whereNotIn('budget_type','7')->sum('amount');
                                    return number_format($sisaPagu);
                                    })
                                ->addColumn('amountPengembalian', function($dataspanPagu){
                                    $btn =   '<a href="' . route('dataspan.show', Crypt::encrypt($dataspanPagu->id)) .'"  >'.number_format($dataspanPagu->dataspan_realisasi->where('budget_type', '7')->sum('amount')).'</a>';
                                    return $btn;
                                    })
                                ->addColumn('namaBiro', function($dataspanPagu){

                                    switch ($dataspanPagu->kegiatan) {
                                        case '1064':
                                        $btn =   'Biro Hukum dan Humas';
                                            break;
                                        case '1065':
                                        $btn =   'Biro Kepegawaian';
                                            break;
                                        case '1066':
                                        $btn =   'Biro Keuangan';
                                            break;
                                        case '1067':
                                        $btn =   'Biro Perencanaan';
                                            break;
                                        case '1068':
                                        $btn =   'Biro Perlengkapn';
                                            break;
                                        case '1069':
                                        $btn =   'Biro Sekretaris Pimpinan';
                                            break;
                                        case '1070':
                                        $btn =   'Biro Umum';
                                            break;
                                        case '1071':
                                        $btn =   'Biro Hukum dan Humas';
                                            break;
                                        }

                                    return $btn;
                                    })
    
                                ->filterColumn('selisih', function ($dataspanPagu) use ($request){
                                    if ($request->get('filter_paguMinus') == 'true'){
                                        // $sisaPagu = $dataspanPagu->amount - $dataspanPagu->dataspan_realisasi->whereNotIn('budget_type','7')->sum('amount');

                                        $dataspanPagu->where('amount','<','0');
                                        return $dataspanPagu;

                                    }
                                })
                                ->rawColumns(['amountRealisasi','amountPengembalian'])
                                ->toJson();
    }

    

    public function apiDataSpanSatker()
    {
        $reffsatker = reffsatker::with(['dataspan_pagu' => function($query) {$query->where('thang', Session::get('thang'));},
                                        'dataspan_realisasi' => function($query) {$query->where('thang', Session::get('thang'));} 
                                        ]);

        $reffsatker = $reffsatker->has('dataspan_pagu')->select('id','nama_satker_lengkap')->orderBy('kode_satker_lengkap');

        $this->filterUserReffSatker($reffsatker);
        $this->filterKatagoriReffSatker($reffsatker);

        return Datatables::eloquent($reffsatker)
                                ->addColumn('amountPagu', function($reffsatker){
                                    return number_format($reffsatker->dataspan_pagu->sum('amount'));
                                    })
                                ->addColumn('amountRealisasi', function($reffsatker){
                                    return (number_format($reffsatker->dataspan_realisasi->sum('amount')).' <br> ('.number_format($reffsatker->dataspan_realisasi->sum('amount') / $reffsatker->dataspan_pagu->sum('amount') * 100, 2).' %)');
                                    })
                                ->addColumn('selisih', function($reffsatker){
                                    return number_format($reffsatker->dataspan_pagu->sum('amount') - $reffsatker->dataspan_realisasi->sum('amount'));
                                    })
                                ->rawColumns(['amountRealisasi'])
                            ->toJson();
    }

    // public function apiDataSpanSatkerDetail()
    // {
    //     $dataspanPagu = reffsatker::with('dataspan_pagu','dataspan_realisasi')
    //     ->has('dataspan_pagu')
    //     ->select('id','nama_satker_lengkap')->orderBy('kode_satker_lengkap');

    //     $this->filterUserReffSatker($dataspanPagu);
    //     $this->filterKatagoriReffSatker($dataspanPagu);

    //     return Datatables::eloquent($dataspanPagu)
    //                             ->addColumn('amountPagu51', function($dataspanPagu){
    //                                 return number_format($dataspanPagu->dataspan_pagu->where('LIKE', '52%')->sum('amount'));
    //                                 })
    //                             ->addColumn('amountRealisasi51', function($dataspanPagu){
    //                                 return (number_format($dataspanPagu->dataspan_realisasi->sum('amount')).' <br> ('.number_format($dataspanPagu->dataspan_realisasi->sum('amount') / $dataspanPagu->dataspan_pagu->sum('amount') * 100, 2).' %)');
    //                                 })
    //                             ->addColumn('amountPagu52', function($dataspanPagu){
    //                                 return number_format($dataspanPagu->dataspan_pagu->sum('amount'));
    //                                 })
    //                             ->addColumn('amountRealisasi52', function($dataspanPagu){
    //                                 return (number_format($dataspanPagu->dataspan_realisasi->sum('amount')).' <br> ('.number_format($dataspanPagu->dataspan_realisasi->sum('amount') / $dataspanPagu->dataspan_pagu->sum('amount') * 100, 2).' %)');
    //                                 })
    //                             ->addColumn('amountPagu53', function($dataspanPagu){
    //                                 return number_format($dataspanPagu->dataspan_pagu->sum('amount'));
    //                                 })
    //                             ->addColumn('amountRealisasi53', function($dataspanPagu){
    //                                 return (number_format($dataspanPagu->dataspan_realisasi->sum('amount')).' <br> ('.number_format($dataspanPagu->dataspan_realisasi->sum('amount') / $dataspanPagu->dataspan_pagu->sum('amount') * 100, 2).' %)');
    //                                 })
    //                             ->addColumn('selisih', function($dataspanPagu){
    //                                 return number_format($dataspanPagu->dataspan_pagu->sum('amount') - $dataspanPagu->dataspan_realisasi->sum('amount'));
    //                                 })
    //                             ->rawColumns(['amountRealisasi'])
    //                         ->toJson();
    // }

    public function apiSisaAnggaran()
    {
        $sisaAnggaran = pagu::where('thang', Session::get('thang'));

        $sisaAnggaran = $sisaAnggaran->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'belanjamodal','reff_bas','pagu_revisi'])->where('kdakun','LIKE','533%');
        $this->filterUser($sisaAnggaran);
        $this->filterKatagori($sisaAnggaran);

        return Datatables::eloquent($sisaAnggaran)
                        ->addColumn('pagu_revisi', function($sisaAnggaran){
                            return number_format($sisaAnggaran->pagu_revisi->jumlah);
                            })
                        ->addColumn('kontrak', function($sisaAnggaran){
                            return number_format($sisaAnggaran->belanjamodal->nilaikontrak);
                            })
    
                        ->addColumn('sisaanggaran', function($sisaAnggaran){
                            if (!empty($sisaAnggaran->belanjamodal->nilaikontrak))
                            {
                                return number_format($sisaAnggaran->pagu_revisi->jumlah - $sisaAnggaran->belanjamodal->nilaikontrak);
                            }else{
                                return number_format(0);
                            }
                            })
    
                        ->addColumn('action', function($sisaAnggaran){
       
                           $btn =   '<a href="' . route('belanjamodal.show', Crypt::encrypt($sisaAnggaran->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                        //    $btn = $btn.'<a href="' . route('belanjamodal.edit', Crypt::encrypt($sisaAnggaran->id)) .'" class="btn btn-success btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-edit fa-xs"></i></a>';
                        //    $btn = $btn.'<a href="' . route('belanjamodal.destroy', Crypt::encrypt($sisaAnggaran->id)) .'" class="btn btn-danger btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:void(0);"><i class="fa fa-trash fa-xs"></i></a>';             
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
    }

    public function apiDataSpanTanpaPagu()
    {
        $dataspanTanpaPagu = dataspan_realisasi::where('thang',Session::get('thang'));

        $dataspanTanpaPagu = $dataspanTanpaPagu->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'dataspan_pagu','reff_bas'])->doesnthave('dataspan_pagu')->whereNotIn('budget_type', ['7']);
        $this->filterUser($dataspanTanpaPagu);
        $this->filterKatagori($dataspanTanpaPagu);

        return Datatables::eloquent($dataspanTanpaPagu)
                            ->addColumn('action', function($dataspanTanpaPagu){
                                            $btn =   '<a href="' . route('dataspan.showTanpaPagu', Crypt::encrypt($dataspanTanpaPagu->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                                            //    $btn = $btn.'<a href="' . route('belanjabarang.edit', Crypt::encrypt($dataspanTanpaPagu->id)) .'" class="btn btn-success btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-edit fa-xs"></i></a>';
                                            //    $btn = $btn.'<a href="' . route('belanjabarang.destroy', Crypt::encrypt($dataspanTanpaPagu->id)) .'" class="btn btn-danger btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:void(0);"><i class="fa fa-trash fa-xs"></i></a>';             
                                                return $btn;
                                })
                            ->rawColumns(['action'])
                            ->toJson();
    }

    public function apiRekonPenghapusan()
    {
        $rekonPenghapusan = reffsatker::with(['transaksibmn' => function($q){$q->where('kode_transaksi', '301')
                                                                                    ->orwhere('kode_transaksi', '391')
                                                                                    ->orwhere('kode_transaksi', '306')
                                                                                    ->orwhere('kode_transaksi', '396')
                                                                                    ->orwhere('kode_transaksi', '308')
                                                                                    ->orwhere('kode_transaksi', '398')
                                                                                    ->orwhere('kode_transaksi', '353')
                                                                                    ->orwhere('kode_transaksi', '371')
                                                                                    ->orwhere('kode_transaksi', '372')
                                                                                    ->orwhere('kode_transaksi', '376')
                                                                                    ->orwhere('kode_transaksi', '378')
                                                                                    ->orwhere('kode_transaksi', '379')
                                                                                    ->orwhere('kode_transaksi', '381')
                                                                                    ;}, 
                                                'penghapusan','penghapusan.penghapusanrevisi'])
                                        ->where(function($query){
                                            $query->has('penghapusan')
                                                ->orWhereHas('transaksibmn', function($q){
                                                    $q->where('kode_transaksi','301')
                                                    ->orwhere('kode_transaksi', '391')
                                                    ->orwhere('kode_transaksi', '306')
                                                    ->orwhere('kode_transaksi', '396')
                                                    ->orwhere('kode_transaksi', '308')
                                                    ->orwhere('kode_transaksi', '398')
                                                    ->orwhere('kode_transaksi', '353')
                                                    ->orwhere('kode_transaksi', '371')
                                                    ->orwhere('kode_transaksi', '372')
                                                    ->orwhere('kode_transaksi', '376')
                                                    ->orwhere('kode_transaksi', '378')
                                                    ->orwhere('kode_transaksi', '379')
                                                    ->orwhere('kode_transaksi', '381')
                                                    ;});
                                            })
                                        ->orderby('kode_satker_lengkap')
                                        ;

        $this->filterUserReffSatker($rekonPenghapusan);
        $this->filterKatagoriReffSatker($rekonPenghapusan);
                                

        return Datatables::eloquent($rekonPenghapusan)
                            ->addColumn('jumlahSK', function($rekonPenghapusan){
                                    return $rekonPenghapusan->penghapusan->sum('nilai_perolehan');
                                    })
                            ->addColumn('jumlahTransaksiBMN', function($rekonPenghapusan){
                                    return $rekonPenghapusan->transaksibmn->sum('nilai');
                                    })
                            ->addColumn('selisih', function($rekonPenghapusan){
                                    return $rekonPenghapusan->penghapusan->sum('nilai_perolehan') + $rekonPenghapusan->transaksibmn->sum('nilai');
                                    })
            
                            ->addColumn('action', function($rekonPenghapusan){
                                            $btn =   '<a href="' . route('penghapusan.show', Crypt::encrypt($rekonPenghapusan->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                                            //    $btn = $btn.'<a href="' . route('belanjabarang.edit', Crypt::encrypt($rekonPenghapusan->id)) .'" class="btn btn-success btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-edit fa-xs"></i></a>';
                                            //    $btn = $btn.'<a href="' . route('belanjabarang.destroy', Crypt::encrypt($rekonPenghapusan->id)) .'" class="btn btn-danger btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:void(0);"><i class="fa fa-trash fa-xs"></i></a>';             
                                                return $btn;
                                })
                            ->rawColumns(['action'])
                            ->toJson();
    }

    public function apiRekonHibah()
    {
        $rekonHibah = reffsatker::with(['transaksibmn' => function($q){$q->where('kode_transaksi', '303')
                                                                                    ->orwhere('kode_transaksi', '354')
                                                                                    ->orwhere('kode_transaksi', '355')
                                                                                    ->orwhere('kode_transaksi', '356')
                                                                                    ->orwhere('kode_transaksi', '373')
                                                                                    ->orwhere('kode_transaksi', '374')
                                                                                    ->orwhere('kode_transaksi', '375')
                                                                                    ->orwhere('kode_transaksi', '393')
                                                                                    ;}, 
                                                'hibah'])
                                        ->where(function($query){
                                            $query->has('hibah')
                                                ->orWhereHas('transaksibmn', function($q){
                                                    $q->where('kode_transaksi','303')
                                                    ->orwhere('kode_transaksi', '354')
                                                    ->orwhere('kode_transaksi', '355')
                                                    ->orwhere('kode_transaksi', '356')
                                                    ->orwhere('kode_transaksi', '373')
                                                    ->orwhere('kode_transaksi', '374')
                                                    ->orwhere('kode_transaksi', '375')
                                                    ->orwhere('kode_transaksi', '393')
                                                    ;});
                                            })
                                        ->orderby('kode_satker_lengkap')
                                        ;

        $this->filterUserReffSatker($rekonHibah);
        $this->filterKatagoriReffSatker($rekonHibah);
                                

        return Datatables::eloquent($rekonHibah)
                            ->addColumn('jumlahSK', function($rekonHibah){
                                    return number_format($rekonHibah->hibah->sum('nilai_perolehan'));
                                    })
                            ->addColumn('jumlahTransaksiBMN', function($rekonHibah){
                                    return number_format($rekonHibah->transaksibmn->sum('nilai'));
                                    })
                            ->addColumn('selisih', function($rekonHibah){
                                    return number_format($rekonHibah->hibah->sum('nilai_perolehan') + $rekonHibah->transaksibmn->sum('nilai'));
                                    })
            
                            ->addColumn('action', function($rekonHibah){
                                            $btn =   '<a href="' . route('penghapusan.show', Crypt::encrypt($rekonHibah->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                                            //    $btn = $btn.'<a href="' . route('belanjabarang.edit', Crypt::encrypt($rekonHibah->id)) .'" class="btn btn-success btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-edit fa-xs"></i></a>';
                                            //    $btn = $btn.'<a href="' . route('belanjabarang.destroy', Crypt::encrypt($rekonHibah->id)) .'" class="btn btn-danger btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:void(0);"><i class="fa fa-trash fa-xs"></i></a>';             
                                                return $btn;
                                })
                            ->rawColumns(['action'])
                            ->toJson();
    }


    public function apiDataSpanPNBP()
    {
        $dataspanEstimasiPNBP = dataspan_estimasipnbp::where('thang', Session::get('thang'));

        $dataspanEstimasiPNBP = $dataspanEstimasiPNBP->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'dataspan_realisasipnbp','reff_bas']);
        $this->filterUser($dataspanEstimasiPNBP);
        $this->filterKatagori($dataspanEstimasiPNBP);

        return Datatables::eloquent($dataspanEstimasiPNBP)
                                ->addColumn('amountRealisasi', function($dataspanEstimasiPNBP){
                                    return number_format($dataspanEstimasiPNBP->dataspan_realisasipnbp->sum('amount'));
                                    })
                                ->addColumn('selisih', function($dataspanEstimasiPNBP){
                                    return number_format($dataspanEstimasiPNBP->amount - $dataspanEstimasiPNBP->dataspan_realisasipnbp->sum('amount'));
                                    })
        
                            ->toJson();
    }

    public function apiDataSpanPNBPSewa()
    {
        $dataspanPNBPSewa = dataspan_realisasipnbp::where('thang', Session::get('thang'));

        $dataspanPNBPSewa = $dataspanPNBPSewa->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'dataspan_estimasipnbp','dataspan_realisasipnbp_penjelasan','akrual', 'reff_bas'])->where('akun', '425131');
        $this->filterUser($dataspanPNBPSewa);
        $this->filterKatagori($dataspanPNBPSewa);

        $dataspanPNBPSewa->when(request('filter_status'), function ($status) {

            switch (request('filter_status')) {
                case 'sudah':
                    return $status->has('dataspan_realisasipnbp_penjelasan');
                break;
                case 'belum':
                    return $status->doesntHave('dataspan_realisasipnbp_penjelasan');
                break;
                }
        });

        $dataspanPNBPSewa->when(request('filter_katagori'), function ($katagori) {

            switch (request('filter_katagori')) {
                case 'Rumah Negara':
                    return $katagori->whereHas('dataspan_realisasipnbp_penjelasan', function($q){
                        $q->where('katagori', 'Rumah Negara');
                    });
                break;
                case 'Non Rumah Negara':
                    return $katagori->whereHas('dataspan_realisasipnbp_penjelasan', function($q){
                        $q->where('katagori', 'Non Rumah Negara');
                    });
                break;
                }

        });



        return Datatables::eloquent($dataspanPNBPSewa)
                                ->addColumn('status', function($dataspanPNBPSewa) {

                                    if (!is_null($dataspanPNBPSewa->dataspan_realisasipnbp_penjelasan->id))
                                    {
                                        $btn =   '<span style="color: blue;">
                                                    <i class="fa fa-circle"> Sudah Tindak Lanjut</i>
                                                  </span>';
                                    }else{
                                        $btn =   '<span style="color: red;">
                                                    <i class="fa fa-circle"> Belum Tindak Lanjut</i>
                                                  </span>';
                                    }
                                    return $btn;
                                    })
                                ->addColumn('nilaiPDD', function($dataspanPNBPsewa){
                                    return $btn = $dataspanPNBPsewa->akrual->where('tahun', Session::get('thang'))->sum('nilai');
                                    })
                                ->addColumn('katagori', function($dataspanPNBPsewa){
                                    if(is_null($dataspanPNBPsewa->dataspan_realisasipnbp_penjelasan->katagori)){
                                        return '-';
                                    }
                                    return $dataspanPNBPsewa->dataspan_realisasipnbp_penjelasan->katagori;
                                    })
    
                                ->addColumn('action', function($dataspanPNBPsewa){
                                       $btn =   '<a href="' . route('dataspanpnbp.showSewa', Crypt::encrypt($dataspanPNBPsewa->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                                        return $btn;
                                     })
                          
                            ->rawColumns(['status','action','nilaiPDD'])
                        
                            ->toJson();
    }

    public function apiDataSpanPNBPSatker()
    {
        $reffsatker = reffsatker::with(['dataspan_estimasipnbp' => function($query) {$query->where('thang', Session::get('thang'));},
                                        'dataspan_realisasipnbp' => function($query) {$query->where('thang', Session::get('thang'));} 
                                        ]);

        $reffsatker = $reffsatker->has('dataspan_estimasipnbp')->select('id','nama_satker_lengkap')->orderBy('kode_satker_lengkap');

        $this->filterUserReffSatker($reffsatker);
        $this->filterKatagoriReffSatker($reffsatker);

        return Datatables::eloquent($reffsatker)
                                ->addColumn('amountPagu', function($reffsatker){
                                    return number_format($reffsatker->dataspan_estimasipnbp->sum('amount'));
                                    })
                                ->addColumn('amountRealisasi', function($reffsatker){
                                    return (number_format($reffsatker->dataspan_realisasipnbp->sum('amount')).' <br> ('.number_format($reffsatker->dataspan_realisasipnbp->sum('amount') / $reffsatker->dataspan_estimasipnbp->sum('amount') * 100, 2).' %)');
                                    })
                                ->addColumn('selisih', function($reffsatker){
                                    return number_format($reffsatker->dataspan_estimasipnbp->sum('amount') - $reffsatker->dataspan_realisasipnbp->sum('amount'));
                                    })
                                ->rawColumns(['amountRealisasi'])
                            ->toJson();
    }

    public function apiDataSpanPNBPTanpaEstimasi()
    {
        $dataspanTanpaEstimasi = dataspan_realisasipnbp::where('thang', Session::get('thang'));
        $dataspanTanpaEstimasi = $dataspanTanpaEstimasi->with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');},'dataspan_estimasipnbp', 'reff_bas'])->doesnthave('dataspan_estimasipnbp')->whereNotIn('budget_type', ['7']);
        $this->filterUser($dataspanTanpaEstimasi);
        $this->filterKatagori($dataspanTanpaEstimasi);

        return Datatables::eloquent($dataspanTanpaEstimasi)
                            ->toJson();
    }

    public function pemeriksaanKeuanganPerkara()
    {
        $pemeriksaanKeuanganPerkara = pemeriksaankeuperkara::with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');}]);
        $this->filterUser($pemeriksaanKeuanganPerkara);
        $this->filterKatagori($pemeriksaanKeuanganPerkara);

        return Datatables::eloquent($pemeriksaanKeuanganPerkara)
            ->addColumn('lampiran', function($pemeriksaanKeuanganPerkara){
                $link_koran_umum = $pemeriksaanKeuanganPerkara->link_file_koran_umum;
                $nama_koran_umum = $pemeriksaanKeuanganPerkara->nama_file_koran_umum;
                if ($nama_koran_umum != null) {
                    # code...
                    $url = url($link_koran_umum."/".$nama_koran_umum);
                    $pdf_koran_umum  =   '<a href="' . $url .'" class="fa fa-file-text-o fa-2x" style="color: gray;" data-toggle="tooltip" data-placement="top" title="Rekening Koran Umum" ></a>';
                } else {
                    $pdf_koran_umum = "";
                }

                $link_koran = $pemeriksaanKeuanganPerkara->link_file;
                $nama_koran = $pemeriksaanKeuanganPerkara->nama_file;
                if ($nama_koran != null) {
                    # code...
                    $url = url($link_koran."/".$nama_koran);
                    $pdf_koran  =   '<a href="' . $url .'" class="fa fa-file-o fa-2x" style="color: blue;" data-toggle="tooltip" data-placement="top" title="Rekening Koran" ></a>';
                } else {
                    $pdf_koran = "";
                }

                $pdf_print  =   '<a href="' . route('pemeriksaanKeuanganPerkara.print', Crypt::encrypt($pemeriksaanKeuanganPerkara->id)) .'" class="fa fa-file-pdf-o fa-2x" style="color: orange;" data-toggle="tooltip" data-placement="top" title="View PDF" ></a>';

                $link_ttd = $pemeriksaanKeuanganPerkara->link_file_ttd;
                $nama_ttd = $pemeriksaanKeuanganPerkara->nama_file_ttd;
                if ($nama_ttd != null) {
                    # code...
                    $url = url($link_ttd."/".$nama_ttd);
                    $pdf_ttd    =   '<a href="' . $url .'" class="fa fa-file-pdf-o fa-2x" style="color: green;" data-toggle="tooltip" data-placement="top" title="Approval" ></a>';
                }else {
                    $pdf_ttd = "";
                }

                $btn = $pdf_koran_umum. " " . $pdf_koran ." ". $pdf_print ." ". $pdf_ttd;

                return $btn;
            })
            ->addColumn('action', function($pemeriksaanKeuanganPerkara){
                $enkrip_id = Crypt::encrypt($pemeriksaanKeuanganPerkara->id);
                $link_approval = $pemeriksaanKeuanganPerkara->link_file_ttd;
                $nama_approval = $pemeriksaanKeuanganPerkara->nama_file_ttd;
                $session_id = Auth::user()->reffsatker_id;
                $data_id = $pemeriksaanKeuanganPerkara->reffsatker_id;
                $btn = 'No Action';
                if ($session_id == $data_id) {
                    # code...
                    if ($link_approval == null) {
                        # code...
                        $btn_hapus =   '<a href="javascript:void(0)" onclick="deleteData('. $pemeriksaanKeuanganPerkara->id .')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        $btn_edit =   '<a href="' . route('pemeriksaankeuperkara.edit', $enkrip_id) .'" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    } else {
                        $btn_hapus = '';
                        // $btn_upload = '';
                        $btn_edit = '';
                    }
                    $btn_upload =   '<a href="javascript:void(0)" onclick="uploadData('. $pemeriksaanKeuanganPerkara->id .')" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Upload ttd" ><i class="fa fa-upload" aria-hidden="true"></i></a>';
                    // $btn_edit = '';

                    $btn = $btn_edit ." ". $btn_hapus ." ".$btn_upload;
                    $btn = '
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            '.
                                $btn_edit.$btn_hapus.$btn_upload
                            .'
                        </div>
                    ';
                }
                return $btn;
            })
            ->rawColumns(['lampiran', 'action'])
            ->toJson();
    }

    public function apiPemeriksaanKas()
    {
        $PemeriksaanKas = pemeriksaanKasModel::with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');}]);
        $this->filterUser($PemeriksaanKas);
        $this->filterKatagori($PemeriksaanKas);

        return Datatables::eloquent($PemeriksaanKas)
                ->addColumn('lampiran', function($PemeriksaanKas){
                    $link_koran = $PemeriksaanKas->link_file;
                    $nama_koran = $PemeriksaanKas->nama_file;
                    if ($nama_koran != null) {
                        # code...
                        $url = url($link_koran."/".$nama_koran);
                        $pdf_koran  =   '<a href="' . $url .'" class="fa fa-file-o fa-2x" style="color: blue;" data-toggle="tooltip" data-placement="top" title="Rekening Koran" ></a>';
                    } else {
                        $pdf_koran = "";
                    }
                    $pdf_print  =   '<a href="' . route('pemeriksaanKas.print', Crypt::encrypt($PemeriksaanKas->id)) .'" class="fa fa-file-pdf-o fa-2x" style="color: orange;" data-toggle="tooltip" data-placement="top" title="View PDF" ></a>';

                    $link_ttd = $PemeriksaanKas->link_file_ttd;
                    $nama_ttd = $PemeriksaanKas->nama_file_ttd;
                    if ($nama_ttd != null) {
                        # code...
                        $url = url($link_ttd."/".$nama_ttd);
                        $pdf_ttd    =   '<a href="' . $url .'" class="fa fa-file-pdf-o fa-2x" style="color: green;" data-toggle="tooltip" data-placement="top" title="Approval" ></a>';
                    }else {
                        $pdf_ttd = "";
                    }

                    $btn = $pdf_koran ." ". $pdf_print ." ". $pdf_ttd;

                    return $btn;
                })
                ->addColumn('action', function($PemeriksaanKas){
                    $enkrip_id = Crypt::encrypt($PemeriksaanKas->id);
                    $link_approval = $PemeriksaanKas->link_file_ttd;
                    $nama_approval = $PemeriksaanKas->nama_file_ttd;
                    $session_id = Auth::user()->reffsatker_id;
                    $data_id = $PemeriksaanKas->reffsatker_id;
                    $btn = 'No Action';
                    if ($session_id == $data_id) {
                        if ($link_approval == null) {
                            # code...
                            $btn_hapus =   '<a href="javascript:void(0)" onclick="deleteData('. $PemeriksaanKas->id .')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            $btn_edit =   '<a href="' . route('pemeriksaanKas.edit', $enkrip_id) .'" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                        } else {
                            $btn_hapus = '';
                            // $btn_upload = '';
                            $btn_edit = '';
                        }
                        $btn_upload =   '<a href="javascript:void(0)" onclick="uploadData('. $PemeriksaanKas->id .')" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Upload ttd" ><i class="fa fa-upload" aria-hidden="true"></i></a>';
                        // $btn_edit = '';

                        $btn = $btn_edit ." ". $btn_hapus ." ".$btn_upload;
                        $btn = '
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                '.
                                    $btn_edit.$btn_hapus.$btn_upload
                                .'
                            </div>
                        ';
                    }
                    return $btn;
                })
                ->rawColumns(['lampiran', 'action'])
                ->toJson();
    }    





    public function apiCapaianKinerja()
    {
        $capaianKinerja = capaiankinerja::with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');}])->where('thang', Session::get('thang'));
        $this->filterUser($capaianKinerja);
        $this->filterKatagori($capaianKinerja);

        return Datatables::eloquent($capaianKinerja)
                        ->toJson();
    }

    public function apiKontrak()
    {
        $kontrak = kontrak::with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');}])->where('thang', Session::get('thang'));
        $this->filterUser($kontrak);
        $this->filterKatagori($kontrak);

        return Datatables::eloquent($kontrak)
                        ->toJson();
    }

    public function apiAsiap()
    {
        $asiap = asiap::with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');}]);
        $this->filterUser($asiap);
        $this->filterKatagori($asiap);

        if(request('filter_rekomendasi') === 'Kendaraan Roda 4'){
            $asiap->whereNotNull('kend4_rekomendasi');
        }if(request('filter_rekomendasi') === 'Kendaraan Roda 2'){
            $asiap->whereNotNull('kend2_rekomendasi');
        }if(request('filter_rekomendasi') === 'Genset'){
            $asiap->whereNotNull('genset_rekomendasi');
        }if(request('filter_rekomendasi') === 'Laptop'){
            $asiap->whereNotNull('laptop_rekomendasi');
        }if(request('filter_rekomendasi') === 'PC'){
            $asiap->whereNotNull('pc_rekomendasi');
        }if(request('filter_rekomendasi') === 'Server'){
            $asiap->whereNotNull('server_rekomendasi');
        }if(request('filter_rekomendasi') === 'Brandkas'){
            $asiap->whereNotNull('brandkas_rekomendasi');
        }if(request('filter_rekomendasi') === 'Printer'){
            $asiap->whereNotNull('printer_rekomendasi');
        }if(request('filter_rekomendasi') === 'Scanner'){
            $asiap->whereNotNull('scaner_rekomendasi');
        }

        return Datatables::eloquent($asiap)
                        ->addColumn('action', function($asiap){
                            $btn =   '<a href="' . route('asiap.show', Crypt::encrypt($asiap->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
    }

    public function apiAsiapAset()
    {
        $asiap_aset = asiap_aset::with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');}]);
        $this->filterUser($asiap_aset);
        $this->filterKatagori($asiap_aset);

        $asiap_aset->when(request('filter_katagori'), function ($katagori) {
            return $katagori->where('kode_katagori', request('filter_katagori'));
        });
        $asiap_aset->when(request('filter_golongan'), function ($golongan) {
            return $golongan->where('kode_golongan', request('filter_golongan'));
        });
        $asiap_aset->when(request('filter_kelompok'), function ($kelompok) {
            return $kelompok->where('kode_kelompok', request('filter_kelompok'));
        });
        $asiap_aset->when(request('filter_kondisi'), function ($kondisi) {
            return $kondisi->where('kondisi', request('filter_kondisi'));
        });
        $asiap_aset->when(request('filter_analisa_masa_manfaat'), function ($analisaMasaManfaat) {
            return $analisaMasaManfaat->where('analisa_masa_manfaat ', request('filter_analisa_masa_manfaat'));
        });


        return Datatables::eloquent($asiap_aset)->toJson();
    }

    public function apiPrepaid()
    {
        $prepaid = prepaid::with(['reffsatker' => function($query) {$query->orderBy('kode_satker_lengkap', 'asc');}, 'akrual'])->where('thang', Session::get('thang'))->latest();
        $this->filterUser($prepaid);
        $this->filterKatagori($prepaid);

        return Datatables::eloquent($prepaid)
                        ->addColumn('lampiran', function($prepaid){
                                    $btn = null;
                                    if ($prepaid->lampiran_memo != null){
                                        $btn =   $btn.' <a href="'.asset('storage/Dokumen Prepaid/'.$prepaid->thang.'/'.$prepaid->reffsatker_id.'-'.$prepaid->reffsatker->nama_satker_lengkap.'/'.$prepaid->akun.'-'.$prepaid->jenis.'/'.$prepaid->lampiran_memo).'" target="_blank" class="fa fa-file-pdf-o fa-3x" style="color: green;" data-toggle="tooltip" data-placement="top" title="Lampiran Memo" ></a>';
                                    }if($prepaid->lampiran_pembayaran != null){
                                        $btn =   $btn.' <a href="'.asset('storage/Dokumen Prepaid/'.$prepaid->thang.'/'.$prepaid->reffsatker_id.'-'.$prepaid->reffsatker->nama_satker_lengkap.'/'.$prepaid->akun.'-'.$prepaid->jenis.'/'.$prepaid->lampiran_pembayaran).'" target="_blank" class="fa fa-file-pdf-o fa-3x" style="color: green;" data-toggle="tooltip" data-placement="top" title="Lampiran Pembayaran" ></a>';
                                    }if($prepaid->lampiran_perjanjian != null){
                                        $btn =   $btn.' <a href="'.asset('storage/Dokumen Prepaid/'.$prepaid->thang.'/'.$prepaid->reffsatker_id.'-'.$prepaid->reffsatker->nama_satker_lengkap.'/'.$prepaid->akun.'-'.$prepaid->jenis.'/'.$prepaid->lampiran_perjanjian).'" target="_blank" class="fa fa-file-pdf-o fa-3x" style="color: green;" data-toggle="tooltip" data-placement="top" title="Lampiran Perjanjian" ></a>';
                                    }
                                    return $btn;
                                })
                        ->addColumn('action', function($prepaid){
                    
                            $btn =   '<a href="' . route('prepaid.show', Crypt::encrypt($prepaid->id)) .'" class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-eye fa-xs"></i></a>';
                            // $btn =   '<button wire:click="destroy('.$prepaid->id.')" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></button>';
                            return $btn;
                            })
                        ->addColumn('nilaiAkrual', function($prepaid){
                            return $btn = $prepaid->akrual->where('tahun', Session::get('thang'))->sum('nilai');
                            })

                        ->rawColumns(['action','lampiran','nilaiAkrual'])
                        ->toJson();

    }

    public function apiPipkPenilaian()
    {
        $reffsatker = reffsatker::with(['pipk','pipk.pipk_penerapan']);

        $reffsatker = $reffsatker->whereHas('pipk', function($q){
                                                                $q->where('thang', Session::get('thang'));            
                                                                })
                                ->select('id','nama_satker_lengkap')->orderBy('kode_satker_lengkap');

        $this->filterUserReffSatker($reffsatker);
        $this->filterKatagoriReffSatker($reffsatker);

        return Datatables::eloquent($reffsatker)
                                    ->addColumn('penerapanKDP', function($reffsatker){
                                        foreach($reffsatker->pipk as $pipk)
                                        {
                                            foreach($pipk->pipk_penerapan as $penerapan)
                                            {
                                                if($penerapan->akun_signifikan == "Konstruksi Dalam Pekerjaan")
                                                {
                                                    return $btn =   '<h6><span class="badge badge-success">Dilakukan Pengendalian</span></h6>';
                                                }
                                            }
                                        }
                                    })
                                    ->addColumn('penerapanPDD', function($reffsatker){
                                        foreach($reffsatker->pipk as $pipk)
                                        {
                                            foreach($pipk->pipk_penerapan as $penerapan)
                                            {
                                                if($penerapan->akun_signifikan == "Pendapatan Diterima Dimuka")
                                                {
                                                    return $btn =   '<h6><span class="badge badge-success">Dilakukan Pengendalian</span></h6>';
                                                }
                                            }
                                        }
                                    })
                                    ->addColumn('action', function($reffsatker){
                                        $btn =   '<a href="' . route('pipk.indexAwal', Crypt::encrypt($reffsatker->id)) .'" class="btn btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-eye fa-xs"></i></a>';
                                        return $btn;
                                        })
                                    ->rawColumns(['penerapanKDP','penerapanPDD','action'])
    	                            ->toJson();
    }

    public function apiJurnalKeuangan()
    {
        $jurnalKeuangan = jurnal_keuangan::with('reffsatker','jurnal_keuangan_penjelasan')
                                        ->where('thang', Session::get('thang'));
        $this->filterUser($jurnalKeuangan);
        $this->filterKatagori($jurnalKeuangan);

        $jurnalKeuangan->when(request('filter_status'), function ($status) {

            switch (request('filter_status')) {
                case 'sudah':
                    return $status->has('jurnal_keuangan_penjelasan');
                break;
                case 'belum':
                    return $status->doesntHave('jurnal_keuangan_penjelasan');
                break;
                case 'verifikasi':
                    return $status->whereHas('jurnal_keuangan_penjelasan', function($q){
                        $q->whereNotNull('verifikasi');
                    });
                break;
                }
        });

        return Datatables::eloquent($jurnalKeuangan)
                        ->addColumn('action', function($jurnalKeuangan){
                                                    $btn =   '<a href="' . route('jurnalkeuangan.show', Crypt::encrypt($jurnalKeuangan->id)) .'" class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="top" title="View" ><i class="fa fa-eye fa-xs"></i></a>';
                                                    return $btn;
                                                    })
                        ->addColumn('status', function($jurnalKeuangan) {

                            if (!is_null($jurnalKeuangan->jurnal_keuangan_penjelasan->id))
                            {
                                $btn =   '<span style="color: blue;">
                                            <i class="fa fa-circle"> Sudah Tindak Lanjut</i>
                                            </span>';
                            }else{
                                $btn =   '<span style="color: red;">
                                            <i class="fa fa-circle"> Belum Tindak Lanjut</i>
                                            </span>';
                            }
                            return $btn;
                            })

                        ->addColumn('verifikasi', function($jurnalKeuangan) {

                            if (!is_null($jurnalKeuangan->jurnal_keuangan_penjelasan->verifikasi))
                            {
                                $btn =   '<span style="color: blue;">
                                            <i class="fa fa-circle"> Sudah Verifikasi</i>
                                            </span>';
                            }else{
                                $btn =   '<span style="color: red;">
                                            <i class="fa fa-circle"> Belum Verifikasi</i>
                                            </span>';
                            }
                            return $btn;
                            })
    
                    
                        ->rawColumns(['action','status','verifikasi'])
                        ->toJson();
    }





}