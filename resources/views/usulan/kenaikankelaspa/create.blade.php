@section('js')

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
            			<h6 class="text-white text-capitalize ps-3">Form {{ $config['pageTitle']  }}</h6>
          			</div>
        		</div>
        	<div class="card-body px-0 pt-0 pb-2">
        		<div class="row p-3">
            		<div class="col-12">

            			<button class="btn btn-primary btn-lg ms-2 mt-2" onclick="history.back()">
							kembali
						</button>

						<h5 class="ms-2 mb-0">Silahkan lengkapi data berikut!</h5>

						<form method="POST" action="{{ route('usulan.kenaikankelaspa.store') }}" enctype="multipart/form-data">
            			<div class="table p-2">
				            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
				              	<thead>
				              		<tr class="bg-gradient-primary" style="color: #ffffff;">
				                  		<th class="text-uppercase font-weight-bolder" colspan="3">Surat Usulan Kenaikan Kelas</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Nomor Surat <span class="text-primary">*</span></th>
				                  		<th class="text-uppercase font-weight-bolder p-2">
				                  			<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
					                  		<div class="input-group input-group-static mb-0">
												<input type="text" name="nomorSurat" class="form-control" placeholder="Nomor Surat" onfocus="focused(this)" onfocusout="defocused(this)" required="">
											</div>	
				                  		</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Tanggal Surat <span class="text-primary">*</span></th>
				                  		<th class="text-uppercase font-weight-bolder p-2">
					                  		<div class="input-group input-group-static mb-0">
												<input type="date" name="tanggalSurat" class="form-control" placeholder="Tanggal Surat" onfocus="focused(this)" onfocusout="defocused(this)" required="">
											</div>	
				                  		</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Nama Satker <span class="text-primary">*</span></th>
				                  		<th class="text-uppercase font-weight-bolder p-2">
											<select class="form-control" name="namaSatker" id="choices-button" placeholder="Nama Satker">
												<option value="">- Pilih -</option>
												@foreach($satker as $data)
											  	<option value="{{ $data->kode_satker }}">{{ $data->nama_satker_lengkap }}</option>
											  	@endforeach
											</select>
				                  		</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Usul Peningkatan <span class="text-primary">*</span></th>
				                  		<th class="text-uppercase font-weight-bolder p-2">
					                  		<div class="input-group input-group-static mb-0">
												<input type="text" name="usulPeningkatan" class="form-control" placeholder="Usul Peningkatan" onfocus="focused(this)" onfocusout="defocused(this)" required="">
											</div>	
				                  		</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Pengusulan Ke <span class="text-primary">*</span></th>
				                  		<th class="text-uppercase font-weight-bolder p-2">
					                  		<div class="input-group input-group-static mb-0">
												<input type="text" name="pengusulanKe" class="form-control" placeholder="Pengusulan Ke" onfocus="focused(this)" onfocusout="defocused(this)" required="">
											</div>	
				                  		</th>
				                	</tr>
				                	<!--
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Data Dukung <span class="text-primary">*</span></th>
				                  		<th class="text-uppercase font-weight-bolder p-2">
					                  		<div class="input-group input-group-static mb-0">
												<input type="file" name="dakung" class="form-control" placeholder="Data Dukung" onfocus="focused(this)" onfocusout="defocused(this)" required="">
											</div>	
				                  		</th>
				                	</tr>
				                	-->
				              	</thead>
				            </table>
				        </div>

            			<div class="table-responsive p-2">
				            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
				              	<thead>
				              		<tr class="bg-gradient-primary" style="color: #ffffff;">
				                		<th class="text-uppercase font-weight-bolder" colspan="5">Unsur Substantif (Jumlah Perkara Putus 3 Tahun terakhir)</th>
				                	</tr>
				                	<tr class="bg-success" style="color: #ffffff;">
				                		<th class="text-uppercase font-weight-bolder" width="200px">Jenis Perkara</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Tahun 1</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Tahun 2</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Tahun 3</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Jumlah</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">
				                  			Cerai Gugat
				                  		</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="cgTahun1" class="form-control text-center" placeholder="Jumlah Perkara 1" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="cgTahun2" class="form-control text-center" placeholder="Jumlah Perkara 2" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
										<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="cgTahun3" class="form-control text-center" placeholder="Jumlah Perkara 3" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
										<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="cgJumlah" class="form-control text-center" placeholder="Jumlah Perkara CG" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">
					                  		Cerai Talak
					                  	</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="ctTahun1" class="form-control text-center" placeholder="Jumlah Perkara 1" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="ctTahun2" class="form-control text-center" placeholder="Jumlah Perkara 2" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
										<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="ctTahun3" class="form-control text-center" placeholder="Jumlah Perkara 3" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
										<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="ctJumlah" class="form-control text-center" placeholder="Jumlah Perkara CT" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">
				                  			Perkara / Kegiatan Lainnya
				                  		</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="plTahun1" class="form-control text-center" placeholder="Jumlah Perkara 1" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="plTahun2" class="form-control text-center" placeholder="Jumlah Perkara 2" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
										<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="plTahun3" class="form-control text-center" placeholder="Jumlah Perkara 3" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
										<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="plJumlah" class="form-control text-center" placeholder="Jumlah Perkara PL" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>	
										</th>
				                	</tr>
				              	</thead>
				            </table>
				        </div>

				        <div class="table-responsive p-2">
				            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
				              	<thead>
				              		<tr class="bg-gradient-primary" style="color: #ffffff;">
				                		<th class="text-uppercase font-weight-bolder" colspan="3">Unsur Penunjang</th>
				                	</tr>
				                	<tr class="bg-success" style="color: #ffffff;">
				                		<th class="text-uppercase font-weight-bolder text-center">Jumlah Penduduk</th>
				                		<th class="text-uppercase font-weight-bolder text-center">Kepadatan Penduduk</th>
				                		<th class="text-uppercase font-weight-bolder text-center">Komunikasi dan Transportasi</th>
				                	</tr>
				                	<tr>
				                		<th class="text-uppercase font-weight-bolder text-center" width="200px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="jumlahPenduduk" class="form-control text-center" placeholder="Jumlah Penduduk" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>
				                  		</th>
				                		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="kepadatanPenduduk" class="form-control text-center" placeholder="Kepadatan Penduduk" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>
				                  		</th>
				                		<th class="text-uppercase font-weight-bolder text-center" width="100px">
				                  			<div class="input-group input-group-static mb-0">
												<input type="text" name="akses" class="form-control text-center" placeholder="Komunikasi & Transportasi" onfocus="focused(this)" onfocusout="defocused(this)">
											</div>
				                  		</th>
				                	</tr>
				              	</thead>
				            </table>
				        </div>

				        <div class="table-responsive p-2">
				            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
				              	<thead>
				              		<tr>
				                		<th class="text-uppercase font-weight-bolder text-end">
				                			<button type="submit" class="btn btn-success btn-lg ms-0 mb-0">
												Simpan
											</button>
				                		</th>
				                	</tr>
				              	</thead>
				            </table>
				        </div>
				    	</form>

            		</div>
            	</div>
        	</div>
        </div>
    </div>
</div>

@endsection