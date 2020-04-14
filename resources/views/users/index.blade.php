@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
@endsection

@section('breadcrumbs')
<li><span>User Management</span></li>
<li><span>Users</span></li>
@endsection

@section('content')
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Users</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
          <a id="addUser" class="btn btn-primary btnCreate" href="#modalUser">Tambah <i class="fa fa-plus"></i></a>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped mb-none" id="table-user">
			<thead>
				<tr>
					<th>Nama</th>
					<th>NIP</th>
					<th>Username</th>
					<th>Roles</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</section>

<!-- Modal tambah/edit user -->
<div id="modalUser" class="modal-block modal-block-lg mfp-hide">
	<section class="panel">
    {!! Form::open(array('route' => 'users.store','method'=>'POST', 'id' => 'formUser', 'class' => 'form-horizontal mb-lg')) !!}
		<header class="panel-heading">
			<h2 class="panel-title">Form User</h2>
		</header>
		<div class="panel-body">
			<div class="row">
				<input id="route" type="hidden">
				<input id="userId" type="hidden">
				<div class="col-xs-12 col-sm-12 col-md-6">
					<div class="form-group mt-lg">
						<label class="col-sm-12 col-md-4 control-label">Nama</label>
						<div class="col-sm-8">
							{!! Form::text('name', null, array('placeholder' => 'Isikan nama','class' => 'form-control')) !!}
							<div id="error_name" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6">
					<div class="form-group mt-lg">
						<label class="col-sm-12 col-md-2 control-label">NIP</label>
						<div class="col-sm-8">
							{!! Form::text('nip', null, array('placeholder' => 'NIP','class' => 'form-control')) !!}
							<div id="error_nip" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group mt-lg">
						<label class="col-sm-2 control-label">Username</label>
						<div class="col-sm-4">
							{!! Form::text('username', null, array('placeholder' => 'Isikan username','class' => 'form-control')) !!}
							<div id="error_username" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6">
					<div class="form-group mt-lg">
						<label class="col-sm-12 col-md-4 control-label">Password</label>
						<div class="col-sm-8">
							{!! Form::password('password', array('placeholder' => 'Password min 8 karakter','class' => 'form-control')) !!}
							<div id="error_password" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6">
					<div class="form-group mt-lg">
						<label class="col-sm-12 col-md-2 control-label">Confirm</label>
						<div class="col-sm-8">
							{!! Form::password('confirm-password', array('placeholder' => 'Input password kembali','class' => 'form-control')) !!}
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group mt-lg">
						<label class="col-sm-2 control-label">Role</label>
						<div class="col-sm-9">
							{!! Form::select('roles[]', $roles,[], array('id' => 'selectRole', 'class' => 'form-control populate','multiple')) !!}
							<div id="error_roles" class="error_text"></div>
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
<script src="{{ asset('vendor/pnotify/pnotify.custom.js') }}"></script>
@endsection

@section('pagescript')
<script>
$(document).ready(function() {
	(function( $ ) {
		///// Display DataTable /////
		function showUsers() {
			$.ajax({
				url: "{{ route('users.all') }}",
				method: "POST",
				data: { _token: "{{ csrf_token() }}" },
				success: function(users) {
					users.forEach(function(user) {
						var dataRoles = '';
						user.roles.forEach(function(role) {
							dataRoles += `<label class="badge badge-success">${role}</label> `;
						});
						var rows = `
							<tr>
								<td>${user.name}</td>
								<td>${user.nip}</td>
								<td class="td-username">${user.username}</td>
								<td>${dataRoles}</td>
								<td>
									<a id="${user.id}" class="btn btn-primary btn-xs btnEdit" href="#modalUser">Edit</a>
									<a id="${user.id}" class="btn btn-danger btn-xs btnDelete" href="#modalDelete">Delete</a>
								</td>
							</tr>
						`;
						$('#table-user tbody').append(rows);
					});
					
					$('#table-user').dataTable()
				}
			});
		};

		///// Display Modal /////
		// Clear form validation at modal close
		function clearValidation() {
			$("#formUser .form-control").removeClass("is-invalid is-valid");
			$("#formUser .error_text").empty();
		};

		// Clear form at modal close
		function clearForm() {
			$('#formUser').trigger("reset");
			$('#formUser input#route').val("create");
			$('#formUser input[name="username"]').prop('disabled', false);
		};

		// Modal Dismiss
		$(document).on('click', '.modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
			// clearValidation();
			// clearForm();
		});

		// Modal Confirm
		$(document).on('click', '.modal-confirm', function (e) {
			e.preventDefault();
			clearValidation();

			var formType = $('#formUser input#route').val();
			if (formType == 'update') {
				var userId = $('#formUser input#userId').val();
				var ajaxUrl = `users/${userId}`; 
				var ajaxType = "PUT";
			} else {
				var ajaxUrl = `{{ route("users.store") }}`; 
				var ajaxType = "POST";
			}
			
			$.ajax({
				url: ajaxUrl,
				type: ajaxType,
				data: $("#formUser").serializeArray(),
				success: function() {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'User berhasil dibuat',
						type: 'success'
					});
					clearForm();

					$('#table-user').DataTable().clear().destroy();
					showUsers();
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
					url: `users/${idUser}/edit`,
					type: "GET",
					data: { _token: "{{ csrf_token() }}" },
					success: function (response) {
						$('#formUser input#route').val('update');
						$('#formUser input#userId').val(response['user']['id']);
						$('#formUser input[name="name"]').val(response['user']['name']);
						$('#formUser input[name="nip"]').val(response['user']['nip']);
						$('#formUser input[name="username"]').val(response['user']['username']);
						$('#formUser input[name="username"]').prop('disabled', true);
						userRoles = Object.values(response.userRole);
						openForm(trigger, userRoles);
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
						$('#selectRole').select2().select2("val", selected);
						$(".select2-drop").css("z-index", "99999");
					},
					close: function() {
						clearValidation();
						clearForm();
					}
				}
			}).magnificPopup('open');
		}

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
				url: `users/${idUser}`,
				type: "DELETE",
				data: { _token: "{{ csrf_token() }}" },
				success: function() {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'User telah dihapus',
						type: 'success'
					});

					$('#table-user').DataTable().clear().destroy();
					showUsers();
				}
			});
		});

		///// Execute at page load /////
		showUsers();

	}).apply( this, [ jQuery ]);
});
</script>
@endsection