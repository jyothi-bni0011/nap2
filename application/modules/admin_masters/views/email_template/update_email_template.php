<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?php echo base_url("assets/tinymce/tinymce.min.js"); ?>"></script>
		<div><?php echo $this->session->flashdata('message');?></div>
<div class="row">
	
	<div class="col-md-12">
		<form class="card form-horizontal" method="post" action="<?php echo current_url(); ?>" autocomplete="off" id="create-template" autocomplete="off">
			<input type="hidden" name="template_id" value="<?php echo $template->{EMAIL_TEMPLATE_ID}; ?>">
			<div class="card-body">

				<div class="form-group row">
					<label class="control-label col-md-3">Subject
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<input type="text" id="subject" name="subject" class="form-control input-height" value="<?php echo $template->template_subject; ?>" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Body
						<span class="required"> * </span>
						<div class="card card-primary border-0">
							<div class="card-header bg-danger"><span class="card-title">Available variables</span></div>
							<ul class="list-group" id="available-variable">
								<?php foreach ($variables as $variable => $value): ?>
								<a href="javascript:return false;" class="active-variable list-group-item list-group-item-action border-0" data-field_name="<?php echo $variable; ?>" data-varname="<?php echo $variable; ?>">
									<?php echo $variable; ?>
								</a>
								<?php endforeach;  ?>
								<a href="javascript:return false;" class="active-variable list-group-item list-group-item-action border-0" data-field_name="{document_title}" data-varname="{document_title}">
									{document_title}
								</a>
								<a href="javascript:return false;" class="active-variable list-group-item list-group-item-action border-0" data-field_name="{rejection_comment}" data-varname="{rejection_comment}">
									{rejection_comment}
								</a>
								
							</ul>
						</div>
					</label>

					<div class="col-md-9">
						<textarea name="body" name="" id="body" cols="30" rows="10">
							<?php echo $template->template_body; ?>
						</textarea>
						<span id="body-error" style="display: none; color: red;">This field is required.</span>
					</div>
				</div>

				<div class="form-actions">
					<div class="row">
						<div class="offset-md-3 col-md-9">
							<button type="submit" class="btn btn-danger">Update</button>
							<button type="button" class="btn btn-default" onclick="javascript:window.history.go(-1);">Cancel</button>
						</div>
					</div>
				</div>
				
			</div>
		</form>
	</div>
</div>
<style>
	.margin-1 { margin: 1px 0 0 0; }
	.list-group .list-group-item { text-align: left; }
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#create-template" ).validate({
			
			rules: {
				subject: {
		      		required: true,
		      		
		    	},
		    	body: {
		    		required: true,
		    		minimum : 1
		    	},
			}
		});
	});
	
	$('#create-template').on('submit', function(e){
		var editorContent = tinyMCE.get('body').getContent();

		if (editorContent == '')
		{
		    // Editor empty
			e.preventDefault();
			$('#body-error').show();
			$('.mce-edit-area').focus();
		}
		
	});
</script>