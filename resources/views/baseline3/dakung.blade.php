@section('js')

<script type="text/javascript">
	window.livewire.on('usersStored', () => {
	    $('#tableBaseline').DataTable().ajax.reload();
	});
</script>

<script type="text/javascript">
  	$(document).ready(function() {

  		var modal = $('.modal')
    	var form = $('.form')

    	$.fn.dataTable.ext.errMode = 'throw';
    	$('#tableBaseline thead tr').clone(true).appendTo( '#tableBaseline thead' );
    	$('#tableBaseline thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == 'Data Dukung')
            {
              $(this).html( '###' );
            }
            else 
            {
            	$(this).html( '<input type="text" style="width:100%;" value="" placeholder="Cari '+title+'" />' );
            }
            $( 'input', this ).on( 'keyup change', function () {
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
              	"url"  : "{{ route ('api.dakungbaseline3') }}", 
              	"data" : function (d) {
              		d.unik = $('#unik').val();
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
                      	{ data: 'kdunit', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      	{ data: 'reffsatker_id', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      	{ data: 'reffsatker.nama_satker_lengkap', sClass: "text-secondary mb-0 text-left"},
                      	{ data: 'kdprogram', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      	//{ data: 'kdgiat', sClass: "text-secondary mb-0 text-center"},
                      	//{ data: 'kdoutput', sClass: "text-secondary mb-0 text-center"},
                      	//{ data: 'kdsoutput', sClass: "text-secondary mb-0 text-center"},
                      	//{ data: 'kdkmpnen', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'coa', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      	{ data: 'deskripsi', sClass: "text-secondary mb-0 text-left"},
                      	{ data: 'total', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'file', sClass: "text-secondary mb-0 text-center", width: "50px"},
                  	],
          	fixedColumns: {
                leftColumns: 3,
                rightColumns: 1
            }
      	});

      	$(document).on('click','.btn-upload',function()
      	{
	        modal.find('.modal-title').text('Upload Dokumen Pendukung')
	        modal.find('.modal-footer button[type="submit"]').text('Simpan')
	        var rowData =  table.row($(this).parents('tr')).data()     
	        form.find('input[name="id"]').val(rowData.reffsatker_id+rowData.kdunit+rowData.kdprogram+rowData.kdgiat+rowData.kdoutput+rowData.kdsoutput+rowData.kdkmpnen)
	        form.find('input[name="kodeSatker"]').val(rowData.reffsatker_id)
	        form.find('input[name="kodeUnit"]').val(rowData.kdunit)
	        form.find('input[name="kodeProgram"]').val(rowData.kdprogram)
	        form.find('input[name="kodeKegiatan"]').val(rowData.kdgiat)
	        form.find('input[name="kodeOutput"]').val(rowData.kdoutput)
	        form.find('input[name="kodeSubOutput"]').val(rowData.kdsoutput)
	        form.find('input[name="kodeKomponen"]').val(rowData.kdkmpnen)
	        form.find('input[name="total"]').val(rowData.total)
	        modal.modal('show')
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

@if (session('msg'))
<script type="text/javascript">
    swal(
            'Pesan',
            '{{ session('msg') }}',
            'info'
        );
</script>
@endif

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
	            		<h6 class="text-white text-capitalize ps-4">Table {{ $config['pageTitle']  }}</h6>
	          		</div>
	        	</div>
	        	<div class="card-body px-0 pb-2">
	          		<div class="row p-3">
	            		<div class="col-12">
	            			<input type="hidden" id="unik" name="unik" value="{{ $unik }}"/>

	            			<button class="btn bg-gradient-danger" onclick="history.back()">
					            <i class="fa fa-arrow-left me-2"></i>kembali
					        </button>

                    		<hr>

				          	<div class="table-responsive p-3">
				            	<table id="tableBaseline" class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
				              		<thead>
				                		<tr>
				                  			<th class="text-uppercase text-secondary font-weight-bolder">No</th>
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Unit</th>
				                  			<th class="text-uppercase text-secondary font-weight-bolder">Kode Satker</th>
				                  			<th class="text-uppercase text-secondary font-weight-bolder">Nama Satker</th>
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Program</th>
				                  			<!--
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Kegiatan</th>
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Output</th>
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Sub Output</th>
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Komponen</th>
				                  			-->
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">COA Sub Komponen</th>
				                  			<th class="text-left text-uppercase text-secondary font-weight-bolder">Deskripsi</th>
				                  			<th class="text-center text-uppercase text-secondary font-weight-bolder">Total</th>
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

<!-- Modal -->
<div class="modal bs-upload-modal-md" id="mUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" style="width: 1024px;">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title" id="mTitle">Upload Data Dukung</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<form class="form" action="{{ route('baseline3.uploads') }}" method="POST" enctype="multipart/form-data">
      		<div class="modal-body">
          		<label>Data Baseline</label>
          		<input type="hidden" name="_token" value="{{ csrf_token() }}">
          		<input type="text" name="id" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="kodeSatker" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="kodeUnit" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="kodeProgram" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="kodeKegiatan" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="kodeOutput" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="kodeSubOutput" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="kodeKomponen" class="form-control is-valid mb-2" readonly="">
          		<input type="hidden" name="total" class="form-control is-valid mb-2" readonly="">

          		<label>TOR</label>
          		<input type="file" class="form-control is-valid" id="tor" name="tor" placeholder="Dokumen TOR" required="">
          		<div class="valid-feedback" style="font-size: 11px;">
            		Maksimal 5MB
          		</div>

          		<label>RAB</label>
          		<input type="file" class="form-control is-valid" id="rab" name="rab" placeholder="Dokumen RAB" required="">
          		<div class="valid-feedback" style="font-size: 11px;">
            		Maksimal 5MB
          		</div>

          		<label>Dokumen Lainnya</label>
          		<input type="file" class="form-control is-valid" id="lainnya" name="lainnya" placeholder="Dokumen RAB" required="">
          		<div class="valid-feedback" style="font-size: 11px;">
            		Maksimal 5MB
          		</div>
      		</div>
      		<div class="modal-footer justify-content-between">
        		<button type="button" class="btn bg-gradient-dark mb-0" data-bs-dismiss="modal">Tutup</button>
        		<button type="submit" id="btnSubmit" class="btn bg-gradient-primary btn-update mb-0">Simpan</button>
      		</div>
    		</form>
    	</div>
  	</div>
</div>
<!-- Modal -->
@endsection