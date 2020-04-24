@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
@endsection

@section('pagestyle')
<style>
.datepicker-dropdown,
.bootstrap-timepicker-widget {
	z-index: 99999 !important;
}
</style>
@endsection

@section('breadcrumbs')
<li><span>Importasi</span></li>
<li><span>Daftar Dokumen</span></li>
@endsection

@section('content')
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Importasi</h2>
	</header>
	<div class="panel-body">
		@can('impor-create')
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
                    <a id="addData" class="btn btn-primary btnCreate" href="#modalForm">Tambah <i class="fa fa-plus"></i></a>
				</div>
			</div>
		</div>
		@endcan
		<table class="table table-bordered table-striped mb-none" id="table-data">
			<thead>
				<tr>
					<th>Permohonan</th>
					<th>AWB</th>
					<th>Importir</th>
					<th>LO</th>
					<th>Kekurangan</th>
					<th>Status</th>
					<th>kd_status</th>
					<th>wk_status</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</section>

@can('impor-create')
<!-- Modal tambah -->
<div id="modalForm" class="modal-block modal-block-lg mfp-hide">
	<section class="panel">
    {!! Form::open(array('id' => 'formEdit', 'class' => 'form-horizontal form-bordered mb-lg')) !!}
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
							<label>{{ Form::checkbox('check_rekomendasi', '1', false, array('class' => 'name')) }}
							Ada rekomendasi BNPB</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label"></label>
						<div class="col-sm-12 col-md-5">
							{!! Form::text('dok_rekomendasi', null, array('placeholder' => 'No. Rekomendasi BNPB','class' => 'form-control','disabled')) !!}
							<div id="error_dok_rekomendasi" class="error_text"></div>
						</div>
						<label class="col-sm-12 col-md-1 control-label">Tgl</label>
						<div class="col-sm-12 col-md-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								{!! Form::text('tgl_rekomendasi', null, array('placeholder' => 'Tgl rekomendasi','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}','disabled')) !!}
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
							<label>{{ Form::checkbox('check_bebas', '1', false, array('class' => 'name','disabled')) }}
							Ada SKMK</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label"></label>
						<div class="col-sm-12 col-md-5">
							{!! Form::text('dok_bebas', null, array('placeholder' => 'No. SKMK','class' => 'form-control','disabled')) !!}
							<div id="error_dok_bebas" class="error_text"></div>
						</div>
						<label class="col-sm-12 col-md-1 control-label">Tgl</label>
						<div class="col-sm-12 col-md-3">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								{!! Form::text('tgl_bebas', null, array('placeholder' => 'Tgl SKMK','class' => 'form-control','data-plugin-datepicker','data-plugin-options' => '{ "format": "dd-mm-yyyy"}','disabled')) !!}
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
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md form-lampiran">
						<div class="col-xs-10 col-md-1"></div>
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
$(document).ready(function() {
	(function( $ ) {
		///// Display DataTable /////
		function showData() {
			$.ajax({
				url: "{{ route('impor.list') }}",
				method: "POST",
				data: { _token: "{{ csrf_token() }}" },
				success: function(data) {
					data.forEach(function(dat) {
						var rekomendasi = null;
						var bebas = null;
						if (dat.awb_duplicate != 0) {
							var duplicate = ` - ${dat.awb_duplicate}`;
						} else {
							var duplicate = '';
						}
						if (dat.check_rekomendasi != 1) {
							rekomendasi = 'Rekomendasi BNPB';
						}
						if (dat.bebas == 1 && dat.check_bebas !=1) {
							bebas = 'SKEP Pembebasan';
						}
						var syarat = [rekomendasi, bebas].filter(Boolean).join('; ');
						var rows = `
							<tr>
								<td>${dat.no_permohonan}<br>${dat.tgl_permohonan}</td>
								<td>${dat.awb}${duplicate}<br>${dat.tgl_awb}</td>
								<td>${dat.importir}</td>
								<td>${dat.officer.name}</td>
								<td>${syarat}</td>
								<td>${dat.latest_status.ur_status}<br>${dat.latest_status.waktu}</td>
								<td>${dat.latest_status.kd_status}</td>
								<td>${dat.latest_status.waktu}</td>
								<td class="center">
									<a class="btn btn-primary btn-xs" href="importasi/${dat.id}">Detail</a>
								</td>
							</tr>
						`;
						$('#table-data tbody').append(rows);
					});
					
					$('#table-data').dataTable({
						columnDefs: [
							{width: "5%", targets: 8},
							{sortable: false, targets: 8},
							{visible: false, targets: [6,7]},
							{searchable: false, targets: [6,7,8]},
							{orderData: [6], targets: 5}
						],
						order: [[ 6, "asc" ],[7, "asc"]]
					});
				}
			});
		};

		///// Display Modal /////
		// Clear form validation at modal close
		function clearValidation() {
			$("#formEdit .form-control").removeClass("is-invalid is-valid");
			$("#formEdit .error_text").empty();
		};

		// Clear form at modal close
		function clearForm() {
			$('#formEdit').trigger("reset");
			$('#formEdit input#route').val("create");
		};

		// Modal Dismiss
		$(document).on('click', '.modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
			$('#formEdit input[type="text"][name="dok_rekomendasi"]').prop('disabled',true);
			$('#formEdit input[type="text"][name="tgl_rekomendasi"]').prop('disabled',true);
			$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('disabled',true);
			$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',true);
			$('#formEdit input[type="text"][name="tgl_bebas"]').prop('disabled',true);
		});

		// Modal Confirm
		$(document).on('click', '.modal-confirm', function (e) {
			e.preventDefault();
			clearValidation();

			var data = new FormData($("#formEdit")[0]);
			
			$.ajax({
				url: '{{ route("impor.store") }}',
				type: 'POST',
				data: data,
				processData: false,
				contentType: false,
				success: function(data) {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'Data berhasil diinput',
						type: 'success'
					});
					clearForm();

					$('#table-data').DataTable().clear().destroy();
					showData();
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

		// Open Create/Edit Form
		$(document).on('click', '.btnCreate', function(e){
			e.preventDefault();

			$(this).magnificPopup({
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
						clearForm();
					}
				}
			}).magnificPopup('open');
		});

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
			$('#group-lampiran').append(form_lampiran);
		});

		// Handling Delete Lampiran
		$(document).on('click', '.del-lampiran', function(e) {
			e.preventDefault();
			$(this).parent().parent().remove();
		});

		///// Execute at page load /////
		showData();

	}).apply( this, [ jQuery ]);
});
</script>
@endsection