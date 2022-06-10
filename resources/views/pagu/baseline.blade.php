@section('js')

<script type="text/javascript">
  window.livewire.on('usersStored', () => {
    $('#tableBaseline').DataTable().ajax.reload();
  });
</script>

<script>
  $(document).ready(function() {

    $('#prioritas').change(function() {
      var sp =  $("#prioritas").val();
      alert(sp);
    });

    $("#volume4").keyup(function(){
      var strval =  $("#volume4").val();
      if(strval == "") {
        //alert("tidak boleh kosong");
      } else {
        vkali()
        //alert("data ada");
      }
    });

    function vkali() {
      var a = $('#volume1').val();
      var b = $('#volume2').val();
      var c = $('#volume3').val();
      var d = $('#volume4').val();
      
      if (a == 0) {
        a = 1
      } else if (b == 0) {
        b = 1
      } else if (c == 0) {
        c = 1
      } else if (d == 0) {
        d = 1
      }

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

  $.fn.dataTable.ext.errMode = 'throw';

  $('#tableBaseline thead tr').clone(true).appendTo( '#tableBaseline thead' );
        $('#tableBaseline thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == 'Status')
            {
              $(this).html( '###' );
            }
            else if(title == 'Action')
            {
              $(this).html( '<a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-search fa-3x"></i></span></a><a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-times-circle fa-3x"></i></span></a>' )
            }
            else{
            $(this).html( '<input type="text" style="width:100%;" value="" placeholder="Cari '+title+'" />' );
            }
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        
      var table = $('#tableBaseline')
      .DataTable({

          processing: true,
          serverSide: true,
          ajax: {
              "url"  : "{{ route ('api.baseline') }}", 
              "data" : function (d) {
                      d.filter_wilayah = $('#filter_wilayah').val();
                      d.filter_eselon = $('#filter_eselon').val();
                      d.filter_peradilan = $('#filter_peradilan').val();
                      d.filter_status = $('#filter_status').val();
                      d.filter_periode = $('#filter_periode').val();
              }
          },

          orderCellsTop: true,
          stateSave: true,
          scrollX:        true,
          scrollCollapse: true,
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          dom:          'lfBrtipr',
          buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data User '
                },
                {
                    extend: 'csv',
                    title: 'Data csv User ' 
                }
            ],

          columns: [
                      { data: null, sClass: "text-secondary mb-0 text-center", sortable: false, searchable: false, width: "7px",
                            render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                            }
                      },
                      { data: 'reffsatker_id', sClass: "text-secondary mb-0 text-left "},
                      { data: 'reffsatker.nama_satker_lengkap', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kddept', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdunit', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdprogram', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdgiat', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdoutput', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdlokasi', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdkabkota', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kddekon', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdsoutput', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdkmpnen', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdskmpnen', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdakun', sClass: "text-secondary mb-0 text-left"},
                      { data: 'kdkppn', sClass: "text-secondary mb-0 text-left"},
                      { data: 'noitem', sClass: "text-secondary mb-0 text-left"},
                      { data: 'nmitem', sClass: "text-secondary mb-0 text-left"},
                      { data: 'vol1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'sat1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'vol2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'sat2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'vol3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'sat3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'vol4', sClass: "text-secondary mb-0 text-center"},
                      { data: 'sat4', sClass: "text-secondary mb-0 text-center"},
                      { data: 'volkeg', sClass: "text-secondary mb-0 text-center"},
                      { data: 'satkeg', sClass: "text-secondary mb-0 text-left"},
                      { data: 'hargasat', sClass: "text-secondary mb-0 text-left"},
                      { data: 'jumlah', sClass: "text-secondary mb-0 text-left"},
                      { data: 'action', sClass: "text-secondary mb-0 text-center"},
                  ],
          fixedColumns: {
                    leftColumns: 3,
                    rightColumns: 1
                }
      } );

      $('#filter_wilayah').change(function () {
          table.draw();
      });

      $('#filter_eselon').change(function () {
          table.draw();
      });

      $('#filter_peradilan').change(function () {
          table.draw();
      });

      $('#filter_status').change(function () {
          table.draw();
      });

      $('#filter_periode').change(function () {
          table.draw();
      });


  });


