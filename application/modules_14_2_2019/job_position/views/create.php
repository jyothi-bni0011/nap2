<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Job Title</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="new-associates.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Job Title</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<form id="create_job_position" method="POST" action="<?php echo base_url('job_position/create'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<div class="form-group row">
							<label class="control-label col-md-3">Job Title Code
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="job_code" id="job_code" data-required="1" placeholder="Enter Job Title Code" class="form-control input-height" value="<?php echo set_value('job_code'); ?>"> 
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Job Title Description
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<textarea class="form-control" name="job_description" id="job_description" rows="3" placeholder="Enter Job Title Description"><?php echo set_value('job_description'); ?></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Functional Area
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select name="department" class="form-control input-height" id="department">
									<option value="">Select Functional Area</option>
									<?php foreach($departments as $department): ?>
			                           <option value="<?php echo $department->{FUNCTIONAL_AREA_ID}; ?>"> <?php echo $department->{FUNCTIONAL_AREA_NAME}; ?> </option>
		                       		<?php endforeach; ?>
								</select> 
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<button type="submit" class="btn btn-danger">Create</button>
									<button type="button" class="btn btn-default">Cancel</button>
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
		$( "#create_job_position" ).validate({
			rules: {
				job_code: {
		      		required: true
		    	},
		    	job_description: {
		      		required: true
		    	},
		    	department: {
		      		required: true
		    	}
			}
			
		});
	});
</script>