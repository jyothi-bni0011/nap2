<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<form id="create_mapping" method="POST" action="<?php echo base_url('admin_masters/map_document_job_position/update_map_document_job_position'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">

						<input type="hidden" name="position_id" value="<?= $job_titles->{JOB_POSITION_ID}; ?>">

						<div class="form-group row">
							<label class="control-label col-md-3">Job Title
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="job_title" data-required="1" placeholder="" class="form-control input-height" value="<?= $job_titles->{JOB_POSITION_CODE}; ?>" disabled> 
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Document Folder
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select name="doc_folder" class="form-control input-height" id="doc_folder">
									<option value="">Select Document Folder</option>
									<?php foreach($doc_folders as $doc_folder): ?>
			                           <option value="<?php echo $doc_folder->{DOCUMENT_FOLDER_ID}; ?>"  > <?php echo $doc_folder->{DOCUMENT_FOLDER_NAME}; ?> </option>
		                       		<?php endforeach; ?>
								</select> 
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Document Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select class="form-control input-height select2-multiple" name="doc_name[]" id="doc_name" multiple>
                                   <option value="">Select Document Name </option>
                                   <?php foreach($doc_names[$job_titles->{JOB_POSITION_ID}] as $doc_name): ?>
			                           <option value="<?php echo $doc_name->{DOCUMENT_ID}; ?>" <?php foreach($rows as $mapped_doc): ?> <?php if ($doc_name->{DOCUMENT_ID}==$mapped_doc->{DOCUMENT_ID}) echo 'selected'; ?> <?php endforeach; ?> > <?php echo $doc_name->{DOCUMENT_TITLE}; ?> </option>
		                       		<?php endforeach; ?>
                                </select> 
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
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#create_mapping" ).validate({
			rules: {
				job_title: {
		      		required: true,
		      		
		    	},
		    	
		    	doc_folder: {
		      		required: true,
		    	},
		    	
			}
			
		});
	});

	$('#doc_folder').change(function(){

		var id = $('#doc_folder').val();

		var selected_option = $('#doc_name').find(':selected');
		$.ajax({
			type: "POST",
			url: '<?php echo base_url('admin_masters/map_document_job_position/find_docs_in_folder');?>',
			data: {folder_id:id},
			success:function(data) {
				/*console.log(data);*/
				if(data.success == "1") {
					var htm="";
					var doc_id_array = new Array();
					
					$.each(selected_option,function( i, option_element ){
						
						htm += "<option value='"+ option_element.value +"' selected>"+ option_element.text +"</option>";
						doc_id_array.push( option_element.value );
					});

					$.each(data.documents,function( i, doc ){
						if( jQuery.inArray( doc.document_id, doc_id_array ) === -1 ){
							htm += "<option value='"+ doc.document_id +"'>"+ doc.document_title +"</option>";
						}
					});
					
					$('#doc_name').html(htm);
					
				}
			},
			error:function()
			{
				alert('fail');
				//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
			}
		});
	});
</script>