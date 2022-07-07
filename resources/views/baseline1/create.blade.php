@section('js')

<script type="text/javascript">
  $(document).ready(function() {

    $("#volume1").keyup(function(){
      var v1 = $("#volume1").val();
      if(v1 <= 1 && v1 != "") {
        $("#volume1").val(1);
        $("#volume1x").val(v1);
        vkali()
      } else {
        $("#volume1").val();
        $("#volume1x").val(v1);
        vkali()
      }
    });

    $("#volume2").keyup(function(){
      var v2 = $("#volume2").val();
      if(v2 <= 1 && v2 != "") {
        $("#volume2").val(1);
        $("#volume2x").val(v2);
        vkali()
      } else {
        $("#volume2").val();
        $("#volume2x").val(v2);
        vkali()
      }
    });

    $("#volume3").keyup(function(){
      var v3 = $("#volume3").val();
      if(v3 <= 1 && v3 != "") {
        $("#volume3").val(1);
        $("#volume3x").val(v3);
        vkali()
      } else {
        $("#volume3").val();
        $("#volume3x").val(v3);
        vkali()
      }
    });

    $("#volume4").keyup(function(){
      var v4 = $("#volume4").val();
      if(v4 <= 1 && v4 != "") {
        $("#volume4").val(1);
        $("#volume4x").val(v4);
        vkali()
      } else {
        $("#volume4").val();
        $("#volume4x").val(v4);
        vkali()
      }
    });

    function vkali() {
      var a = $('#volume1').val();
      var b = $('#volume2').val();
      var c = $('#volume3').val();
      var d = $('#volume4').val();
      
      var z = a * b * c * d;

      //alert(z);
      $("#volumeKegiatan").val(z);
    }

    $("#hargaSatuan").keyup(function(){
      var strval =  $("#hargaSatuan").val();
      if(strval == "") {
        //alert("tidak boleh kosong");
      } else {
        hkali()
        //alert("data ada");
      }
    });

    function hkali() {
      var a = $('#hargaSatuan').val();
      var b = $('#volumeKegiatan').val();
      var c = a * b;
      
      //alert(c);
      $("#jumlah").val(c);
    }

});
</script>


@stop

@section('css')
@stop


@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Tambah {{ $config['pageTitle']  }}</h6>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="row p-3">
            <div class="col-12">

              	<button class="btn bg-gradient-danger" onclick="history.back()">
                    <i class="fa fa-arrow-left me-2"></i>kembali
                </button>

              <hr>

              <div id="mForm" style="display: block;">
              <form method="post" autocomplete="off" action="{{ route('baseline3.store') }}">
              <div class="card-body pb-2">
                <div class="row">
                  <div class="col-md-4">
                    <input
                      type="hidden"
                      name="_token"
                      value="{{ csrf_token() }}"
                    />

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Satuan Kerja</label>
                      <input type="hidden" id="idPagu" name="idPagu">
                      <input type="text" id="kodeSatker" name="kodeSatker" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Nama Satuan Kerja</label>
                      <input type="text" id="namaSatker" name="namaSatker" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Departemen</label>
                      <input type="text" id="kodeDepartemen" name="kodeDepartemen" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Unit</label>
                      <input type="text" id="kodeUnit" name="kodeUnit" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Lokasi</label>
                      <input type="text" id="kodeLokasi" name="kodeLokasi" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Kabupaten Kota</label>
                      <input type="text" id="kodeKabkot" name="kodeKabkot" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label for="exampleFormControlSelect1" class="ms-0">Kode Program</label>
                      <input type="text" id="kodeProgram" name="kodeProgram" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label for="exampleFormControlSelect1" class="ms-0">Kode Kegiatan</label>
                      <input type="text" id="kodeKegiatan" name="kodeKegiatan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label for="exampleFormControlSelect1" class="ms-0">Kode Output</label>
                      <input type="text" id="kodeOutput" name="kodeOutput" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label for="exampleFormControlSelect1" class="ms-0">Kode Sub Output</label>
                      <input type="text" id="kodeSubOutput" name="kodeSubOutput" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-static mb-2">
                      <label>Kode Dekon</label>
                      <input type="text" id="kodeDekon" name="kodeDekon" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Komponen</label>
                      <input type="text" id="kodeKomponen" name="kodeKomponen" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Sub Komponen</label>
                      <input type="text" id="kodeSubKomponen" name="kodeSubKomponen" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode Akun</label>
                      <input type="text" id="kodeAkun" name="kodeAkun" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Kode KPPN</label>
                      <input type="text" id="kodeKppn" name="kodeKppn" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Nomor Item</label>
                      <input type="number" id="nomorItem" name="nomorItem" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Nama Item</label>
                      <input type="text" id="namaItem" name="namaItem" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Volume 1</label>
                      <input type="number" id="volume1" name="volume1" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                      <input id="volume1x" name="volume1x" type="hidden">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Satuan 1</label>
                      <input type="text" id="satuan1" name="satuan1" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Volume 2</label>
                      <input type="number" id="volume2" name="volume2" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                      <input id="volume2x" name="volume2x" type="hidden">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-static mb-2">
                      <label>Satuan 2</label>
                      <input type="text" id="satuan2" name="satuan2" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Volume 3</label>
                      <input type="number" id="volume3" name="volume3" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                      <input id="volume3x" name="volume3x" type="hidden">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Satuan 3</label>
                      <input type="text" id="satuan3" name="satuan3" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Volume 4</label>
                      <input type="number" id="volume4" name="volume4" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                      <input id="volume4x" name="volume4x" type="hidden">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Satuan 4</label>
                      <input type="text" id="satuan4" name="satuan4" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Volume Kegiatan</label>
                      <input type="number" id="volumeKegiatan" name="volumeKegiatan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Satuan Kegiatan</label>
                      <input type="text" id="satuanKegiatan" name="satuanKegiatan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Harga Satuan</label>
                      <input type="number" id="hargaSatuan" name="hargaSatuan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label>Jumlah = Harga Satuan x Volume Kegiatan</label>
                      <input type="number" id="jumlah" name="jumlah" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label for="exampleFormControlSelect1" class="ms-0">Jenis Belanja</label>
                      <select id="operasional" name="operasional" class="form-control">
                        <option value="Y">Belanja Operasional</option>
                        <option value="T">Belanja Non Operasional</option>
                      </select>
                    </div>

                    <div class="input-group input-group-static mb-2">
                      <label for="exampleFormControlSelect1" class="ms-0">Skala Prioritas</label>
                      <select id="prioritas" name="prioritas" class="form-control">
                        <option value="Y">Ya</option>
                        <option value="T">Tidak</option>
                      </select>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12 text-end">
                    <a href="{{ route('baseline.index') }}" class="btn btn-outline-danger mt-2">
                      <i class="fa fa-close me-3 fa-2x"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-outline-info mt-2">
                      <i class="fa fa-save me-3 fa-2x"></i>Simpan
                    </button>
                  </div>
                </div>
              </div>
            </form>
            </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

<script type="text/javascript">
</script>