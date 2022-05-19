@section('js')

<script type="text/javascript">
  window.livewire.on('usersStored', () => {
    $('#tableUser').DataTable().ajax.reload();
  });
</script>

<script>
  $(document).ready(function() {
  $.fn.dataTable.ext.errMode = 'throw';

  $('#tableUser thead tr').clone(true).appendTo( '#tableUser thead' );
        $('#tableUser thead tr:eq(1) th').each( function (i) {
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

        


  
      var table = $('#tableUser')
      .DataTable({

          processing: true,
          serverSide: true,
          ajax: {
              "url"  : "{{ route ('api.user') }}", 
              "data" : function (d) {
                      d.filter_wilayah = $('#filter_wilayah').val();
                      d.filter_eselon = $('#filter_eselon').val();
                      d.filter_peradilan = $('#filter_peradilan').val();
                      d.filter_status = $('#filter_status').val();
                      d.filter_periode = $('#filter_periode').val();
              }
          },

          orderCellsTop: true,
          // stateSave: true,
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
                      { data: null, sClass: "text-xs text-secondary mb-0 text-center", sortable: false, searchable: false, width: "7px",
                            render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                            }
                      },
                      { data: 'name', sClass: "text-xs text-secondary mb-0 text-left "},
                      { data: 'username', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'email', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'reffsatker_id', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'reffsatker.nama_satker_lengkap', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'jabatan', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'kantor', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'level', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'status', sClass: "text-xs text-secondary mb-0 text-left"},
                      { data: 'action', sClass: "text-center"},
                  ],
          fixedColumns: {
                    leftColumns: 3,
                    rightColumns: 1
                }
      } );

                  
      // yadcf.init(table, [
      //     {column_number : 3, filter_type: "auto_complete"},
      //   ]);

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
          $('#tableUser').DataTable().ajax.reload();
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
          <div class="table-responsive p-0">
            <table id="tableUser" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xs font-weight-bolder">No</th>
                  <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-2">Nama</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">Username</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Email</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Kode Satker</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Satker</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jabatan</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Kantor</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Level</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                  <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">Action</th>
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

