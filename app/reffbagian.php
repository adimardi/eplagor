<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reffbagian extends Model
{
    //
    protected $table = "reffbagian";

    public function users()
    {
    	return $this->hasMany(users::class);
    }

    public function temuanbpk_disposisi()
    {
    	return $this->hasMany(temuanbpk_disposisi::class);
    }

    public function suratmasuk_disposisi()
    {
    	return $this->hasMany(suratmasuk_disposisi::class);
    }
}
