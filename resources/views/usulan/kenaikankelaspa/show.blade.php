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
            			<h6 class="text-white text-capitalize ps-3">Detail {{ $config['pageTitle']  }}</h6>
          			</div>
        		</div>
        	<div class="card-body px-0 pb-2">
        		<div class="row p-2">
            		<div class="col-12">

            			<button class="btn btn-primary btn-lg" onclick="history.back()">
							kembali
						</button>
						
            			<div class="table-responsive p-2">
				            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
				              	<thead>
				              		<tr>
				                  		<th class="text-uppercase font-weight-bolder" colspan="3">Surat Usulan Kenaikan Kelas</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Nomor Surat</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="1px">:</th>
				                  		<th class="text-uppercase font-weight-bolder">-</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Tanggal Surat</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="1px">:</th>
				                  		<th class="text-uppercase font-weight-bolder">-</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Nama Satker</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="1px">:</th>
				                  		<th class="text-uppercase font-weight-bolder">-</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Usul Peningkatan</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="1px">:</th>
				                  		<th class="text-uppercase font-weight-bolder">-</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Pengusulan Ke</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="1px">:</th>
				                  		<th class="text-uppercase font-weight-bolder">-</th>
				                	</tr>
				              	</thead>
				            </table>
				        </div>

            			<div class="table-responsive p-2">
				            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
				              	<thead>
				              		<tr>
				                		<th class="text-uppercase font-weight-bolder" colspan="6">Unsur Substantif (Jumlah Perkara Putus 3 Tahun terakhir)</th>
				                		<th class="text-uppercase font-weight-bolder text-center" width="100px">Skor Unsur Substantif (80%)</th>
				                	</tr>
				                	<tr>
				                		<th class="text-uppercase font-weight-bolder" width="200px">Jenis Perkara</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Tahun 1</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Tahun 2</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Tahun 3</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Jumlah</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="200px">Rata-Rata</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Cerai Gugat</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                	</tr><tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Cerai Talak</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" width="200px">Perkara Kegiatan Lainnya</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">0000000</th>
				                	</tr>
				              	</thead>
				            </table>
				        </div>

				        <div class="table-responsive p-2">
				            <table class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0">
				              	<thead>
				              		<tr>
				                		<th class="text-uppercase font-weight-bolder" colspan="2">Unsur Penunjang</th>
				                		<th class="text-uppercase font-weight-bolder text-center" width="100px">Skor Unsur Penunjang (20%)</th>
				                	</tr>
				                	<tr>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Penduduk</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">100%</th>
				                	</tr>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder">Kepadatan Penduduk</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">100%</th>
				                	</tr><tr>
				                  		<th class="text-uppercase font-weight-bolder">Komunikasi dan Transportasi</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">0000000</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" width="100px">100%</th>
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

@endsection