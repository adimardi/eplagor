<?php

namespace App\Imports;

use Illuminate\Http\Request;

use App\pagu_revisi;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue; //IMPORT SHOUDLQUEUE
use Maatwebsite\Excel\Concerns\WithChunkReading; //IMPORT CHUNK READIN

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
 
use RealRashid\SweetAlert\Facades\Alert;

use Auth;
use Carbon\Carbon;
use Session;


class PaguRevisiImport implements ToModel, WithHeadingRow, WithEvents, WithChunkReading, ShouldQueue
{
    use Importable;

    public function model(array $row)
    {
            return new pagu_revisi([
                //
                'id' => $row['thang'].".".$row['kddept'].".".$row['kdunit'].".".$row['kdlokasi'].".".$row['kdsatker'].".".$row['kdprogram'].".".$row['kdgiat'].".".$row['kdoutput'].".".$row['kdsoutput'].".".$row['kdkmpnen'].".".$row['kdskmpnen'].".".$row['kdakun'].".".$row['noitem'],
                'thang' => $row['thang'],
                'kdjendok' => $row['kdjendok'],
                'reffsatker_id' => $row['kdsatker'],
                'kddept' => $row['kddept'],
                'kdunit' => $row['kdunit'],
                'kdprogram' => $row['kdprogram'],
                'kdgiat' => $row['kdgiat'],
                'kdoutput' => $row['kdoutput'],
                'kdlokasi' => $row['kdlokasi'],
                'kdkabkota' => $row['kdkabkota'],
                'kddekon' => $row['kddekon'],
                'kdsoutput' => $row['kdsoutput'],
                'kdkmpnen' => $row['kdkmpnen'],
                'kdskmpnen' => $row['kdskmpnen'],
                'kdakun' => $row['kdakun'],
                'kdkppn' => $row['kdkppn'],
                'noitem' => $row['noitem'],
                'nmitem' => $row['nmitem'],
                'vol1' => $row['vol1'],
                'sat1' => $row['sat1'],
                'vol2' => $row['vol2'],
                'sat2' => $row['sat2'],
                'vol3' => $row['vol3'],
                'sat3' => $row['sat3'],
                'vol4' => $row['vol4'],
                'sat4' => $row['sat4'],
                'volkeg' => $row['volkeg'],
                'satkeg' => $row['satkeg'],
                'hargasat' => $row['hargasat'],
                'jumlah' => $row['jumlah']
            ]);
    }

    public function chunkSize(): int
    {
        return 1000; //ANGKA TERSEBUT PERTANDA JUMLAH BARIS YANG AKAN DIEKSEKUSI
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $hapusData = pagu_revisi::where('thang', Session::get('thang'))->delete();
            },
        ];
    }

}
