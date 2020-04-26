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
	$importasi->check_rekomendasi != 1 || 
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
		@if ($importasi->check_rekomendasi != 1)
		<div class="col-sm-12 col-md-4">
			<div id="notif-nib" class="alert alert-warning mx-1">
				Belum ada rekomendasi BNPB.
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
						<h3 class="h3 mt-none mb-sm text-dark text-bold">AWB 
							<span id="display_awb_dup">
								{{ $importasi->awb }}
								@if( $importasi->awb_duplicate != 0 )
									{{ ' - ' . $importasi->awb_duplicate }}
								@endif
							</span>
							<span>
								@if( $importasi->covid != null )
									<a href="{{ route('covid.show',$importasi->covid->idTanggap) }}" class="ml-md btn btn-xs btn-default">Aju COVID</a>
								@endif
							</span>
						</h3>
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
								<span class="invoice-label text-dark">Status</span>
								<span id="display_jns_importir">{{ $importasi->jenis_importir->jns_importir }}</span>
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

							<h5 class="h5 mb-xs text-dark text-semibold">Clearance:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Rekomendasi</span>
								<span id="display_rekomendasi_clearance">{{ $importasi->rekomendasi_impor->rekomendasi }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Waktu</span>
								<span id="display_perkiraan_clearance">{{ $importasi->tgl_clearance . ' ' . $importasi->wkt_clearance }}</span>
							</p>
						</div>
					</div>	
					<div class="col-sm-12 col-md-6">
						<div class="bill-data">
							<h5 class="h5 mb-xs text-dark text-semibold">No Aju Permohonan Covid:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">No. Aju</span>
								<span id="display_no_permohonan">{{ $importasi->no_permohonan }}</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Tanggal</span>
								<span id="display_tgl_permohonan">{{ $importasi->tgl_permohonan }}</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">Rekomendasi BNPB:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">No. Surat</span>
								<span id="display_dok_rekomendasi">
								@if ( $importasi->check_rekomendasi == 1)
									{{ $importasi->dok_rekomendasi }}
								@else
									-
								@endif
								</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Tanggal</span>
								<span id="display_tgl_rekomendasi">
								@if ( $importasi->check_rekomendasi == 1)
									{{ $importasi->tgl_rekomendasi }}
								@else
									-
								@endif
								</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">Pungutan:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Pembayaran</span>
								<span id="display_pungutan">
								@if ( $importasi->bebas == 1)
									Bebas
								@else
									Dibayar
								@endif
								</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">SKMK</span>
								<span id="display_dok_bebas">
								@if ( $importasi->check_bebas == 1)
									{{ $importasi->dok_bebas }}
								@else
									-
								@endif
								</span>
							</p>
							<p class="mb-none">
								<span class="invoice-label text-dark">Tanggal</span>
								<span id="display_tgl_bebas">
								@if ( $importasi->check_bebas == 1)
									Ada {{ $importasi->tgl_bebas}}
								@else
									-
								@endif
								</span>
							</p>

							<h5 class="h5 mb-xs text-dark text-semibold">License Officer:</h5>
							<p class="mb-none">
								<span class="invoice-label text-dark">Nama</span>
								<span id="display_officer">{{ $importasi->officer->name }}</span>
							</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="bill-data">
							<h5 class="h5 mb-xs text-dark text-semibold">Lampiran:</h5>
							<div id="list-lampiran">
							@foreach( $attachments as $attachment )
								<a target="_blank" href="{{ asset(Storage::url($attachment->filename)) }}">{{ '['.strtoupper(explode('.', $attachment->filename)[1]).']' }} {{ $attachment->comment }}</a>
								<br>
							@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="text-right mr-lg">
		@can('impor-edit')
			<a id="{{ $importasi->id }}" class="btn btn-primary btnEdit" href="#modalForm">Edit <i class="fa fa-edit"></i></a>
		@endcan
		@can('impor-delete')
			<a id="{{ $importasi->id }}" class="btn btn-danger btnDelete" href="#modalDelete">Hapus <i class="fa fa-trash-o"></i></a>
		@endcan
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
									{{ $history->uraian_status->ur_status }}
									@if( $history->no_dok_impor != null )
									<br>{{ $history->jns_dok_impor }} {{ $history->no_dok_impor }}
									@endif
									@if( $history->tgl_dok_impor != null )
										tgl {{ $history->tgl_dok_impor }}
									@endif
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

	@if( $importasi->status->ur_status != 'SELESAI' )
	@can('status-create')
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
							<div id="error_kd_status" class="error_text"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Dok</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::select('jns_dok_impor', ['RH'=>'RH','Lainnya'=>'Lainnya'],null, array('class' => 'form-control')) !!}
						</div>
						<div class="col-sm-12 col-md-6">
							{!! Form::text('no_dok_impor', null, array('placeholder' => 'No Dokumen','class' => 'form-control')) !!}
						</div>
						<div id="error_jns_dok_impor" class="error_text"></div>
						<div id="error_no_dok_impor" class="error_text"></div>
					</div>
					<div class="col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-3 control-label">Tgl Dok</label>
						<div class="col-sm-12 col-md-9">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								{!! Form::text('tgl_dok_impor', null, array('placeholder' => 'Tgl Dokumen','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}')) !!}
							</div>
							<div id="error_tgl_dok_impor" class="error_text"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 mb-md">
						<div class="col-sm-12">
							{!! Form::textarea('detail', null, array('placeholder' => 'Keterangan','class' => 'form-control')) !!}
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
	@endcan
	@endif
