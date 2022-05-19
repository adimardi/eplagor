@section('js')

{{-- <script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example thead tr').clone(true).appendTo( '#example thead' );
    $('#example thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        if(title == 'No' || title == 'Action')
        {
          $(this).html( '###' );
        }
        else
        {
          $(this).html( '<input type="text" placeholder="'+title+'" style="width: 100%" />' );
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
 
    var table = $('#example').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        fixedColumns: true,
        colReorder: true,
        // processing : true, //process it
        // serverSide : true, //make it server side
        // scrollY:        "900px",
        // scrollX:        true,
        // scrollCollapse: true,
        info:     false,
        ordering: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        paging: false,
        // dom: 'Bfrtip',
        // dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],

        columns: [
                    { data: 'no', sClass: "text-center", searchable: false, width: "5px"},
                    { data: 'nama', sClass: "text-left", width: "100px"},
                    { data: 'email', sClass: "text-left"},
                    { data: 'level', sClass: "text-left"},
                    { data: 'satker', sClass: "text-justify"},
                    { data: 'action', sClass: "text-left", orderable: false, searchable: false },
                ],
                
                fixedColumns: {
                    leftColumns: 0,
                    rightColumns: 0
                }
        
    } );

} );

</script> --}}

<script>
  $(document).ready(function() {
   
      var table = $('#tableBelanjaBarang').DataTable( {
  
          processing: true,
          serverSide: true,
          ajax: {
              "url"  : "{{ route ('api.databelanjabarang') }}", 
              "data" : function (d) {
                      d.filter_wilayah = $('#filter_wilayah').val();
                      d.filter_eselon = $('#filter_eselon').val();
                      d.filter_peradilan = $('#filter_peradilan').val();
              }
          },
  
          orderCellsTop: true,
          fixedHeader: false,
          colReorder: true,
          // stateSave: true,
          scrollX:        true,
          scrollCollapse: true,
          ordering: true,
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          // paging: false,
          dom:          'lfBrtipr',
          buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Kwitansi SAS UP-TUP'
                },
                {
                    extend: 'csv',
                    title: 'Data csv Kwitansi SAS UP-TUP'
                }
            ],
  
          columns: [
                      { data: null, sClass: "text-center", sortable: false, searchable: false, width: "7px",
                            render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                            }
                      },
                      { data: 'reffsatker_id', sClass: "text-center"},
                      { data: 'reffsatker.nama_satker_lengkap', sClass: "text-center"},
                      { data: 'tanggal_kwitansi', sClass: "text-center"},
                      { data: 'no_kwitansi', sClass: "text-center"},
                      { data: 'kd_kegiatan', sClass: "text-center"},
                      { data: 'kd_output', sClass: "text-center"},
                      { data: 'kds_output', sClass: "text-center"},
                      { data: 'kd_komponen', sClass: "text-center"},
                      { data: 'kds_komponen', sClass: "text-center"},
                      { data: 'kd_akun', sClass: "text-center"},
                      { data: 'kds_dana', sClass: "text-center"},
                      { data: 'uraian', sClass: "text-left"},
                      { data: 'nm_trim', sClass: "text-left"},
                      { data: 'nilai', sClass: "text-right", render: $.fn.dataTable.render.number( ',', '.')},
                      { data: 'no_transaksi', sClass: "text-center"},
                      { data: 'no_pjk', sClass: "text-center"},
                      { data: 'no_drpp', sClass: "text-center"},
                      { data: 'no_spby', sClass: "text-center"},
                      { data: 'no_dpt', sClass: "text-center"},
                      { data: 'tahun_anggaran', sClass: "text-center"},
                      { data: 'lampiran', sClass: "text-center"},
                      { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
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
  
  
  
  });
  
  </script>
  



<!-- PNotify -->
<script src="{{asset('vendors/pnotify/dist/pnotify.js')}}"></script>
<script src="{{asset('vendors/pnotify/dist/pnotify.buttons.js')}}"></script>
<script src="{{asset('vendors/pnotify/dist/pnotify.nonblock.js')}}"></script>

<script>
PNotify.success({
  title: 'Success!',
  text: 'That thing that you were trying to do worked.'
});
</script>

@stop

@extends('layouts.app')

@section('content')
<div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Administrator <small></small></h3>
        </div>

      </div>
    </div>

    <div class="clearfix"></div>      
      <div class="col-md-12 col-sm-12 ">
        <div class="col-lg-12">
            @if (Session::has('message'))
            <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              {{ Session::get('message') }}
            </div>
            @endif
        </div>
      </div>
      <div class="x_panel">
        <div class="x_title">
              <h2>Data User<small></small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
        </div>
        <div class="col-lg-2">
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i> Tambah User</a>
                <button type="button" class="fa fa-share btn btn-success btn-sm" data-toggle="modal" data-target="#importUser">
                  Import data User
                </button>
        </div>
        
        
        <!-- Import Excel -->
        <div class="modal fade" id="importUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form method="post" action="user/import_excel" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Import Data User</h5>
                </div>
                <div class="modal-body">
                  
                  {{ csrf_field() }}
                  
                  <label>Pilih file excel</label>
                  <div class="form-group">
                    <input type="file" name="file" required="required">
                  </div>
                  <div>
                    <p>
                      isi dengan </br>
                      1. colom a1 = Nama </br>
                      2. colom a2 = email </br>
                      3. colom a3 = password </br>
                      kesalahan pengisian mengakibatkan kegagalan import data!!
                    </p>
                  </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Import</button>
                </div>
              </div>
            </form>
          </div>
        </div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Satker</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $i=1
                    @endphp
                    @foreach($datas as $data)
                    <tr>
                      <td> {{$i++}} </td>
                      <td>
                      <a href="{{route('user.edit', Crypt::encrypt($data->id))}}"> 
                        {{$data->name}}
                      </a>
                      </td>
                      <td>
                        {{$data->email}}
                      </td>
                      <td>
                        {{$data->level}}
                      </td>
                      <td>
                        @if($data->reffsatker != null)
                        {{$data->reffsatker->nama_satker}}
                        @endif
                      </td>
                      <td>
                       <div class="btn-group dropdown">
                      <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                        <a class="dropdown-item" href="{{route('user.edit', Crypt::encrypt($data->id))}}"> Edit </a>
                        
                        <form action="{{ route('user.destroy', $data->id) }}" class="pull-left"  method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button class="dropdown-item" onclick="return confirm('Anda yakin ingin menghapus data ini?')"> Delete
                        </button>
                        </form>
                       
                      </div>  
                    </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{-- {{ $datas->fragment('foo')->links() }}
              Halaman : {{ $datas->currentPage() }} <br/>
              Jumlah Data : {{ $datas->total() }} <br/>
              Data Per Halaman : {{ $datas->perPage() }} <br/> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection