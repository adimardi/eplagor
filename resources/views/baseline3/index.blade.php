@section('js')

<script>
  	$(document).ready(function() {
  	$.fn.dataTable.ext.errMode = 'throw';
  	$('#tableBaseline thead tr').clone(true).appendTo( '#tableBaseline thead' );
        $('#tableBaseline thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == 'Aksi' || title == 'Data Dukung')
            {
              $(this).html( '###' );
            }
            else if(title == 'XXX')
            {
              $(this).html( '<a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-search fa-2x"></i></span></a><a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-times-circle fa-2x"></i></span></a>' )
            }
            else
            {
            	$(this).html( '<input type="text" style="width:100%;" value="" placeholder="Cari '+title+'" />' );
            }
            $('input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        
      	var table = $('#tableBaseline')
      	.DataTable({
          	processing: true,
          	serverSide: true,
          	ajax: {
              	"url"  : "{{ route ('api.baseline3') }}", 
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
          	dom: 'lfBrtipr',
          	buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Baseline '
                },
                {
                    extend: 'csv',
                    title: 'Data csv Baseline ' 
                }
            ],

          	columns: [
                      	{ data: null, sClass: "text-secondary mb-0 text-center", sortable: false, searchable: false, width: "7px",
                            render: function (data, type, row, meta) {
                            	return meta.row + meta.settings._iDisplayStart + 1;
                           }
                      	},
                      	//{ data: 'reffsatker.nama_eselon', sClass: "text-secondary mb-0 text-left"},
                      	{ data: 'reffsatker.kode_satker', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      	{ data: 'satker', sClass: "text-secondary mb-0 text-left"},
                      	{ data: 'total_belanja_pegawai', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'total_belanja_barang_operasional', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'total_belanja_barang_nonoperasional', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'total_belanja_modal_tanah', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'total_belanja_modal_gedung', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                        { data: 'total_belanja_modal_mesin', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'total', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'aksi', sClass: "text-secondary mb-0 text-center", width: "10px"},
                  	],
          	fixedColumns: {
                    leftColumns: 0,
                    rightColumns: 0
                }
      	});

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
		            		<div class="table-responsive p-3">
				            	<table id="tableBaseline" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
				              		<thead>
				                		<tr>
				                  			<th class="text-uppercase text-secondary font-weight-bolder">No</th>
                                            <!--
				                  			<th class="text-uppercase text-secondary font-weight-bolder">Eselon</th>
                                            -->
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Kode Satker</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Nama Satker</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Pegawai</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Operasioanal</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Non Operasioanal</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Tanah</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Gedung</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Peralatan dan Mesin</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Total Pagu</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Data Dukung</th>
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
@endsection