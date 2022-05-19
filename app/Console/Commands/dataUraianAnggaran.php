<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\ApiJobAnggaran;
use App\Jobs\ApiJobUraianAnggaran;
use App\Jobs\ApiJobStatusAnggaran;
use App\Jobs\ApiJobRealisasiAnggaran;

use App\anggaran;
use App\reffsatker;

class dataUraianAnggaran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikeu:dataUraianAnggaran';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $options = array(

            'http' => array(
    
                'method' => 'GET',
                'header' => 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3IiOiJXZWJzZXJ2aWNlIE1haGthbWFoIEFndW5nIiwidWlkIjoiTUFIIiwicm9sIjoid2Vic2VydmljZSIsImtkcyI6IldTVjAyNiIsImtkYiI6IiIsImtkdCI6IjIwMjEiLCJpYXQiOjE2MjE1OTY1MTEsIm5iZiI6MTYyMTU5NTkxMSwia2lkIjoiMjc2MSJ9.gAYDnUlKSt_PsQ0dQmgmMQd_pThgptZ5rVQOt-UTdWU'
    
            ),
    
            'ssl' => array(
    
                'verify_peer' => false,
                'verify_peer_name' => false
    
            )
    
        );

        $reffsatkers = reffsatker::get();

        foreach ($reffsatkers as $reffsatker){
            $kodeSatker = $reffsatker->kode_satker;

            ApiJobUraianAnggaran::dispatch($options, $kodeSatker);
        }

        \logAktifitas::addToLog('Tarik API Data Uraian Anggaran');

    }
}
