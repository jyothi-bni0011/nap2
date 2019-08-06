$(document).ready(function(){
	
	$('select[name="template"]').on('change', function(event) {
		
		event.preventDefault();
		var val = $(this).val();
		if( $.isNumeric(val) ) {
			window.location.href = base_url + "document/generate/index/" + val;
			return;
		}

		window.location.href = base_url + "document/create";
	});
	
	$(document).on('click', '#var_create', function(event) {
		event.preventDefault();
		$('#var_create_modal').modal("show");
	});

	$(document).on('click', '#signature', function(event) {
		event.preventDefault();
		$('#signature_modal').prepend(
			'<input type="hidden" name="signature_var" value="' + $(this).attr('class') + '">'
		);
		$('#signature_modal').modal("show");
	});
	
	$('input[name="field_name"]').on("keyup", function() {
		var text = $(this).val(),
 			varname = text.toLowerCase().replace(/[_\W]+/g, "_");

		$('input[name="varname"]').val('{' + varname + '}');
	});

	$('#var_create_modal').on("submit", function(event) {
		
		event.preventDefault();
		var data 			= $(this).serialize(),
			field_name 		= $(this).find('input[name="field_name"]').val(),
			varname 		= $(this).find('input[name="varname"]').val(),
			role_id			= $(this).find('select[name="role_id"] option:selected').val(),
			role_name		= $(this).find('select[name="role_id"] option:selected').text(),
			key 			= varname.replace('{', '').replace('}', '');

			input_hidden 	= 
				'<input type="hidden" name="variables[' + key + '][field_name]" value="' + field_name + '">' +
				'<input type="hidden" name="variables[' + key + '][varname]" value="' + varname + '">' +
				'<input type="hidden" name="variables[' + key + '][role_id]" value="' + role_id + '">',
			
			variable 		= '<a href="javascript:return false;" class="active-variable justify-content-between list-group-item list-group-item-action border-0" data-field_name="' + field_name + '" data-varname="' + varname + '">' + varname + '<span class="badge badge-primary badge-pill">' + role_name + '</span></a>';

		$('.no-variable').hide();
		$('#create-template').prepend(input_hidden);
		$('#available-variable').prepend(variable);
		$.growl.notice({ message: "Variable has been added." });
		$(this).find('input[name="field_name"]').val("");
		$(this).find('input[name="varname"]').val("");

	});

	$(document).on('keyup', '.update-changes', function(event) {
		
		var varname = $(this).attr('name'),
			value = $(this).val();
		
		if( value.length > 0 ) {
			$("." + varname).text(value);
		}
	});

	$(document).on('focus', '.update-changes', function(event) {
		var varname = $(this).attr('name');
		$("." + varname).addClass('highlight');
	});

	$(document).on('blur', '.update-changes', function(event) {
		var varname = $(this).attr('name');
		$("." + varname).removeClass('highlight');
	});

	$(document).on('click', '.active-variable', function(event) {
		event.preventDefault();
		
		var field_name	= $(this).data("field_name"),
 			varname 	= $(this).data("varname"),
 			key 		= varname.replace('{', '').replace('}', ''),
 			append 		= varname;

		tinymce.activeEditor.execCommand('mceReplaceContent', false, append);
	});

	$(document).on('click', '.system-variable', function(event) {
		event.preventDefault();
		
		var field_name	= $(this).data("field_name"),
 			varname 	= $(this).data("varname"),
 			key 		= varname.replace('{', '').replace('}', ''),
 			append 		= varname;

 		$('#var_create_modal').find('input[name="field_name"]').val(field_name);
 		$('#var_create_modal').find('input[name="varname"]').val(varname);
 		$('#var_create_modal').modal('toggle');

	});

	// Rearrange Available variables according to template variable entries
	var variables_pos 		= $('.generate-document [class*="var_"]');
	if( variables_pos.length ) {

		var generate_variables 	= $('.generate-variable .form-group'),
			rearrage 			= "", 
			class_names 		= "",
			classes				= [];

		$.each(variables_pos, function(index, val) {
			var _class 	= $(val).attr('class'), html = "";

			if( $.inArray(_class, classes) === -1 ) {

				var form_group 	= generate_variables.find('[name="' + _class + '"]');
				if( form_group.length ) 
				{
					class_names 	= form_group.closest('.form-group').attr('class');
					html 			+= form_group.closest('.form-group').html();
					rearrage 		+= '<div class="' + class_names + '">' + html + '</div>';
					classes[index] 	= _class;
				}
			}
			
		});

		$('.generate-variable').html(rearrage);
	}

	if( typeof SignaturePad !== 'undefined' )
	{
		var saveButton 		= document.getElementById('save_signature');
		var clearButton 	= document.getElementById('clear_signature');
		var uploadButton 	= document.getElementById('upload_signature');
		var signaturePad 	= new SignaturePad(document.getElementById('signature-pad'), {
			backgroundColor: 'rgba(255, 255, 255, 0)',
			penColor: 'rgb(0, 0, 0)'
		});

		saveButton.addEventListener('click', function (event) {
			signaturePad.removeWhites();
			signaturePad.removeBlanks();
			var data = signaturePad.toDataURL();
			$('#signature_modal').modal("hide");

			var signature_var = $('#signature_modal').find('input[name="signature_var"]').val();
			$('.' + signature_var ).after('<img src="' + data + '" width="125" />').remove();
			$('form input[name="' + signature_var + '"]').val(data);
		});

		clearButton.addEventListener('click', function (event) {
			signaturePad.clear();
		});

		uploadButton.addEventListener('click', function (event) {
			var file = $('input[type="file"]');
				file.trigger('click');
		});

		$('input[type="file"]').on('change', function(event) {
			
			var file    = document.querySelector('input[type="file"]').files[0];
			var reader  = new FileReader();
			reader.addEventListener("load", function () {
				signaturePad.fromDataURL(reader.result);
			}, false);

			if (file) {
				reader.readAsDataURL(file);
			}
		});
	}

	var $form_steps_modal = $('#form_steps_modal');
	$('select[name="form_steps"]').on("change", function() {
		
		var form_steps 	= parseInt($(this).val()),
			row 		= $form_steps_modal.find('.form-row')[0],
			_class 		= $(row).attr('class'),
			form_modal = $form_steps_modal.find('.modal-body');

		form_modal.html("");
		for(var i = 0; i < form_steps; i++) {
			html = $(row).html();

			form_modal.append('<div class="' + _class + '">' + html + '</div>');
		}

		//$form_steps_modal.find('option[value="4"]').first().remove();

		$form_steps_modal.modal('toggle');

	});

	$form_steps_modal.on("submit", function(event) {
		event.preventDefault();

		var roles = $form_steps_modal.find('select[name="form_steps_role[]"]'),
			input_hidden = '';

		$('input[name="form_steps_role[]"]').remove();
		$.each(roles, function(index, val) {
			input_hidden += '<input type="hidden" name="form_steps_role[]" value="' + $(val).val() + '">'
		});

		$('#create-template').prepend(input_hidden);
		$form_steps_modal.modal('toggle');

	});

});