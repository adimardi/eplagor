@section('js')

<script>
$(document).ready(function() {
$.fn.dataTable.ext.errMode = 'throw';
$('#tableSatker thead tr').clone(true).appendTo( '#tableSatker thead' );
      $('#tableSatker thead tr:eq(1) th').each( function (i) {
          var title = $(this).text();
          if(title == 'No' || title == 'Status'  || title == 'Action')
          {
            $(this).html( '###' );
          }else{
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

 
    var table = $('#tableSatker').DataTable( {

        processing: true,
        serverSide: true,
        ajax: {
            "url"  : "{{ route ('api.satker') }}", 
            "data" : function (d) {
                    d.filter_wilayah = $('#filter_wilayah').val();
                    d.filter_eselon = $('#filter_eselon').val();
                    d.filter_peradilan = $('#filter_peradilan').val();
            }
        },

        orderCellsTop: true,
        fixedHeader: false,
        colReorder: true,
        stateSave: true,
        scrollX:        true,
        scrollCollapse: true,
        ordering: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        // paging: false,
        dom:          'lfBrtipr',
        buttons: [
              {
                  extend: 'excelHtml5',
                  title: 'Data Satker '
              },
              {
                  extend: 'csv',
                  title: 'Data csv Satker '
              }
          ],

        columns: [
                    { data: null, sClass: "text-center", sortable: false, searchable: false, width: "7px",
                          render: function (data, type, row, meta) {
                          return meta.row + meta.settings._iDisplayStart + 1;
                          }
                    },
                    { data: 'kode_satker_lengkap', sClass: "text-left"},
                    { data: 'nama_satker_lengkap', sClass: "text-left"},
                    { data: 'action', sClass: "text-center"},
                ],
                
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
          <h3>Satkers <small></small></h3>
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
          <h2>Data Satker</h2>
          <div class="text-right">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
              Advance Filter
            </button>
          </div>
        <div class="clearfix"></div>
      </div>
        {{-- <div class="col-2">
          <a href="{{ route('satker.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Satker</a>
        </div> --}}
        
        
      <div class="accordion" id="accordionFilter">
        <div id="collapseFilter" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionFilter">

          @include('layouts.filter')

        </div>
      </div>
      <div>
          <div class="x_content">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card-box">
                  <table id="tableSatker" class="table table-resposive table-striped table-bordered table-sm stripe row-border order-column nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <b>
                      <th>No</th>
                      <th>Kode Satker</th>
                      <th>Nama Sakter</th>
                      <th>Action</th>
                      </b>
                    </tr>
                  </thead>
                </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

