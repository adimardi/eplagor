<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pagu extends Model
{


    protected $table = "pagu";

    protected $keyType = 'string';
    public $incrementing = false;


    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }

    public function belanjamodal ()
    {
        return $this->hasOne(belanjamodal::class)->withDefault();
    }

    public function reff_bas ()
    {
        return $this->belongsTo(reff_bas::class,'kdakun');
    }

    public function pagu_revisi ()
    {
        return $this->hasOne(pagu_revisi::class,'id')->withDefault();
    }




}