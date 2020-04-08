@extends('layouts.octopus')

@section('vendorstyle')
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/pnotify/pnotify.custom.css') }}" />
@endsection

@section('breadcrumbs')
<li><span>User Management</span></li>
<li><span>Roles</span></li>
@endsection

@section('content')
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Roles</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
					<a id="addRole" class="btn btn-primary btnCreate" href="#modalRole">Tambah <i class="fa fa-plus"></i></a>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped mb-none" id="table-role">
			<thead>
				<tr>
					<th>Role</th>
					<th width="280px">Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</section>

<!-- Modal tambah/edit role -->
<div id="modalRole" class="modal-block modal-block-lg mfp-hide">
	<section class="panel">
    {!! Form::open(array('id' => 'formRole', 'class' => 'form-horizontal mb-lg')) !!}
		<header class="panel-heading">
			<h2 class="panel-title">Form Role</h2>
		</header>
		<div class="panel-body">
			<div class="row">
				<input id="route" type="hidden">
				<input id="roleId" type="hidden">
				<div class="col-xs-12 col-sm-12">
					<div class="form-group mt-lg">
						<label class="col-sm-12 col-md-2" style="padding-left: 25px;">Nama Role</label>
						<div class="col-sm-8">
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
							<div id="error_name" class="error_text"></div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12">
					<div class="form-group mt-lg">
						<label class="col-sm-12 col-md-2" style="padding-left: 25px;">Permision</label>
						<div class="col-sm-12">
                            @foreach($permission as $value)
							<div class="col-sm-6 col-md-3 checkbox">
								<label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
								{{ $value->name }}</label>
							</div>
							@endforeach
							<div id="error_permission" class="error_text"></div>
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
			<h2 class="panel-title">Hapus Role!</h2>
		</header>
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-icon">
					<i class="fa fa-warning"></i>
				</div>
				<div class="modal-text">
					<h4>Perhatian</h4>
					<p>Apakah yakin role <strong id="deleteRolename"></strong> akan dihapus?</p>
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
		function showRoles() {
			$.ajax({
				url: "{{ route('roles.list') }}",
				method: "POST",
				data: { _token: "{{ csrf_token() }}" },
				success: function(roles) {
					roles.forEach(function(role) {
						var rows = `
							<tr>
								<td class="td-rolename">${role.name}</td>
								<td>
									<a id="${role.id}" class="btn btn-primary btn-xs btnEdit" href="#modalRole">Edit</a>
									<a id="${role.id}" class="btn btn-danger btn-xs btnDelete" href="#modalDelete">Delete</a>
								</td>
							</tr>
						`;
						$('#table-role tbody').append(rows);
					});
					
					$('#table-role').dataTable()
				}
			});
		};

		///// Display Modal /////
		// Clear form validation at modal close
		function clearValidation() {
			$("#formRole .form-control").removeClass("is-invalid is-valid");
			$("#formRole .error_text").empty();
		};

		// Clear form at modal close
		function clearForm() {
			$('#formRole').trigger("reset");
			$('#formRole input#route').val("create");
		};

		// Modal Dismiss
		$(document).on('click', '.modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
		});

		// Modal Confirm
		$(document).on('click', '#formRole .modal-confirm', function (e) {
			e.preventDefault();
			clearValidation();

			var formType = $('#formRole input#route').val();
			if (formType == 'update') {
				var roleId = formType = $('#formRole input#roleId').val();
				var ajaxUrl = `/roles/${roleId}`; 
				var ajaxType = "PUT";
			} else {
				var ajaxUrl = `/roles`; 
				var ajaxType = "POST";
			}
			
			$.ajax({
				url: ajaxUrl,
				type: ajaxType,
				data: $("#formRole").serializeArray(),
				success: function() {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'Role berhasil dibuat',
						type: 'success'
					});
					clearForm();

					$('#table-role').DataTable().clear().destroy();
					showRoles();
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
				var roleId = $(this).attr("id");
				
				$.ajax({
					url: `/roles/${roleId}/edit`,
					type: "GET",
					data: { _token: "{{ csrf_token() }}" },
					success: function (response) {
						$('#formRole input#route').val('update');
						$('#formRole input#roleId').val(response['role']['id']);
						$('#formRole input[name="name"]').val(response['role']['name']);
						rolePermissions = Object.values(response.rolePermission);
						rolePermissions.forEach(function(permission) {
							var checkbox = $(`#formRole input[type="checkbox"][value="${permission}"]`);
							$(`#formRole input[type="checkbox"][value="${permission}"]`).prop('checked', true);
						});
						openForm(trigger);
					}
				});
			} else {
				openForm(trigger);
			}

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
			var username = $(this).parent().siblings(".td-rolename").html();
			$('#modalDelete input#deleteId').val(idUser);
			$('#modalDelete strong#deleteRolename').html(username);
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
						$('#modalDelete strong#deleteRolename').empty();
					}
				}
			}).magnificPopup('open');
		}

		// Delete User
		$(document).on('click', '.btnDeleteConfirm', function(e){
			e.preventDefault();
			var roleId = $('#modalDelete input#deleteId').val();
			$.ajax({
				url: `/roles/${roleId}`,
				type: "DELETE",
				data: { _token: "{{ csrf_token() }}" },
				success: function() {
					$.magnificPopup.close();
					new PNotify({
						title: 'Success!',
						text: 'Role telah dihapus',
						type: 'success'
					});

					$('#table-role').DataTable().clear().destroy();
					showRoles();
				}
			});
		});

		///// Execute at page load /////
		showRoles();

	}).apply( this, [ jQuery ]);
});
</script>
@endsection