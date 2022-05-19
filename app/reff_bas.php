<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reff_bas extends Model
{
    protected $table = "reff_bas";

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

    public function databelanjabarang()
    {
    	return $this->hasMany(databelanjabarang::class);
    }

    public function prepaid()
    {
    	return $this->hasMany(prepaid::class);
    }

    //
}
