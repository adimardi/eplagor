<?php

namespace App\Exports;

use App\Temuanbpk;
use App\Temuanbpk_tindaklanjut;
use App\Temuanbpk_satker;
use App\Temuanbpk_uraian;
use App\Temuanbpk_disposisi;
use App\reffsatker;
use App\reffbagian;
use App\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\View\View;


// class TemuanbpkExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return temuanbpk::all();
//     }
 
// }


class TemuanbpkExport implements FromView
{
    // use Exportable;

    public function view(): View
    {
        return view('temuanbpk.exportexcel', [
            'temuans' =>  temuanbpk::with(['temuanbpk_tindaklanjut','temuanbpk_rekomendasi','temuanbpk_disposisi.reffbagian','temuanbpk_satker.reffsatker'])->get()
        ]);
    }
 
}


