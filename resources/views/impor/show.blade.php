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

.timeline .tm-items > li {
	margin: 15px 0;
}

textarea { 
	resize:none;
	max-height:100px;
}
</style>
@endsection

@section('breadcrumbs')
<li><span>Importasi</span></li>
<li><span>Detail</span></li>
<li><span>{{ $importasi->id }}</span></li>
@endsection

@section('content')
@if($errors->any())
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		{!! implode('', $errors->all('<div>:message</div>')) !!}
	</div>
@endif
<!-- Notifikasi persyaratan -->
@if (
	$importasi->check_nib == 0 || 
	$importasi->check_lartas != 1 || 
	($importasi->bebas == 1 && $importasi->check_bebas != 1) 
)
<section id="notif-syarat" class="panel panel-warning col-sm-12">
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
			<div id="notif-nib" class="alert alert-warning mx-1">
				Syarat NIB belum dipenuhi.
			</div>
		</div>
		@endif
		@if ($importasi->check_lartas != 1)
		<div class="col-sm-12 col-md-4">
			<div id="notif-lartas" class="alert alert-warning mx-1">
				Lartas belum dipenuhi.
			</div>
		</div>
		@endif
		@if ($importasi->bebas == 1 && $importasi->check_bebas != 1)
		<div class="col-sm-12 col-md-4">
			<div id="notif-bebas" class="alert alert-warning mx-1">
				Pembebasan belum dipenuhi.
			</div>
		</div>
		@endif
	</div>
</section>
@endif

