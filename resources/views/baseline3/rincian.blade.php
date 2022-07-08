@section('js')

<script>
  	$(document).ready(function() {
  		$("#volume1").keyup(function(){
      		var v1 = $("#volume1").val();
      		if(v1 <= 1 && v1 != "") {
        		$("#volume1").val(1);
       			 $("#volume1x").val(v1);
        		vkali()
      		} else {
        		$("#volume1").val();
        		$("#volume1x").val(v1);
        		vkali()
      		}
    	});

    	$("#volume2").keyup(function(){
      		var v2 = $("#volume2").val();
      		if(v2 <= 1 && v2 != "") {
        		$("#volume2").val(1);
        		$("#volume2x").val(v2);
        		vkali()
      		} else {
        		$("#volume2").val();
        		$("#volume2x").val(v2);
        		vkali()
      		}
    	});

    	$("#volume3").keyup(function(){
      		var v3 = $("#volume3").val();
      		if(v3 <= 1 && v3 != "") {
        		$("#volume3").val(1);
        		$("#volume3x").val(v3);
        		vkali()
      		} else {
        		$("#volume3").val();
        		$("#volume3x").val(v3);
        		vkali()
      		}
    	});

    	$("#volume4").keyup(function(){
      		var v4 = $("#volume4").val();
      		if(v4 <= 1 && v4 != "") {
        		$("#volume4").val(1);
        		$("#volume4x").val(v4);
        		vkali()
      		} else {
        		$("#volume4").val();
        		$("#volume4x").val(v4);
        		vkali()
      		}
    	});

    	function vkali() {
      		var a = $('#volume1').val();
      		var b = $('#volume2').val();
      		var c = $('#volume3').val();
      		var d = $('#volume4').val();
      
      		var z = a * b * c * d;

      		//alert(z);
      		$("#volumeKegiatan").val(z);
    	}

    	$("#hargaSatuan").keyup(function(){
      		var strval =  $("#hargaSatuan").val();
      		if(strval == "") {
        		//alert("tidak boleh kosong");
      		} else {
        		hkali()
        		//alert("data ada");
      		}
    	});

    	function hkali() {
      		var a = $('#hargaSatuan').val();
      		var b = $('#volumeKegiatan').val();
      		var c = a * b;
      
      		//alert(c);
      		$("#jumlah").val(c);
      	}
    
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
              	"url"  : "{{ route ('api.databaseline3') }}", 
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
                      	{ data: 'reffsatker_id', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'reffsatker.nama_satker_lengkap', sClass: "text-secondary mb-0 text-left"},
                      	{ data: 'kddept', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdunit', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdprogram', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdgiat', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdoutput', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdlokasi', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdkabkota', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kddekon', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdsoutput', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdkmpnen', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdskmpnen', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdakun', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'kdkppn', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'noitem', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'nmitem', sClass: "text-secondary mb-0 text-start"},
                      	{ data: 'vol1', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'sat1', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'vol2', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'sat2', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'vol3', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'sat3', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'vol4', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'sat4', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'volkeg', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'satkeg', sClass: "text-secondary mb-0 text-center"},
                      	{ data: 'hargasat', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.')},
                      	{ data: 'jumlah', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.')},
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
		            		<input type="hidden" id="unik" name="unik" value="{{ $unik }}"/>
		            		<div class="row">
		            			<div class="col-1">
				            		<button class="btn bg-gradient-danger" onclick="history.back()">
					                  	<i class="fa fa-arrow-left me-2"></i>kembali
					                </button>
					            </div>
					            <div class="col-2">
					            	<div class="dropdown">
										<button class="btn bg-gradient-info dropdown-toggle ms-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-plus me-2"></i>Tambah Data
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<li><a class="dropdown-item text-secondary" href="javascript:;" onclick="add()">Opsi 1 (Mengambil Pagu Awal)</a></li>
		                    				<li><a class="dropdown-item text-secondary" href="{{ route('baseline3.create') }}">Opsi 2 (Menginput Pagu Baru)</a></li>
										</ul>
									</div>
					            </div>
		            		</div>

							<div id="mForm" style="display: none;">
				              	<form method="post" autocomplete="off" action="{{ route('baseline3.store') }}">
				              		<div class="card-body pb-2">
				                		<div class="row">
				                  			<div class="col-md-4">
				                    			<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Satuan Kerja</label>
				                      				<input type="hidden" id="idPagu" name="idPagu">
				                      				<input type="text" id="kodeSatker" name="kodeSatker" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Nama Satuan Kerja</label>
				                     				 <input type="text" id="namaSatker" name="namaSatker" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Departemen</label>
				                      				<input type="text" id="kodeDepartemen" name="kodeDepartemen" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
				                   				</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Unit</label>
				                      				<input type="text" id="kodeUnit" name="kodeUnit" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Lokasi</label>
				                      				<input type="text" id="kodeLokasi" name="kodeLokasi" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Kabupaten Kota</label>
				                      				<input type="text" id="kodeKabkot" name="kodeKabkot" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label for="exampleFormControlSelect1" class="ms-0">Kode Program</label>
				                      				<input type="text" id="kodeProgram" name="kodeProgram" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label for="exampleFormControlSelect1" class="ms-0">Kode Kegiatan</label>
				                      				<input type="text" id="kodeKegiatan" name="kodeKegiatan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label for="exampleFormControlSelect1" class="ms-0">Kode Output</label>
				                      				<input type="text" id="kodeOutput" name="kodeOutput" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label for="exampleFormControlSelect1" class="ms-0">Kode Sub Output</label>
				                      				<input type="text" id="kodeSubOutput" name="kodeSubOutput" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>
				                  			</div>
				                  			<div class="col-md-4">
				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Dekon</label>
				                      				<input type="text" id="kodeDekon" name="kodeDekon" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Komponen</label>
				                      				<input type="text" id="kodeKomponen" name="kodeKomponen" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Sub Komponen</label>
				                      				<input type="text" id="kodeSubKomponen" name="kodeSubKomponen" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode Akun</label>
				                      				<input type="text" id="kodeAkun" name="kodeAkun" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Kode KPPN</label>
				                      				<input type="text" id="kodeKppn" name="kodeKppn" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Nomor Item</label>
				                      				<input type="number" id="nomorItem" name="nomorItem" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Nama Item</label>
				                      				<input type="text" id="namaItem" name="namaItem" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Volume 1</label>
				                      				<input type="number" id="volume1" name="volume1" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"  required="">
				                      				<input type="hidden" id="volume1x" name="volume1x" value="0">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Satuan 1</label>
				                      				<input type="text" id="satuan1" name="satuan1" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Volume 2</label>
				                      				<input type="number" id="volume2" name="volume2" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                      				<input type="hidden" id="volume2x" name="volume2x" value="0">
				                    			</div>
				                  			</div>
				                  			<div class="col-md-4">
				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Satuan 2</label>
				                      				<input type="text" id="satuan2" name="satuan2" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Volume 3</label>
				                      				<input type="number" id="volume3" name="volume3" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                      				<input type="hidden" id="volume3x" name="volume3x" value="0">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Satuan 3</label>
				                      				<input type="text" id="satuan3" name="satuan3" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Volume 4</label>
							                      	<input type="number" id="volume4" name="volume4" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
							                      	<input type="hidden" id="volume4x" name="volume4x" value="0">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Satuan 4</label>
				                      				<input type="text" id="satuan4" name="satuan4" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Volume Kegiatan</label>
				                      				<input type="number" id="volumeKegiatan" name="volumeKegiatan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Satuan Kegiatan</label>
				                      				<input type="text" id="satuanKegiatan" name="satuanKegiatan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Harga Satuan</label>
				                      				<input type="number" id="hargaSatuan" name="hargaSatuan" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required="">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label>Jumlah = Harga Satuan x Volume Kegiatan</label>
				                      				<input type="number" id="jumlah" name="jumlah" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="">
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label for="exampleFormControlSelect1" class="ms-0">Jenis Belanja</label>
				                      				<select id="operasional" name="operasional" class="form-control">
				                        				<option value="Y">Belanja Operasional</option>
				                        				<option value="T">Belanja Non Operasional</option>
				                      				</select>
				                    			</div>

				                    			<div class="input-group input-group-static mb-2">
				                      				<label for="exampleFormControlSelect1" class="ms-0">Skala Prioritas</label>
				                      				<select id="prioritas" name="prioritas" class="form-control">
				                        				<option value="Y">Ya</option>
				                        				<option value="T">Tidak</option>
				                      				</select>
				                    			</div>
				                			</div>
				                		</div>
				                		<div class="row">
				                  			<div class="col-md-12 text-end">
				                    			<button type="button" class="btn btn-outline-danger mt-2" onclick="hideForm()">
				                      				<i class="fa fa-close me-3 fa-2x"></i>Batal
				                    			</button>
				                    			<button type="submit" class="btn btn-outline-info mt-2">
				                      				<i class="fa fa-save me-3 fa-2x"></i>Simpan
				                    			</button>
				                  			</div>
				                		</div>
				            		</div>
				            	</form>
				          	</div>

				          	<hr>

		            		<div class="table-responsive p-3">
				            	<table id="tableBaseline" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
				              		<thead>
				                		<tr>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">No</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Kode Satker</th>
						                  	<th class="text-uppercase text-secondary font-weight-bolder">Nama Satker</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Departement</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Unit</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Program</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Giat</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Output</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Lokasi</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Kab Kota</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Dekon</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Sub Output</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Komponen</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Sub Komponen</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Akun</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode KPPN</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">No Item</th>
						                  	<th class="text-left text-uppercase text-secondary font-weight-bolder">Nama Item</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol1</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat1</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol2</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat2</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol3</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat3</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol4</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat4</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Volume Kegiatan</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Satuan Kegiatan</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Harga Satuan</th>
						                  	<th class="text-center text-uppercase text-secondary font-weight-bolder">Jumlah</th>
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
<div class="modal fade" id="mAdd" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="max-width: 90%;">
    	<div class="modal-content">
      	<div class="modal-header">
        	<h5 class="modal-title" id="mTitle">Your modal title</h5>
        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      	</div>
      	<div class="modal-body">
        	<!-- tabel pagu-->
        	@include('baseline3.modalpagu')
      	</div>
      	<div class="modal-footer justify-content-between">
        	<button type="button" class="btn bg-gradient-dark mb-0" data-bs-dismiss="modal">Tutup</button>
        	<!--
        	<button type="button" class="btn bg-gradient-primary mb-0">Simpan</button>
        	-->
      	</div>
    	</div>
  	</div>
</div>
<!-- Modal -->
@endsection

<script type="text/javascript">
  	function add() { 
    	$('#mAdd').modal('show');
    	$('#mTitle').text('Daftar Pagu Awal');
  	}

  	function hideForm() {
    	document.getElementById("mForm").style.display = "none"; 
  	}

  	function use(unik) {
        $.ajax({
            type: 'POST',
            url : '{{ route ('baseline3.pagu') }}',
            data: 	{
                    	'_token': "{{ csrf_token() }}",
                    	'unik': unik,
                	},

            success:function(data) {
                //alert("Hello! I am an alert box!!");
                $("#idPagu").val(data.id);
                $("#kodeSatker").val(data.reffsatker_id);
                $("#kodeDepartemen").val(data.kddept);
                $("#kodeUnit").val(data.kdunit);
                $("#kodeProgram").val(data.kdprogram);
                $("#kodeKegiatan").val(data.kdgiat);
                $("#kodeOutput").val(data.kdoutput);
                $("#kodeSubOutput").val(data.kdsoutput);
                $("#kodeLokasi").val(data.kdlokasi);
                $("#kodeKabkot").val(data.kdkabkota);
                $("#kodeDekon").val(data.kddekon);
                $("#kodeKomponen").val(data.kdkmpnen);
                $("#kodeSubKomponen").val(data.kdskmpnen);
                $("#kodeAkun").val(data.kdakun);
                $("#kodeKppn").val(data.kdkppn);
                $("#nomorItem").val(data.noitem);
                $("#namaItem").val(data.nmitem);
                //$("#volume1").val(data.vol1);
                $("#satuan1").val(data.sat1);
                //$("#volume2").val(data.vol2);
                $("#satuan2").val(data.sat2);
                //$("#volume3").val(data.vol3);
                $("#satuan3").val(data.sat3);
                //$("#volume4").val(data.vol4);
                $("#satuan4").val(data.sat4);
                //$("#volumeKegiatan").val(data.volkeg);
                $("#satuanKegiatan").val(data.satkeg);
                //$("#hargaSatuan").val(data.hargasat);
                //$("#jumlah").val(data.jumlah);
                //$("#opr").val(data.operasional);
                //$("#prior").val(data.prioritas);

                $('#mAdd').modal('hide');
                document.getElementById("mForm").style.display = "block"; 
            },
            error:function(data) {
                alert("Data gagal ditampilkan!");
                }
       	});
    }
</script>