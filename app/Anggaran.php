<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = "anggaran";
    protected $keyType = 'string';
    public $incrementing = false;

    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }
}