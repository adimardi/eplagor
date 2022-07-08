@section('js')

<script type="text/javascript">
  window.livewire.on('usersStored', () => {
    $('#tablePagu').DataTable().ajax.reload();
  });
</script>

<script>
  $(document).ready(function() {
  $.fn.dataTable.ext.errMode = 'throw';

  $('#tablePagu thead tr').clone(true).appendTo( '#tablePagu thead' );
        $('#tablePagu thead tr:eq(1) th').each( function (i) {
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

        


  
      var table = $('#tablePagu')
      .DataTable({

          processing: true,
          serverSide: true,
          ajax: {
              "url"  : "{{ route ('api.pagu') }}", 
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
                    leftColumns: 0,
                    rightColumns: 0
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
              url: "{{ route('user.hapus') }}",
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
          $('#tablePagu').DataTable().ajax.reload();
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
          <div class="table-responsive p-3">
            <table id="tablePagu" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary font-weight-bolder">No</th>
                  <th class="text-uppercase text-secondary font-weight-bolder">Kode Satker</th>
                  <th class="text-uppercase text-secondary font-weight-bolder">Nama Satker</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Departement</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Unit</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Program</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Kode Kegiatan</th>
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
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

