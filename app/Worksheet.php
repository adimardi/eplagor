<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    protected $table = "worksheet_";
    protected $keyType = 'string';
    public $incrementing = false;

    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }
}