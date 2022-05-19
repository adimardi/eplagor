<?php

namespace App\Exports;

use App\piutangpnbp;
use App\piutangpnbp_pembayaran;
use App\reffsatker;
use App\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\View\View;




class PiutangpnbpExport implements FromView, ShouldAutoSize
{
    // use Exportable;

    public function view(): View
    {
        return view('piutangpnbp.exportexcel', [
            'piutangpnbps' =>  piutangpnbp::with('reffsatker', 'piutangpnbp_pembayaran')->get()
            ]);
    }


 
}


