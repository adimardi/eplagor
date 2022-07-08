<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baseline extends Model
{
    protected $table = "baseline";
    protected $guarded = [];

    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }

}