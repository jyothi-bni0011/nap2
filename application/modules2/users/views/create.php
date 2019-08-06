<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Users</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="new-associates.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Users</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<form id="create_user" method="POST" action="<?php echo base_url('users/create'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						
						<div class="form-group row">
							<label class="control-label col-md-3">Username
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_name" data-required="1" placeholder="Enter Username" class="form-control input-height" value="<?php echo set_value('user_name'); ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">First Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_first_name" data-required="1" placeholder="Enter First Name" class="form-control input-height" value="<?php echo set_value('user_first_name'); ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Last Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_last_name" data-required="1" placeholder="Enter Last Name" class="form-control input-height" value="<?php echo set_value('user_last_name'); ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Role
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select class="form-control input-height select2-multiple" name="user_role[]" id="user_role" multiple>
                                   <option value="">Select User Role </option>
                                   <?php foreach($roles as $role): ?>
			                           <option value="<?php echo $role->{ROLE_ID}; ?>"> <?php echo $role->{ROLE_NAME}; ?> </option>
		                       		<?php endforeach; ?>
                                </select> 
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Email
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_email" data-required="1" placeholder="Enter Email ID" class="form-control input-height" value="<?php echo set_value('user_email'); ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Password
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="password" id="password" name="password" data-required="1" placeholder="Enter Password" class="form-control input-height" value="<?php echo set_value('password'); ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Confirm Password
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="password" name="confirm_password" data-required="1" placeholder="Confirm Password" class="form-control input-height" value="<?php echo set_value('confirm_password'); ?>">
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
		$( "#create_user" ).validate({
			rules: {
				user_name: {
		      		required: true
		    	},
		    	user_email: {
		    		required: true,
		    		email: true
		    	},
				password: {
		      		required: true,
		      		minlength: 6
		    	},
				confirm_password: {
		      		required: true,
		      		equalTo: "#password"
		    	},
		    	user_first_name: {
					required: true
				},
				user_last_name: {
					required: true
				}
			}
			
		});


    	//$('#user_role').select2();
	});

</script>