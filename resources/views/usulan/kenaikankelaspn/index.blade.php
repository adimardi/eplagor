@section('js')

<script type="text/javascript">
  	window.livewire.on('usersStored', () => {
    	$('#tableUsulan').DataTable().ajax.reload();
  	});
</script>

<script type="text/javascript">
  	$(document).ready(function() {
  		$.fn.dataTable.ext.errMode = 'throw';

      	var table = $('#tableUsulan')
      	.DataTable({
          	processing: true,
          	serverSide: true,
          	ajax: {
              	"url"  : "{{ route ('api.usulankenaikankelaspa') }}", 
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
          	scrollX: true,
          	scrollCollapse: true,
          	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          	dom: 'lfBrtipr',
          	buttons: [
                {
                    extend: 'excelHtml5',
                    title: '{{ $config['pageTitle'] }}'
                },
                {
                    extend: 'csv',
                    title: '{{ $config['pageTitle'] }}' 
                }
            ],

          	columns: [
                      	{ data: null, sClass: "text-secondary mb-0 text-center", sortable: false, searchable: false, width: "7px",
                            render: function (data, type, row, meta) {
                            	return meta.row + meta.settings._iDisplayStart + 1;
                            }
                      	},
                      	{ data: 'reffsatker.tingkat_banding', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'reffsatker.nama_satker_lengkap', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'usulan', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'usulan_ke', sClass: "text-secondary mb-0 text-center"},

                      	{ data: 'nomor_surat', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'tanggal_surat', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'file', sClass: "text-secondary mb-0 text-center"},

                      	{ data: 'cg_tahun1', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_cg_tahun1', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'cg_tahun2', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_cg_tahun2', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'cg_tahun3', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_cg_tahun3', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},

                      	{ data: 'total_cg', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'rata_cg', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},

                      	{ data: 'ct_tahun1', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_ct_tahun1', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'ct_tahun2', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_ct_tahun2', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'ct_tahun3', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_ct_tahun3', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},

                      	{ data: 'total_ct', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'rata_ct', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},

                      	{ data: 'p_tahun1', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_p_tahun1', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'p_tahun2', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_p_tahun2', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'p_tahun3', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'jumlah_p_tahun3', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	
                      	{ data: 'total_p', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'rata_p', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},

                      	{ data: 'jumlah_penduduk', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'kepadatan_penduduk', sClass: "text-secondary mb-0 text-center", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      	{ data: 'kemudahan_akses', sClass: "text-secondary mb-0 text-center"},

                      	{ data: 'keterangan', sClass: "text-secondary mb-0 text-center"},
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
            			<h6 class="text-white text-capitalize ps-3">Table {{ $config['pageTitle'] }}</h6>
          			</div>
        		</div>
        		<div class="card-body px-0 pb-2">
        			<div class="row p-2">
            			<div class="col-12">
            				<a href="{{ route('usulan.kenaikankelaspa.create') }}" class="btn bg-gradient-danger">
								Tambah Usulan
							</a>

							<hr>

							<div class="table-responsive p-3">
				            	<table id="tableUsulan" class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
				              		<thead>
				              			<tr>
				              				<th class=" text-secondary -uppercase font-weight-bolder text-center" rowspan="2">
				                				No
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" rowspan="2">
				                				Pengadilan Tingkat Banding
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" rowspan="2">
				                				Nama Satker
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" rowspan="2">
				                				Usul Peningkatan
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" rowspan="2">
				                				Usulan Ke
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" colspan="3">
				                				Dokumen Pendukung
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" colspan="8">
				                				Cerai Gugat
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" colspan="8">
				                				Cerai Talak
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" colspan="8">
				                				Permohonan
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" colspan="3">
				                				Unsur Penunjang
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center" rowspan="2">
				                				Keterangan
				                			</th>
				              			</tr>
				                		<tr>
				                			<!-- Dokumen Pendukung -->
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Nomor Surat
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tanggal Surat
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				File
				                			</th>

				                			<!-- CG -->
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 1
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 2
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 3
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Total
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Rata-Rata
				                			</th>

				                			<!-- CT -->
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 1
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 2
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				CT Tahun 3
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Total
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Rata-Rata
				                			</th>

				                			<!-- P -->
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 1
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 2
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Tahun 3
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Total
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Rata-Rata
				                			</th>

				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Jumlah Penduduk
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Kepadatan Penduduk
				                			</th>
				                			<th class=" text-secondary text-uppercase font-weight-bolder text-center">
				                				Kemudahan Akses
				                			</th>
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