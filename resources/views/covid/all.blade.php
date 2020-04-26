@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
@endsection

@section('pagestyle')
<style>
#table-data_paginate > a, 
#table-data_paginate > span > a,
#table-data_paginate > span > span {
	position: relative;
	float: left;
	padding: 6px 12px;
	line-height: 1.42857143;
	text-decoration: none;
	color: #428bca;
	background-color: #ffffff;
	border: 1px solid #dddddd;
		border-top-color: rgb(221, 221, 221);
		border-right-color: rgb(221, 221, 221);
		border-bottom-color: rgb(221, 221, 221);
		border-left-color: rgb(221, 221, 221);
	margin-left: -1px;
}

#table-data_paginate #table-data_first {
	margin-left: 0;
    border-bottom-left-radius: 4px;
    border-top-left-radius: 4px;
}

#table-data_paginate #table-data_last {
	border-bottom-right-radius: 4px;
	border-top-right-radius: 4px;
}

#table-data_paginate .current {
	background-color: #0088cc;
	border-color: #0088cc;
	z-index: 2;
	color: #ffffff;
	cursor: default;
}

#table-data_paginate .disabled {
	color: #777777;
	background-color: #ffffff;
	border-color: #dddddd;
	cursor: not-allowed;
}
</style>
@endsection

@section('breadcrumbs')
<li><span>Covid</span></li>
<li><span>Semua Aju</span></li>
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
					<th>Kantor Mohon</th>
					<th>Kantor Masuk</th>
					<th>Indikasi</th>
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
<script src="//cdn.datatables.net/plug-ins/1.10.20/pagination/input.js"></script>
@endsection

@section('pagescript')
<script>
$(document).ready(function() {
	(function( $ ) {
		///// Display DataTable /////
		function showData() {
			$.ajax({
				url: "{{ route('covid.all_list') }}",
				method: "GET",
				data: { _token: "{{ csrf_token() }}" },
				success: function(data) {
					data.forEach(function(dat) {
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
								<td>${dat.kantor_permohonan}</td>
								<td>${dat.kantor_pemasukan}</td>
								<td>${validasi}</td>
								<td class="center">
									<a class="btn btn-primary btn-xs" href="covid/${dat.idTanggap}">Detail</a>
								</td>
							</tr>
						`;
						$('#table-data tbody').append(rows);
					});
					
					$('#table-data').dataTable({
						columnDefs: [
							{width: "5%", targets: [4,5]},
							{width: "5%", targets: 7},
							{sortable: false, targets: 7},
							{visible: false, targets: 1},
							{searchable: false, targets: 7}
						],
						order: [[ 1, "desc" ]],
						pagingType: "full_numbers"
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