</section>

@can('impor-edit')
<!-- Modal edit -->
<div id="modalForm" class="modal-block modal-block-lg mfp-hide">
	<section class="panel">
    {!! Form::model($importasi, ['id' => 'formEdit', 'class' => 'form-horizontal form-bordered mb-lg']) !!}
		<header class="panel-heading">
			<h2 class="panel-title">Form Impor</h2>
		</header>
		<div class="panel-body">
			<div class="row mx-0">
				<input id="route" type="hidden">
				<input id="dataId" type="hidden">
				<input name="awb_duplicate" type="hidden">
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
						<label class="col-sm-12 col-md-2 control-label">Permohonan</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::text('no_permohonan', null, array('placeholder' => 'No aju COVID','class' => 'form-control')) !!}
							<div id="error_no_permohonan" class="error_text"></div>
						</div>
						<label class="col-sm-12 col-md-2 control-label">Tgl</label>
						<div class="col-sm-12 col-md-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								{!! Form::text('tgl_permohonan', null, array('placeholder' => 'Tgl permohonan','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}')) !!}
							</div>
							<div id="error_tgl_permohonan" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Importir</label>
						<div class="col-sm-12 col-md-9">
							{!! Form::text('importir', null, array('placeholder' => 'Nama importir','class' => 'form-control')) !!}
							<div id="error_importir" class="error_text"></div>
						</div>
						<!-- <label class="col-sm-12 col-md-2 control-label">NPWP</label>
						<div class="col-sm-12 col-md-3">
							{!! Form::text('npwp', null, array('placeholder' => 'NPWP importir','class' => 'form-control')) !!}
							<div id="error_npwp" class="error_text"></div>
						</div> -->
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Status</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::select('status_importir', $jnsImportir->pluck('jns_importir','id'),null, array('class' => 'form-control')) !!}
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
								{!! Form::text('tgl_clearance', null, array('placeholder' => 'Tgl pengeluaran barang','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}')) !!}
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
						<label class="col-sm-12 col-md-2 control-label">Rekomendasi</label>
						<div class="col-sm-12 col-md-6 checkbox">
							<label>
								{{ Form::checkbox('check_rekomendasi', '1', $importasi->check_rekomendasi, array('class' => 'name')) }}
								Ada rekomendasi BNPB
							</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label"></label>
						<div class="col-sm-12 col-md-5">
							@if( $importasi->check_rekomendasi == 1 )
								{!! Form::text('dok_rekomendasi', null, array('placeholder' => 'No. Rekomendasi BNPB','class' => 'form-control')) !!}
							@else
								{!! Form::text('dok_rekomendasi', null, array('placeholder' => 'No. Rekomendasi BNPB','class' => 'form-control','disabled')) !!}
							@endif
							<div id="error_dok_rekomendasi" class="error_text"></div>
						</div>
						<label class="col-sm-12 col-md-1 control-label">Tgl</label>
						<div class="col-sm-12 col-md-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								@if( $importasi->check_rekomendasi == 1 )
									{!! Form::text('tgl_rekomendasi', null, array('placeholder' => 'Tgl Surat','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}')) !!}
								@else
									{!! Form::text('tgl_rekomendasi', null, array('placeholder' => 'Tgl Surat','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}','disabled')) !!}
								@endif
							</div>
							<div id="error_tgl_rekomendasi" class="error_text"></div>
						</div>
					</div>
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
						<label class="col-sm-12 col-md-2 control-label">SKEP bebas</label>
						<div class="col-sm-12 col-md-4 checkbox">
							<label>
								@if( $importasi->bebas == 1 )
									{{ Form::checkbox('check_bebas', '1', $importasi->check_bebas, array('class' => 'name')) }}
								@else
									{{ Form::checkbox('check_bebas', '1', $importasi->check_bebas, array('class' => 'name','disabled')) }}
								@endif
								Ada SKMK
							</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label"></label>
						<div class="col-sm-12 col-md-5">
							@if( $importasi->check_bebas == 1 )
								{!! Form::text('dok_bebas', null, array('placeholder' => 'No. SKMK','class' => 'form-control')) !!}
							@else
								{!! Form::text('dok_bebas', null, array('placeholder' => 'Keterangan dok. pembebasan','class' => 'form-control','disabled')) !!}
							@endif
							<div id="error_dok_bebas" class="error_text"></div>
						</div>
						<label class="col-sm-12 col-md-1 control-label">Tgl</label>
						<div class="col-sm-12 col-md-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								@if( $importasi->check_bebas == 1 )
									{!! Form::text('tgl_bebas', null, array('placeholder' => 'Tgl SKMK','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}')) !!}
								@else
									{!! Form::text('tgl_bebas', null, array('placeholder' => 'Tgl SKMK','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}','disabled')) !!}
								@endif
							</div>
							<div id="error_tgl_bebas" class="error_text"></div>
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
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-3 control-label">License Officer</label>
						<div class="col-sm-12 col-md-4">
							{!! Form::select('officer_id', $officers->pluck('name','id'),null, array('class' => 'form-control')) !!}
						</div>
					</div>
				</div>
				<div id="group-lampiran" class="form-group mt-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Lampiran</label>
					</div>
					<div id="form-current-lampiran" class="col-xs-12 col-sm-12 col-md-12 mb-md"></div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">Tambah Lampiran</label>
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
@endcan

