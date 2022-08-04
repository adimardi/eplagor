<style>
	body {
  		font-family: Arial, Helvetica, sans-serif;
  		font-size: 11px;
	}

	#table {
	  	font-family: Arial, Helvetica, sans-serif;
	  	border-collapse: collapse;
	  	width: 100%;
	}

	#table tr:nth-child(even){background-color: #ffffff;}

	#table th {
		border: 1px solid #ddd;
	  	padding-top: 10px;
	  	padding-bottom: 10px;
	  	text-align: left;
	  	background-color: #FFF;
	  	color: #000;
	}

	#table td {
	  	border-left: 1px solid #ddd;
	  	border-right: 1px solid #ddd;
	  	padding: 6px;
	}

	#table tr:last-of-type {
	    /*border:none;*/
	    border-bottom: 1px solid #ddd;
	    /*any other style*/
	}
</style>
<h3>
	<center>
		RINCIAN KERTAS KERJA SATKER T.A {{ date('Y')+1 }}
	</center>
</h3>

@php
	$satker = App\reffsatker::where('id', $id)->first();
    $totals = App\anggaran::where('thang', 2023)->where('reffsatker_id', $id)->sum('total');
    $kode_programs = App\anggaran::where('thang', 2023)
                                 ->where('reffsatker_id', $id)
                                 ->groupBy('kode_program')
                                 ->selectRaw('kode_program, SUM(total) as total_programs')
                                 ->get();
@endphp

<table border="0">
	<thead style="font-weight: bold;">
		<tr>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				<strong>KEMEN/LEMB</strong>
			</th>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				(005)
			</th>
			<th style="tvertical-align: middle; text-align: left;">
				MAHKAMAH AGUNG
			</th>
		</tr>
		<tr>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				<strong>UNIT ORG</strong>
			</th>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				(01)
			</th>
			<th style="vertical-align: middle; text-align: left;">
				Badan Urusan Administrasi
			</th>
		</tr>
		<tr>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				<strong>UNIT KERJA</strong>
			</th>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				({{ $satker->kode_satker }})
			</th>
			<th style="vertical-align: middle; text-align: left;">
				{{ $satker->nama_satker_lengkap }}
			</th>
		</tr>
		<tr>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				<strong>ALOKASI</strong>
			</th>
			<th width="150px" style="vertical-align: middle; text-align: left;">
				{{ number_format($totals) }}
			</th>
			<th colspan="2" style="vertical-align: middle; text-align: left;"></th>
		</tr>
	</thead>
</table>

<br>

