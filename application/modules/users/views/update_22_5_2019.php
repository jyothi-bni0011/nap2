<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Users</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
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
				<form method="POST" id="update_user" action="<?php echo base_url('users/update'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

						<div class="form-group row">
							<label class="control-label col-md-3">Username
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_name" data-required="1" placeholder="Enter Username" class="form-control input-height" value="<?php echo $user_name; ?>" data-msg-required="Username is required.">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">First Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_first_name" data-required="1" placeholder="Enter First Name" class="form-control input-height" value="<?php echo $user_first_name; ?>" data-msg-required="First Name is required.">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Last Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_last_name" data-required="1" placeholder="Enter Last Name" class="form-control input-height" value="<?php echo $user_last_name; ?>" data-msg-required="Last Name is required.">
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
                                   		<?php if($role->{ROLE_ID} != 4) : ?>
		                           			<option value="<?php echo $role->{ROLE_ID}; ?>"<?php foreach($user_roles as $user_role): ?> <?php if ($role->{ROLE_ID}==$user_role->{ROLE_ID}) echo 'selected'; ?> <?php endforeach; ?> > <?php echo $role->{ROLE_NAME}; ?> </option>
		                           		<?php endif; ?>
		                           <?php endforeach; ?>
                                </select> 

                                <label id="user_role-error_custome" class="error" style="display: none;">Role is required.</label>

							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Email
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_email" data-required="1" placeholder="Enter Email ID" class="form-control input-height" value="<?php echo $email_id; ?>" data-msg-required="Email is required.">
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
		$( "#update_user" ).validate({
			rules: {
				user_name: {
		      		required: true,
		      		minlength: 4
		    	},
		    	user_email: {
		    		required: true,
		    		email: true
		    	},
				user_first_name: {
					required: true
				},
				user_last_name: {
					required: true
				}
			}
			
		});



		$( "#update_user" ).on('submit', function(e){
			
			var album_text = [];
			$("select[name='user_role[]']").each(function() {
			    var value = $(this).val();
			    if (value != '') {
			        album_text.push(value);
			    }
			});
			    	
			if (album_text.length === 0) {
			    console.log('field is empty');
			    $( "#user_role-error_custome" ).show();
			    $( "#user_role-error_custome" ).text('Role is required.');
			    e.preventDefault();
			}

		});
		
		$('#user_role').on('change',function(){
			var album_text = [];
			$("select[name='user_role[]']").each(function() {
			    var value = $(this).val();
			    if (value != '') {
			        album_text.push(value);
			    }
			});
			    	
			if (album_text.length === 0) {
			    //console.log('field is empty');
			    $( "#user_role-error_custome" ).show();
			    $( "#user_role-error_custome" ).text('Role is required.');
			}
			else
			{
				$( "#user_role-error_custome" ).hide();
			    $( "#user_role-error_custome" ).text('');	
			}
		});
	});
</script>