</script>
<script>
    function deleteData(ID) {
    
    swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang anda pilih akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Yakin!',
        cancelButtonText: 'Tidak',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
              url: "{{ route('baseline.hapus') }}",
              type: 'POST',
              data: {
                _token: "{{ csrf_token() }}",
                idnya: ID
              },
              error: function (xhr, status) {
                Swal.fire('Data Gagal Dihapus!', '', 'error')
              },
              success: function (data) {
                
                // console.log(data);
                var datanya = JSON.parse(data);
                if(datanya.status) {
                    Swal.fire('Data Berhasil Dihapus!', '', 'success')
                  }
              }
          });
          $('#tableBaseline').DataTable().ajax.reload();
        }
    })
  }

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
            <h6 class="text-white text-capitalize ps-3">Table {{ $config['pageTitle']  }}</h6>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="row p-3">
            <div class="col-12">
              <div class="dropdown">
                <button class="btn bg-gradient-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  Tambah
                </button>
                <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton" style="">
                  <li><a class="dropdown-item border-radius-md" href="javascript:;" onclick="add()">Opsi 1 (Mengambil Pagu Awal)</a></li>
                  <li><a class="dropdown-item border-radius-md" href="javascript:;" onclick="plus()">Opsi 2 (Menginput Pagu Baru)</a></li>
                </ul>
              </div>

              <hr>

              <div id="mForm" style="display: none;">
              <form method="post" autocomplete="off" action="{{ route('baseline.store') }}">
              <div class="card-body pb-2">
                <div class="row">
                  <div class="col-md-4">
                    <input
                      type="hidden"
                      name="_token"
                      value="{{ csrf_token() }}"
                    />

                    <label>Kode Satker</label>
                    <div class="input-group mb-2">
                      <input id="idPagu" name="idPagu"class="form-control" placeholder="Id Pagu" type="hidden">
                      <input id="kodeSatker" name="kodeSatker"class="form-control" placeholder="Kode Satker" type="text" required="" readonly="">
                    </div>

                    <label>Nama Satker</label>
                    <div class="input-group mb-2">
                      <input id="namaSatker" name="namaSatker" type="text" class="form-control" placeholder="Nama Satuan Kerja">
                    </div>

                    <label>Kode Departemen</label>
                    <div class="input-group mb-2">
                      <input id="kodeDepartemen" name="kodeDepartemen" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Unit</label>
                    <div class="input-group mb-2">
                      <input id="kodeUnit" name="kodeUnit" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Program</label>
                    <div class="input-group mb-2">
                      <input id="kodeProgram" name="kodeProgram" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Kegiatan</label>
                    <div class="input-group mb-2">
                      <input id="kodeKegiatan" name="kodeKegiatan" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Output</label>
                    <div class="input-group mb-2">
                      <input id="kodeOutput" name="kodeOutput" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Sub Output</label>
                    <div class="input-group mb-2">
                      <input id="kodeSubOutput" name="kodeSubOutput" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Kode Lokasi</label>
                    <div class="input-group mb-2">
                      <input id="kodeLokasi" name="kodeLokasi" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Kabupaten Kota</label>
                    <div class="input-group mb-2">
                      <input id="kodeKabkot" name="kodeKabkot" type="text" class="form-control" placeholder="" readonly="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>Kode Dekon</label>
                    <div class="input-group mb-2">
                      <input id="kodeDekon" name="kodeDekon" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Komponen</label>
                    <div class="input-group mb-2">
                      <input id="kodeKomponen" name="kodeKomponen" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Sub Komponen</label>
                    <div class="input-group mb-2">
                      <input id="kodeSubKomponen" name="kodeSubKomponen" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode Akun</label>
                    <div class="input-group mb-2">
                      <input id="kodeAkun" name="kodeAkun" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Kode KPPN</label>
                    <div class="input-group mb-2">
                      <input id="kodeKppn" name="kodeKppn" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Nomor Item</label>
                    <div class="input-group mb-2">
                      <input id="nomorItem" name="nomorItem" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Nama Item</label>
                    <div class="input-group mb-2">
                      <input id="namaItem" name="namaItem" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Volume 1</label>
                    <div class="input-group mb-2">
                      <input id="volume1" name="volume1" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Satuan 1</label>
                    <div class="input-group mb-2">
                      <input id="satuan1" name="satuan1" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Volume 2</label>
                    <div class="input-group mb-2">
                      <input id="volume2" name="volume2" type="text" class="form-control" placeholder="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>Satuan 2</label>
                    <div class="input-group mb-2">
                      <input id="satuan2" name="satuan2" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Volume 3</label>
                    <div class="input-group mb-2">
                      <input id="volume3" name="volume3" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Satuan 3</label>
                    <div class="input-group mb-2">
                      <input id="satuan3" name="satuan3" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Volume 4</label>
                    <div class="input-group mb-2">
                      <input id="volume4" name="volume4" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Satuan 4</label>
                    <div class="input-group mb-2">
                      <input id="satuan4" name="satuan4" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Volume Kegiatan</label>
                    <div class="input-group mb-2">
                      <input id="volumeKegiatan" name="volumeKegiatan" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Satuan Kegiatan</label>
                    <div class="input-group mb-2">
                      <input id="satuanKegiatan" name="satuanKegiatan" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Harga Satuan</label>
                    <div class="input-group mb-2">
                      <input id="hargaSatuan" name="hargaSatuan" type="text" class="form-control" placeholder="">
                    </div>

                    <label>Jumlah = Harga Satuan x Volume Kegiatan</label>
                    <div class="input-group mb-2">
                      <input id="jumlah" name="jumlah" type="text" class="form-control" placeholder="" readonly="">
                    </div>

                    <label>Jenis Belanja</label>
                    <div class="input-group mb-2">
                      <input id="opr" type="text" class="form-control" placeholder="">
                      <select id="operasional" name="operasional" class="form-control" required="">
                        <option value="Y">Belanja Operasional</option>
                        <option value="T">Belanja Non Operasional</option>
                      </select>
                    </div> 

                    <label>Skala Prioritas</label>
                    <div class="input-group mb-2">
                      <input id="prior" type="text" class="form-control" placeholder="">
                      <select id="prioritas" name="prioritas" class="form-control" required="">
                        <option value="Y">Ya</option>
                        <option value="T">Tidak</option>
                      </select>
                    </div> 
                </div>
                <div class="row">
                  <div class="col-md-12 text-left">
                    <button type="submit" class="btn bg-gradient-primary mt-3 mb-0">Simpan</button>
                    <button type="button" class="btn bg-gradient-primary mt-3 mb-0" onclick="hideForm()">Batal</button>
                  </div>
                </div>
              </div>
            </form>
            <hr>
            </div>
            </div>
          </div>


          <div class="table-responsive p-3">
            <table id="tableBaseline" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary font-weight-bolder">No</th>
                  <th class="text-uppercase text-secondary font-weight-bolder">Kode Satker</th>
                  <th class="text-uppercase text-secondary font-weight-bolder">Nama Satker</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Departement</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Unit</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Program</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Giat</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Output</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Lokasi</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Kab Kota</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Dekon</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Sub Output</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Komponen</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Sub Komponen</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Akun</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode KPPN</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">No Item</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Nama Item</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Vol1</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Sat1</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Vol2</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Sat2</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Vol3</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Sat3</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Vol4</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Sat4</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Volume Kegiatan</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Satuan Kegiatan</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Harga Satuan</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Jumlah</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mAdd" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 1024px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mTitle">Your modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- tabel pagu-->
        @include('pagu.table')
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn bg-gradient-dark mb-0" data-bs-dismiss="modal">Tutup</button>
        <!--
        <button type="button" class="btn bg-gradient-primary mb-0">Simpan</button>
        -->
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

