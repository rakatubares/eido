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
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
                    <a id="addData" class="btn btn-primary btnCreate" href="#modalForm">Tambah <i class="fa fa-plus"></i></a>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped mb-none" id="table-data">
			<thead>
				<tr>
					<th>AWB</th>
					<th>Tgl AWB</th>
					<th>Importir</th>
					<th>Status</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</section>

<!-- Modal tambah/edit -->
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
							<label>{{ Form::checkbox('check_nib', '1', false, array('class' => 'name')) }}
							Memiliki NIB/pengecualian NIB</label>
						</div>
						<div class="col-sm-12 col-md-5">
							{!! Form::text('dok_nib', null, array('placeholder' => 'Keterangan dok. NIB','class' => 'form-control', 'disabled')) !!}
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
							<label>{{ Form::checkbox('check_lartas', '1', false, array('class' => 'name')) }}
							Bukan lartas / Ada izin lartas atau pengecualian lartas</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label"></label>
						<div class="col-sm-12 col-md-5">
							{!! Form::text('dok_lartas', null, array('placeholder' => 'Keterangan dok. Lartas','class' => 'form-control','disabled')) !!}
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
							<label>{{ Form::checkbox('rekomendasi_bebas', '1', false, array('class' => 'name','disabled')) }}
							Ada rekomendasi bebas</label>
						</div>
						<div class="col-sm-12 col-md-5">
							{!! Form::text('dok_rekomendasi_bebas', null, array('placeholder' => 'Keterangan dok. rekomendasi','class' => 'form-control','disabled')) !!}
							<div id="error_dok_rekomendasi_bebas" class="error_text"></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 mb-md">
						<label class="col-sm-12 col-md-2 control-label">SKEP bebas</label>
						<div class="col-sm-12 col-md-4 checkbox">
							<label>{{ Form::checkbox('check_bebas', '1', false, array('class' => 'name','disabled')) }}
							Ada SKEP pembebasan</label>
						</div>
						<div class="col-sm-12 col-md-5">
							{!! Form::text('dok_bebas', null, array('placeholder' => 'Keterangan dok. pembebasan','class' => 'form-control','disabled')) !!}
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

<!-- Modal delete user -->
<div id="modalDelete" class="modal-block modal-header-color modal-block-warning mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Hapus User!</h2>
		</header>
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-icon">
					<i class="fa fa-warning"></i>
				</div>
				<div class="modal-text">
					<h4>Perhatian</h4>
					<p>Apakah yakin <strong id="deleteUsername"></strong> akan dihapus?</p>
				</div>
			</div>
			<input id="deleteId" type="hidden">
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-danger btnDeleteConfirm">Hapus</button>
					<button class="btn btn-default modal-dismiss">Batal</button>
				</div>
			</div>
		</footer>
	</section>
</div>
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
						var rows = `
							<tr>
								<td>${dat.awb}</td>
								<td>${dat.tgl_awb}</td>
								<td>${dat.importir}</td>
								<td>${dat.status.ur_status}</td>
								<td>
									<a class="btn btn-primary btn-xs" href="/importasi/${dat.id}">Detail</a>
								</td>
							</tr>
						`;
						$('#table-data tbody').append(rows);
					});
					
					$('#table-data').dataTable()
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
			$('#formEdit input[type="text"][name="dok_nib"]').prop('disabled',true);
			$('#formEdit input[type="text"][name="dok_nib"]').prop('disabled',true);
			$('#formEdit input[type="checkbox"][name="rekomendasi_bebas"]').prop('disabled',true);
			$('#formEdit input[type="text"][name="dok_rekomendasi_bebas"]').prop('disabled',true);
			$('#formEdit input[type="checkbox"][name="check_bebas"]').prop('disabled',true);
			$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',true);
		});

		// Modal Confirm
		$(document).on('click', '.modal-confirm', function (e) {
			e.preventDefault();
			clearValidation();

			var formType = $('#formEdit input#route').val();
			if (formType == 'update') {
				var userId = formType = $('#formEdit input#dataId').val();
				var ajaxUrl = `/importasi/${userId}`; 
				var ajaxType = "PUT";
			} else {
				var ajaxUrl = `/importasi`; 
				var ajaxType = "POST";
			}

			var data = $('#formEdit').serializeArray();
			console.log(data);
			
			$.ajax({
				url: ajaxUrl,
				type: ajaxType,
				data: $("#formEdit").serializeArray(),
				success: function() {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'User berhasil dibuat',
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
							$(`#error_${type}`).html(`<p class="text-danger">${messages[idx]}</p>`);
						}
					}
				},
			});
		});

		// Trigger Create/Edit Form
		$(document).on('click', '.btnCreate, .btnEdit', function(e){
			e.preventDefault();
			var trigger = $(this);

			if ($(this).hasClass("btnEdit")) {
				var idUser = $(this).attr("id");
				
				$.ajax({
					url: `/importasi/${idUser}/edit`,
					type: "GET",
					data: { _token: "{{ csrf_token() }}" },
					success: function (response) {
						// $('#formEdit input#route').val('update');
						// $('#formUser input#userId').val(response['user']['id']);
						// $('#formUser input[name="name"]').val(response['user']['name']);
						// $('#formUser input[name="nip"]').val(response['user']['nip']);
						// $('#formUser input[name="username"]').val(response['user']['username']);
						// $('#formUser input[name="username"]').prop('disabled', true);
						// userRoles = Object.values(response.userRole);
						// openForm(trigger, userRoles);
					}
				});
			} else {
				openForm(trigger);
			}

		});

		// Open Create/Edit Form Modal
		function openForm(trigger, selected=[]) {
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
						clearForm();
					}
				}
			}).magnificPopup('open');
		}

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

		// Handling Rekomendasi Bebas
		$(document).on('change', '#formEdit input[type="checkbox"][name="check_bebas"]', function() {
			if(this.checked) {
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',false);
			} else {
				$('#formEdit input[type="text"][name="dok_bebas"]').prop('disabled',true);
				$('#formEdit input[type="text"][name="dok_bebas"]').val(null);
			}
		});

		// Trigger Delete
		$(document).on('click', '.btnDelete', function(e){
			e.preventDefault();
			var trigger = $(this);
			var idUser = $(this).attr("id");
			var username = $(this).parent().siblings(".td-username").html();
			$('#modalDelete input#deleteId').val(idUser);
			$('#modalDelete strong#deleteUsername').html(username);
			openModal(trigger);
		});

		// Open Delete Modal
		function openModal(trigger) {
			$(trigger).magnificPopup({
				type: 'inline',
				preloader: false,
				modal: true,
				callbacks: {
					close: function() {
						$('#modalDelete input#deleteId').val(null);
						$('#modalDelete strong#deleteUsername').empty();
					}
				}
			}).magnificPopup('open');
		}

		// Delete User
		$(document).on('click', '.btnDeleteConfirm', function(e){
			e.preventDefault();
			var idUser = $('#modalDelete input#deleteId').val();
			$.ajax({
				url: `/importasi/${idUser}`,
				type: "DELETE",
				data: { _token: "{{ csrf_token() }}" },
				success: function() {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'User telah dihapus',
						type: 'success'
					});

					$('#table-data').DataTable().clear().destroy();
					showData();
				}
			});
		});

		///// Execute at page load /////
		showData();

	}).apply( this, [ jQuery ]);
});
</script>
@endsection