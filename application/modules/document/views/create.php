<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?php echo base_url("assets/tinymce/tinymce.min.js"); ?>"></script>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?= $title; ?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<?php if(!empty($message)) echo $message; ?>
		<form class="card form-horizontal" method="post" action="<?php echo current_url(); ?>" id="create-template" autocomplete="off" enctype="multipart/form-data">
			<input type="hidden" name="form_steps_role[]" value="4">
			<div class="card-body">
				<div class="form-group row">
					<label class="control-label col-md-3">Document Category
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="doc_category" id="doc_category">
                           <option value="">Select Document Category </option>
                           <?php foreach($doc_categories as $doc_category): ?>
	                           <option value="<?php echo $doc_category->{DOCUMENT_CATEGORY_ID}; ?>"> <?php echo $doc_category->{DOCUMENT_CATEGORY_NAME}; ?> </option>
                       		<?php endforeach; ?>
                        </select> 
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Document Folder
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="doc_folder" id="doc_folder">
                           <option value="">Select Document Folder </option>
                           <?php foreach($doc_folders as $doc_folder): ?>
	                           <option value="<?php echo $doc_folder->{DOCUMENT_FOLDER_ID}; ?>"> <?php echo $doc_folder->{DOCUMENT_FOLDER_NAME}; ?> </option>
                       		<?php endforeach; ?>
                        </select> 
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-md-3">Status
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="status" id="status">
                           <option value="">Select Document Status</option>
                           <option value="1">Active </option>
                           <option value="0">In-active </option>
                        </select> 
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Form Steps
						<span class="required">*</span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="form_steps" id="form_steps">
                           
                           <option value="1">1 Step Form</option>
                           <!--<option value="2">2 Step Form</option>-->
                        </select> 
						<div id="doc_steps">
                        	Form Step 1 : New Associate <br>
                        </div>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-md-3">Password
						<span class="required"></span>
					</label>
					<div class="col-md-9">
						<div class="input-group">
						  <div class="input-group-prepend">
						    <div class="input-group-text">
						      <input type="checkbox" id="is_password" aria-label="form-control input-height" id="pass_check">
						    </div>
						  </div>
						  <input type="password" name="doc_password" class="form-control input-height" aria-label="Text input with checkbox" id="pass_text" disabled>
						  <span toggle="#pass_text" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-md-3">Document Name
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<input type="text" name="document_title" class="form-control input-height check_unique" id="document_title">
						<span id="docname_error" class="error" style="display: none; color: red;">This document name already exists.</span>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-md-3">Document Type
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-4">
								<label class="radio-inline control-label"><input type="radio" name="doc_type" style="margin-right: 7px;" value="template" checked>Document Template</label>
							</div>
							<div class="col-md-6">
								<label class="radio-inline control-label"><input type="radio" name="doc_type" style="margin-right: 7px;" value="upload">Document Upload</label>
							</div>
						</div>
					</div>
				</div>


				<div class="form-group row" style="display: none;" id="upload_div">
					<label class="control-label col-md-3">Upload Document
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<div class="custom-file">
						    <input type="file" class="custom-file-input" id="customFile" name="upload_file" accept="application/pdf">
						    <label class="custom-file-label" for="customFile" id="file_name">Choose file</label>
						</div>	
							<span style="font-size: smaller;" id="file_info"><i>Max allowed Size: <?php echo ini_get('upload_max_filesize'); ?><i/></span>	
					</div>	
				</div>

				<div class="form-group row" id="template_div">
					<label class="control-label col-md-3 pt-0">
						<div class="card card-primary border-0">
							<div class="card-header bg-danger"><span class="card-title">System variables</span></div>
							<ul class="list-group border-0" id="system-variable">
								<a href="javascript:return false;" class="system-variable border-1 list-group-item list-group-item-action border-0" data-field_name="Signature HR Admin" data-varname="{signature_hr_admin}">{signature}</a>
								<!-- <a href="javascript:return false;" class="system-variable border-1 list-group-item list-group-item-action border-0" data-field_name="Signature 2" data-varname="{signature_2}">{signature_2}</a> -->
							</ul>
						</div>
						<div class="card card-primary border-0">
							<div class="card-header bg-danger"><span class="card-title">Available variables</span></div>
							<ul class="list-group border-0" id="available-variable">
								<a href="#" class="no-variable border-0 list-group-item list-group-item-action">No variables are assigned for this document.</a>
								<a href="#" id="var_create" class="list-group-item list-group-item-action border-0">Create / Manage Variables</a>
							</ul>
						</div>
					</label>
					<div class="col-md-9">
						<textarea name="document" name="" id="" cols="30" rows="10" novalidate style="width:100%;"></textarea>
					</div>
				</div>

				<div class="form-actions">
					<div class="row">
						<div class="offset-md-3 col-md-9">
							<button type="submit" class="btn btn-danger">Create</button>
							<button type="button" class="btn btn-default" onclick="javascript:window.history.go(-1);">Cancel</button>
						</div>
					</div>
				</div>
				
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="var_create_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content" id="modal-form" method="post" action="" autocomplete="off">
			<div class="modal-header bg-danger">
				<h5 class="modal-title m-0">Document Variable</h5>
			</div>
			<input type="hidden" name="modal_type" id="modal_type">
			<div class="modal-body">
				<div class="form-group">
					<label for="" class="small">Field Name</label>
					<input type="text" name="field_name" value="" class="form-control" placeholder="Field Name" required>
				</div>
				<div class="form-group">
					<label for="" class="small">Variable</label>
					<input type="text" name="varname" placeholder="Variable" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="" class="small">Select Role</label>
					<select name="role_id" class="form-control" id="signature_role_id">
						<?php foreach($roles as $role):?>
							<option value="<?= $role->{ROLE_ID}; ?>"><?= $role->{ROLE_NAME}; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
                                <div class="form-group feild_radio">
					<label for="" class="small">Select Type</label>
					<select name="type_id" class="form-control" id="type_id">
                                             <option value="0">Text</option>
                                            <option value="1">Radio</option>
                                            <option value="2">File</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="form_steps_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content form-horizontal" id="modal-form" method="post" action="" autocomplete="off">
			<div class="modal-header bg-danger">
				<h5 class="modal-title m-0">Assign Form Steps</h5>
			</div>
			<div class="modal-body">
				<div class="form-row align-items-center mb-3">
					<label for="" class="col-md-4 col-form-label text-right">Form Step</label>
					<div class="col-md-6">
						<select name="form_steps_role[]" class="form-control">
							<?php foreach($roles as $role):?>
								<option value="<?= $role->{ROLE_ID}; ?>"><?= $role->{ROLE_NAME}; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div>
