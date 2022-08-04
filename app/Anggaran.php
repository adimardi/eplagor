<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;
use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;

use DB;

class anggaran extends Model
{
    use LaravelSubQueryTrait;

    protected $table = "anggaran";

    protected $keyType = 'string';
    public $incrementing = false;


    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }

    public function reff_bas ()
    {
        return $this->belongsTo(reff_bas::class,'kode_akun');
    }

}