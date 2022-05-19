@section('css')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@stop
@section('js')

<script type="text/javascript">
        function readURL() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).prev().attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $(".uploads").change(readURL)
            $("#f").submit(function(){
                // do ajax submit or just classic form submit
              //  alert("fake subminting")
                return false
            })
        })


var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('submit').disabled = false;
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
  } else {
    document.getElementById('submit').disabled = true;
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
  }
}
    </script>
@stop

@extends('layouts.app')

@section('content')
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Data User</h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-6 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Tambah User Baru <small></small></h2>
              <div class="clearfix">
            </div>
            <div class="col-lg-12">
              @if (Session::has('message'))
              <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">{{ Session::get('message') }}</div>
              @endif
            </div>
            </div>
            <div class="x_content">
              <br/>
              <form class="form-label-left input_mask" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div class="form-group col-md-12 col-sm-12 has-feedback">
                  <input type="text" class="form-control has-feedback-left" name="name" value="{{ old('name') }}" required id="name" placeholder="Nama">
                  @if ($errors->has('name'))
                  <span class="fa fa-user form-control-feedback left help-block" aria-hidden="true">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>

                <div class="form-group col-md-6 col-sm-6 has-feedback">
                  <input type="text" class="form-control has-feedback-left" name="username" value="{{ old('username') }}" required id="username" placeholder="Username">
                  @if ($errors->has('username'))
                  <span class="fa fa-user form-control-feedback left help-block" aria-hidden="true">
                    <strong>{{ $errors->first('username') }}</strong>
                  </span>
                  @endif
                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>

                
                <div class="form-group col-md-6 col-sm-6 has-feedback">
                  <input type="email" class="form-control has-feedback-right" name="email" value="{{ old('email') }}" required id="email" placeholder="E-Mail">
                  @if ($errors->has('email'))
                  <span class="fa fa-envelope form-control-feedback right help-block" aria-hidden="true">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
                  <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-md-2 control-label">Gambar</label>
                  <div class="col-md-3">
                    <img class="product" width="80" height="100" />
                    <input type="file" class="uploads form-control" style="margin-top: 20px;" name="gambar">
                  </div>
                </div>                  
                <div class="form-group row">
                  <label for="level" class="col-md-2 control-label">Level</label>
                  <div class="col-md-5">
                    <select size="2" class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="level" required="required">
                      @if(Auth::user()->level == 'root')
                      <option value="admin">Admin</option>
                      @endif
                      <option value="user">User</option>
                    </select>
                  </div>
                </div>
                @if (Auth::user()->kantor == 'pusat')
                <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                  <label for="level" class="col-md-2 control-label">kewenangan</label>
                  <div class="col-md-5">
                    <select size="2" class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="kewenangan" required="required">
                      <option value="pusat">Pusat</option>
                      <option value="dirjen">Dirjen</option>
                      <option value="eselon_1">Eselon 1</option>
                      <option value="banding">Banding</option>
                      <option value="korwil">Korwil</option>
                      <option value="satker">Satker</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                  <label for="level" class="col-md-2 control-label">Bagian</label>
                  <div class="col-md-5 col-sm-6 ">
                    <select size="2" class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="reffbagian_id">
                      @foreach($reffbagians as $reffbagian)
                    <option data-tokens="ketchup mustard" value="{{$reffbagian->id}}">{{$reffbagian->eselon_3}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @else
                <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                  <label for="level" class="col-md-2 control-label">kewenangan</label>
                  <div class="col-md-5">
                    <select size="2" class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="kewenangan" required="required">
                      <option value="satker">Satker</option>
                    </select>
                  </div>
                </div>
                @endif
                <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                  <label class="col-md-2 control-label">Satker</label>
                  <div class="col-md-5 col-sm-6 ">
                    <select size="2" class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="reffsatker_id" required="required">
                      @foreach($reffsatkers as $reffsatker)
                      <option data-tokens="ketchup mustard" value="{{$reffsatker->id}}">{{$reffsatker->nama_satker}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                  <label class="col-md-2 control-label">NIP</label>
                  <div class="col-md-5 col-sm-6 ">
                    <input type="text" class="form-control" maxlength="18" minlength="18" name="nip">
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                  <label class="col-md-2 control-label">Telephone</label>
                  <div class="col-md-5 col-sm-6 ">
                    <input type="text" class="form-control" name="telephpne">
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                  <label class="col-md-2 control-label">Jabatan</label>
                  <div class="col-md-6 col-sm-6 ">
                    <select size="2" class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="jabatan">
                      <option value="Ketua">Ketua</option>
                      <option value="Panitera">Panitera</option>
                      <option value="Sekretaris">Sekretaris</option>
                      <option value="Operator">Operator</option>
                      <option value="Kasir">Kasir</option>
                      <option value="Bendahara Pengeluaran">Bendahara Pengeluaran</option>
                      <option value="Bendahara Penerimaan">Bendahara Penerimaan</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password" class="col-md-2 control-label">Password</label>
                  <div class="col-md-5">
                    <input id="password" type="password" class="form-control" onkeyup='check();' name="password" required>
                    @if ($errors->has('password'))
                      <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password-confirm" class="col-md-2 control-label">Confirm Password</label>
                  <div class="col-md-5">
                    <input id="confirm_password" type="password" onkeyup="check()" class="form-control" name="password_confirmation" required>
                      <span id='message'></span>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary" id="submit">
                    Register
                </button>
                <button type="reset" class="btn btn-danger">
                    Reset
                </button>
                <a href="{{route('user.index')}}" class="btn btn-light ">Back</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection