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
				<form id="assign_doc" method="POST" action="<?php echo base_url('document/assign_document'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<?php foreach ($associate as $key => $info ): ?>
							<input type="hidden" name="<?= $key; ?>" value="<?= $info; ?>" >
						<?php endforeach; ?>
						<div class="form-group row">
							<label class="control-label col-md-3">Documents
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php foreach( $documents as $document ): ?>
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" class="form-check-input" name="documents[]" value="<?= $document->{DOCUMENT_ID} ?>"><?= $document->{DOCUMENT_TITLE} ?>
									  </label>
									</div>
								<?php endforeach; ?>
								<label id="user_role-error_custome" style="display: none; color: red;">Please select at least 1 document.</label>
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
		$( "#assign_doc" ).validate({
			rules: {
				documents: {
		      		required: true,
		      		maxlength: 50
		    	}
			}
			
		});
	});

	$("#assign_doc").on('submit', function(e){
		var album_text = [];
		$("input[name='documents[]']").each(function() {
		    var value = $(this).prop('checked');
		    if (value != '') {
		        album_text.push(value);
		    }
		});
		    	
		if (album_text.length === 0) {
		    //console.log('field is empty');
		    $( "#user_role-error_custome" ).show();
		    $( "#user_role-error_custome" ).text('Please select at least 1 document.');
		    e.preventDefault();
		}
	});
</script>