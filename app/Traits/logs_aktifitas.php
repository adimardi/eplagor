<?php

namespace App\Traits;

use Request;
use App\logs_aktifitas as logsAktifitasModel;

class logs_aktifitas

{
    public static function addToLog ($subject)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['users_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        logsAktifitasModel::create($log);
    }

    public static function logAktifitasList()
    {
        return logsAktifitasModel::lastest()->get;
    }

}