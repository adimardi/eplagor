<?php

namespace App\Imports;

use App\Temuanbpk;
use Maatwebsite\Excel\Concerns\ToModel;

class TemuanbpkImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new temuanbpk([
            //
            'tahun_temuan' => $row[0],
            'jenis_temuan' => $row[1],
            'lhp_bpk' => $row[2],
            'status' => $row[3],
            'lampiran' => $row[4],
        ]);
    }
}
