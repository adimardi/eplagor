<?php

namespace App\Imports;

use Illuminate\Http\Request;

use App\databelanjabarang;
use App\databelanjabarang_upload;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Auth;
use Carbon\Carbon;
use Session;


class DatabelanjabarangImport implements ToModel, WithHeadingRow
{
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

    public function  __construct($bulan,$tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function model(array $row)
    {
        if($this->transformDate($row['tglkwt'])->format('m') == $this->bulan)
        {

            return new databelanjabarang([
                //
                'id' => $this->tahun.".".Auth::user()->reffsatker_id.".".$row['kdgiat'].".".$row['kdoutput'].".".$row['kdsoutput'].".".$row['kdkmpnen'].".".$row['kdskmpnen'].".".$row['kdakun'].".".$row['kdsdana'].".".$row['nokwt'],
                'reffsatker_id' => Auth::user()->reffsatker_id,
                'tanggal_kwitansi' => $this->transformDate($row['tglkwt']),
                'no_kwitansi' => $row['nokwt'],
                'kd_kegiatan' => $row['kdgiat'],
                'kd_output' => $row['kdoutput'],
                'kds_output' => $row['kdsoutput'],
                'kd_komponen' => $row['kdkmpnen'],
                'kds_komponen' => $row['kdskmpnen'],
                'kd_akun' => $row['kdakun'],
                'kds_dana' => $row['kdsdana'],
                'uraian' => $row['uraian'],
                'nm_trim' => $row['nmtrim'],
                'nilai' => $row['rupiah'],
                'no_transaksi' => $row['notran'],
                'no_pjk' => $row['nopjk'],
                'no_drpp' => $row['nodrpp'],
                'no_spby' => $row['nospby'],
                'no_dpt' => $row['nodpt'],
                'tahun_anggaran' => $row['thang'],
                'kkp' => $row['kkp'],
                'kdanaks' => $row['kdanaks'],
                ]);

                Session::flash('title', 'Berhasil');
                Session::flash('text', 'Data Bulan '.$this->bulan.' Berhasil Di Tambahkan');
                Session::flash('type', 'success');
                Session::flash('styling', 'bootstrap3');
    


        }

        Session::flash('title', 'Gagal');
        Session::flash('text', 'File tidak sesuai untuk upload bulan '.$this->bulan);
        Session::flash('type', 'error');
        Session::flash('styling', 'bootstrap3');


    }
}
