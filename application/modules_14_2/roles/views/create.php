<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Role</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Roles</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<form id="create_role" method="POST" action="<?php echo base_url('roles/create'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						
						<div class="form-group row">
							<label class="control-label col-md-3">Role name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="role_name" data-required="1" placeholder="Enter Role Name" class="form-control input-height" value="<?php echo set_value('role_name'); ?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Role Description
								<span class="required">  </span>
							</label>
							<div class="col-md-5">
								<textarea class="form-control" name="role_description" rows="3" placeholder="Enter Role Description"><?php echo set_value('role_description'); ?></textarea>
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
		$( "#create_role" ).validate({
			rules: {
				role_name: {
		      		required: true
		    	}
			}
			
		});
	});
</script>