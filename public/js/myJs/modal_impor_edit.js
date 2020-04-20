$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

var form_lampiran = `
	<div class="col-xs-12 col-sm-12 col-md-12 mb-md form-lampiran">
		<div class="col-xs-12 col-md-1"></div>
		<div class="col-xs-10 col-md-4 mb-2">
			<input class="form-control" name="lampiran[]" type="file">
			<div id="error_lampiran" class="error_text"></div>
		</div>
		<div class="col-xs-10 col-md-5">
			<input placeholder="Keterangan lampiran" class="form-control" name="ket_lampiran[]" type="text">
			<div id="error_ket_lampiran" class="error_text"></div>
		</div>
		<div class="col-xs-2 col-md-1">
			<button class="btn btn-default add-lampiran"><i class="fa fa-plus"></i></button>
		</div>
	</div>
`;

// Open form
function openForm(trigger,data=null) {
	
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
				fillForm(data);
				// Make select2 visible (not obstructed by modal)
				$(".mfp-wrap").removeAttr("tabindex");
			},
			close: function() {
				clearValidation();
			}
		}
	}).magnificPopup('open');
};

function getFormOptions() {
	$.ajax({
		url: window.urlImporOptions,
		type: "POST",
		success: function (data) {
			(data.jnsImportir).forEach(function(jenis) {
				var option = `<option value="${jenis.id}">${jenis.jns_importir}</option>`;
				$('#formEdit select[name="status_importir"]').append(option);
			});
			(data.rekomendasi).forEach(function(rekom) {
				var option = `<option value="${rekom.id}">${rekom.rekomendasi}</option>`;
				$('#formEdit select[name="rekomendasi_clearance"]').append(option);
			});
			(data.officers).forEach(function(officer) {
				var option = `<option value="${officer.id}">${officer.name}</option>`;
				$('#formEdit select[name="officer_id"]').append(option);
			});
		}
	});
}
getFormOptions();

// Fill form data for edit
function fillForm(data) {
	$('#formEdit input[name="idTanggap"]').val(data['idTanggap']);
	$('#formEdit input[name="awb"]').val(data['awb']);
	$('#formEdit input[name="tgl_awb"]').val(data['tgl_awb']);
	$('#formEdit input[name="no_permohonan"]').val(data['no_permohonan']);
	$('#formEdit input[name="tgl_permohonan"]').val(data['tgl_permohonan']);
	$('#formEdit input[name="importir"]').val(data['importir']);
	$('#formEdit input[name="npwp"]').val(data['npwp']);
	$('#formEdit select[name="status_importir"]').val(data['status_importir']);

	$('#formEdit input[name="pic"]').val(data['pic']);
	$('#formEdit input[name="hp_pic"]').val(data['hp_pic']);
	$('#formEdit input[name="email_pic"]').val(data['email_pic']);
	$('#formEdit input[name="tgl_clearance"]').val(data['tgl_clearance']);
	$('#formEdit input[name="wkt_clearance"]').val(data['wkt_clearance']);

	if (data['check_rekomendasi'] == 1) {
		$('#formEdit input[name="check_rekomendasi"]').prop('checked',true);
		$('#formEdit input[name="dok_rekomendasi"]').prop('disabled',false);
		$('#formEdit input[name="tgl_rekomendasi"]').prop('disabled',false);
	} else {
		$('#formEdit input[name="check_rekomendasi"]').prop('checked',false);
		$('#formEdit input[name="dok_rekomendasi"]').prop('disabled',true);
		$('#formEdit input[name="tgl_rekomendasi"]').prop('disabled',true);
	}
	$('#formEdit input[name="dok_rekomendasi"]').val(data['dok_rekomendasi']);
	$('#formEdit input[name="tgl_rekomendasi"]').val(data['tgl_rekomendasi']);

	$(`#formEdit input[name="bebas"]`).prop('checked', false);
	$(`#formEdit input[name="bebas"][value=${data['bebas']}]`).prop('checked', true);
	if (data['bebas'] == 1) {
		$('#formEdit input[name="check_bebas"]').prop('disabled',false);
	} else {
		$('#formEdit input[name="check_bebas"]').prop('disabled',true);
	}
	if (data['check_bebas'] == 1) {
		$('#formEdit input[name="check_bebas"]').prop('checked',true);
		$('#formEdit input[name="dok_bebas"]').prop('disabled',false);
		$('#formEdit input[name="tgl_bebas"]').prop('disabled',false);
	} else {
		$('#formEdit input[name="check_bebas"]').prop('checked',false);
		$('#formEdit input[name="dok_bebas"]').prop('disabled',true);
		$('#formEdit input[name="tgl_bebas"]').prop('disabled',true);
	}
	$('#formEdit input[name="dok_bebas"]').val(data['dok_bebas']);
	$('#formEdit input[name="tgl_bebas"]').val(data['tgl_bebas']);

	$('#formEdit input[name="rekomendasi_clearance"]').val(data['rekomendasi_clearance']);
	$('#formEdit input[name="officer_id"]').val(data['officer_id']);

	if (data['attachments'] != null) {
		$('#formEdit #form-current-lampiran').empty();
		var lampiran = '';
		(data['attachments']).forEach(function(attachment) {
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

	if (window.formType == 'covid-monitor') {
		$('#group-lampiran').remove();
	} else {
		$('#group-lampiran').append(form_lampiran);	
	}
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

// Clear form validation at modal close
function clearValidation() {
	$("#formEdit .form-control").removeClass("is-invalid is-valid");
	$("#formEdit .error_text").empty();
};

// Modal Confirm
$(document).on('click', '.modal-confirm', function (e) {
	e.preventDefault();
	clearValidation();

	var formData = new FormData($("#formEdit")[0]);

	// Display the key/value pairs
	for (var pair of formData.entries()) {
		console.log(pair[0]+ ', ' + pair[1]); 
	}

	$.ajax({
		url: window.urlForm,
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		success: function() {
			$.magnificPopup.close();
			$('#formEdit .form-lampiran').remove();
			new PNotify({
				title: 'Success!',
				text: 'Data berhasil diupdate',
				type: 'success'
			});

			if (window.formType == 'covid-monitor') {
				location.href = window.urlRedirect;
			}
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