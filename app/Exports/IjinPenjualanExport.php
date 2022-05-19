<?php

namespace App\Exports;

use App\ijinpenjualan;
use App\reffsatker;
use App\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\View\View;
use Auth;




class IjinPenjualanExport implements FromView, ShouldAutoSize
{
    // use Exportable;

    public function view(): View
    {
        if (Auth::user()->kantor == 'satker')
        {
            return view('ijinpenjualan.exportexcel', [
            'ijinpenjualans' =>  ijinpenjualan::with('reffsatker')->where('reffsatker_id', Auth::user()->reffsatker_id)->get()
            ]);
        }
        if (Auth::user()->kantor == 'korwil')
        {
            return view('ijinpenjualan.exportexcel', [
            'ijinpenjualans' =>  ijinpenjualan::with('reffsatker')->whereHas('reffsatker', function($q){
                                                                    $q->where('kode_wilayah',Auth::user()->reffsatker->kode_wilayah)
                                                                        ;})->get()
            ]);
        }
        if (Auth::user()->kantor == 'banding')
        {
            return view('ijinpenjualan.exportexcel', [
            'ijinpenjualans' =>  ijinpenjualan::with('reffsatker')->whereHas('reffsatker', function($q){
                                                                    $q->where('tingkat_banding',Auth::user()->reffsatker->tingkat_banding)
                                                                        ;})->get()
            ]);
        }
        if (Auth::user()->kantor == 'eselon_1')
        {
            return view('ijinpenjualan.exportexcel', [
            'ijinpenjualans' =>  ijinpenjualan::with('reffsatker')->whereHas('reffsatker', function($q){
                                                                    $q->where('kode_eselon',Auth::user()->reffsatker->kode_eselon)
                                                                        ;})->get()
            ]);
        }
        if (Auth::user()->kantor == 'dirjen')
        {
            return view('ijinpenjualan.exportexcel', [
            'ijinpenjualans' =>  ijinpenjualan::with('reffsatker')->whereHas('reffsatker', function($q){
                                                                    $q->where('dirjen',Auth::user()->reffsatker->dirjen)
                                                                        ;})->get()
            ]);
        }
        if (Auth::user()->kantor == 'pusat')
        {
            return view('ijinpenjualan.exportexcel', [
            'ijinpenjualans' =>  ijinpenjualan::with('reffsatker')->get()
            ]);
        }
    }


 
}


