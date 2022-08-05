@section('js')

<script type="text/javascript">
  	window.livewire.on('usersStored', () => {
    	$('#tableAkun').DataTable().ajax.reload();
  	});
</script>

<script>
  	$(document).ready(function() {
  	$.fn.dataTable.ext.errMode = 'throw';

      	var table = $('#tableAkun')
      	.DataTable({
          	processing: true,
          	serverSide: true,
          	ajax: {
              	"url"  : "{{ route ('api.rincianakun') }}", 
              	"data" : function (d) {
              			d.akun = $('#akun').val();
                      	d.filter_wilayah = $('#filter_wilayah').val();
                      	d.filter_eselon = $('#filter_eselon').val();
                      	d.filter_peradilan = $('#filter_peradilan').val();
                      	d.filter_status = $('#filter_status').val();
                      	d.filter_periode = $('#filter_periode').val();
              	}
          	},

          	orderCellsTop: true,
          	stateSave: true,
          	scrollX: true,
          	scrollCollapse: true,
          	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          	dom: 'lfBrtipr',
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
                      	{ data: 'reffsatker_id', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      	{ data: 'reffsatker.nama_satker_lengkap', sClass: "text-secondary mb-0 text-left"},
                      	//{ data: 'kode_akun', sClass: "text-secondary mb-0 text-center", width: "50px"},
                        //{ data: 'total', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "10px"},
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
            			<h6 class="text-white text-capitalize ps-3">{{ $config['pageTitle']  }}</h6>
          			</div>
        		</div>
        		<div class="card-body px-0 pb-0">
		          	<div class="row p-3">
		            	<div class="col-12">
		            		<input type="hidden" id="akun" name="akun" value="{{ $akun }}"/>

		            		<button class="btn bg-gradient-danger" onclick="history.back()">
					            <i class="fa fa-arrow-left me-2"></i>kembali
					        </button>

		            		<div class="table-responsive p-3">
				            	<table id="tableAkun" class="table table-bordered table-hover nowrap align-items-center mb-0" width="100%">
				              		<thead>
				                		<tr>
				                  			<th class="text-uppercase text-secondary font-weight-bolder text-center">No</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder text-center">Kode Satker</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder text-start">Nama Satker</th>
						                  	<!--
						                  	<th class="text-uppercase text-secondary font-weight-bolder text-center">Kode Akun</th>
				                  			<th class="text-uppercase text-secondary font-weight-bolder text-center">Total Pagu</th>
						                  	-->
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