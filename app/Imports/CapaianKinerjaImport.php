<?php

namespace App\Imports;

use App\capaiankinerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use Session;

class CapaianKinerjaImport implements ToModel, WithHeadingRow, WithEvents
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new capaiankinerja([
            //

            'thang' => Session::get('thang'),
            'reffsatker_id' => $row['kode_satker'],
            'penyerapan_anggaran' => $row['penyerapan'],
            'konsistensi_rpd_awal' => $row['konsistensi'],
            'konsistensi_rpd_akhir' => $row['konsistensi'],
            'capaian_keluaran' => $row['cro'],
            'efisiensi' => $row['efisiensi'],
            'nilai_efisiensi' => $row['nilai_efisiensi'],
            'nilai_kinerja' => $row['kinerja'],
        ]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $hapusData = capaiankinerja::where('thang',Session::get('thang'))->delete();
            },
        ];
    }

}
