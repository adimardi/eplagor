@section('js')

{{--script push value ID to database  --}}
<script>
  $("#cboSelect").change(function(){    
      $("#cboSelect option:selected").text($("#cboSelect").val());
  });  
</script>

<script>
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
        // scrollY:        "900px",
        // scrollX:        true,
        // scrollCollapse: true,
        info:     false,
        ordering: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

        // paging: false,
        // dom: 'Bfrtip',
        // dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],

        columns: [
                    { data: 'no', sClass: "text-center", searchable: false, width: "7px"},
                    { data: 'user', sClass: "text-center", width: "100px"},
                    { data: 'aktifitas', sClass: "text-left", width: "200px"},
                    { data: 'created_at', sClass: "text-justify", width: "140px"},
                ],
                
                fixedColumns: {
                    leftColumns: 0,
                    rightColumns: 0
                }
        
    } );

} );

</script>
@stop

@section('css')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@stop



@extends('layouts.app')

@section('content')
<div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Temuan BPK RI <small></small></h3>
        </div>

      </div>
    </div>

    <div class="clearfix"></div>      
      <div class="col-md-12 col-sm-12 ">
        <div class="col-lg-12">
            @if (Session::has('message'))
            <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">{{ Session::get('message') }}</div>
            @endif
        </div>
      </div>
      <div class="x_panel">
        <div class="x_title">
              <h2>Log Aktifitas User<small></small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li> 
              </ul>
              <div class="clearfix"></div>
        </div>
        <a href="{{ route('logs.hapussemua') }}" class="fa fa-plus btn btn-primary active btn-sm" role="button" aria-pressed="true" onclick="return confirm('Anda yakin ingin menghapus semua log?')"> Clear ALL Logs</a>
        <div>
            <div class="x_content">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card-box">
                  {{-- <p class="text-muted font-13 m-b-30">
                    Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.
                  </p> --}}
                    
                    <style>
                    .table.dataTable  {
                      font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                      /* font-family: Verdana, Geneva, Tahoma, sans-serif; */
                      font-size: 10px;
                      /* direction: rtl; membalik table*/ 
                      position: relative;
                      table-layout: fixed;
                      width: 180px;
                    }
                      
                      ol, ul { 
                      padding-left: 13px; 
                      }
                    
                    </style>
                    <table id="example" class=" table table-responsive dt-responsive table-striped table-bordered table-sm stripe row-border order-column" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <b>
                        <th>No</th>
                        <th>User</th>
                        <th>Aktifitas</th>
                        <th>Created_at</th>
                        </b>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                          $i=1
                        @endphp
                        @foreach($logs as $log)
                      <tr>
                        <td>
                            {{$i++}}
                        </td>
                        <td>
                            {{$log->users->name}}, {{$log->users->email}}
                        </td>
                        <td >
                            {{$log->aktifitas}}
                        </td>
                        <td >
                          {{$log->created_at}}
                        </td>
                      </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
