@section('js')

<script type="text/javascript">
  window.livewire.on('usersStored', () => {
    $('#tableUsulan').DataTable().ajax.reload();
  });
</script>

<script>
  $(document).ready(function() {
  $.fn.dataTable.ext.errMode = 'throw';

  $('#tableUsulan thead tr').clone(true).appendTo( '#tableUsulan thead' );
        $('#tableUsulan thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == 'Status')
            {
              $(this).html( '###' );
            }
            else if(title == 'Action')
            {
              $(this).html( '<a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-search fa-2x"></i></span></a><a href="javascript:void(0)" onclick="deleteData()" type="button" class=""><span><i class="fas fa-times-circle fa-2x"></i></span></a>' )
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
          scrollX:        true,
          scrollCollapse: true,
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          dom:          'lfBrtipr',
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
                      { data: 'nomor_surat', sClass: "text-secondary mb-0 text-center"},
                      { data: 'tanggal_surat', sClass: "text-secondary mb-0 text-center"},
                      { data: 'usul_peningkatan', sClass: "text-secondary mb-0 text-center"},
                      { data: 'usulan_ke', sClass: "text-secondary mb-0 text-center"},
                      { data: 'ct_tahun1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_ct_tahun1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'ct_tahun2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_ct_tahun2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'ct_tahun3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_ct_tahun3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'cg_tahun1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_cg_tahun1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'cg_tahun2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_cg_tahun2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'cg_tahun3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_cg_tahun3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'p_tahun1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_p_tahun1', sClass: "text-secondary mb-0 text-center"},
                      { data: 'p_tahun2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_p_tahun2', sClass: "text-secondary mb-0 text-center"},
                      { data: 'p_tahun3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_p_tahun3', sClass: "text-secondary mb-0 text-center"},
                      { data: 'jumlah_penduduk', sClass: "text-secondary mb-0 text-center"},
                      { data: 'kepadatan_penduduk', sClass: "text-secondary mb-0 text-center"},
                      { data: 'kemudahan_akses', sClass: "text-secondary mb-0 text-center"},
                      { data: 'action', sClass: "text-secondary mb-0 text-center", width: "10px"},
                  ],
          fixedColumns: {
                    leftColumns: 3,
                    rightColumns: 1
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
            			<h6 class="text-white text-capitalize ps-3">Table {{ $config['pageTitle'] }}</h6>
          			</div>
        		</div>
        	<div class="card-body px-0 pb-2">
        		<div class="row p-2">
            		<div class="col-12">
            			<a href="{{ route('usulan.kenaikankelaspa.create') }}" class="btn btn-primary btn-lg">
							Tambah Usulan
						</a>
            			<div class="table-responsive p-3">
				            <table id="tableUsulan" class="table table-bordered table-resposive table-sm order-column nowrap align-items-center mb-0" width="100%">
				              	<thead>
				                	<tr>
				                  		<th class="text-uppercase font-weight-bolder text-center">No</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Tingkat Banding</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Nama Satker</th>
				                  		<!-- surat usulan -->
				                  		<th class="text-uppercase font-weight-bolder text-center">Nomor Surat</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Tanggal Surat</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Usul Peningkatan</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Pengusulan Ke</th>
				                  		<!-- cerai talak -->
				                  		<th class="text-uppercase font-weight-bolder text-center">CT Tahun 1</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">CT Tahun 2</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">CT Tahun 3</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<!-- cerai gugat -->
				                  		<th class="text-uppercase font-weight-bolder text-center">CG Tahun 1</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">CG Tahun 2</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">CG Tahun 3</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<!-- permohonan -->
				                  		<th class="text-uppercase font-weight-bolder text-center">P Tahun 1</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">P Tahun 2</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">P Tahun 3</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah</th>
				                  		<!-- unsur penunjang -->
				                  		<th class="text-uppercase font-weight-bolder text-center">Jumlah Penduduk</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Kepadatan Penduduk</th>
				                  		<th class="text-uppercase font-weight-bolder text-center">Kemudahan Akses</th>
				                  		<!-- Aksi -->
				                  		<th class="text-uppercase font-weight-bolder text-center">Action</th>
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