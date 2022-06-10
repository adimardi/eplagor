@section('css')
@stop

@section('js')
<script type="text/javascript">

  $('#password, #confirm_password').on('keyup', function () {
    if ($('#password').val() == $('#confirm_password').val()) {
      $('#message').html('Matching').css('color', 'green');
      // document.getElementById('submit').disabled = false;
    } else 
      $('#message').html('Not Matching').css('color', 'red');
      // document.getElementById('submit').disabled = true;
  });

</script>

@stop


@extends('layouts.app')

@section('content')

<div class="container-fluid px-2 px-md-4">
  <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
    <span class="mask  bg-gradient-primary  opacity-6"></span>
  </div>
  <div class="card card-body mx-3 mx-md-4 mt-n6">
    <div class="row gx-4 mb-2">
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img src="{{ asset($data->gambar == null || !file_exists(public_path('images/user/' . $data->gambar)) ? 'images/user.png' : 'images/user/' . $data->gambar) }}"  class="navbar-brand-img h-100"/>
        </div>
      </div>
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1">
            {{ $data->name }}
          </h5>
          <p class="mb-0 font-weight-normal text-sm">
            {{ $data->email }}
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="row">
        <div class="col-12 col-xl-6">
          <div class="card card-plain h-100">
            <div class="card-body p-3">
              <ul class="list-group">
                <li class="list-group-item border-0 ps-0 text-sm">
                  <label class="col-4">
                    <strong class="text-dark">Level</strong>
                  </label>{{ $data->level }}
                </li>
                <li class="list-group-item border-0 ps-0 text-sm"><label class="col-4"><strong class="text-dark">Bagian</strong></label>{{ $data->reffbagian_id != null ? $data->reffbagian->eselon_3 : "-" }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><label class="col-4"><strong class="text-dark">Satker</strong></label>{{$data->reffsatker->nama_satker}}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><label class="col-4"><strong class="text-dark">NIP</strong></label>{{ $data->nip }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><label class="col-4"><strong class="text-dark">Telephone</strong></label>{{ $data->telephone }}</li>
                <li class="list-group-item border-0 ps-0 text-sm"><label class="col-4"><strong class="text-dark">Jabatan</strong></label>{{ $data->jabatan }}</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-6">
          <div class="card card-plain h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Password</h6>
            </div>
            <div class="card-body p-3">
              <form action="{{ route('user.update', $data->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('put') }}

                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Password</label>
                  <input id="password" type="password" class="form-control" name="password">
                </div>
                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Confirm Password</label>
                  <input id="confirm_password" type="password" class="form-control" name="confirm_password">
                </div>
                <h6><span id='message'></span></h6>
                <button type="submit" class="btn btn-primary" id="submit">
                  Update
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

