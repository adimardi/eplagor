@section('js')

<script>
  	$(document).ready(function() {

  		var bPegawai = document.getElementById('bPegawai');
  		var bBarang = document.getElementById('bBarang');
  		var bModal = document.getElementById('bModal');

	    bPegawai.addEventListener('keyup', function(e)
	    {
	        bPegawai.value = formatRupiah(this.value);
	    });

	    bBarang.addEventListener('keyup', function(e)
	    {
	        bBarang.value = formatRupiah(this.value);
	    });

	    bModal.addEventListener('keyup', function(e)
	    {
	        bModal.value = formatRupiah(this.value);
	    });

	    /* Fungsi */
	    function formatRupiah(angka, prefix)
	    {
	        var number_string = angka.replace(/[^,\d]/g, '').toString(),
	            split    = number_string.split(','),
	            sisa     = split[0].length % 3,
	            rupiah     = split[0].substr(0, sisa),
	            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
	            
	        if (ribuan) {
	            separator = sisa ? '.' : '';
	            rupiah += separator + ribuan.join('.');
	        }
	        
	        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	    }

  		$.fn.dataTable.ext.errMode = 'throw';

  		var table = $('#tableAbt')
      	.DataTable({
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
          	fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
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
        		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          			<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            			<h6 class="text-white text-capitalize ps-3">{{ $config['pageTitle'].' ('.$usulan->reffsatker->nama_satker_lengkap.')' }}</h6>
          			</div>
        		</div>
        		<div class="card-body px-0 pb-0">
		          	<div class="row p-3">
		            	<div class="col-12">

		            		<a href="{{ route('abt.index') }}" class="btn bg-gradient-warning ms-0">
								<i class="fa fa-arrow-left me-2"></i>Kembali
							</a>

							<div class="row">
		            			<div class="col-6">
									<div class="table p-0">
							            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
							              	<thead>
							              		<tr class="bg-gradient-primary" style="color: #ffffff;">
							                  		<th class="text-uppercase font-weight-bolder" colspan="2">
							                  			<span style="line-height: 26px;">Surat Usulan ABT</span>
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Nomor Surat</th>
							                  		<th>
							                  			{{ $usulan->nomor_surat }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Tanggal Surat</th>
							                  		<th>
								                  		{{ $usulan->tanggal_surat }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Perihal Surat</th>
							                  		<th>
								                  		{{ $usulan->perihal_surat }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">File Surat</th>
							                  		<th>
								                  		-
							                  		</th>
							                	</tr>
							                </thead>
							            </table>
							        </div>
							    </div>
							    <div class="col-3">
							    	<div class="table p-0">
							            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
							              	<thead>
							              		<tr class="bg-gradient-primary" style="color: #ffffff;">
							                  		<th class="text-uppercase font-weight-bolder" colspan="2">
							                  			<span style="line-height: 26px;">Usulan Anggaran</span>
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Belanja Pegawai</th>
							                  		<th class="text-end">
							                  			Rp. {{ number_format($tpegawai) }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Belanja Barang</th>
							                  		<th class="text-end">
							                  			Rp. {{ number_format($tbarang) }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Belanja Modal</th>
							                  		<th class="text-end">
								                  		Rp. {{ number_format($tmodal) }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Total</th>
							                  		<th class="text-end">
							                  			Rp. {{ number_format($tpegawai+$tbarang+$tmodal) }}
							                  		</th>
							                	</tr>
							                </thead>
							            </table>
							        </div>
							    </div>
							    <div class="col-3">
							    	<div class="table p-0">
							            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
							              	<thead>
							              		<tr class="bg-gradient-primary" style="color: #ffffff;">
							                  		<th class="text-uppercase font-weight-bolder" colspan="2">
							                  			<span style="line-height: 26px;">Anggaran yang Disetujui</span>
				                    					<button class="btn btn-sm btn-icon btn-2 btn-warning ms-0 mb-0" type="button" style="float: right;"  data-bs-toggle="modal" data-bs-target="#mAnggaran" title="Update Anggaran">
														  	<span class="btn-inner--text">Update</span>
														</button>
				                    				</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Belanja Pegawai</th>
							                  		<th class="text-end">
							                  			@if(!empty($usulan->setujui_pegawai))
								                  			Rp. {{ number_format($usulan->setujui_pegawai) }}
								                  		@else
								                  			-
								                  		@endif
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Belanja Barang</th>
							                  		<th class="text-end">
							                  			@if(!empty($usulan->setujui_barang))
								                  			Rp. {{ number_format($usulan->setujui_barang) }}
								                  		@else
								                  			-
								                  		@endif
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Belanja Modal</th>
							                  		<th class="text-end">
								                  		@if(!empty($usulan->setujui_modal))
								                  			Rp. {{ number_format($usulan->setujui_modal) }}
								                  		@else
								                  			-
								                  		@endif
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Total</th>
							                  		<th class="text-end">
							                  			@if(!empty($usulan->setujui_pegawai) && !empty($usulan->setujui_barang) && !empty($usulan->setujui_modal))
								                  			Rp. {{ number_format($usulan->setujui_pegawai+$usulan->setujui_barang+$usulan->setujui_modal) }}
								                  		@else
								                  			-
								                  		@endif
							                  		</th>
							                	</tr>
							                </thead>
							            </table>
							        </div>
							    </div>
							</div>

							<div class="row">
		            			<div class="col-6">
									<div class="table p-0">
							            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
							              	<thead>
							              		<tr class="bg-gradient-primary" style="color: #ffffff;">
							                  		<th class="text-uppercase font-weight-bolder" colspan="2">
							                  			<span style="line-height: 26px;">Verifikasi Tingkat Banding</span>
				                    					<button class="btn btn-sm btn-icon btn-2 btn-warning ms-0 mb-0" type="button" title="Verifikasi" onclick="verifikasi(1)" style="float: right;" >
														  	<span class="btn-inner--text">Verifikasi</span>
														</button>
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Status Usulan</th>
							                  		<th>
							                  			{{ $verifpta->status_text }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Alasan</th>
							                  		<th>
								                  		{{ $verifpta->alasan }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Keterangan</th>
							                  		<th>
								                  		{{ $verifpta->keterangan }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">Nomor Surat Pengantar</th>
							                  		<th>
								                  		{{ $verifpta->nomor_surat }}
							                  		</th>
							                	</tr>
							                	<tr>
							                  		<th width="200px">File Surat</th>
							                  		<th>
								                  		{{ $verifpta->file_surat }}
							                  		</th>
							                	</tr>
							                </thead>
							            </table>
							        </div>
		            			</div>
		            			<div class="col-6">
		            				<div class="table-responsive">
		            					<table class="table align-items-center mb-0">
							              	<thead>
							              		<tr class="bg-gradient-primary" style="color: #ffffff;">
							                  		<th class="text-uppercase font-weight-bolder" colspan="4">
							                  			<span style="line-height: 26px;">Verifikasi Tingkat Pusat</span>
				                    					<button class="btn btn-sm btn-icon btn-2 btn-warning ms-0 mb-0" type="button" style="float: right;" onclick="verifikasi(2)" title="Verifikasi">
														  	<span class="btn-inner--text">Verifikasi</span>
														</button>
							                  		</th>
							                	</tr>
							                </thead>
							            </table>
							        </div>
		            				<div class="table-responsive">
    									<table class="table align-items-center mb-0">
							              	<thead>
							                	<tr class="bg-success" style="color: #ffffff;">
							                  		<th>Esselon I</th>
							                  		<th>Status</th>
							                  		<th>Alasan</th>
							                  		<th>Keterangan</th>
							                  		<th class="text-center" width="10px">Tanggal Verifikasi</th>
							                	</tr>
						              			@foreach($verifpusat as $data)
							                	<tr>
							                  		<th>
								                  		{{ $data->verifikator }}
							                  		</th>
							                  		<th>
							                  			@if($data->status == 1)
								                  			Disetuji
								                  		@else
								                  			Tidak Disetujui
								                  		@endif
							                  		</th>
							                  		<th>
								                  		{{ $data->alasan }}
							                  		</th>
							                  		<th>
								                  		{{ $data->keterangan }}
							                  		</th>
							                  		<th class="text-center">
								                  		{{ $data->created_at }}
							                  		</th>
							                	</tr>
							                	@endforeach
							                </thead>
							            </table>
							        </div>
		            			</div>

							</div>

							<div class="row">
		            			<div class="col-12">
									<div class="table p-0">
							            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
							              	<thead>
							              		<tr class="bg-gradient-primary" style="color: #ffffff;">
							                  		<th class="text-uppercase font-weight-bolder" colspan="2">
							                  			<span style="line-height: 26px;">Rekap Detail Usulan</span>
							                  		</th>
							                	</tr>
							                </thead>
							            </table>
							        </div>

							        <div class="table-responsive p-0">
								        <table id="tableAbt" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
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
								                  	<th class="text-end text-uppercase text-secondary font-weight-bolder">Harga Satuan</th>
								                  	<th class="text-end text-uppercase text-secondary font-weight-bolder">Jumlah</th>
								                  	<th class="text-uppercase text-secondary font-weight-bolder" width="10px">Aksi</th>
								                </tr>
						              		</thead>
						              		<tbody>
						              			@php $i = 0 @endphp
						              			@foreach($items as $data)
						              			@php $i++ @endphp
						              			<tr>
						              				<td class="text-secondary text-center"> {{ $i }} </td>
						              				<td class="text-secondary text-center"> {{ $data->reffsatker_id }} </td>
						              				<td class="text-secondary text-center"> {{ $data->reffsatker->nama_satker_lengkap }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kddept }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdunit }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdprogram }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdgiat }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdoutput }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdlokasi }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdkabkota }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kddekon }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdsoutput }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdkmpnen }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdskmpnen }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdakun }} </td>
						              				<td class="text-secondary text-center"> {{ $data->kdkppn }} </td>
						              				<td class="text-secondary text-center"> {{ $data->noitem }} </td>
						              				<td class="text-secondary text-left"> {{ $data->nmitem }} </td>
						              				<td class="text-secondary text-center"> {{ $data->vol1 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->sat1 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->vol2 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->sat2 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->vol3 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->sat3 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->vol4 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->sat4 }} </td>
						              				<td class="text-secondary text-center"> {{ $data->volkeg }} </td>
						              				<td class="text-secondary text-center"> {{ $data->satkeg }} </td>
						              				<td class="text-secondary text-end"> {{ number_format($data->hargasat) }} </td>
						              				<td class="text-secondary text-end"> {{ number_format($data->jumlah) }} </td>
						              				<td class="text-secondary text-end"> 
						              					<a href="{{ route('abt.show', $data->unik) }}" class="ml-0 mb-0 text-danger" title="Hapus Data" style="padding: 8px 13px;"><i class="fas fa-trash"></i></a> 
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
    </div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade" id="mVerifikasi" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="max-width: 500px;">
    	<div class="modal-content">
    		<form class="mb-0" method="post" autocomplete="off" action="{{ route('abt.verified') }}" enctype="multipart/form-data">
	      	<div id="isi"></div>	
	      	</form>
    	</div>
  	</div>
</div>
<!-- Modal -->

<!-- Modal Anggaran -->
<div class="modal fade" id="mAnggaran" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="max-width: 500px;">
    	<div class="modal-content">
    		<form class="mb-0" method="post" autocomplete="off" action="{{ route('abt.anggaran_disetujui') }}" enctype="multipart/form-data">
	      	<div class="modal-header">
                <h5 class="modal-title" id="mTitle">Anggaran Disetujui</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	<input type="text" id="unik" name="unik" value="{{ $usulan->unik }}">
            	<div class="input-group input-group-static mb-2">
                    <label>Kode Satker</label>
                    <input type="text" id="reffsatker_id" name="reffsatker_id" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="" value="{{ $satker->kode_satker }}">
               	</div>
               	<div class="input-group input-group-static mb-2">
                    <label>Nama Satker</label>
                    <input type="text" id="namaSatker" name="namaSatker" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" readonly="" value="{{ $satker->nama_satker_lengkap }}">
               	</div>
               	<p class="m-3">Anggaran Disetui</p>
               	<div class="input-group input-group-static mb-2">
                    <label>Belanja Pegawai</label>
                    <input type="text" id="bPegawai" name="bPegawai" class="form-control harga" onfocus="focused(this)" onfocusout="defocused(this)" required="">
               	</div>
               	<div class="input-group input-group-static mb-2">
                    <label>Belanja Barang</label>
                    <input type="text" id="bBarang" name="bBarang" class="form-control harga" onfocus="focused(this)" onfocusout="defocused(this)" required="">
               	</div>
               	<div class="input-group input-group-static mb-2">
                    <label>Belanja Modal</label>
                    <input type="text" id="bModal" name="bModal" class="form-control harga" onfocus="focused(this)" onfocusout="defocused(this)" required="">
               	</div>
            </div>
            <div class="modal-footer justify-content-between text-center p-3">
                <button type="button" class="btn bg-gradient-danger mb-0" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn bg-gradient-primary mb-0">Simpan</button>
            </div>
	      	</form>
    	</div>
  	</div>
</div>
<!-- Modal -->
@endsection

<script type="text/javascript">
  	function verifikasi(param) { 
    	$.ajax({
            url : "{{ route ('abt.verifikasi').'/'.$usulan->unik }}"+'/'+param,
            type: "GET",
                //dataType: "JSON",
            success: function(data) {
               	$('#isi').html(data);
                $('#mVerifikasi').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown){
            	alert('error');
            }
        });
  	}
</script>