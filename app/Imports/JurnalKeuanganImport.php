<?php

namespace App\Imports;

use Session;
use App\jurnal_keuangan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;


class JurnalKeuanganImport implements ToModel, WithHeadingRow, WithEvents
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new jurnal_keuangan([
            //
            'id' => Session::get('thang').".".$row['kdsatker'].".".$row['jnsdok1'].".".$row['nodok1'],
            'thang' => Session::get('thang'),
            'reffsatker_id' => $row['kdsatker'],
            'jnsdok' => $row['jnsdok1'],
            'tgldok' => $row['tgldok1'],
            'nodok' => $row['nodok1'],
            'jrn_bmn' => $row['jrn_bmn'],
            'uraian' => $row['uraian'],
            'perkkor' => $row['perkkor'],
            'uraian_perkkor' => $row['uraian_perkkor'],
            'perkkor1' => $row['perkkor1'],
            'uraian_perkkor1' => $row['uraian_perkkor1'],
            'rphreal' => $row['rphreal'],
        ]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $hapusData = jurnal_keuangan::where('thang',Session::get('thang'))->delete();
            },
        ];
    }

}
