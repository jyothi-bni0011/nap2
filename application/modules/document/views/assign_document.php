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

						
						<div class="row">
							<div class="col-md-9">
							<?php foreach( $documents as $doc_category_id => $document ): ?>
							<!-- for categories -->
							<?php if( $doc_category_id != 1 ): ?>
								
									<div class="panel panel-default">
										<div class="panel-heading">
											<?= $documents[$doc_category_id][0]->{DOCUMENT_CATEGORY_NAME}; ?>
											<div style="float: right;">
												<input type="checkbox" class="form-check-input select_all" id="<?= $documents[$doc_category_id][0]->{DOCUMENT_CATEGORY_ID}; ?>" checked>Select All
											</div>
										</div>
										<div class="panel-body">
											<div class="row">	
												<?php foreach( $document as $key => $doc ):?>
													<?php if( $doc->{DOCUMENT_ID} ): ?>
													<div class="col-md-4">
														<div class="form-check">
														  <label class="form-check-label">
														    <input type="checkbox" class="form-check-input <?= $documents[$doc_category_id][0]->{DOCUMENT_CATEGORY_ID}; ?>" name="documents[]" value="<?= $doc->{DOCUMENT_ID} ?>" checked><?= $doc->{DOCUMENT_TITLE} ?>
														  </label>
														</div>
													</div>
													<?php else: ?>
													<div class="col-md-12">No Document Found</div>
													<?php endif; ?>
												<?php endforeach; ?>
											</div>
										</div>
									</div>
								
								<?php endif; ?>
							<?php endforeach; ?>
							</div>

							<!-- Optional category -->
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-default">
											<?php foreach( $documents as $doc_category_id => $document ): ?>
												<?php if( $doc_category_id == 1 ): ?>
												<div class="panel-heading">
													<?= $documents[$doc_category_id][0]->{DOCUMENT_CATEGORY_NAME}; ?>
													<div style="float: right;">
														<input type="checkbox" class="form-check-input select_all" id="<?= $documents[$doc_category_id][0]->{DOCUMENT_CATEGORY_ID}; ?>">Select All
													</div>
												</div>
												<div class="panel-body">
													<?php foreach( $document as $key => $doc ):?>
														<?php if( $doc->{DOCUMENT_ID} ): ?>
															<div class="form-check">
															  <label class="form-check-label">
															    <input type="checkbox" class="form-check-input <?= $documents[$doc_category_id][0]->{DOCUMENT_CATEGORY_ID}; ?>" name="documents[]" value="<?= $doc->{DOCUMENT_ID} ?>" ><?= $doc->{DOCUMENT_TITLE} ?>
															  </label>
															</div>
														<?php else: ?>
															<div class="col-md-12">No Document Found</div>
														<?php endif; ?>
													<?php endforeach; ?>
												</div>
												<?php endif; ?>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="row">
					  		<label id="user_role-error_custome" style="display: none; color: red;">Please select at least 1 document.</label>
					  	</div>
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-5 col-md-7">
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
<style type="text/css">
	.panel-default>.panel-heading {
	    color: #333;
	    background-color: #f5f5f5;
	    border-color: #ddd;
	}
</style>
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
	
	$('.select_all').click(function(){
		var id = '.' + $(this).attr('id');
		if ($(this).is(':checked')) {
			$(id).prop("checked", true);
        	// $(id).attr('checked','checked');
	    } else {
	        $(id).prop('checked',false);
	        // $(id).attr('checked',false);
	    }
	});

	
</script>