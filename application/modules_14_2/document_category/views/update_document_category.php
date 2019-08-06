<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
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
				<form id="update_doc_category" method="POST" action="<?php echo base_url('document_category/updatedocumentcategory'); ?>" class="form-horizontal" autocomplete="off">
					<input type="hidden" name="doc_cat_id" value="<?= $doc_cat_id; ?>">
					<div class="form-body">
						<div class="form-group row">
							<label class="control-label col-md-3">Document Category
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="doc_category" id="doc_category" data-required="1" placeholder="Enter Document Category" class="form-control input-height" value="<?= $doc_cat_name; ?>"> 
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Description
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<textarea class="form-control" name="doc_description" id="doc_description" rows="3" placeholder="Enter Description"><?= $doc_cat_description; ?></textarea>
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
		$( "#update_doc_category" ).validate({
			rules: {
				doc_category: {
		      		required: true
		    	},
		    	doc_description: {
		      		required: true
		    	},
		    	
			}
			
		});
	});
</script>