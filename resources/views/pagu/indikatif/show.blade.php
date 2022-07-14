@section('js')

<script type="text/javascript">
  window.livewire.on('usersStored', () => {
    $('#tablePagu').DataTable().ajax.reload();
  });
</script>

<script>
  $(document).ready(function() {
  $.fn.dataTable.ext.errMode = 'throw';

  $('#tablePagu thead tr').clone(true).appendTo( '#tablePagu thead' );
        $('#tablePagu thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == 'Status')
            {
              $(this).html( '###' );
            }
            else if(title == 'Action')
            {
              $(this).html( '<a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-search fa-3x"></i></span></a><a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-times-circle fa-3x"></i></span></a>' )
            }
            else{
            $(this).html( '<input type="text" style="width:100%;" value="" placeholder="Cari '+title+'" />' );
            }
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

  
      var table = $('#tablePagu')
      .DataTable({

          processing: true,
          serverSide: true,
          ajax: {
              "url"  : "{{ route ('api.rincianindikatif') }}", 
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
          dom:          'lfBrtipr',
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
                      { data: 'reffsatker.kode_satker', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'reffsatker.nama_satker_lengkap', sClass: "text-secondary mb-0 text-start"},
                      { data: 'thang', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_program', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_kegiatan', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_output', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'volume_suboutput', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_suboutput', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'volume_suboutput', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_komponen', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_subkomponen', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'uraian_subkomponen', sClass: "text-secondary mb-0 text-start"},
                      { data: 'kode_akun', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_jenis_beban', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_jenis_bantuan', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'kode_item', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'nomor_item', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'uraian_item', sClass: "text-secondary mb-0 text-start"},
                      { data: 'vol_keg_1', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'sat_keg_1', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'vol_keg_2', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'sat_keg_2', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'vol_keg_3', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'sat_keg_3', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'vol_keg_4', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'sat_keg_4', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'volkeg', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'satkeg', sClass: "text-secondary mb-0 text-center", width: "50px"},
                      { data: 'hargasat', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                      { data: 'total', sClass: "text-secondary mb-0 text-end", render: $.fn.dataTable.render.number( '.', '.'), width: "50px"},
                  ],
          fixedColumns: {
                    leftColumns: 0,
                    rightColumns: 0
                }
      } );

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
            			<h6 class="text-white text-capitalize ps-3">Daftar Rincian {{ $config['pageTitle'] }}</h6>
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
		            			<table id="tablePagu" class="table table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
		              				<thead>
		                				<tr>
		                  					<th class="text-uppercase text-secondary font-weight-bolder">No</th>
		                  					<th class="text-uppercase text-secondary font-weight-bolder">Kode Satker</th>
		                  					<th class="text-uppercase text-secondary font-weight-bolder">Nama Satker</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Tahun</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Program</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Kegiatan</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Output</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Volume Output</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Sub Output</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Volume Sub Output</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Komponen</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Sub Komponen</th>
		                  					<th class="text-uppercase text-secondary font-weight-bolder">Uraian Sub Komponen</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Akun</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Jenis Beban</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Jenis Bantuan</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Kode Item</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Nomor Item</th>
		                  					<th class="text-uppercase text-secondary font-weight-bolder">Uraian Item</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol Keg 1</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat Keg 1</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol Keg 2</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat Keg 2</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol Keg 3</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat Keg 3</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol Keg 4</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat Keg 4</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Vol Keg</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Sat Keg</th>
		                  					<th class="text-center text-uppercase text-secondary font-weight-bolder">Harga Satuan</th>
		                  					<th class="text-uppercase text-secondary font-weight-bolder">Total Pagu</th>
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