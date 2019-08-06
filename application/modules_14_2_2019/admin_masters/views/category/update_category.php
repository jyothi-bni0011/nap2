<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="new-associates.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
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
				<form id="create_category" method="POST" action="<?php echo base_url('admin_masters/category/update_category/'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<input type="hidden" name="category_id" value="<?= $category_id; ?>">
						<div class="form-group row">
							<label class="control-label col-md-3">Category
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="category_name" data-required="1" placeholder="Enter Category Name" class="form-control input-height" value="<?= $category_name; ?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Category Description
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<textarea class="form-control" name="category_description" rows="3" placeholder="Enter Category Description"><?= $category_description; ?></textarea>
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
		$( "#create_category" ).validate({
			rules: {
				category_name: {
		      		required: true,
		      		maxlength: 50
		    	},
		    	category_description: {
		      		required: true,
		      		maxlength: 255
		    	}
			}
			
		});
	});
</script>