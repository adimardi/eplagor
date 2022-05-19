<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PaguRevisiImport; //IMPORT CLASS Dataspanrealisasi
use App\pagu_revisi;

class ImportJobPaguRevisi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        //
        $this->file = $file; //MENERIMA PARAMETER YANG DIKIRIM 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		  Excel::import(new PaguRevisiImport, public_path('Import Data Pagu/'.$this->file));
    }
}
