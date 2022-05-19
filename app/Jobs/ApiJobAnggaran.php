<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\anggaran;


class ApiJobAnggaran implements ShouldQueue
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
      $output = file_get_contents('https://monsakti.kemenkeu.go.id/sitp-monsakti-omspan/webservice/mahkamahAgungAPI/data/'.$this->kodeSatker, false, stream_context_create($this->options));
      $output = json_decode($output);

      foreach($output as $outputs){
          // $kode_satker = $outputs->KDSATKER;

          anggaran::updateOrCreate([
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
              'kode_program' => $outputs->KODE_PROGRAM,
              'kode_kegiatan' => $outputs->KODE_KEGIATAN,
              'kode_output' => $outputs->KODE_OUTPUT,
              'kode_suboutput' => $outputs->KODE_SUBOUTPUT,
              'kode_komponen' => $outputs->KODE_KOMPONEN,
              'kode_subkomponen' => $outputs->KODE_SUBKOMPONEN,
              'kode_akun' => $outputs->KODE_AKUN,
              'kode_jenis_beban' => $outputs->KODE_JENIS_BEBAN,
              'kode_cara_tarik' => $outputs->KODE_CARA_TARIK,
              'header1' => $outputs->HEADER1,
              'header2' => $outputs->HEADER2,
              'kode_item' => $outputs->KODE_ITEM,
              'nomor_item' => $outputs->NOMOR_ITEM,
              'uraian_item' => $outputs->URAIAN_ITEM,
              'sumber_dana' => $outputs->SUMBER_DANA,
              'vol_keg_1' => $outputs->VOL_KEG_1,
              'sat_keg_1' => $outputs->SAT_KEG_1,
              'vol_keg_2' => $outputs->VOL_KEG_2,
              'sat_keg_2' => $outputs->SAT_KEG_2,
              'vol_keg_3' => $outputs->VOL_KEG_3,
              'sat_keg_3' => $outputs->SAT_KEG_3,
              'vol_keg_4' => $outputs->VOL_KEG_4,
              'sat_keg_4' => $outputs->SAT_KEG_4,
              'volkeg' => $outputs->VOLKEG,
              'satkeg' => $outputs->SATKEG,
              'hargasat' => $outputs->HARGASAT,
              'total' => $outputs->TOTAL,
              'kode_blokir' => $outputs->KODE_BLOKIR,
              'kdib' => $outputs->KDIB,
              'kode_sts_history' => $outputs->KODE_STS_HISTORY,
              'jenis_revisi' => $outputs->JENIS_REVISI,
              'revisi_ke' => $outputs->REVISI_KE,
              'nomor_dipa' => $outputs->NOMOR_DIPA,
              'tanggal_revisi' => date("Y-m-d", strtotime(str_replace('/','-',$outputs->TANGGAL_REVISI)))

          ]);
      }


    }
}
