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
  	$('#tableAbt thead tr').clone(true).appendTo( '#tableAbt thead' );
        $('#tableAbt thead tr:eq(1) th').each( function (i) {
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

        
      	var table = $('#tableSemula')
      	.DataTable({
          	orderCellsTop: true,
          	stateSave: true,
          	scrollX: true,
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
          	fixedColumns: {
                leftColumns: 0,
                rightColumns: 0
            }
      	});

      	var table = $('#tableMenjadi')
      	.DataTable({
          	orderCellsTop: true,
          	stateSave: true,
          	scrollX: true,
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
          	fixedColumns: {
                leftColumns: 0,
                rightColumns: 0
            }
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
        		<div class="card-header p-0 position-relative mt-n4 mx-0 z-index-2">
          			<div class="bg-gradient-primary shadow-primary pt-4 pb-3">
            			<h6 class="text-white text-capitalize ps-3">{{ $config['pageTitle']  }}</h6>
          			</div>
        		</div>
        		<div class="card-body pt-2 ps-0 pe-0 pb-0">
        			<div class="row p-0 my-3 mx-1">
		            			<div class="col-6">
		            				<a href="{{ route('abt.index') }}" class="btn bg-gradient-warning ms-2">
										<i class="fa fa-arrow-left me-2"></i>Kembali
									</a>
		            			</div>
		            			<div class="col-6">
		            				<!--
		            				<a href="{{ route('abt.hapus', $unik) }}" class="btn bg-gradient-danger me-2" style="float: right;">
										<i class="fa fa-trash me-2"></i>Batal
									</a>
									<a href="{{ route('abt.save', $unik) }}" class="btn bg-gradient-info ms-2" style="float: right;">
										<i class="fa fa-save me-2"></i>Simpan Usulan
									</a>
									-->
									<button type="submit" class="btn bg-gradient-info me-3" style="float: right;"><i class="fa fa-save me-2"></i>Simpan Usulan</button>
		            			</div>
		            		</div>

                    <div class="row p-3">
                        <div class="col-lg-6 mb-2">
                            <div class="card my-0">
				        		<div class="card-header p-0 position-relative mt-n4 mx-0 z-index-2">
				          			<div class="bg-gradient-primary shadow-primary pt-3 pb-2">
				            			<h6 class="text-white text-capitalize ps-3">Semula</h6>
				          			</div>
				        		</div>
				        		<div class="card-body p-3">
				        			<div class="table-responsive p-0">
								        <table id="tableSemula" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
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
                        <div class="col-lg-6 mb-2">
                            <div class="card my-0">
				        		<div class="card-header p-0 position-relative mt-n4 mx-0 z-index-2">
				          			<div class="bg-gradient-primary shadow-primary pt-3 pb-2">
				            			<h6 class="text-white text-capitalize ps-3">Menjadi</h6>
				          			</div>
				        		</div>
				        		<div class="card-body p-3">
				        			<div class="table-responsive p-0">
								        <table id="tableMenjadi" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
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
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mTable" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="max-width: 90%;">
    	<div class="modal-content">
      	<div class="modal-header">
        	<h5 class="modal-title" id="mTitle">Your modal title</h5>
        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      	</div>
      	<div class="modal-body">
        	<!-- tabel pagu-->
        	@include('abt.modalpagu')
      	</div>
      	<div class="modal-footer justify-content-between text-center p-3">
        	<button type="button" class="btn bg-gradient-danger mb-0" data-bs-dismiss="modal">Tutup</button>
      	</div>
    	</div>
  	</div>
</div>
<!-- Modal -->

@endsection

<script type="text/javascript">
  	function getTable() { 
    	$('#mTable').modal('show');
    	$('#mTitle').text('Daftar Pagu Awal');
    	//alert('Ambil Data Pagu');
    	//document.getElementById("mForm").style.display = "block"; 
  	}

  	function hideForm() {
    	document.getElementById("mForm").style.display = "none"; 
  	}

  	function use(unik) {
        $.ajax({
            type: 'POST',
            url : '{{ route ('abt.getpagu') }}',
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

                $('#mTable').modal('hide');
                document.getElementById("mForm").style.display = "block"; 
            },
            error:function(data) {
                alert("Data gagal ditampilkan!");
            }
       	});
    }
</script>