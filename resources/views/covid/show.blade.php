@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
@endsection

@section('pagestyle')
<style>
.inv-line {
	margin-top: 10px;
	border-bottom: 1px dotted #ddd;
}
.inv-group {
	padding: 0;
}
.inv-row {
	margin: 0;
}
.inv-label {
	padding5 0 10px;
}
.inv-detail {
	padding: 0;
}
</style>
@endsection

@section('breadcrumbs')
<li><span>Covid</span></li>
<li><span>{{ $covid->idTanggap }}</span></li>
@endsection

@section('content')
<section id="display-data" class="panel col-sm-12">
	<div class="panel-body">
		<div class="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-sm-12 col-md-8 mt-md mb-md">
						<h3 class="h3 mt-none mb-sm text-dark text-bold">Aju <span>{{ $covid->no_permohonan }}</span></h3>
						<h5 class="h5 m-none text-dark">Tanggal <span>{{ $covid->tgl_permohonan }}</span></h5>
					</div>
				</div>
			</header>

			<!-- Data header -->
			<div class="bill-info">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="bill-data">
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Importasi:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">AWB</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->awb }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Tanggal</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->tgl_awb }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Kantor</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->kantor_pemasukan }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Dok. impor</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->dok_layanan }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">No dok.</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->no_dokumen_layanan }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Tgl dok.</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->tgl_dokumen_layanan }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Entitas:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Nama</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->nama_entitas }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">NPWP</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->npwp_entitas }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Jenis</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->jenis_entitas }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Alamat</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->alamat_entitas }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Importir:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Nama</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->nama_importir }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">NPWP</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->npwp_importir }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Alamat</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->alamat_importir }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Pengiriman:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Asal negara</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->negara_asal }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Pengirim</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->nama_pengirim }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Pelabuhan</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->pelabuhan_masuk }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Penerima</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->nama_penerima }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Kegiatan:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Proyek</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->proyek_kegiatan }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Tujuan</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->penggunaan_barang }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Sumber</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->sumber_barang }}</div>
								</div>
							</div>
						</div>
					</div>	
					<div class="col-sm-12 col-md-6">
						<div class="bill-data">
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">PIC:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Nama</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->nama_pic }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Telp</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->telp_pic }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Telp 2</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->telp2_pic }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Email</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->mail_pic }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Pemohon:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Nama</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->nama_pemohon }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Jabatan</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->jabatan_pemohon }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Pungutan:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Bebas</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->status_bebas }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Skema</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->skema_pmk }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Valuta</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->valuta }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">NDPBM</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->ndpbm }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Rekomendasi BNPB:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Nomor</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->no_rekomendasi_bnpb }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Tanggal</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->tgl_rekomendasi_bnpb }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">SKMK:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Nomor</div>
									<div class="inv-detail col-xs-7 col-sm-9">
										{{ $covid->no_skmk }}&nbsp;
										@if( $covid->file_skmk != '' )
											<a href="{{ $covid->file_skmk }}" target="_blank"><i class="fa fa-download"></i></a>
										@endif
									</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Tanggal</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->tgl_skmk }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Penerbit</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->penerbit_skmk }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Akta Yayasan:</h5>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Nomor</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->no_akta_yayasan }}</div>
								</div>
								<div class="row inv-row">
									<div class="inv-label col-xs-5 col-sm-3 text-dark">Tanggal</div>
									<div class="inv-detail col-xs-7 col-sm-9">{{ $covid->tgl_akta_yayasan }}</div>
								</div>
							</div>
							<div class="col-xs-12 inv-group">
								<h5 class="h5 mb-xs text-dark text-semibold">Dokumen Pelengkap:</h5>
								@if( $covid->file_awb != '' )
									<div class="col-xs-10 col-sm-4 mb-1"><a href="{{ $covid->file_awb }}" target="_blank" class="btn btn-sm btn-primary">AWB <i class="fa fa-download"></i></a></div>
								@else
									<div class="col-xs-10 col-sm-4 mb-1"><button class="btn btn-sm btn-default" disabled>AWB <i class="fa fa-download"></i></button></div>
								@endif

								@if( $covid->file_invoice != '' )
									<div class="col-xs-10 col-sm-4 mb-1"><a href="{{ $covid->file_invoice }}" target="_blank" class="btn btn-sm btn-primary">Invoice <i class="fa fa-download"></i></a></div>
								@else
									<div class="col-xs-10 col-sm-4 mb-1"><button class="btn btn-sm btn-default" disabled>Invoice <i class="fa fa-download"></i></button></div>
								@endif

								@if( $covid->file_packing_list != '' )
									<div class="col-xs-10 col-sm-4 mb-1"><a href="{{ $covid->file_packing_list }}" target="_blank" class="btn btn-sm btn-primary">P/L <i class="fa fa-download"></i></a></div>
								@else
									<div class="col-xs-10 col-sm-4 mb-1"><button class="btn btn-sm btn-default" disabled>P/L <i class="fa fa-download"></i></button></div>
								@endif

								@if( $covid->file_pernyataan != '' )
									<div class="col-xs-10 col-sm-4 mb-1"><a href="{{ $covid->file_pernyataan }}" target="_blank" class="btn btn-sm btn-primary">Pernyataan <i class="fa fa-download"></i></a></div>
								@else
									<div class="col-xs-10 col-sm-4 mb-1"><button class="btn btn-sm btn-default" disabled>Pernyataan <i class="fa fa-download"></i></button></div>
								@endif

								@if( $covid->file_hibah != '' )
									<div class="col-xs-10 col-sm-4 mb-1"><a href="{{ $covid->file_hibah }}" target="_blank" class="btn btn-sm btn-primary">Surat hibah <i class="fa fa-download"></i></a></div>
								@else
									<div class="col-xs-10 col-sm-4 mb-1"><button class="btn btn-sm btn-default" disabled>Surat hibah <i class="fa fa-download"></i></button></div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="inv-line"></div>

			<!-- Data barang -->
			<h5 class="h4 mt-lg mb-xs text-dark text-semibold">Data barang:</h5>
			<table class="table table-bordered table-striped mb-none" id="table-barang">
				<thead>
					<tr>
						<th>No</th>
						<th>Uraian</th>
						<th>Jumlah</th>
						<th>Berat</th>
						<th>Volume</th>
						<th>Nilai perkiraan (IDR)</th>
					</tr>
				</thead>
				<tbody>
				@foreach( $covid->barang as $brg )
					<tr>
						<td>{{ $brg->seri_barang }}</td>
						<td>{{ $brg->uraian_barang }}</td>
						<td>{{ $brg->jumlah_barang }}</td>
						<td>{{ $brg->berat }}</td>
						<td>{{ $brg->volume }}</td>
						<td>{{ $brg->nilai_perkiraan }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<div class="inv-line"></div>

			<!-- Data lampiran -->
			<h5 class="h4 mt-lg mb-xs text-dark text-semibold">Dokumen lampiran:</h5>
			<table class="table table-bordered table-striped mb-none" id="table-dokumen">
				<thead>
					<tr>
						<th>No</th>
						<th>No Dokumen</th>
						<th>Tgl Dokumen</th>
						<th>Keterangan</th>
						<th>Download</th>
					</tr>
				</thead>
				<tbody>
				@foreach( $covid->dokumen as $dok )
					<tr>
						<td>{{ $dok->seri_dokumen }}</td>
						<td>{{ $dok->no_dokumen }}</td>
						<td>{{ $dok->tgl_dokumen }}</td>
						<td>{{ $dok->keterangan }}</td>
						<td class="center"><a href="{{ $dok->link }}" target="_blank" class="btn btn-primary btn-sm">Download <i class="fa fa-download"></i></a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<div class="inv-line"></div>
		</div>
		
		<div class="text-right mr-lg">
			<a class="btn btn-primary btnMonitor" href="#modalForm">Edit <i class="fa fa-edit"></i></a>
			<a class="btn btn-danger btnDelete" href="#modalDelete">Hapus <i class="fa fa-trash-o"></i></a>
		</div>
	</div>
</section>

@include('impor.modal_edit')
@endsection

@section('vendorscript')
<script src="{{ asset('vendor/select2/select2.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('vendor/pnotify/pnotify.custom.js') }}"></script>
@endsection

@section('pagescript')
<script>
	window.urlImporOptions = "{{ route('impor.options') }}";
	window.formType = "covid-monitor";
	window.urlForm = "{{ route('impor.store') }}";
	window.urlRedirect = "{{ route('covid.index') }}";
</script>
<script src="{{ asset('js/myJs/modal_impor_edit.js') }}"></script>
<script>
$(document).ready(function() {
	(function( $ ) {
		$('#table-barang').dataTable({
			columnDefs: [
				{width: "5%", targets: 0},
				{width: "35%", targets: 1},
				{searchable: false, targets: 0}
			]
		});
		$('#table-dokumen').dataTable({
			columnDefs: [
				{width: "5%", targets: 0},
				{width: "15%", targets: 4},
				{searchable: false, targets: [0,4]}
			]
		});
		$(document).on('click','.btnMonitor',function (e) {
			e.preventDefault();
			var trigger = $(this);
			$.ajax({
				url: '{{ route("covid.monitor", $covid->idTanggap) }}',
				type: "POST",
				data: { _token: "{{ csrf_token() }}" },
				success: function (response) {
					if (response['form'] == 'insert') {
						window.urlForm = "{{ route('impor.store') }}";
					} else if (response['form'] == 'update') {
						var urlForm = "{{ route('impor.update',0) }}";
						window.urlForm = urlForm.replace("/0/", `/${response['data']['idImpor']}/`);
					}
					openForm(trigger, response['data']);
				}
			});
		})
	}).apply( this, [ jQuery ]);
});
</script>
@endsection