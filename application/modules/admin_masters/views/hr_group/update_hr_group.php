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
				<form id="update_hr_group" method="POST" action="<?php echo base_url('admin_masters/hr_group/update_hr_group'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<input type="hidden" name="group_id" value="<?= $group_id; ?>">
						<div class="form-group row">
							<label class="control-label col-md-3">HR Group
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="group_name" data-required="1" placeholder="Enter Group Name" class="form-control input-height" value="<?= $group_name; ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Group Description
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<textarea class="form-control" name="group_description" rows="3" placeholder="Enter Group Description"><?= $group_description; ?></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Functional Area
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select name="functional_area" class="form-control input-height" id="functional_area">
									<option value="">Select Functional Area</option>
									<?php foreach($functional_areas as $functional_area): ?>
			                           <option value="<?php echo $functional_area->{FUNCTIONAL_AREA_ID}; ?>" <?php if ($functional_area->{FUNCTIONAL_AREA_ID}==$fun_area) echo 'selected'; ?> > <?php echo $functional_area->{FUNCTIONAL_AREA_NAME}; ?> </option>
		                       		<?php endforeach; ?>
								</select> 
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Members
								<span class="required">  </span>
							</label>
							<div class="col-md-5">
								<select class="form-control input-height select2" name="members[]" id="members" multiple>
                                   <option value="">Select Members </option>
		                       		<?php foreach($members as $member): ?>
		                           		<option value="<?php echo $member->{USER_ID}; ?>"<?php foreach($mapped_members as $user): ?> <?php if ($member->{USER_ID}==$user->{USER_ID}) echo 'selected'; ?> <?php endforeach; ?> > <?php echo $member->{USER_FIRST_NAME}.' '.$member->{USER_LAST_NAME}; ?> </option>
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
		$( "#create_hr_group" ).validate({
			rules: {
				group_name: {
		      		required: true,
		      		maxlength: 50
		    	},
		    	group_description: {
		      		required: true,
		      		maxlength: 255
		    	},
		    	functional_area: {
		      		required: true,
		    	},
		    	members: {
		      		required: true,
		    	},
			}
			
		});
	});
</script>