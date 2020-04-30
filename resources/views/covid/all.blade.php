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
			$('#table-data').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('covid.all_list') }}',
				columns: [
					{ 
						data: 'tgl_permohonan',
						render: function (data, type, row) {
							return row.no_permohonan + '<br>' + row.tgl_permohonan
						}
					},
					{ 
						data: 'tgl_awb',
						render: function (data, type, row) {
							return row.awb + '<br>' + row.tgl_awb
						}
					},
					{ data: 'nama_importir' },
					{ data: 'kantor_permohonan' },
					{ data: 'kantor_pemasukan' },
					{ 
						data: 'validasi',
						render: function (data, type, row) {
							if (data.length > 0) {
								var lsValidasi = []
								data.forEach(function(val) {
									lsValidasi.push(val.keterangan);
								});
								var validasi = lsValidasi.join('; ');
							} else {
								var validasi = ''
							}
							return validasi
						}
					},
					{ 
						data: 'idTanggap',
						render: function (data, type, row) {
							return `<a class="btn btn-primary btn-xs" href="covid/${data}">Detail</a>`
						}
					},
					{ data: 'no_permohonan' },
					{ data: 'awb' }
				],
				columnDefs: [
					{width: "5%", targets: [3,4,6]},
					{sortable: false, targets: [5,6,7,8]},
					{searchable: false, targets: [5,6]},
					{visible: false, targets: [7,8]},
					{className: "center", targets: [6] }
				],
				order: [[ 0, "desc" ]],
				pagingType: "full_numbers"
			});
		};
		showData();
	}).apply( this, [ jQuery ]);
});
</script>
@endsection