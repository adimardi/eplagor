<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class abt_usulan extends Model
{
    protected $table = "abt_usulan";
    protected $guarded = [];

    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }
}