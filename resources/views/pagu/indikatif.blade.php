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
              "url"  : "{{ route ('api.indikatif') }}", 
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
                      { data: 'reffsatker.kode_satker', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'satker', sClass: "text-secondary mb-0 text-left"},
                      { data: 'thang', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'total_belanja_pegawai', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      { data: 'total_belanja_barang', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      { data: 'total_belanja_modal', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      { data: 'file', sClass: "text-secondary mb-0 text-center", width: "50px"},
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
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Tahun</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Belanja Pegawai</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Belanja Barang</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Belanja Modal</th>
                  <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">Data Dukung</th>
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