@endsection

<script>

</script>

<script type="text/javascript">
  function add() { 
    $('#mAdd').modal('show');
    $('#mTitle').text('Tambah Data Baseline');
  }

  function take(unik) {
            $.ajax({
                type:'POST',
                url : '{{ route ('baseline.getpagu') }}',
                data: {
                        '_token': "{{ csrf_token() }}",
                        'unik': unik,
                      },

                success:function(data) {
                    //alert("Hello! I am an alert box!!");
                    $("#idPagu").val(data.id);
                    $("#kodeSatker").val(data.reffsatker_id);
                    $("#kodeDepartemen").val(data.kddept);
                    $("#kodeUnit").val(data.kdunit);
                    $("#kodeProgram").val(data.kdprogram);
                    $("#kodeKegiatan").val(data.kdgiat);
                    $("#kodeOutput").val(data.kdoutput);
                    $("#kodeSubOutput").val(data.kdsoutput);
                    $("#kodeLokasi").val(data.kdlokasi);
                    $("#kodeKabkot").val(data.kdkabkota);
                    $("#kodeDekon").val(data.kddekon);
                    $("#kodeKomponen").val(data.kdkmpnen);
                    $("#kodeSubKomponen").val(data.kdskmpnen);
                    $("#kodeAkun").val(data.kdakun);
                    $("#kodeKppn").val(data.kdkppn);
                    $("#nomorItem").val(data.noitem);
                    $("#namaItem").val(data.nmitem);
                    $("#volume1").val(data.vol1);
                    $("#satuan1").val(data.sat1);
                    $("#volume2").val(data.vol2);
                    $("#satuan2").val(data.sat2);
                    $("#volume3").val(data.vol3);
                    $("#satuan3").val(data.sat3);
                    $("#volume4").val(data.vol4);
                    $("#satuan4").val(data.sat4);
                    $("#volumeKegiatan").val(data.volkeg);
                    $("#satuanKegiatan").val(data.satkeg);
                    $("#hargaSatuan").val(data.hargasat);
                    $("#jumlah").val(data.jumlah);
                    $("#opr").val(data.operasional);
                    $("#prior").val(data.prioritas);

                    $('#mAdd').modal('hide');
                    document.getElementById("mForm").style.display = "block"; 
                },
                error:function(data) {
                    alert("Data gagal ditampilkan!");
                }
            });
        }

  function hideForm() {
    document.getElementById("mForm").style.display = "none"; 
  }
</script>