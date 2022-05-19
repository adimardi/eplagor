@section('css')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@stop
@section('js')

@stop


@extends('layouts.app')

@section('content')
<div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Satuan Kerja</h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-6 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Data Satker <small></small></h2>
              <div class="clearfix">
              </div>
            </div>
            <form action="{{ route('satker.update', $data->id) }}" method="post" enctype="multipart/form-data">
              <div class="x_content">
                  {{ csrf_field() }}
                  {{ method_field('put') }}

                  <div class="form-group row">
                    <label class="col-md-2 control-label">Kode Satker</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="kodeSatkerLengkap" class="form-control" value="{{ $data->kode_satker_lengkap }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Nama Satker</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="kodeSatkerLengkap" class="form-control" value="{{ $data->nama_satker_lengkap }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Korwil</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="korwil" class="form-control" value="{{ $data->korwil }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Tingkat Banding</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="tingkatBanding" class="form-control" value="{{ $data->tingkat_banding }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">KPKNL</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="KPKNL" class="form-control" value="{{ $data->kpnkl }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Kanwil DJKN</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="kanwilDJKN" class="form-control" value="{{ $data->kanwil_djkn }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Ketua</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="ketua" class="form-control" value="{{ $data->ketua }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">NIP Ketua</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="nipKetua" maxlength="18" minlength="18" class="form-control" value="{{ $data->ketua_nip }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Sekretaris</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="sekretaris" class="form-control" value="{{ $data->sekretaris }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">NIP Sekretaris</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="nipSekretaris" maxlength="18" minlength="18" class="form-control" value="{{ $data->sekretaris_nip }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Bendahara</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="bendahara" class="form-control" value="{{ $data->bendahara }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">NIP Bendahara</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="nipBendahara" maxlength="18" minlength="18" class="form-control" value="{{ $data->bendahara_nip }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Panitera</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="panitera" class="form-control" value="{{ $data->panitera }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">NIP Panitera</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="nipPanitera" maxlength="18" minlength="18" class="form-control" value="{{ $data->panitera_nip }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Kasir</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="kasir" class="form-control" value="{{ $data->kasir }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label">NIP Kasir</label>
                    <div class="col-md-6 col-sm-6">
                    <input type="text" name="nipKasir" maxlength="18" minlength="18" class="form-control" value="{{ $data->kasir_nip }}">
                    </div>
                  </div>

                  <input type="submit" value="Submit" class="btn btn-primary">
                  <a href="{{route('satker.index')}}" class="btn btn-light ">Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      
    </div>
</div>



@endsection