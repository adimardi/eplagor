<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reffsatker extends Model
{
    protected $table = "reffsatker";

    protected $casts = ['id'=>'string'];
    public $incrementing = false;


    public function temuanbpk_satker()
    {
    	return $this->hasMany(temuanbpk_satker::class);
    }

    public function pinjampakaitanah()
    {
    	return $this->hasMany(pinjampakaitanah::class);
    }

    public function penghapusan()
    {
    	return $this->hasMany(penghapusan::class);
    }

    public function hibah()
    {
    	return $this->hasMany(hibah::class);
    }


    public function transaksibmn()
    {
    	return $this->hasMany(transaksibmn::class);
    }

    public function saldo_akrual()
    {
    	return $this->hasMany(saldo_akrual::class);
    }

    public function users()
    {
    	return $this->hasMany(users::class);
    }

    public function piutangpnbp()
    {
    	return $this->hasMany(piutangpnbp::class);
    }

    public function piutanglainnya()
    {
    	return $this->hasMany(piutanglainnya::class);
    }

    public function rekeninglainnya()
    {
    	return $this->hasMany(rekening_lainnya::class);
    }

    public function suratmasuk()
    {
    	return $this->hasMany(suratmasuk::class);
    }

    public function koreksilk()
    {
    	return $this->hasMany(koreksilk::class);
    }

    public function jurnalpenyesuaian()
    {
    	return $this->hasMany(jurnalpenyesuaian::class);
    }

    public function pendapatansewa()
    {
    	return $this->hasMany(pendapatansewa::class);
    }

    public function pensiun()
    {
    	return $this->hasMany(pensiun::class);
    }

    public function belanjamodal()
    {
    	return $this->hasMany(belanjamodal::class);
    }

    public function databelanjabarang()
    {
    	return $this->hasMany(databelanjabarang::class);
    }

    public function databelanjabarang_upload()
    {
    	return $this->hasMany(databelanjabarang_upload::class);
    }

    public function pagu()
    {
    	return $this->hasMany(pagu::class);
    }

    public function pagu_revisi()
    {
    	return $this->hasMany(pagu_revisi::class);
    }

    public function dataspan_pagu()
    {
    	return $this->hasMany(dataspan_pagu::class);
    }

    public function dataspan_realisasi()
    {
    	return $this->hasMany(dataspan_realisasi::class);
    }

    public function dataspan_estimasipnbp()
    {
    	return $this->hasMany(dataspan_estimasipnbp::class);
    }

    public function dataspan_realisasipnbp()
    {
    	return $this->hasMany(dataspan_realisasipnbp::class);
    }

    public function pemeriksaankeuperkara()
    {
    	return $this->hasMany(pemeriksaankeuperkara::class);
    }

    public function pemeriksaanKasModel()
    {
    	return $this->hasMany(pemeriksaanKasModel::class);
    }

    public function capaiankinerja()
    {
    	return $this->hasMany(capaiankinerja::class);
    }

    public function prepaid()
    {
    	return $this->hasMany(prepaid::class);
    }


    public function kontrak()
    {
    	return $this->hasMany(kontrak::class);
    }


    public function asiap()
    {
    	return $this->hasMany(asiap::class);
    }

    public function asiap_aset()
    {
    	return $this->hasMany(asiap_aset::class);
    }

    public function pipk()
    {
    	return $this->hasMany(pipk::class);
    }

    public function pipk_penilaian()
    {
    	return $this->hasMany(pipk_penilaian::class);
    }

    public function pipk_review()
    {
    	return $this->hasMany(pipk_review::class);
    }

    public function jurnal_keuangan()
    {
    	return $this->hasMany(jurnal_keuangan::class);
    }



}
