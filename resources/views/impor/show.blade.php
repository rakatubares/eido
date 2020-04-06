@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
@endsection

@section('pagestyle')
<style>
.datepicker-dropdown,
.bootstrap-timepicker-widget {
	z-index: 99999 !important;
}

.panel-heading {
	padding: 10px;
}

.panel-title {
	font-size: 17px;
}

.alert {
	padding-top: 10px;
	padding-bottom: 10px;
	margin-bottom: 5px;
	text-align: center;
}

.invoice-label {
	display: inline-block;
	width: 100px;
	margin-left: 5px;
}
</style>
@endsection

@section('breadcrumbs')
<li><span>Importasi</span></li>
<li><span>Detail</span></li>
<li><span>{{ $importasi->id }}</span></li>
@endsection

@section('content')
@if (
	$importasi->check_nib == 0 || 
	$importasi->check_lartas != 1 || 
	($importasi->bebas == 0 && $importasi->check_bebas != 1) 
)
<section class="panel panel-warning">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Kurang persyaratan</h2>
	</header>
	<div class="panel-body">
		@if ($importasi->check_nib == 0)
		<div class="col-sm-12 col-md-4">
			<div class="alert alert-warning mx-1">
				Syarat NIB belum dipenuhi.
			</div>
		</div>
		@endif
		@if ($importasi->check_lartas != 1)
		<div class="col-sm-12 col-md-4">
			<div class="alert alert-warning mx-1">
				Lartas belum dipenuhi.
			</div>
		</div>
		@endif
		@if ($importasi->bebas == 0 && $importasi->check_bebas != 1)
		<div class="col-sm-12 col-md-4">
			<div class="alert alert-warning mx-1">
				Pembebasan belum dipenuhi.
			</div>
		</div>
		@endif
	</div>
</section>
@endif
<section class="panel">
	<div class="panel-body">
		<div class="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-sm-12 mt-md mb-md">
						<h3 class="h3 mt-none mb-sm text-dark text-bold">AWB {{ $importasi->awb }}</h3>
						<h5 class="h5 m-none text-dark">Tanggal {{ $importasi->tgl_awb }}</h5>
					</div>
				</div>
			</header>
			<div class="bill-info">
				<div class="row">
					<div class="col-sm-12">
						<div class="bill-data">
							<h5 class="h5 mb-xs text-dark text-semibold">Importir:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span>{{ $importasi->importir }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">NPWP</span>
								<span>{{ $importasi->npwp }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Status</span>
								<span>{{ $importasi->status_importir }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">NIB</span>
								<span>
								@if ( $importasi->nib == 1)
									OK {{ $importasi->dok_nib }}
								@else
									Tidak Ada
								@endif
								</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">Pengirim:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span>{{ $importasi->pengirim }}</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">PIC:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span>{{ $importasi->pic }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">No HP</span>
								<span>{{ $importasi->hp_pic }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Email</span>
								<span>{{ $importasi->email_pic }}</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">Lartas:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Syarat lartas</span>
								<span>
								@if ( $importasi->check_lartas == 1)
									OK {{ $importasi->dok_lartas }}
								@else
									Belum terpenuhi
								@endif
								</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">Pungutan:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Pembayaran</span>
								<span>
								@if ( $importasi->bebas == 1)
									Pembebasan
								@else
									Dibayar
								@endif
								</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Rekomendasi</span>
								<span>
								@if ( $importasi->rekomendasi_bebas == 1)
									Ada {{ $importasi->dok_rekomendasi_bebas }}
								@else
									Tidak ada
								@endif
								</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Skep Bebas</span>
								<span>
								@if ( $importasi->check_bebas == 1)
									Ada {{ $importasi->dok_bebas}}
								@else
									TIdak ada
								@endif
								</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">Clearance:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Rekomendasi</span>
								<span>{{ $importasi->rekomendasi_clearance }}</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('vendorscript')
<script src="{{ asset('vendor/select2/select2.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('vendor/pnotify/pnotify.custom.js') }}"></script>
@endsection