<table id="table">
	<thead style="font-weight: bold;">
		<tr>
			<th rowspan="2" style="vertical-align: middle;">
				<center><strong>KODE</strong></center>
			</th>
			<th rowspan="2" style="tvertical-align: middle;">
				<center>PROGRAM/ KEGIATAN/ KRO/ RO/ KOMPONEN/ SUBKOMP/ DETIL</center>
			</th>
			<th colspan="4" style="tvertical-align: middle;">
				<center>PERHITUNGAN TAHUN {{ date('Y')+1 }}</center>
			</th>
			<th rowspan="2" style="tvertical-align: middle;">
				<center>SD/CP</center>
			</th>
		</tr>

		<tr>
			<th style="vertical-align: middle;">
				<center>VOLUME</center>
			</th>
			<th style="vertical-align: middle;">
				<center>HARGA SATUAN</center>
			</th>
			<th colspan="2" style="vertical-align: middle;">
				<center>JUMLAH BIAYA</center>
			</th>
		</tr>
		<tr>
			<th style="vertical-align: middle;">
				<center>(1)</center>
			</th>
			<th style="vertical-align: middle;">
				<center>(2)</center>
			</th>
			<th style="vertical-align: middle;">
				<center>(3)</center>
			</th>
			<th style="vertical-align: middle;">
				<center>(4)</center>
			</th>
			<th colspan="2" style="vertical-align: middle;">
				<center>(5)</center>
			</th>
			<th style="vertical-align: middle;">
				<center>(6)</center>
			</th>
		</tr>
	</thead>

	<tbody>
		<!-- Kode Program -->
		@foreach ($kode_programs as $programs)
		<tr>
			<td style="vertical-align: top;">
				005.01.{{ $programs->kode_program }}
			</td>
			<td style="vertical-align: top; text-align: left;">
				@php
				$uraian = App\UraianAnggaran::where('kode', $programs->kode_program)->first();
				@endphp
				{{ $uraian->deskripsi }}
			</td>
			<td style="vertical-align: top;">
				<center></center>
			</td>
			<td style="vertical-align: top;">
				<center></center>
			</td>
			<td style="vertical-align: top; text-align: right;">
				{{ number_format($programs->total_programs) }}
			</td>
			<td style="vertical-align: top;">
				<center></center>
			</td>
			<td style="vertical-align: top;">
				<center></center>
			</td>
		</tr>
			<!-- Kode Kegiatan -->
			@php
			$kode_kegiatans = App\anggaran::where('thang', 2023)
	                                      ->where('reffsatker_id', $id)
	                                      ->where('kode_program', $programs->kode_program)
	                                      ->groupBy('kode_kegiatan')
	                                      ->selectRaw('kode_kegiatan, SUM(total) as total_kegiatans')
	                                      ->get();
            @endphp

            @foreach ($kode_kegiatans as $kegiatans)
			<tr style="color: blue;">
				<td style="vertical-align: top;">
					<p style="margin-left: 5px;">{{ $kegiatans->kode_kegiatan }}</p>
				</td>
				<td style="vertical-align: top; text-align: left;">
					@php
					$uraian = App\UraianAnggaran::where('jenis', 'kegiatan')->where('kode', $kegiatans->kode_kegiatan)->first();
					@endphp
					{{ $uraian->deskripsi }}
				</td>
				<td style="vertical-align: top;">
					<center></center>
				</td>
				<td style="vertical-align: top;">
					<center></center>
				</td>
				<td style="vertical-align: top; text-align: right;">
					{{ number_format($kegiatans->total_kegiatans) }}
				</td>
				<td style="vertical-align: top;">
					<center></center>
				</td>
				<td style="vertical-align: top;">
					<center></center>
				</td>
			</tr>
				<!-- Kode Output -->
				@php
				$kode_outputs = App\anggaran::where('thang', 2023)
	                                        ->where('reffsatker_id', $id)
		                                    ->where('kode_program', $programs->kode_program)
		                                    ->where('kode_kegiatan', $kegiatans->kode_kegiatan)
	                                        ->groupBy('kode_output')
	                                        ->selectRaw('kode_output, SUM(total) as total_outputs')
	                                        ->get();
	            @endphp

	            @foreach ($kode_outputs as $outputs)
				<tr style="color: red;">
					<td style="vertical-align: top;">
						<p style="margin-left: 10px;">{{ $kegiatans->kode_kegiatan.'.'.$outputs->kode_output }}</p>
					</td>
					<td style="vertical-align: top; text-align: left;">
						@php
						$uraian = App\UraianAnggaran::where('jenis', 'output')->where('kode', $kegiatans->kode_kegiatan.'.'.$outputs->kode_output)->first();
						@endphp
						{{ $uraian->deskripsi }}
					</td>
					<td style="vertical-align: top;">
						<center></center>
					</td>
					<td style="vertical-align: top;">
						<center></center>
					</td>
					<td style="vertical-align: top; text-align: right;">
						{{ number_format($outputs->total_outputs) }}
					</td>
					<td style="vertical-align: top;">
						<center></center>
					</td>
					<td style="vertical-align: top;">
						<center></center>
					</td>
				</tr>
					<!-- Kode Sub Output -->
					@php
					$kode_suboutputs = App\anggaran::where('thang', 2023)
		                                        	->where('reffsatker_id', $id)
			                                    	->where('kode_program', $programs->kode_program)
			                                    	->where('kode_kegiatan', $kegiatans->kode_kegiatan)
			                                    	->where('kode_output', $outputs->kode_output)
		                                        	->groupBy('kode_suboutput')
		                                        	->selectRaw('kode_suboutput, SUM(total) as total_suboutputs')
		                                        	->get();
		            @endphp

		            @foreach ($kode_suboutputs as $suboutputs)
					<tr style="color: black;">
						<td style="vertical-align: top;">
							<p style="margin-left: 15px;">{{ $kegiatans->kode_kegiatan.'.'.$outputs->kode_output.'.'.$suboutputs->kode_suboutput }}</p>
						</td>
						<td style="vertical-align: top; text-align: left;">
							@php
							$uraian = App\UraianAnggaran::where('jenis', 'suboutput')->where('kode', $kegiatans->kode_kegiatan.'.'.$outputs->kode_output.'.'.$suboutputs->kode_suboutput)->first();
							@endphp
							{{ $uraian->deskripsi }}
						</td>
						<td style="vertical-align: top;">
							<center></center>
						</td>
						<td style="vertical-align: top;">
							<center></center>
						</td>
						<td style="vertical-align: top; text-align: right;">
							{{ number_format($suboutputs->total_suboutputs) }}
						</td>
						<td style="vertical-align: top;">
							<center></center>
						</td>
						<td style="vertical-align: top;">
							<center></center>
						</td>
					</tr>

						<!-- Kode Komponen -->
						@php
						$kode_komponens = App\anggaran::where('thang', 2023)
			                                        	->where('reffsatker_id', $id)
				                                    	->where('kode_program', $programs->kode_program)
				                                    	->where('kode_kegiatan', $kegiatans->kode_kegiatan)
				                                    	->where('kode_output', $outputs->kode_output)
				                                    	->where('kode_suboutput', $suboutputs->kode_suboutput)
			                                        	->groupBy('kode_komponen')
			                                        	->selectRaw('kode_komponen, SUM(total) as total_komponens')
			                                        	->get();
			            @endphp

			            @foreach ($kode_komponens as $komponens)
						<tr style="color: black;">
							<td style="vertical-align: top;">
								<p style="margin-left: 20px;">{{ $komponens->kode_komponen }}</p>
							</td>
							<td style="vertical-align: top; text-align: left;">
								@php
								$uraian = App\UraianAnggaran::where('jenis', 'komponen')->where('kode', $kegiatans->kode_kegiatan.'.'.$outputs->kode_output.'.'.$suboutputs->kode_suboutput.'.'.$komponens->kode_komponen)->first();
								@endphp
								{{ $uraian->deskripsi }}
							</td>
							<td style="vertical-align: top;">
								<center></center>
							</td>
							<td style="vertical-align: top;">
								<center></center>
							</td>
							<td style="vertical-align: top; text-align: right;">
								{{ number_format($komponens->total_komponens) }}
							</td>
							<td style="vertical-align: top;">
								<center></center>
							</td>
							<td style="vertical-align: top;">
								<center></center>
							</td>
						</tr>

							<!-- Kode Sub Komponen -->
							@php
							$kode_subkomponens = App\anggaran::where('thang', 2023)
				                                        	->where('reffsatker_id', $id)
					                                    	->where('kode_program', $programs->kode_program)
					                                    	->where('kode_kegiatan', $kegiatans->kode_kegiatan)
					                                    	->where('kode_output', $outputs->kode_output)
					                                    	->where('kode_suboutput', $suboutputs->kode_suboutput)
					                                    	->where('kode_komponen', $komponens->kode_komponen)
				                                        	->groupBy('kode_subkomponen', 'uraian_subkomponen')
				                                        	->selectRaw('kode_subkomponen, uraian_subkomponen, SUM(total) as total_subkomponens')
				                                        	->get();
				            @endphp

				            @foreach ($kode_subkomponens as $subkomponens)
							<tr style="color: black;">
								<td style="vertical-align: top;">
									<p style="margin-left: 25px;">{{ $subkomponens->kode_subkomponen }}</p>
								</td>
								<td style="vertical-align: top; text-align: left;">
									{{ $subkomponens->uraian_subkomponen }}
								</td>
								<td style="vertical-align: top;">
									<center></center>
								</td>
								<td style="vertical-align: top;">
									<center></center>
								</td>
								<td style="vertical-align: top; text-align: right;">
									{{ number_format($subkomponens->total_subkomponens) }}
								</td>
								<td style="vertical-align: top;">
									<center></center>
								</td>
								<td style="vertical-align: top;">
									<center></center>
								</td>
							</tr>

								<!-- Kode Akun -->
								@php
								$kode_akuns = App\anggaran::where('thang', 2023)
					                                        	->where('reffsatker_id', $id)
						                                    	->where('kode_program', $programs->kode_program)
						                                    	->where('kode_kegiatan', $kegiatans->kode_kegiatan)
						                                    	->where('kode_output', $outputs->kode_output)
						                                    	->where('kode_suboutput', $suboutputs->kode_suboutput)
						                                    	->where('kode_komponen', $komponens->kode_komponen)
						                                    	->where('kode_subkomponen', $subkomponens->kode_subkomponen)
						                                    	->groupBy('kode_akun')
					                                        	->selectRaw('kode_akun, SUM(total) as total_akuns')
					                                        	->get();
					            @endphp

					            @foreach ($kode_akuns as $akuns)
								<tr style="color: black;">
									<td style="vertical-align: top;">
										<p style="margin-left: 30px;">{{ $akuns->kode_akun }}</p>
									</td>
									<td style="vertical-align: top; text-align: left;">
										@php
										$uraian = App\UraianAnggaran::where('jenis', 'akun')->where('kode', $akuns->kode_akun)->first();
										@endphp
										{{ $uraian->deskripsi }}

										@php
										$dataakuns = App\anggaran::where('thang', 2023)
							                                 	 ->where('reffsatker_id', $id)
								                             	 ->where('kode_akun', $akuns->kode_akun)
							                                 	 ->get();
							            @endphp
							            @foreach ($dataakuns as $datas)
							            	<p style="margin-left: 0px;"><span style="margin-left: 20px; margin-right: 20px;">-</span>{{ $datas->uraian_item }}</p>
							            @endforeach
									</td>
									<td style="vertical-align: top;">
										<center></center>
									</td>
									<td style="vertical-align: top;">
										<center></center>
									</td>
									<td style="vertical-align: top; text-align: right;">
										{{ number_format($akuns->total_akuns) }}

										@php
										$jumlahakuns = App\anggaran::where('thang', 2023)
							                                 	 ->where('reffsatker_id', $id)
								                             	 ->where('kode_akun', $akuns->kode_akun)
							                                 	 ->get();
							            @endphp
							            @foreach ($jumlahakuns as $jumlahs)
							            	<p>{{ number_format($jumlahs->total) }}</p>
							            @endforeach
									</td>
									<td style="vertical-align: top;">
										<center></center>
									</td>
									<td style="vertical-align: top;">
										<center></center>
									</td>
								</tr>
								@endforeach
							@endforeach
						@endforeach
					@endforeach
				@endforeach
			@endforeach
		@endforeach
	</tbody>
</table>