<!-- Detail dokumen -->
<section id="display-data" class="panel col-sm-12 col-md-8">
	<div class="panel-body">
		<div class="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-sm-12 col-md-8 mt-md mb-md">
						<h3 class="h3 mt-none mb-sm text-dark text-bold">AWB <span id="display_awb">{{ $importasi->awb }}</span></h3>
						<h5 class="h5 m-none text-dark">Tanggal <span id="display_tgl_awb">{{ $importasi->tgl_awb }}</span></h5>
					</div>
					<div class="col-sm-12 col-md-4 mt-md mb-md">
						<button id="display_current_stat" class="btn btn-danger pull-right"> 
							{{ $importasi->status->ur_status }}
						</button>
					</div>
				</div>
			</header>
			<div class="bill-info">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="bill-data">
							<h5 class="h5 mb-xs text-dark text-semibold">Importir:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span id="display_importir">{{ $importasi->importir }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">NPWP</span>
								<span id="display_npwp">{{ $importasi->npwp }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Status</span>
								<span id="display_jns_importir">{{ $importasi->jenis_importir->jns_importir }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">NIB</span>
								<span id="display_nib">
								@if ( $importasi->check_nib == 1)
									OK {{ $importasi->dok_nib }}
								@else
									Belum terpenuhi
								@endif
								</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">Pengirim:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span id="display_pengirim">{{ $importasi->pengirim }}</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">PIC:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span id="display_pic">{{ $importasi->pic }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">No HP</span>
								<span id="display_hp_pic">{{ $importasi->hp_pic }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Email</span>
								<span id="display_email_pic">{{ $importasi->email_pic }}</span>
							</p>
						</div>
					</div>	
					<div class="col-sm-12 col-md-6">
						<div class="bill-data">
							<h5 class="h5 mb-xs text-dark text-semibold">Lartas:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Syarat lartas</span>
								<span id="display_lartas">
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
								<span id="display_pungutan">
								@if ( $importasi->bebas == 1)
									Pembebasan
								@else
									Dibayar
								@endif
								</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Rekomendasi</span>
								<span id="display_rekomendasi">
								@if ( $importasi->rekomendasi_bebas == 1)
									Ada {{ $importasi->dok_rekomendasi_bebas }}
								@else
									Tidak ada
								@endif
								</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Skep Bebas</span>
								<span id="display_pembebasan">
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
								<span id="display_rekomendasi_clearance">{{ $importasi->rekomendasi_impor->rekomendasi }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Waktu</span>
								<span id="display_perkiraan_clearance">{{ $importasi->tgl_clearance . ' ' . $importasi->wkt_clearance }}</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">License Officer:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span id="display_officer">{{ $importasi->officer->name }}</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="text-right mr-lg">
			<a id="{{ $importasi->id }}" class="btn btn-primary btnEdit" href="#modalForm">Edit <i class="fa fa-edit"></i></a>
		</div>
	</div>
</section>

<!-- Status -->
<section class="col-sm-12 col-md-4">
	<!-- Detail Status -->
	<div class="panel panel-featured">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
			</div>

			<h2 class="panel-title">Status</h2>
		</header>
		<div class="panel-body">
			<div class="timeline timeline-simple mb-md">
				<div class="tm-body py-0">
					<ol id="timeline-status" class="tm-items">
						@foreach ($histories as $history)
						<li>
							<div class="tm-box">
								<p class="text-muted mb-none">{{ $history->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</p>
								<p>
									{{ $history->uraian_status->ur_status }} {{ $history->no_dok_impor }}
								</p>
								@if( $history->detail != null )
								<p>
									{{ $history->detail }}
								</p>
								@endif
							</div>
						</li>
						@endforeach
					</ol>
				</div>
			</div>
		</div>
	</div>

	<!-- Form Update Status -->
	<div id="panel-update-status" class="panel">
		<div class="panel-body center">
			<button id="btn-status-update" class="btn btn-primary">Update status <i class="fa fa-clock-o"></i></button>
			{!! Form::open(['id' => 'formStatus', 'method' => 'POST', 'class' => 'form-horizontal form-bordered mb-lg', 'style' => 'display: none;']) !!}
				<div class="form-group">
					<div class="col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Status</label>
						<div class="col-sm-12 col-md-10">
							{!! Form::select('kd_status', $statOptions->pluck('ur_status','kd_status'),null, array('class' => 'form-control')) !!}
							<div id="error_npwp" class="error_text"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Dok</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::select('jns_dok_impor', ['RH','PIB','CN','PIBK','CD','Lainnya'],null, array('class' => 'form-control')) !!}
							<div id="error_npwp" class="error_text"></div>
						</div>
						<div class="col-sm-12 col-md-6">
							{!! Form::text('no_dok_impor', null, array('placeholder' => 'No Dokumen','class' => 'form-control')) !!}
							<div id="error_npwp" class="error_text"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 mb-md">
						<div class="col-sm-12">
							{!! Form::textarea('detail', null, array('placeholder' => 'Keterangan','class' => 'form-control')) !!}
							<div id="error_npwp" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12 text-right">
					<button id="btn-status-submit" class="btn btn-primary">Submit</button>
					<button id="btn-status-cancel" class="btn btn-default">Cancel</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</section>

<!-- Modal edit -->
<div id="modalForm" class="modal-block modal-block-lg mfp-hide">
	<section class="panel">
    {!! Form::model($importasi, ['id' => 'formEdit', 'method' => 'PUT', 'route' => ['impor.update', $importasi->id], 'class' => 'form-horizontal form-bordered mb-lg']) !!}
		<header class="panel-heading">
			<h2 class="panel-title">Form Impor</h2>
		</header>
		<div class="panel-body">
			<div class="row mx-0">
				<input id="route" type="hidden">
				<input id="dataId" type="hidden">
				<div class="form-group mt-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">AWB</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::text('awb', null, array('placeholder' => 'Isikan no AWB','class' => 'form-control')) !!}
							<div id="error_awb" class="error_text"></div>
						</div>
						<label class="col-sm-12 col-md-2 control-label">Tgl AWB</label>
						<div class="col-sm-12 col-md-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								{!! Form::text('tgl_awb', null, array('placeholder' => 'Isikan tgl AWB','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}')) !!}
							</div>
							<div id="error_tgl_awb" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Importir</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::text('importir', null, array('placeholder' => 'Nama importir','class' => 'form-control')) !!}
							<div id="error_importir" class="error_text"></div>
						</div>
						<label class="col-sm-12 col-md-2 control-label">NPWP</label>
						<div class="col-sm-12 col-md-3">
							{!! Form::text('npwp', null, array('placeholder' => 'NPWP importir','class' => 'form-control')) !!}
							<div id="error_npwp" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Status</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::select('status_importir', $jnsImportir->pluck('jns_importir','id'),null, array('class' => 'form-control')) !!}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">NIB</label>
						<div class="col-sm-12 col-md-4 checkbox">
							<label>
								{{ Form::checkbox('check_nib', '1', $importasi->check_nib, array('class' => 'name')) }}
								Memiliki NIB/pengecualian NIB
							</label>
						</div>
						<div class="col-sm-12 col-md-5">
							@if( $importasi->check_nib == 1 )
								{!! Form::text('dok_nib', null, array('placeholder' => 'Keterangan dok. NIB','class' => 'form-control')) !!}
							@else
								{!! Form::text('dok_nib', null, array('placeholder' => 'Keterangan dok. NIB','class' => 'form-control', 'disabled')) !!}
							@endif
							<div id="error_dok_nib" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Pengirim</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::text('pengirim', null, array('placeholder' => 'Pengirim barang','class' => 'form-control')) !!}
							<div id="error_pengirim" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="form-group mt-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">PIC</label>
						<div class="col-sm-12 col-md-9">
							{!! Form::text('pic', null, array('placeholder' => 'Nama PIC importir','class' => 'form-control')) !!}
							<div id="error_pic" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Kontak</label>
						<div class="col-sm-12 col-md-4 mb-2">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-mobile"></i>
								</span>
								{!! Form::text('hp_pic', null, array('placeholder' => 'No handphone PIC','class' => 'form-control')) !!}
							</div>
							<div id="error_hp_pic" class="error_text"></div>
						</div>
						<div class="col-sm-12 col-md-5">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-envelope"></i>
								</span>
								{!! Form::text('email_pic', null, array('placeholder' => 'Email PIC','class' => 'form-control')) !!}
							</div>
							<div id="error_email_pic" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Clearance</label>
						<div class="col-sm-12 col-md-4 mb-2">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								{!! Form::text('tgl_clearance', null, array('placeholder' => 'Tgl pengurusan barang','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}')) !!}
							</div>
							<div id="error_tgl_clearance" class="error_text"></div>
						</div>
						<div class="col-sm-12 col-md-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</span>
								{!! Form::text('wkt_clearance', null, array('placeholder' => 'Waktu','class' => 'form-control','data-plugin-timepicker','data-plugin-options' => '{ "showMeridian": false, "defaultTime": null }')) !!}
							</div>
							<div id="error_wkt_clearance" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="form-group mt-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Lartas</label>
						<div class="col-sm-12 col-md-6 checkbox">
							<label>
								{{ Form::checkbox('check_lartas', '1', $importasi->check_lartas, array('class' => 'name')) }}
								Bukan lartas / Ada izin lartas atau pengecualian lartas
							</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label"></label>
						<div class="col-sm-12 col-md-5">
							@if( $importasi->check_lartas == 1 )
								{!! Form::text('dok_lartas', null, array('placeholder' => 'Keterangan dok. Lartas','class' => 'form-control')) !!}
							@else
								{!! Form::text('dok_lartas', null, array('placeholder' => 'Keterangan dok. Lartas','class' => 'form-control','disabled')) !!}
							@endif
							<div id="error_dok_lartas" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="form-group mt-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-xs-12 col-sm-12 col-md-2 control-label">Pungutan</label>
						<div class="col-xs-6 col-sm-6 col-md-2 radio">
							<label>{{ Form::radio('bebas', '0', true) }}
							Bayar</label>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-2 radio">
							<label>{{ Form::radio('bebas', '1', false) }}
							Bebas</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Rekomendasi</label>
						<div class="col-sm-12 col-md-4 checkbox">
							<label>
								@if( $importasi->bebas == 1 )
									{{ Form::checkbox('rekomendasi_bebas', '1', $importasi->rekomendasi_bebas, array('class' => 'name')) }}
								@else
									{{ Form::checkbox('rekomendasi_bebas', '1', $importasi->rekomendasi_bebas, array('class' => 'name','disabled')) }}
								@endif
								Ada rekomendasi bebas
							</label>
						</div>
						<div class="col-sm-12 col-md-5">
							@if( $importasi->rekomendasi_bebas == 1 )
								{!! Form::text('dok_rekomendasi_bebas', null, array('placeholder' => 'Keterangan dok. rekomendasi','class' => 'form-control')) !!}
							@else
								{!! Form::text('dok_rekomendasi_bebas', null, array('placeholder' => 'Keterangan dok. rekomendasi','class' => 'form-control','disabled')) !!}
							@endif
							<div id="error_dok_rekomendasi_bebas" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">SKEP bebas</label>
						<div class="col-sm-12 col-md-4 checkbox">
							<label>
								@if( $importasi->bebas == 1 )
									{{ Form::checkbox('check_bebas', '1', $importasi->check_bebas, array('class' => 'name')) }}
								@else
									{{ Form::checkbox('check_bebas', '1', $importasi->check_bebas, array('class' => 'name','disabled')) }}
								@endif
								Ada SKEP pembebasan
							</label>
						</div>
						<div class="col-sm-12 col-md-5">
							@if( $importasi->check_bebas == 1 )
								{!! Form::text('dok_bebas', null, array('placeholder' => 'Keterangan dok. pembebasan','class' => 'form-control')) !!}
							@else
								{!! Form::text('dok_bebas', null, array('placeholder' => 'Keterangan dok. pembebasan','class' => 'form-control','disabled')) !!}
							@endif
							<div id="error_dok_bebas" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="form-group mt-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-3 control-label">Rekomendasi impor</label>
						<div class="col-sm-12 col-md-4">
						{!! Form::select('rekomendasi_clearance', $rekomendasi->pluck('rekomendasi','id'),null, array('class' => 'form-control')) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-primary modal-confirm">Submit</button>
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</div>
			</div>
    </footer>
    {!! Form::close() !!}
	</section>
</div>
@endsection

@section('vendorscript')
<script src="{{ asset('vendor/select2/select2.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('vendor/pnotify/pnotify.custom.js') }}"></script>
@endsection

@section('pagescript')
<script>
$(document).ready(function() {
	(function( $ ) {
		///// Display Modal /////
		// Clear form validation at modal close
		function clearValidation() {
			$("#formEdit .form-control").removeClass("is-invalid is-valid");
			$("#formEdit .error_text").empty();
		};

		// Modal Dismiss
		$(document).on('click', '.modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
			clearValidation();
		});

		// Modal Confirm
		$(document).on('click', '.modal-confirm', function (e) {
			e.preventDefault();
			clearValidation();

			var dataId = $('#formEdit input#dataId').val();
			var data = $("#formEdit").serializeArray();

			$.ajax({
				url: `${dataId}`,
				type: 'PUT',
				data: data,
				success: function(data) {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'Dokumen berhasil diupdate',
						type: 'success'
					});

					displayData(data);
				},
				error: function (response) {
					var errors = response["responseJSON"]["errors"];
					for (var type in errors) {
						var messages = errors[type];
						$(`.form-control[name='${type}`).addClass("is-invalid");
						for (var idx in messages) {
							$(`#error_${type}`).html(`<p class="text-danger">${messages[idx]}</p>`);
						}
					}
				},
			});
		});

		// Trigger Create/Edit Form
		$(document).on('click', '.btnEdit', function(e){
			e.preventDefault();
			var trigger = $(this);
			var dataId = $(this).attr('id');
			$('#formEdit input#dataId').val(dataId);
				
			$.ajax({
				url: `${dataId}/detail`,
				type: "GET",
				data: { _token: "{{ csrf_token() }}" },
				success: function (response) {
					$('#formEdit input[name="awb"]').val(response['awb']);
					$('#formEdit input[name="tgl_awb"]').val(response['tgl_awb']);
					$('#formEdit input[name="importir"]').val(response['importir']);
					$('#formEdit input[name="npwp"]').val(response['npwp']);
					$('#formEdit select[name="status_importir"]').val(response['status_importir']);
					if (response['check_nib'] == 1) {
						$('#formEdit input[name="check_nib"]').prop('checked',true);
						$('#formEdit input[name="dok_nib"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="check_nib"]').prop('checked',false);
						$('#formEdit input[name="dok_nib"]').prop('disabled',true);
					}
					$('#formEdit input[name="dok_nib"]').val(response['dok_nib']);
					$('#formEdit input[name="pengirim"]').val(response['pengirim']);

					$('#formEdit input[name="pic"]').val(response['pic']);
					$('#formEdit input[name="hp_pic"]').val(response['hp_pic']);
					$('#formEdit input[name="tgl_clearance"]').val(response['tgl_clearance']);
					$('#formEdit input[name="wkt_clearance"]').val(response['wkt_clearance']);

					if (response['check_lartas'] == 1) {
						$('#formEdit input[name="check_lartas"]').prop('checked',true);
						$('#formEdit input[name="dok_lartas"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="check_lartas"]').prop('checked',false);
						$('#formEdit input[name="dok_lartas"]').prop('disabled',true);
					}
					$('#formEdit input[name="dok_lartas"]').val(response['dok_lartas']);

					$(`#formEdit input[name="bebas"]`).prop('checked', false);
					$(`#formEdit input[name="bebas"][value=${response['bebas']}]`).prop('checked', true);
					if (response['bebas'] == 1) {
						$('#formEdit input[name="rekomendasi_bebas"]').prop('disabled',false);
						$('#formEdit input[name="check_bebas"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="rekomendasi_bebas"]').prop('disabled',true);
						$('#formEdit input[name="check_bebas"]').prop('disabled',true);
					}
					if (response['rekomendasi_bebas'] == 1) {
						$('#formEdit input[name="rekomendasi_bebas"]').prop('checked',true);
						$('#formEdit input[name="dok_rekomendasi_bebas"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="rekomendasi_bebas"]').prop('checked',false);
						$('#formEdit input[name="dok_rekomendasi_bebas"]').prop('disabled',true);
					}
					$('#formEdit input[name="dok_rekomendasi_bebas"]').val(response['dok_rekomendasi_bebas']);
					if (response['check_bebas'] == 1) {
						$('#formEdit input[name="check_bebas"]').prop('checked',true);
						$('#formEdit input[name="dok_bebas"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="check_bebas"]').prop('checked',false);
						$('#formEdit input[name="dok_bebas"]').prop('disabled',true);
					}
					$('#formEdit input[name="dok_bebas"]').val(response['dok_bebas']);

					$('#formEdit input[name="rekomendasi_clearance"]').val(response['rekomendasi_clearance']);

					openForm(trigger);
				}
			});
		});

		// Open Create/Edit Form Modal
		function openForm(trigger) {
			$(trigger).magnificPopup({
				type: 'inline',
				preloader: false,
				focus: '#name',
				modal: true,

				// When elemened is focused, some mobile browsers in some cases zoom in
				// It looks not nice, so we disable it:
				callbacks: {
					beforeOpen: function() {
						if($(window).width() < 700) {
							this.st.focus = false;
						} else {
							this.st.focus = '#name';
						}
					},
					open: function() {
						// Make select2 visible (not obstructed by modal)
						$(".mfp-wrap").removeAttr("tabindex");
					},
					close: function() {
						clearValidation();
						// clearForm();
					}
				}
			}).magnificPopup('open');
		};

		// Handling NIB
		$(document).on('change', '#formEdit input[type="checkbox"][name="check_nib"]', function() {
			if(this.checked) {
				$('#formEdit input[type="text"][name="dok_nib"]').prop('disabled',false);
			} else {
				$('#formEdit input[type="text"][name="dok_nib"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_nib"]').val(null);
			}
		});

		// Handling Lartas
		$(document).on('change', '#formEdit input[type="checkbox"][name="check_lartas"]', function() {
			if(this.checked) {
				$('#formEdit input[type="text"][name="dok_lartas"]').prop('disabled',false);
			} else {
				$('#formEdit input[type="text"][name="dok_lartas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_lartas"]').val(null);
			}
		});

		// Handling Pungutan
		$(document).on('change', '#formEdit input[type="radio"][name="bebas"]', function() {
			if (this.value == '1') {
				$('#formEdit input[type="checkbox"][name="rekomendasi_bebas"]').prop('disabled',false);
				$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('disabled',false);
			} else if (this.value == '0') {
				$('#formEdit input[type="checkbox"][name="rekomendasi_bebas"]').prop('disabled',true);
				$('#formEdit input[type="checkbox"][name="rekomendasi_bebas"]').prop('checked',false);
				$('#formEdit input[type="text"][name="dok_rekomendasi_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_rekomendasi_bebas"]').val(null);

				$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('disabled',true);
				$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('checked',false);
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_bebas"]').val(null);
			}
		});

		// Handling Rekomendasi Bebas
		$(document).on('change', '#formEdit input[type="checkbox"][name="rekomendasi_bebas"]', function() {
			if(this.checked) {
				$('#formEdit input[type="text"][name="dok_rekomendasi_bebas"]').prop('disabled',false);
			} else {
				$('#formEdit input[type="text"][name="dok_rekomendasi_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_rekomendasi_bebas"]').val(null);
			}
		});

		// Handling SKEP Bebas
		$(document).on('change', '#formEdit input[type="checkbox"][name="check_bebas"]', function() {
			if(this.checked) {
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',false);
			} else {
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_bebas"]').val(null);
			}
		});

		///// Display Data ///// 
		// Display data
		function displayData(data) {
			$.ajax({
				url: '{{ route("impor.detail", $importasi->id) }}',
				type: 'GET',
				data: { _token: "{{ csrf_token() }}" },
				success: function(data) {
					displayNotif(data);
					displayMainData(data);
					displayStatus();
				}
			});
		}

		// Display main data
		function displayMainData(data) {
			for (var key in data) {
				$(`section#display-data #display_${key}`).html(data[key]);	
			}		
			$('section#display-data #display_current_stat').html(data.status.ur_status);
			$('section#display-data #display_jns_importir').html(data.jenis_importir.jns_importir);
			if (data.check_nib == 1) {
				$('section#display-data #display_nib').html(`OK - ${data.dok_nib}`);	
			} else {
				$('section#display-data #display_nib').html('Belum terpenuhi');	
			}
			if (data.check_lartas == 1) {
				$('section#display-data #display_lartas').html(`OK - ${data.dok_lartas}`);	
			} else {
				$('section#display-data #display_lartas').html('Belum terpenuhi');	
			}
			if (data.bebas == 1) {
				$('section#display-data #display_pungutan').html('Bebas');
			} else {
				$('section#display-data #display_pungutan').html('Dibayar');
			}
			if (data.rekomendasi_bebas == 1) {
				$('section#display-data #display_rekomendasi').html(`Ada - ${data.rekomendasi_bebas}`);	
			} else {
				$('section#display-data #display_rekomendasi').html(`Tidak ada`);	
			}
			if (data.check_bebas == 1) {
				$('section#display-data #display_pembebasan').html(`Ada - ${data.dok_bebas}`);	
			} else {
				$('section#display-data #display_pembebasan').html(`Tidak ada`);	
			}
			$('section#display-data #display_rekomendasi_clearance').html(data.rekomendasi_impor.rekomendasi);
			if (typeof data.tgl_clearance !== 'undefined') {
				if (data.wkt_clearance != null) {
					$('section#display-data #display_perkiraan_clearance').html(data.tgl_clearance + ' ' + data.wkt_clearance);	
				} else {
					$('section#display-data #display_perkiraan_clearance').html(data.tgl_clearance);
				}
			} else {
				$('section#display-data #display_perkiraan_clearance').empty();
			}
			
		}

		// Display notifikasi
		function displayNotif(data) {
			if (
				data.check_nib == 0 || 
				data.check_lartas != 1 || 
				(data.bebas == 1 && data.check_bebas != 1) 
			) {
				$('section#notif-syarat').show();
				if (data.check_nib == 0) {
					$('section#notif-syarat #notif-nib').show();
				} else {
					$('section#notif-syarat #notif-nib').hide();
				}
				if (data.check_lartas != 1) {
					$('section#notif-syarat #notif-lartas').show();
				} else {
					$('section#notif-syarat #notif-lartas').hide();
				}
				if (data.bebas == 1 && data.check_bebas != 1) {
					$('section#notif-syarat #notif-bebas').show();
				} else {
					$('section#notif-syarat #notif-bebas').hide();
				}
			} else {
				$('section#notif-syarat').hide();
			}
		}

		///// Display Status Form /////
		// Show form
		$(document).on('click', '#btn-status-update', function(e) {
			e.preventDefault();
			$(this).hide();
			$('#formStatus').show();
		});

		// Close form
		$(document).on('click', '#btn-status-cancel', function(e) {
			e.preventDefault();
			closeForm();
		});
		function closeForm() {
			$('#btn-status-update').show();
			$('#formStatus').hide();
			$('#formStatus').trigger("reset");
		}

		// Submit form
		$(document).on('click', '#btn-status-submit', function(e) {
			e.preventDefault();
			var data = $('#formStatus').serializeArray();
			$.ajax({
				url: '{{ route("status.store", $importasi->id) }}',
				type: 'POST',
				data: data,
				success: function() {
					closeForm();
					displayStatus();
				}
			});
		});

		// Display status
		function displayStatus() {
			$.ajax({
				url: '{{ route("status.list", $importasi->id) }}',
				type: 'GET',
				data: { _token: "{{ csrf_token() }}" },
				success: function(data) {
					$('#timeline-status').empty();
					(data.histories).forEach(function(history) {
						if (history.no_dok_impor != null) {
							var dok = history.no_dok_impor;
						} else {
							var dok = '';
						}

						if (history.detail != null) {
							var detail = `<p>${history.detail}</p>`;	
						} else {
							var detail = '';
						}
						
						var stat = `
							<li>
								<div class="tm-box">
									<p class="text-muted mb-none">${history.time}</p>
									<p>
										${history.status} ${dok}
									</p>
									${detail}
								</div>
							</li>
						`;
						$('#timeline-status').append(stat);
					});
					$('#display_current_stat').html(data.status);
				}
			});
		}
	}).apply( this, [ jQuery ]);
});
</script>
@endsection