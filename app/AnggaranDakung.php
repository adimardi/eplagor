<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnggaranDakung extends Model
{
    protected $table = "anggaran_dakung";
    protected $guarded = [];

    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }

}