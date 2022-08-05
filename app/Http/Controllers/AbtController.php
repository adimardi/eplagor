<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

use App\pagu;
use App\abt_usulan;
use App\abt_items;
use App\abt_verifikasi;
use App\reffbagian;
use App\reffsatker;
use App\reff_bas;
use App\Users;

use Carbon\Carbon;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

use Cache;
use Session;
use Auth;
use DB;

use App\Traits\filter;


class AbtController extends Controller
{
    use filter;

    protected $session;
    private $title = 'Usulan ABT';

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
        return view('abt.index', $data);
    }

    public function show($unik)
    {
        $user = Auth::user();

        $this->config = [
            'title'     => 'Detail Usulan ABT',
            'pageTitle' => 'Detail Usulan ABT',
        ];

        $data['config'] = $this->config;
        $data['satker'] = reffsatker::where('id', $user->reffsatker_id)->first();
        $data['usulan'] = abt_usulan::with('reffsatker')->where('unik', $unik)->first();
        $data['items'] = abt_items::with('reffsatker')->where('unik', $unik)->get();
        $data['verifikasi'] = abt_verifikasi::where('unik', $unik)->get();

        $data['verifpta'] = abt_verifikasi::where('unik', $unik)->where('verifikator', 'Tingkat Banding')->first();
        $data['verifpusat'] = abt_verifikasi::where('unik', $unik)->where('verifikator', '!=', 'Tingkat Banding')->get();

        $data['tpegawai'] = abt_items::where('unik', $data['usulan']->unik)
                                     ->where('kdakun','LIKE','51%')
                                     ->sum('jumlah');

        $data['tbarang'] = abt_items::where('unik', $data['usulan']->unik)
                                     ->where('kdakun','LIKE','52%')
                                     ->sum('jumlah');

        $data['tmodal'] = abt_items::where('unik', $data['usulan']->unik)
                                    ->where('kdakun','LIKE','53%')
                                    ->sum('jumlah');

        return view('abt.show', $data);
    }

    public function create()
    {

    }

    public function add($unik)
    {
        //echo $unik;
        $user = Auth::user();

        $this->config = [
            'title'     => 'Tambah ABT',
            'pageTitle' => 'Tambah ABT',
        ];

        $data['config'] = $this->config;
        $data['satker'] = reffsatker::where('id', $user->reffsatker_id)->first();
        $data['unik'] = $unik;
        $data['abt'] = abt_usulan::where('unik', $unik)->first();

        return view('abt.create', $data);
    }

    public function save($unik)
    {
        $abt = abt_usulan::where('unik', $unik)->first();
        if (!empty($abt->unik)) {
            echo 'Ada';
        } else {
            echo 'Tidak Ada';
        }
    }

    public function getpagu(Request $request)
    {
        $pagu = pagu::find($request->unik);
        return response()->json($pagu);
    }

    public function store(Request $request)
    {
        abt_usulan::updateOrCreate([
            'unik' => $request->unik
        ],
        [
            'reffsatker_id' => $request->kodeSatker,
            'tanggal_surat' => $request->tanggalSurat, 
            'nomor_surat' => $request->nomorSurat,
            'perihal_surat' => $request->perihal,
        ]);

        return redirect('/abt/add/'.$request->unik)->with('msg', 'Catatan perbaikan berhasil diperbaharui.');
    }

    public function store_items(Request $request)
    {
        abt_usulan::updateOrCreate([
            'unik' => $request->unik
        ],
        [
            'reffsatker_id' => $request->kodeSatker,
            'tanggal_surat' => $request->tanggalSurat, 
            'nomor_surat' => $request->nomorSurat,
            'perihal_surat' => $request->perihal,
        ]);

        abt_items::updateOrCreate([
            'id_pagu' => $request->idPagu
        ],
        [
            'unik' => $request->unik,
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
            'jumlah' => $request->jumlah
        ]);

        Alert::warning('Warning Title', 'Warning Message');

        //Session::flash('message', ['text'=>'this is a danger message','type'=>'danger']);
        return redirect('/abt/add/'.$request->unik)->with('info','You added new items, follow next step!');
    }

    public function edit($id)
    {

    }

    public function update(Request $request)
    {

    }

    public function destroy($id)
    {

    }

    public function hapus($unik)
    {
        abt_usulan::where('unik', $unik)->delete();
        abt_items::where('unik', $unik)->delete();
        return redirect('abt')->with('info','You added new items, follow next step!');
    }

    public function uploads(Request $request)
    {

    }

    public function verifikasi($unik, $param)
    {
        $output = '';

        if ($param == 1) {
            $status = 'Verifikasi Tingkat Banding';
            $output .=  '
                        <div class="modal-header">
                            <h5 class="modal-title" id="mTitle">'.$status.'</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group input-group-static mb-2">
                                <label for="status" class="ms-0">Status Usulan</label>
                                <input type="hidden" name="_token" value="'.csrf_token().'"/>
                                <input type="hidden" id="unik" name="unik" value="'.$unik.'">
                                <input type="hidden" id="verifikator" name="verifikator" value="Tingkat Banding">
                                <select id="status" name="status" class="form-control" required="">
                                    <option value="">Pilih</option>
                                    <option value="1">Disetujui dan Diteruskan Ke Eselon I</option>
                                    <option value="2">Tidak Disetujui dan Diteruskan Ke Eselon I</option>
                                </select>
                            </div>
                            <div class="input-group input-group-static mb-2">
                                <label>Alasan</label>
                                <input type="text" id="alasan" name="alasan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                            </div>
                            <div class="input-group input-group-static mb-2">
                                <label>Keterangan</label>
                                <input type="text" id="keterangan" name="keterangan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                            </div>
                            <div class="input-group input-group-static mb-2">
                                <label>Nomor Surat Pengantar</label>
                                <input type="text" id="nomor_surat" name="nomor_surat" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                            </div>
                            <div class="input-group input-group-static mb-2">
                                <label>File Surat Pengantar</label>
                                <input type="file" id="file_surat" name="file_surat" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between text-center p-3">
                            <button type="button" class="btn bg-gradient-danger mb-0" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn bg-gradient-primary mb-0">Simpan</button>
                        </div>
                    ';
        } else if ($param == 2) {
            $status = 'Verifikasi Tingkat Pusat';
            $output .=  '
                        <div class="modal-header">
                            <h5 class="modal-title" id="mTitle">'.$status.'</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group input-group-static mb-2">
                                <input type="hidden" name="_token" value="'.csrf_token().'"/>
                                <input type="hidden" id="unik" name="unik" value="'.$unik.'">
                                <label for="verifikator" class="ms-0">Pusat</label>
                                <select id="verifikator" name="verifikator" class="form-control" required="">
                                    <option value="">Pilih</option>
                                    <option value="Biro Perlengkapan">Biro Perlengkapan</option>
                                    <option value="Biro Perencanaan">Biro Perencanaan</option>
                                    <option value="Biro Keuangan">Biro Keuangan</option>
                                </select>
                            </div>
                            <div class="input-group input-group-static mb-2">
                                <label for="status" class="ms-0">Status Usulan</label>
                                <select id="status" name="status" class="form-control" required="">
                                    <option value="">Pilih</option>
                                    <option value="1">Disetujui</option>
                                    <option value="2">Tidak Disetujui</option>
                                </select>
                            </div>
                            <div class="input-group input-group-static mb-2">
                                <label>Alasan</label>
                                <input type="text" id="alasan" name="alasan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                            </div>
                            <div class="input-group input-group-static mb-2">
                                <label>Keterangan</label>
                                <input type="text" id="keterangan" name="keterangan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between text-center p-3">
                            <button type="button" class="btn bg-gradient-danger mb-0" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn bg-gradient-primary mb-0">Simpan</button>
                        </div>
                    ';
        }

        echo $output;
    }

    public function verified(Request $request)
    {
        $user = Auth::user();

        if ($request->verifikator != 'Tingkat Banding') {
            if ($request->status == 1) {
                $status = 'Disetui';
            } else {
                $status = 'Tidak Disetui';
            }

            abt_verifikasi::updateOrCreate(
                [
                    'unik' => $request->unik,
                    'verifikator' => $request->verifikator,
                ],
                [
                    
                    'status' => $request->status,
                    'status_text' => $status,
                    'alasan' => $request->alasan,
                    'keterangan' => $request->keterangan,
                    'created_by' => $user->id,
                ]
            );

            abt_usulan::where('unik', $request->unik)
                      ->update(['status' => $status.' '.$request->verifikator]);
        } else {
            if(!empty($request->file('file_surat')))
            {
                $file = $request->file('file_surat');
                $file_dir = 'storage/dokumen_usulan_abt/';

                // menyimpan data file yang diupload ke variabel $file
                $generate = strtotime(Carbon::parse()->now()->format('Y-m-d H:i:s'));
                $dokumen = 'usulan_abt';
                $nama_file = $dokumen."_".$generate."_".$request->unik.".".$file->getClientOriginalExtension();

                // isi dengan nama folder tempat kemana file diupload
                //$folder_tahun = Carbon::parse()->now()->format('Y')."/".Carbon::parse()->now()->format('m')."/".Carbon::parse()->now()->format('d');
                $tujuan_upload = $file_dir.$request->id;

                if (!file_exists($file_dir)) {
                    mkdir($file_dir, 0777, true);
                }

                $file->move($tujuan_upload, $nama_file);

                if ($request->status == 1) {
                    $status = 'Disetui dan Diteruskan Ke Eselon I';
                } else {
                    $status = 'Tidak Disetui dan Diteruskan Ke Eselon I';
                }

                abt_verifikasi::updateOrCreate(
                    [
                        'unik' => $request->unik,
                        'verifikator' => ''.$request->verifikator,
                    ],
                    [
                        'nomor_surat' => $request->nomor_surat,
                        'status' => $request->status,
                        'status_text' => $status,
                        'alasan' => $request->alasan,
                        'keterangan' => $request->keterangan,
                        'file_surat' => $nama_file,
                        'created_by' => $user->id,
                    ]
                );

                abt_usulan::where('unik', $request->unik)->update(['status' => $status]);

                //echo 'Tor Tersimpan';
            }
        }

        return redirect('/abt/'.$request->unik)->with('info','You added new items, follow next step!'); 
    }

    public function anggaran_disetujui(Request $request)
    {
        $user = Auth::user();
        abt_usulan::updateOrCreate(
                    [
                        'unik' => $request->unik,
                    ],
                    [
                        'setujui_pegawai' => str_replace("." , "" , $request->bPegawai),
                        'setujui_barang' => str_replace("." , "" , $request->bBarang),
                        'setujui_modal' => str_replace("." , "" , $request->bModal),
                        'updated_by' => $user->id
                    ]
                );

        return redirect('/abt/'.$request->unik)->with('info','You added new items, follow next step!'); 
    }

}
