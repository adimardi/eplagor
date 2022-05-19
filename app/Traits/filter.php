<?php

namespace App\Traits;
use Auth;


trait filter {
    public function filterUser($query)
    {
        if(Auth::user()->kantor == 'satker')
        {
            return $query->whereReffsatker_id(Auth::user()->reffsatker_id);
        }elseif(Auth::user()->kantor == 'korwil'){
            return $query->whereHas('reffsatker', function($q){
                        $q->where('korwil',Auth::user()->reffsatker->korwil)
                            ;});
        }elseif(Auth::user()->kantor == 'banding'){
            return $query->whereHas('reffsatker', function($q){
                        $q->where('tingkat_banding',Auth::user()->reffsatker->tingkat_banding)
                            ;});
        }elseif(Auth::user()->kantor == 'eselon_1'){
            return $query->whereHas('reffsatker', function($q){
                          $q->where('kode_eselon',Auth::user()->reffsatker->kode_eselon)
                            ;});
        }elseif(Auth::user()->kantor == 'dirjen'){
            return $query->whereHas('reffsatker', function($q){
                        $q->where('dirjen',Auth::user()->reffsatker->dirjen)
                            ;});
        }else{
            return $query;
        }
    }

    public function filterUserReffSatker($query)
    {
        if(Auth::user()->kantor == 'satker'){
            $query->whereId(Auth::user()->reffsatker_id);
        }elseif(Auth::user()->kantor == 'korwil'){
            $query->wherekorwil(Auth::user()->reffsatker->korwil);
        }elseif(Auth::user()->kantor == 'banding'){
            $query->whereTingkat_banding(Auth::user()->reffsatker->tingkat_banding);
        }elseif(Auth::user()->kantor == 'eselon_1'){
            $query->whereKode_eselon(Auth::user()->reffsatker->kode_eselon);
        }elseif(Auth::user()->kantor == 'dirjen'){
            $query->whereDirjen(Auth::user()->reffsatker->dirjen);
        }else{
            $query;
        }
    }

    public function filterKatagori($filter)
    {
        $filter->when(request('filter_wilayah'), function ($wilayah) {
            return $wilayah->whereHas('reffsatker', function($q){
                $q->where('kode_wilayah', request('filter_wilayah'));
            });
        });
        $filter->when(request('filter_eselon'), function ($eselon) {
            return $eselon->whereHas('reffsatker', function($q){
                $q->where('kode_eselon', request('filter_eselon'));
            });
        });
        $filter->when(request('filter_peradilan'), function ($peradilan) {
            return $peradilan->whereHas('reffsatker', function($q){
                $q->where('dirjen', request('filter_peradilan'));
            });
        });
        $filter->when(request('filter_akunSpan'), function ($akun) {
            return $akun->where('akun','LIKE',request('filter_akunSpan')."%");
        });
    }

    public function filterKatagoriReffSatker($filter)
    {
        $filter->when(request('filter_wilayah'), function ($wilayah) {
            return $wilayah->where('kode_wilayah', request('filter_wilayah'));
            });
        $filter->when(request('filter_eselon'), function ($eselon) {
            return $eselon->where('kode_eselon', request('filter_eselon'));
            });
        $filter->when(request('filter_peradilan'), function ($peradilan) {
            return $peradilan->where('dirjen', request('filter_peradilan'));
            });

        $filter->when(request('filter_akunSpan'), function ($akun) {
            return $akun->where('akun','LIKE',request('filter_akunSpan')."%");
        });
    }

    public function filterKatagoriReffSatkerRekonPenghapusan($filter)
    {
        $filter->when(request('filter_wilayah'), function ($wilayah) {
            return $wilayah->where('kode_wilayah', request('filter_wilayah'));
            });
        $filter->when(request('filter_eselon'), function ($eselon) {
            return $eselon->where('kode_eselon', request('filter_eselon'));
            });
        $filter->when(request('filter_peradilan'), function ($peradilan) {
            return $peradilan->where('dirjen', request('filter_peradilan'));
            });

        $filter->when(request('filter_akunSpan'), function ($akun) {
            return $akun->where('akun','LIKE',request('filter_akunSpan')."%");
        });
    }


}