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

use App\UsulanKelasPa;

class KenaikanKelasPaController extends Controller
{
    protected $session;
    private $title = 'Usulan Kenaikan Kelas Peradilan Agama';

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
        return view('usulan.kenaikankelaspa.index', $data);
    }

    public function create()
    {
        $data['config'] = $this->config;
    	$data['satker'] = reffsatker::where('peradilan', 'agama')->orderBy('id')->get();
        return view('usulan.kenaikankelaspa.create', $data);
    }

    public function show($id)
    {
      	$data['config'] = $this->config;
        return view('usulan.kenaikankelaspa.show', $data);  
    }

    public function store(Request $request)
    {
        if(!empty($request->file('dakung')))
        {
            $file = $request->file('dakung');
            $file_dir = 'storage/Dokumen_usulanpa/';

            // menyimpan data file yang diupload ke variabel $file
            $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
            $dokumen = 'UsulanKenaikanKelasPA';
            $nama_file = $dokumen."_".$generate."_".$request->idSatker.".".$file->getClientOriginalExtension();

            // isi dengan nama folder tempat kemana file diupload
            //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
            $tujuan_upload = $file_dir.$request->id;

            if (!file_exists($file_dir)) {
                mkdir($file_dir, 0777, true);
            }

            $file->move($tujuan_upload, $nama_file);

            UsulanKelasPa::Create([
                'reffsatker_id' => $request->idSatker,
                'nomor_surat' => $request->nomorSurat,
                'tanggal_surat' => $request->tanggalSurat,
                'usul_peningkatan_ke' => $request->usulPeningkatan,
                'usulan_ke' => $request->pengusulanKe,
                'cg_tahun1' => $request->cgTahun1,
                'cg_tahun2' => $request->cgTahun2,
                'cg_tahun3' => $request->cgTahun3,
                'ct_tahun1' => $request->ctTahun1,
                'ct_tahun2' => $request->ctTahun2,
                'ct_tahun3' => $request->ctTahun3,
                'p_tahun1' => $request->pTahun1,
                'p_tahun2' => $request->pTahun2,
                'p_tahun3' => $request->pTahun3,
                'jumlah_cg_tahun1' => $request->cgJumlahTahun1,
                'jumlah_cg_tahun2' => $request->cgJumlahTahun2,
                'jumlah_cg_tahun3' => $request->cgJumlahTahun3,
                'jumlah_ct_tahun1' => $request->ctJumlahTahun1,
                'jumlah_ct_tahun2' => $request->ctJumlahTahun2,
                'jumlah_ct_tahun3' => $request->ctJumlahTahun3,
                'jumlah_p_tahun1' => $request->pJumlahTahun1,
                'jumlah_p_tahun2' => $request->pJumlahTahun2,
                'jumlah_p_tahun3' => $request->pJumlahTahun3,
                'file' => $nama_file,
                'jumlah_penduduk' => $request->jumlahPenduduk,
                'kepadatan_penduduk' => $request->kepadatanPenduduk,
                'kemudahan_akses' => $request->kemudahanAkses,
            ]);

            Session::flash('message', 'Berhasil ditambahkan!');
            Session::flash('message_type', 'success');
            return redirect()->route('usulan.kenaikankelaspa.index');
        }
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
