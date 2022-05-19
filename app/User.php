<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // protected $fillable = [
    //     'name', 'email', 'password','gambar', 'level','reffbagian_id', 'reffsatker_id','nip','telephone'
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reffbagian()
    {
        return $this->belongsTo(reffbagian::class);
    }

    public function reffsatker()
    {
        return $this->belongsTo(reffsatker::class);
    }

}

class users extends Model
{
    //
    protected $table = "users";
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [];
    
    
    public function temuanbpk_tindaklanjut()
    {
        return $this->hasMany(temuanbpk_tindaklanjut::class);
    }

    public function reffbagian()
    {
        return $this->belongsTo(reffbagian::class);
    }

    public function reffsatker()
    {
        return $this->belongsTo(reffsatker::class);
    }

    public function logs()
    {
        return $this->hasMany(logs::class);
    }

    public function rekeninglainnya()
    {
        return $this->hasMany(rekeninglainnya::class);
    }

    public function rekeninglainnya_saldo()
    {
        return $this->hasMany(rekeninglainnya_saldo::class);
    }

    public function referensi()
    {
        return $this->hasMany(referensi::class);
    }

    public function suratmasuk_tindaklanjut()
    {
        return $this->hasMany(suratmasuk_tindaklanjut::class);
    }

    public function koreksilk()
    {
        return $this->hasMany(koreksilk::class);
    }

    public function pendapatansewa()
    {
        return $this->hasMany(pendapatansewa::class);
    }

    public function pendapatansewa_pembayaran()
    {
        return $this->hasMany(pendapatansewa_pembayaran::class);
    }

    public function databelanjabarang_upload()
    {
        return $this->hasMany(databelanjabarang_upload::class);
    }

    public function databelanjabarang_lampiran()
    {
        return $this->hasMany(databelanjabarang_lampiran::class);
    }

    public function jurnal_keuangan_penjelasan()
    {
        return $this->hasMany(jurnal_keuangan_penjelasan::class);
    }



    
}