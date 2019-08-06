<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="new-associates.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?= $title ?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<form id="create_doc_category" method="POST" action="<?php echo base_url('document_folder/create'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<div class="form-group row">
							<label class="control-label col-md-3">Document Folder
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="folder_name" id="folder_name" data-required="1" placeholder="Enter Document Folder" class="form-control input-height" value="<?php echo set_value('folder_name'); ?>"> 
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Description
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<textarea class="form-control" name="folder_description" id="folder_description" rows="3" placeholder="Enter Description"><?php echo set_value('folder_description'); ?></textarea>
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
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		jQuery.validator.addMethod("noSpace", function(value, element)   { //Code used for blank space Validation 
	    	return value.indexOf(" ") < 0 && value != ""; 
	    }, "No space please.");
		
		$( "#create_doc_category" ).validate({
			rules: {
				folder_name: {
		      		required: true,
					noSpace: true
		    	},
		    	folder_description: {
		      		required: true
		    	},
		    	
			}
			
		});
	});
</script>