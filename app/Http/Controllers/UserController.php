<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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


class UserController extends Controller
{
    protected $session;
    private $title = 'User';

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

        return view('auth.user', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::error('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->back();
        }
        if(Auth::user()->level == 'root') {
            $reffbagians = reffbagian::get();
            $reffsatkers = reffsatker::get();
        }
        else
        {
            if (Auth::user()->kantor == 'satker') {
                $reffbagians = reffbagian::get();
                $reffsatkers = reffsatker::where('id',Auth::user()->reffsatker_id)->get();
            }
            if (Auth::user()->kantor == 'korwil') {
                $reffbagians = reffbagian::get();
                $reffsatkers = reffsatker::where('korwil',Auth::user()->reffsatker->korwil)->get();
            }
            if (Auth::user()->kantor == 'banding') {
                $reffbagians = reffbagian::get();
                $reffsatkers = reffsatker::where('tingkat_banding',Auth::user()->reffsatker->tingkat_banding)->get();
            }
            if (Auth::user()->kantor == 'eselon_1') {
                $reffbagians = reffbagian::get();
                $reffsatkers = reffsatker::where('kode_eselon',Auth::user()->reffsatker->kode_eselon)->get();
            }
            if (Auth::user()->kantor == 'dirjen') {
                $reffbagians = reffbagian::get();
                $reffsatkers = reffsatker::where('dirjen',Auth::user()->reffsatker->dirjen)->get();
            }
            if (Auth::user()->kantor == 'pusat') {
                $reffbagians = reffbagian::get();
                $reffsatkers = reffsatker::get();
            }
        }


        
        return view('auth.tambahuser', compact('reffbagians','reffsatkers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (User::where('username', "=", $request->input('username'))->exists()) {
        //     Session::flash('alert', 'Username Sudah Ada');
        //     Session::flash('message_type', 'danger');
        //     return redirect()->back();
        //  }

        $count = User::where('username',$request->get('username'))->count();

        if($count>0){
            Session::flash('alert', 'Username Sudah Ada');
            Session::flash('message_type', 'danger');
            Alert::info('Oopss..', 'Name Already exist!');
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        if($request->file('gambar') == '') {
            $gambar = NULL;
        } else {
            $file = $request->file('gambar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('gambar')->move("images/user", $fileName);
            $gambar = $fileName;
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'kantor' => $request->input('kewenangan'),
            'level' => $request->input('level'),
            'username' => $request->input('username'),
            'reffbagian_id' => $request->input('reffbagian_id'),
            'reffsatker_id' => $request->input('reffsatker_id'),
            'nip' => $request->input('nip'),
            'telephone' => $request->input('telephpne'),
            'jabatan' => $request->input('jabatan'),
            'password' => bcrypt(($request->input('password'))),
            'gambar' => $gambar
        ]);

        Session::flash('message', 'Berhasil ditambahkan!');
        Session::flash('message_type', 'success');
        return redirect()->route('user.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->back();
        }

        $data = User::findOrFail($id);

        return view('auth.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['config'] = $this->config;

        $id = Crypt::decrypt($id);
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda Tidak Bisa Melakukan Perubahan.');
                return redirect()->back();
        }
        if(Auth::user()->level == 'root') {
            $data['data'] = User::with('reffbagian')->findOrFail($id);
            $data['data2'] = User::with('reffsatker')->findOrFail($id);
            $data['reffbagians'] = reffbagian::get();
            $data['reffsatkers'] = reffsatker::get();
        }
        else
        {
            if (Auth::user()->kantor == 'satker') {
                $data['data'] = User::with('reffbagian')->findOrFail($id);
                $data['data2'] = User::with('reffsatker')->findOrFail($id);
                $data['reffbagians'] = reffbagian::get();
                $data['reffsatkers'] = reffsatker::where('kode_satker',Auth::user()->reffsatker_id)->get();
            }
            if (Auth::user()->kantor == 'korwil') {
                $data['data'] = User::with('reffbagian')->findOrFail($id);
                $data['data2'] = User::with('reffsatker')->findOrFail($id);
                $data['reffbagians'] = reffbagian::get();
                $data['reffsatkers'] = reffsatker::where('kode_satker',Auth::user()->reffsatker_id)->get();
            }
            if (Auth::user()->kantor == 'banding') {
                $data['data'] = User::with('reffbagian')->findOrFail($id);
                $data['data2'] = User::with('reffsatker')->findOrFail($id);
                $data['reffbagians'] = reffbagian::get();
                $data['reffsatkers'] = reffsatker::where('kode_satker',Auth::user()->reffsatker_id)->get();
            }
            if (Auth::user()->kantor == 'eselon_1') {
                $data['data'] = User::with('reffbagian')->findOrFail($id);
                $data['data2'] = User::with('reffsatker')->findOrFail($id);
                $data['reffbagians'] = reffbagian::get();
                $data['reffsatkers'] = reffsatker::where('kode_satker',Auth::user()->reffsatker_id)->get();
            }
            if (Auth::user()->kantor == 'dirjen') {
                $data['data'] = User::with('reffbagian')->findOrFail($id);
                $data['data2'] = User::with('reffsatker')->findOrFail($id);
                $data['reffbagians'] = reffbagian::get();
                $data['reffsatkers'] = reffsatker::where('kode_satker',Auth::user()->reffsatker_id)->get();
            }
            if (Auth::user()->kantor == 'pusat') {
                $data['data'] = User::with('reffbagian')->findOrFail($id);
                $data['data2'] = User::with('reffsatker')->findOrFail($id);
                $data['reffbagians'] = reffbagian::get();
                $data['reffsatkers'] = reffsatker::where('kode_satker',Auth::user()->reffsatker_id)->get();
            }
        }

        return view('auth.edit', $data);
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
        $user_data = User::findOrFail($id);

        if($request->file('gambar')) 
        {
            $file = $request->file('gambar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('gambar')->move("images/user", $fileName);
            $user_data->gambar = $fileName;
        }

            // $user_data->name = $request->input('name');
            // $user_data->email = $request->input('email');
        
        if($request->input('reffbagian_id') != null)
        {
            $user_data->reffbagian_id = $request->input('reffbagian_id');
        }
        if($request->input('reffsatker_id') != null)
        {
            $user_data->reffsatker_id = $request->input('reffsatker_id');
        }
        // if($request->input('password'))
        // {
        //     $user_data->level = $request->input('level');
        // }
        if($request->input('password')) {
            $user_data->password= bcrypt(($request->input('password')));
        }

        // $user_data->nip = $request->input('nip');
        // $user_data->telephone = $request->input('telephone');
        // $user_data->jabatan = $request->input('jabatan');

        $user_data->update();

        Alert::success('Great', 'Perubahan Data Berhasil Disimpan');
        return redirect()->back();

        // return redirect()->to('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->id != $id) {
            
            $user_data = User::findOrFail($id);
            $user_data->delete();

            Session::flash('message', 'Berhasil dihapus!');
            Session::flash('message_type', 'success');
        } else {
            Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
            Session::flash('message_type', 'danger');
        }

        $data = [
            'status' => true,
            'message' => 'Data Berhasil di uplad'
        ];

        return json_encode($data);

    }

    public function hapus(Request $request) 
    {
        $hapus = User::where('id', $request->idnya);
        $hapus->forceDelete();

        $data = [
            'status' => true,
            'message' => 'Data Berhasil di uplad'
        ];
        return json_encode($data);
    }


    public function import_excel(Request $request) 
	{

		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = date("Y-m-d")."_".time()."_".$file->getClientOriginalName();
 
		// upload ke folder file_pegawai di dalam folder public
		$file->move('ImportData_User',$nama_file);
 
		// import data
		Excel::import(new UsersImport, public_path('ImportData_User/'.$nama_file));
 
		// notifikasi dengan session
		Session::flash('sukses','Data pegawai Berhasil Diimport!');
 
		// alihkan halaman kembali
        return redirect()->route('user.index');
        
        logs::create([
            'users_id' => Auth::user()->id,
            'aktifitas' => 'Import Data Users',
            ]);
    }
}