@can('impor-delete')
<!-- Modal delete -->
<div id="modalDelete" class="modal-block modal-header-color modal-block-warning mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Hapus Importasi!</h2>
		</header>
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-icon">
					<i class="fa fa-warning"></i>
				</div>
				<div class="modal-text">
					<h4>Perhatian</h4>
					<p>Apakah yakin AWB <strong>{{ $importasi->awb }}</strong> akan dihapus?</p>
				</div>
			</div>
			<input id="deleteId" type="hidden">
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
				{!! Form::open(['id' => 'formDelete', 'route' => ['impor.destroy', $importasi->id]]) !!}
					{{ method_field('DELETE') }}
					<button type="submit" class="btn btn-danger">Hapus</button>
					<button class="btn btn-default modal-dismiss">Batal</button>
				{!! Form::close() !!}
				</div>
			</div>
		</footer>
	</section>
</div>
@endcan
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
		// Modal component
		var form_lampiran = `
				<div class="col-xs-12 col-sm-12 col-md-12 mb-md form-lampiran">
					<div class="col-xs-12 col-md-1"></div>
					<div class="col-xs-10 col-md-4 mb-2">
						{!! Form::file('lampiran[]', array('class' => 'form-control')) !!}
						<div id="error_lampiran" class="error_text"></div>
					</div>
					<div class="col-xs-10 col-md-5">
						{!! Form::text('ket_lampiran[]', null, array('placeholder' => 'Keterangan lampiran','class' => 'form-control')) !!}
						<div id="error_ket_lampiran" class="error_text"></div>
					</div>
					<div class="col-xs-2 col-md-1">
						<button class="btn btn-default add-lampiran"><i class="fa fa-plus"></i></button>
					</div>
				</div>
			`;

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
			$('#formEdit .form-lampiran').remove();
			$('#formEdit input[name="del_lampiran[]"]').remove();
		});

		// Modal Confirm
		$(document).on('click', '.modal-confirm', function (e) {
			e.preventDefault();
			clearValidation();

			var formData = new FormData($("#formEdit")[0]);

			$.ajax({
				url: '{{ route("impor.update", $importasi->id) }}',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(data) {
					$.magnificPopup.close();
					$('#formEdit .form-lampiran').remove();
					new PNotify({
						title: 'Success!',
						text: 'Data berhasil diupdate',
						type: 'success'
					});

					displayData();
				},
				error: function (response) {
					var errors = response["responseJSON"]["errors"];
					for (var type in errors) {
						var messages = errors[type];
						$(`.form-control[name='${type}`).addClass("is-invalid");
						for (var idx in messages) {
							if (type.includes('ket_lampiran.')) {
								var arr_type = type.split('.');
								$(`.form-lampiran:nth-child(${Number(arr_type[1]) + 2}) #error_${arr_type[0]}`).html(`<p class="text-danger">${messages[idx]}</p>`);
							} else {
								$(`#error_${type}`).html(`<p class="text-danger">${messages[idx]}</p>`);
							}
						}
						
					}
				},
			});
		});

		// Trigger Edit Form
		$(document).on('click', '.btnEdit', function(e){
			e.preventDefault();
			var trigger = $(this);
			$('#formEdit input#dataId').val(dataId);
				
			$.ajax({
				url: '{{ route("impor.detail", $importasi->id) }}',
				type: "GET",
				data: { _token: "{{ csrf_token() }}" },
				success: function (response) {
					$('#formEdit input[name="awb"]').val(response['awb']);
					$('#formEdit input[name="awb_duplicate"]').val(response['awb_duplicate']);
					$('#formEdit input[name="tgl_awb"]').val(response['tgl_awb']);
					$('#formEdit input[name="no_permohonan"]').val(response['no_permohonan']);
					$('#formEdit input[name="tgl_permohonan"]').val(response['tgl_permohonan']);
					$('#formEdit input[name="importir"]').val(response['importir']);
					$('#formEdit input[name="npwp"]').val(response['npwp']);
					$('#formEdit select[name="status_importir"]').val(response['status_importir']);

					$('#formEdit input[name="pic"]').val(response['pic']);
					$('#formEdit input[name="hp_pic"]').val(response['hp_pic']);
					$('#formEdit input[name="tgl_clearance"]').val(response['tgl_clearance']);
					$('#formEdit input[name="wkt_clearance"]').val(response['wkt_clearance']);

					if (response['check_rekomendasi'] == 1) {
						$('#formEdit input[name="check_rekomendasi"]').prop('checked',true);
						$('#formEdit input[name="dok_rekomendasi"]').prop('disabled',false);
						$('#formEdit input[name="tgl_rekomendasi"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="check_rekomendasi"]').prop('checked',false);
						$('#formEdit input[name="dok_rekomendasi"]').prop('disabled',true);
						$('#formEdit input[name="tgl_rekomendasi"]').prop('disabled',true);
					}
					$('#formEdit input[name="dok_rekomendasi"]').val(response['dok_rekomendasi']);
					$('#formEdit input[name="tgl_rekomendasi"]').val(response['tgl_rekomendasi']);

					$(`#formEdit input[name="bebas"]`).prop('checked', false);
					$(`#formEdit input[name="bebas"][value=${response['bebas']}]`).prop('checked', true);
					if (response['bebas'] == 1) {
						$('#formEdit input[name="check_bebas"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="check_bebas"]').prop('disabled',true);
					}
					if (response['check_bebas'] == 1) {
						$('#formEdit input[name="check_bebas"]').prop('checked',true);
						$('#formEdit input[name="dok_bebas"]').prop('disabled',false);
						$('#formEdit input[name="tgl_bebas"]').prop('disabled',false);
					} else {
						$('#formEdit input[name="check_bebas"]').prop('checked',false);
						$('#formEdit input[name="dok_bebas"]').prop('disabled',true);
						$('#formEdit input[name="tgl_bebas"]').prop('disabled',true);
					}
					$('#formEdit input[name="dok_bebas"]').val(response['dok_bebas']);
					$('#formEdit input[name="tgl_bebas"]').val(response['tgl_bebas']);

					$('#formEdit input[name="rekomendasi_clearance"]').val(response['rekomendasi_clearance']);
					$('#formEdit input[name="officer_id"]').val(response['officer_id']);

					if (response['attachments'] != null) {
						$('#formEdit #form-current-lampiran').empty();
						var lampiran = '';
						(response['attachments']).forEach(function(attachment) {
							var att = `
								<div class="current-lampiran col-xs-12">
									<div class="col-xs-10 col-md-1"></div>
									<div class="col-xs-10">
										[${((((attachment.filename).split('.')).slice(-1))[0]).toUpperCase()}] ${attachment.comment} 
										<a href="#" id="${attachment.id}" class="text-danger rem-lampiran"><i class="fa fa-times"></i>Remove</a>
									</div>
								</div>
							`;
							lampiran += att;
						});
						$('#formEdit #form-current-lampiran').html(lampiran);
					} else {
						$('#formEdit #form-current-lampiran').empty();
					}

					$('#group-lampiran').append(form_lampiran);

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
					}
				}
			}).magnificPopup('open');
		};

		// Handling Rekomendasi
		$(document).on('change', '#formEdit input[type="checkbox"][name="check_rekomendasi"]', function() {
			if(this.checked) {
				$('#formEdit input[type="text"][name="dok_rekomendasi"]').prop('disabled',false);
				$('#formEdit input[type="text"][name="tgl_rekomendasi"]').prop('disabled',false);
			} else {
				$('#formEdit input[type="text"][name="dok_rekomendasi"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_rekomendasi"]').val(null);
				$('#formEdit input[type="text"][name="tgl_rekomendasi"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="tgl_rekomendasi"]').val(null);
			}
		});

		// Handling Pungutan
		$(document).on('change', '#formEdit input[type="radio"][name="bebas"]', function() {
			if (this.value == '1') {
				$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('disabled',false);
			} else if (this.value == '0') {
				$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('disabled',true);
				$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('checked',false);
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_bebas"]').val(null);
				$('#formEdit input[type="text"][name="tgl_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="tgl_bebas"]').val(null);
			}
		});

		// Handling SKEP Bebas
		$(document).on('change', '#formEdit input[type="checkbox"][name="check_bebas"]', function() {
			if(this.checked) {
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',false);
				$('#formEdit input[type="text"][name="tgl_bebas"]').prop('disabled',false);
			} else {
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_bebas"]').val(null);
				$('#formEdit input[type="text"][name="tgl_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="tgl_bebas"]').val(null);
			}
		});

		// Handling Add Lampiran
		$(document).on('click', '.add-lampiran', function(e) {
			e.preventDefault();
			$(this).removeClass('add-lampiran').addClass('del-lampiran');
			$(this).children('.fa').removeClass('fa-plus').addClass('fa-minus');
			$('#group-lampiran').append(form_lampiran);
		});

		// Handling Delete Lampiran
		$(document).on('click', '.del-lampiran', function(e) {
			e.preventDefault();
			$(this).parent().parent().remove();
		});

		// Handling Remove Lampiran
		$(document).on('click', '.rem-lampiran', function(e) {
			e.preventDefault();
			var idLampiran = $(this).attr('id');
			$('<input type="hidden">').attr({
				name: 'del_lampiran[]',
				value: idLampiran
			}).appendTo('#group-lampiran');
			$(this).parent().parent().hide();
		});

		///// Display Data ///// 
		// Display data
		function displayData() {
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
			if (data.awb_duplicate == 0) {
				$(`section#display-data #display_awb_dup`).html(data.awb);	
			} else {
				$(`section#display-data #display_awb_dup`).html(`${data.awb} - ${data.awb_duplicate}`);	
			}
			$('section#display-data #display_current_stat').html(data.status.ur_status);
			$('section#display-data #display_jns_importir').html(data.jenis_importir.jns_importir);
			if (data.check_rekomendasi == 1) {
				$('section#display-data #display_rekomendasi').html(`Ada - ${data.dok_rekomendasi} tgl ${data.tgl_rekomendasi}`);
			} else {
				$('section#display-data #display_rekomendasi').html('Tidak ada');	
			}
			if (data.bebas == 1) {
				$('section#display-data #display_pungutan').html('Bebas');
			} else {
				$('section#display-data #display_pungutan').html('Dibayar');
			}
			if (data.check_bebas == 1) {
				$('section#display-data #display_pembebasan').html(`Ada - ${data.dok_bebas} tgl ${data.tgl_bebas}`);	
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

			if (data.attachments != null) {
				$('section#display-data #list-lampiran').empty();
				var lampiran = '';
				(data.attachments).forEach(function(attachment) {
					var att = `
						<a target="_blank" href="/eido/${(attachment.filename).replace('public', 'storage')}">[${((((attachment.filename).split('.')).slice(-1))[0]).toUpperCase()}] ${attachment.comment}</a>
						<br>
					`;
					lampiran += att;
				});
				$('section#display-data #list-lampiran').html(lampiran);
			} else {
				$('section#display-data #list-lampiran').empty();
			}
		}

		// Display notifikasi
		function displayNotif(data) {
			if (
				data.check_rekomendasi != 1 || 
				(data.bebas == 1 && data.check_bebas != 1) 
			) {
				$('section#notif-syarat').show();
				if (data.check_rekomendasi != 1) {
					$('section#notif-syarat #notif-rekomendasi').show();
				} else {
					$('section#notif-syarat #notif-rekomendasi').hide();
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

		///// Modal Delete //////
		// Show confirmation
		$(document).on('click', '.btnDelete', function (e) {
			e.preventDefault();
			var trigger = $(this);
			openForm(trigger);
		});

		///// Display Status Form /////
		// Clear form status validation
		function clearStatusValidation() {
			$("#formStatus .form-control").removeClass("is-invalid is-valid");
			$("#formStatus .error_text").empty();
		}

		// Select document type
		function selectType(input) {
			$('#formStatus select[name="jns_dok_impor"]').empty();

			var status = input.val();
			if (status == 22) {
				var types = ['RH', 'Lainnya'];
			} else {
				var types = ['PIB', 'CN', 'PIBK', 'CD', 'Lainnya'];
			}

			var options = ''
			types.forEach(function(type) {
				var option = `<option value="${type}">${type}</option>`;
				options = options.concat(option);
			});

			$('#formStatus select[name="jns_dok_impor"]').html(options);
		}
		$(document).on('change', '#formStatus select[name="kd_status"]', function() {
			selectType($(this));
		});

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
			clearStatusValidation();
		}

		// Submit form
		$(document).on('click', '#btn-status-submit', function(e) {
			e.preventDefault();
			clearStatusValidation();

			var data = $('#formStatus').serializeArray();
			$.ajax({
				url: '{{ route("status.store", $importasi->id) }}',
				type: 'POST',
				data: data,
				success: function() {
					closeForm();
					displayStatus();
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
							if (history.tgl_dok_impor != null) {
								var dok = `<br>${history.jns_dok_impor} ${history.no_dok_impor} tgl ${history.tgl_dok_impor}`;
							} else {
								var dok = `<br>${history.jns_dok_impor} ${history.no_dok_impor}`;
							}
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
					if (data.status == 'SELESAI') {
						$('#panel-update-status').remove();
					}
				}
			});
		}
	}).apply( this, [ jQuery ]);
});
</script>
@endsection