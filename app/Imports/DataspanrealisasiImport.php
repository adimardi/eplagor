<?php

namespace App\Imports;

use Illuminate\Http\Request;

use App\dataspan_realisasi;

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


class DataspanrealisasiImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithEvents
{
    // use Importable, RegistersEventListeners;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }

    public function  __construct($tahun,$eselon)
    {
        $this->tahun = $tahun;
        $this->eselon = $eselon;
    }


    public function model(array $row)
    {
        if($row['baes1'] == '005'.$this->eselon)
        {

            return dataspan_realisasi::updateOrCreate([
                //
                'id' => $this->tahun.".".$row['kdsatker'].".".$row['baes1'].".".$row['akun'].".".$row['program'].".".$row['kegiatan'].".".$row['output'].".".$row['kewenangan'].".".$row['sumber_dana'].".".date("Y-m-d", strtotime(str_replace('/','-',$row['tanggal']))).".".$row['amount']]
            ,[
                'dataspan_pagu_id' => $this->tahun.".".$row['kdsatker'].".".$row['baes1'].".".$row['akun'].".".$row['program'].".".$row['kegiatan'].".".$row['output'].".".$row['kewenangan'].".".$row['sumber_dana'].".".$row['cara_tarik'].".".$row['kdregister'].".".$row['lokasi'],
                'thang' => $this->tahun,
                'reffsatker_id' => $row['kdsatker'],
                'ba' => $row['ba'],
                'baes1' => $row['baes1'],
                'akun' => $row['akun'],
                'program' => $row['program'],
                'kegiatan' => $row['kegiatan'],
                'output' => $row['output'],
                'kewenangan' => $row['kewenangan'],
                'sumber_dana' => $row['sumber_dana'],
                'cara_tarik' => $row['cara_tarik'],
                'kdregister' => $row['kdregister'],
                'lokasi' => $row['lokasi'],
                'budget_type' => $row['budget_type'],
                'tanggal' => date("Y-m-d", strtotime(str_replace('/','-',$row['tanggal']))),
                'amount' => $row['amount'],
                'imported_at' => 'True',
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000; //ANGKA TERSEBUT PERTANDA JUMLAH BARIS YANG AKAN DIEKSEKUSI
    }

    public function registerEvents(): array
    {
        return [

            // Handle by a closure.
            BeforeImport::class => function(BeforeImport $event) {
                $eselon = $this->eselon;
                $updateImport = dataspan_realisasi::with('reffsatker')
                                                    ->whereHas('reffsatker', function($q) use($eselon) {
                                                        $q->where('kode_eselon', $eselon)
                                                            ;})
                                                    ->where('thang', Session::get('thang'))
                                                    ->update(['imported_at' => 'False']);
            },
			
            AfterImport::class => function(AfterImport $event) {
                $eselon = $this->eselon;
                $hapusdataspan = dataspan_realisasi::with('reffsatker')
                                                    ->whereHas('reffsatker', function($q) use($eselon) {
                                                        $q->where('kode_eselon', $eselon)
                                                            ;})
                                                    ->where('thang', Session::get('thang'))
                                                    ->where('imported_at', 'False')
                                                    ->delete();
            },
        ];
    }

}
