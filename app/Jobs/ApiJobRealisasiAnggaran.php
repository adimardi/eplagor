<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\anggaran_realisasi;


class ApiJobRealisasiAnggaran implements ShouldQueue
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
    
    
        $output = file_get_contents('https://monsakti.kemenkeu.go.id/sitp-monsakti-omspan/webservice/mahkamahAgungAPI/realisasi/'.$this->kodeSatker, false, stream_context_create($this->options));
        $output = json_decode($output);

      foreach($output as $outputs){
          // $kode_satker = $outputs->KDSATKER;

          anggaran_realisasi::updateOrCreate([
              'id' => '2021'.'.'.
                      $outputs->KDSATKER.'.'.
                      $outputs->PROGRAM.'.'.
                      $outputs->KEGIATAN.'.'.
                      $outputs->OUTPUT.'.'.
                      $outputs->SUMBER_DANA.'.'.
                      $outputs->AKUN.'.'.
                      date("Y-m-d", strtotime(str_replace('/','-',$outputs->TANGGAL_REALISASI))).'.'.
                      $outputs->JUMLAH_REALISASI]
              ,[
              'thang' => '2021',
              'reffsatker_id' => $outputs->KDSATKER,
              'program' => $outputs->PROGRAM,
              'kegiatan' => $outputs->KEGIATAN,
              'output' => $outputs->OUTPUT,
              'sumber_dana' => $outputs->SUMBER_DANA,
              'akun' => $outputs->AKUN,
              'jumlah_realisasi' => $outputs->JUMLAH_REALISASI,
              'tanggal_realisasi' => date("Y-m-d", strtotime(str_replace('/','-',$outputs->TANGGAL_REALISASI))),
          ]);
      }


    }
}
