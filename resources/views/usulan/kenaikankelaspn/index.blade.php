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
            			<h6 class="text-white text-capitalize ps-3">Table {{ $config['pageTitle']  }}</h6>
          			</div>
        		</div>
        	<div class="card-body px-0 pb-2">
        		<div class="row p-3">
            		<div class="col-12">
            			<a href="{{ route('usulan.kenaikankelaspn.create') }}" class="btn btn-primary btn-lg">
							Tambah Usulan
						</a>
            			<div class="table-responsive p-3">
				            <table id="tableBaseline" class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
				              	<thead>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder" rowspan="3">No</th>
				                  		<th class="text-uppercase font-weight-bolder" rowspan="3">Tingkat Banding</th>
				                  		<th class="text-uppercase font-weight-bolder" rowspan="3">Nama Satker</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="2">Pengajuan</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="32">Perkara Pidana</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="32">Perkara Perdata</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="5">Unsur Penunjang</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Skor Unsur Substantif (80%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="6">Skor Unsur Penunjang (30%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="3">Jumlah Skor (100%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="3">Aksi</th>
				                	</tr>
				                	<tr>
				                		<th class="text-uppercase font-weight-bolder" rowspan="2">Usulan Peningkatan</th>
				                  		<th class="text-uppercase font-weight-bolder" rowspan="2">Usulan Ke</th>

				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Pidana Biasa dan Pidana Singkat</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Persentase  Pidana Biasa dan Pidana Singkat</th>

				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Pidana Khusus dan Cepat</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Persentase Khusus dan Cepat</th>

				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Gugatan</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Persentase Perkara Gugatan</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Permohonan</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" colspan="8">Persentase Perkara Permohonan</th>

				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Jumlah Penduduk</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Kepadatan Penduduk</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Kemudahan Akses</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Penerapan RB</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Letak Pengadilan</th>

				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Perkara Pidana Biasa dan Singkat (15%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Persentase Pidana Biasa dan Singkat (15%)</th>

				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Pidana Khusus dan Cepat (9%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Persentase Pidana Khusus dan Cepat (6%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Perkara Gugatan (9%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Persentase Perkara Gugatan (6%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Perkara Permohonan (9%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Persentase Perkara Permohonan (6%)</th>

				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Kepadatan (5%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Kemudahan Akses (5%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Penerapan RB (5%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Penerapan RB (5%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Letak Pengadilan (10%)</th>
				                  		<th class="text-uppercase font-weight-bolder text-center" rowspan="2">Total (30%)</th>
				                	</tr>
				                	<tr>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>

				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>

				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>

				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>

				                		<!-- Perkara Gugatan -->
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>

				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>

				                		<!-- Perkara Permohonan -->
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah Perkara</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>

				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Tahun</th>
				                		<th class="text-uppercase font-weight-bolder">Persentase</th>
				                		<th class="text-uppercase font-weight-bolder">Jumlah</th>
				                		<th class="text-uppercase font-weight-bolder">Rata-Rata</th>
				                	</tr>
				              	</thead>
				              	<tbody>
				              		<tr>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">-</td>
				              			<td class="text-center">
				              				<a href="{{ route('usulan.kenaikankelaspn.show', 1) }}" type="button" class="btn btn-info btn-round ml-0" title="Edit" style="margin: 5px;">
		                                        <i class="fa fa-edit" aria-hidden="true"></i>
		                                    </a>
				              			</td>
				              		</tr>
				              	</tbody>
				            </table>
				        </div>
            		</div>
            	</div>
        	</div>
        </div>
    </div>
</div>

@endsection