<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\anggaran_uraian;


class ApiJobUraianAnggaran implements ShouldQueue
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
    
    
        $output = file_get_contents('https://monsakti.kemenkeu.go.id/sitp-monsakti-omspan/webservice/mahkamahAgungAPI/refUraian/'.$this->kodeSatker, false, stream_context_create($this->options));
        $output = json_decode($output);

      foreach($output as $outputs){
          // $kode_satker = $outputs->KDSATKER;

          anggaran_uraian::updateOrCreate([
              'id' => '2021'.'.'.
                      $outputs->KDSATKER.'.'.
                      $outputs->KODE_PROGRAM.'.'.
                      $outputs->KODE_KEGIATAN.'.'.
                      $outputs->KODE_OUTPUT.'.'.
                      $outputs->KODE_SUBOUTPUT.'.'.
                      $outputs->KODE_KOMPONEN.'.'.
                      $outputs->KODE_SUBKOMPONEN.'.'.
                      $outputs->KODE_AKUN.'.'.
                      $outputs->KODE_ITEM.'.'.
                      $outputs->KODE_STS_HISTORY,]
              ,[
              'thang' => '2021',
              'reffsatker_id' => $outputs->KDSATKER,
              'kode_sts_history' => $outputs->KODE_STS_HISTORY,
              'kode_program' => $outputs->KODE_PROGRAM,
              'uraian_program' => $outputs->URAIAN_PROGRAM,
              'kode_kegiatan' => $outputs->KODE_KEGIATAN,
              'uraian_kegiatan' => $outputs->URAIAN_KEGIATAN,
              'kode_output' => $outputs->KODE_OUTPUT,
              'uraian_output' => $outputs->URAIAN_OUTPUT,
              'kode_suboutput' => $outputs->KODE_SUBOUTPUT,
              'uraian_suboutput' => $outputs->URAIAN_SUBOUTPUT,
              'kode_komponen' => $outputs->KODE_KOMPONEN,
              'uraian_komponen' => $outputs->URAIAN_KOMPONEN,
              'kode_subkomponen' => $outputs->KODE_SUBKOMPONEN,
              'uraian_subkomponen' => $outputs->URAIAN_SUBKOMPONEN,
              'kode_akun' => $outputs->KODE_AKUN,
              'uraian_akun' => $outputs->URAIAN_AKUN,
              'kode_item' => $outputs->KODE_ITEM
          ]);
      }


    }
}