</div>
<style>
	.margin-1 { margin: 1px 0 0 0; }
	.list-group .list-group-item { text-align: left; }
	
	.field-icon {
     	float: right;
	    margin-left: -23px;
	    margin-top: 15px;
	    right: 7px;
	    position: relative;
	    z-index: 99;
	    font-size: large;
	}
</style>

<script>
$(document).ready(function(){
	$( "#create-template" ).validate({
		rules: {
			doc_category: {
	      		required: true,
	    	},
	    	doc_folder: {
	      		required: true,
	    	},
	    	status: {
	      		required: true,
	    	},
	    	form_steps: {
	    		required: true
	    	},
	    	document_title: {
	    		required: true
	    	}
		}
		
	});
	
	$('#is_password').on('click',function(){
		if($("#is_password").prop('checked') == true){
		    $('#pass_text').removeAttr('disabled');
		    //$("#pass_text").rules("add", "required");
		}
		else{
			$('#pass_text').val('');
			$('#pass_text').attr('disabled',true);
		}
	});

	

	$(".toggle-password").click(function() {

	  $(this).toggleClass("fa-eye fa-eye-slash");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
	    input.attr("type", "text");
	  } else {
	    input.attr("type", "password");
	  }
	});
	
	$("input[type='radio']").click(function(){
        var radioValue = $("input[name='doc_type']:checked").val();
        if(radioValue == 'upload'){
            $('#upload_div').show();
            $('#template_div').hide();
        }
        else{
        	$('#upload_div').hide();
            $('#template_div').show();
        }
    });
	
	$('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('#file_name').html(fileName);
    });
	
	(function ($) {
	  $.each(['show', 'hide'], function (i, ev) {
	    var el = $.fn[ev];
	    $.fn[ev] = function () {
	      this.trigger(ev);
	      return el.apply(this, arguments);
	    };
	  });
	})(jQuery);

	$('#upload_div').on('show',function(){
		$("#customFile").rules("add", "required");
	});

	$('#upload_div').on('hide',function(){
		$("#customFile").rules("remove", "required");
	});
	
	var file_size;
    $('input[type="file"]').change(function(e){
    	file_size = this.files[0].size;
    	if ( this.files[0].size < 36700160 ) 
    	{	
	        var fileName = e.target.files[0].name;
	        $('#file_name').html(fileName);
	        $('#file_info').html(file_msg);
    	}
    	else
    	{
    		$('#file_info').html('<i style="color:red;">(Max file size exceeded.)<i/>');
    	}
    });

    var tmp = 1;
    $('#create-template').on('submit', function(e){
    	if ( tmp == 1 ) 
    	{
    		e.preventDefault();
	    	if ( file_size > 36700160 || $('#docname_error').is(":visible") ) 
	    	{
	    		if ( file_size > 36700160 ) 
	    		{
		    		$('input[type="file"]').focus();
		    		return false;
	    		}
	    		
	    		if ( $('#docname_error').is(":visible") ) 
	    		{
	    			$('#document_title').focus();
	    			return false;
	    		}
	    	}
	    	else
	    	{
	    		var table = 'document';
				// var id = $(this).attr('id');
				var column = 'document_title';
				var value = $('.check_unique').val();


				$.ajax({
					type: "POST",
					url: '<?php echo base_url('document/check_duplicate_document_by_ajax');?>',
					data: { table : table,
					        column : column,
					        id : value,
					        doc_id : 0
					      },
					success:function(data) {
					  
					  if(data.success == "0") {
					    $('#docname_error').show();
					     $('#document_title').focus();
					  }
					  else
					  {
					     tmp = 2;
		    			$('#create-template').submit(); 
					  }
					},
					error:function()
					{
					}
				});
	    	}
    	}
    });
	
	$('.check_unique').on('keypress',function(){
    	$('#docname_error').hide(); 
    });
	
	$("#form_steps_modal").on("hidden.bs.modal", function(){
		if ( $('input[name="form_steps_role[]"]').length != $('#form_steps').val() ) 
		{
			$('#form_steps').val(1);
		}
	});
	
});
</script>