<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usulan_pa extends Model
{
    protected $table = "usulan_pa";

    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];


    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }
}