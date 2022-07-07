<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaselineDakung extends Model
{
    protected $table = "baseline_dakung";
    protected $guarded = [];

    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }

}