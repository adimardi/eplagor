<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class abt_items extends Model
{
    protected $table = "abt_items";
    protected $guarded = [];

    public function reffsatker ()
    {
        return $this->belongsTo(reffsatker::class);
    }
}