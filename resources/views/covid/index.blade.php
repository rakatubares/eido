@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
@endsection

@section('pagestyle')
@endsection

@section('breadcrumbs')
<li><span>Covid</span></li>
<li><span>Pengajuan Baru</span></li>
@endsection

@section('content')
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Aju Covid</h2>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-striped mb-none" id="table-data">
			<thead>
				<tr>
					<th>Permohonan</th>
					<th>Tgl Permohonan</th>
					<th>AWB</th>
					<th>Importir</th>
					<th>SKMK</th>
					<th>Indikasi</th>
					<th>stat</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</section>
@endsection

@section('vendorscript')
<script src="{{ asset('vendor/select2/select2.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
@endsection

@section('pagescript')
<script>
$(document).ready(function() {
	(function( $ ) {
		///// Display DataTable /////
		function showData() {
			$.ajax({
				url: "{{ route('covid.list') }}",
				method: "GET",
				data: { _token: "{{ csrf_token() }}" },
				success: function(data) {
					console.log(data);
					data.forEach(function(dat) {
						// console.log(dat.latest_status.kode_status);
						lsValidasi = []
						dat.validasi.forEach(function(val) {
							lsValidasi.push(val.keterangan);
						});
						var validasi = lsValidasi.join('; ');

						var rows = `
							<tr>
								<td>${dat.no_permohonan}<br>${dat.tgl_permohonan}</td>
								<td>${dat.tgl_permohonan}</td>
								<td>${dat.awb}<br>${dat.tgl_awb}</td>
								<td>${dat.nama_importir}</td>
								<td>${dat.no_skmk}<br>${dat.tgl_skmk}</td>
								<td>${validasi}</td>
								<td>${dat.latest_status.kode_status}</td>
								<td class="center">
									<a class="btn btn-primary btn-xs" href="covid/${dat.idTanggap}">Detail</a>
								</td>
							</tr>
						`;
						$('#table-data tbody').append(rows);
					});
					
					$('#table-data').dataTable({
						columnDefs: [
							{width: "15%", targets: 4},
							{width: "5%", targets: 7},
							{sortable: false, targets: 7},
							{visible: false, targets: 1},
							{searchable: false, targets: 7}
						],
						order: [[ 1, "asc" ]]
					});

					$('#table-data_wrapper .dataTables_paginate a').removeClass('paginate_button');
					$('#table-data_wrapper .dataTables_paginate a').addClass('paginate');
				}
			});
		};
		showData();
	}).apply( this, [ jQuery ]);
});
</script>
@endsection