<?php

namespace App\Imports;

use App\kontrak;
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

class KontrakImport implements ToModel, WithHeadingRow, WithEvents
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return kontrak::updateOrCreate ([
            'nomor_kontrak' => $row['nomor_kontrak']]
        ,[
            'thang' => Session::get('thang'),
            'reffsatker_id' => $row['kode_satker'],
            'kelompok' => $row['kelompok'],
            'nomor_po_can' => $row['nomor_po_can'],
            'supplier' => $row['supplier'],
            'tanggal_approve' => $row['tanggal_approve'],
            'nomor_kontrak' => $row['nomor_kontrak'],
            'uraian_kontrak' => $row['uraian_kontrak'],
            'tanggal_mulai' => date("Y-m-d", strtotime(str_replace('/','-',$row['tanggal_mulai']))),
            'tanggal_berakhir' => date("Y-m-d", strtotime(str_replace('/','-',$row['tanggal_berakhir']))),
            'nilai_kontrak' => $row['nilai_kontrak'],
            'nilai_realisasi' => $row['nilai_realisasi'],
            'sisa_kontrak' => $row['sisa_kontrak'],
        ]);

    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $hapusData = kontrak::where('thang', Session::get('thang'))->delete();
            },
        ];
    }


}
