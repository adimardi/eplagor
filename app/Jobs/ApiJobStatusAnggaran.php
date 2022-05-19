<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\anggaran_status;


class ApiJobStatusAnggaran implements ShouldQueue
{
    public $tries = 5;
    public $timeout = 0;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $options;
    protected $kodeSatker;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($options, $kodeSatker)
    {
        //
        $this->options = $options; //MENERIMA PARAMETER YANG DIKIRIM 
        $this->kodeSatker = $kodeSatker; //MENERIMA PARAMETER YANG DIKIRIM 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    
    
        $output = file_get_contents('https://monsakti.kemenkeu.go.id/sitp-monsakti-omspan/webservice/mahkamahAgungAPI/refSts/'.$this->kodeSatker, false, stream_context_create($this->options));
        $output = json_decode($output);

      foreach($output as $outputs){
          // $kode_satker = $outputs->KDSATKER;

          anggaran_status::updateOrCreate([
              'id' => $outputs->ID,]
              ,[
              'thang' => '2021',
              'reffsatker_id' => $outputs->KDSATKER,
              'pagu_belanja' => $outputs->PAGU_BELANJA,
              'jenis_revisi' => $outputs->JENIS_REVISI,
              'kode_sts_history' => $outputs->KODE_STS_HISTORY,
              'revisi_ke' => $outputs->REVISI_KE,
              'no_dipa' => $outputs->NO_DIPA,
              'tanggal_dipa' => date("Y-m-d", strtotime(str_replace('/','-',$outputs->TGL_DIPA))),
              'tanggal_revisi' => date("Y-m-d", strtotime(str_replace('/','-',$outputs->TGL_REVISI))),
          ]);
      }


    }
}
