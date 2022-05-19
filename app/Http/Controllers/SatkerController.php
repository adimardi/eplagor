<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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


class SatkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('satker.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Alert::error('Oopss..', 'Anda dilarang masuk ke area ini.');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {

    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $id = Crypt::decrypt($id);

        if(Auth::user()->level == 'user') {
            Alert::error('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->back();
        }else
        {
            $data = reffsatker::findOrFail($id);
            return view('satker.show', compact('data'));
        }
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
        $user_data = reffsatker::findOrFail($id);

        $user_data->kpknl = $request->input('KPKNL');
        $user_data->kanwil_djkn = $request->input('kanwilDJKN');
        $user_data->ketua = $request->input('ketua');
        $user_data->ketua_nip = $request->input('nipKetua');
        $user_data->bendahara = $request->input('bendahara');
        $user_data->bendahara_nip = $request->input('nipBendahara');
        $user_data->sekretaris = $request->input('sekretaris');
        $user_data->sekretaris_nip = $request->input('nipSekretaris');
        $user_data->panitera = $request->input('panitera');
        $user_data->panitera_nip = $request->input('nipPanitera');
        $user_data->kasir = $request->input('kasir');
        $user_data->kasir_nip = $request->input('nipKasir');

        $user_data->update();

        Session::flash('title', 'Berhasil');
        Session::flash('text', 'Data Berhasil dirubah');
        Session::flash('type', 'success');
        Session::flash('styling', 'bootstrap3');
        
        return redirect()->back();

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

}
