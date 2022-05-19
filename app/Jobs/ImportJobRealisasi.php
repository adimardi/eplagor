<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataspanrealisasiImport; //IMPORT CLASS Dataspanrealisasi
use App\dataspan_realisasi;

class ImportJobRealisasi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file;
    protected $tahun;
    protected $eselon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file,$tahun,$eselon)
    {
        //
        $this->file = $file; //MENERIMA PARAMETER YANG DIKIRIM 
        $this->tahun = $tahun; //MENERIMA PARAMETER YANG DIKIRIM 
        $this->eselon = $eselon; //MENERIMA PARAMETER YANG DIKIRIM 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		  Excel::import(new DataspanrealisasiImport($this->tahun,$this->eselon), public_path('Import Data SPAN/'.$this->file));
    }
}
