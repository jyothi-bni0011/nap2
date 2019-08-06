<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?php echo base_url("assets/tinymce/tinymce.min.js"); ?>"></script>
		<div><?php echo $this->session->flashdata('message');?></div>
<div class="row">
	
	<div class="col-md-12">
		<form class="card form-horizontal" method="post" action="<?php echo current_url(); ?>" autocomplete="off" id="create-template" autocomplete="off">
			<input type="hidden" name="template_id" value="<?php echo $template->{EMAIL_TEMPLATE_ID}; ?>">
			<div class="card-body">

				<div class="form-group row">
					<label class="control-label col-md-3">Subject
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<input type="text" name="subject" class="form-control input-height" value="<?php echo $template->template_subject; ?>" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Body
						<span class="required"> * </span>
						<div class="card card-primary border-0">
							<div class="card-header bg-danger"><span class="card-title">Available variables</span></div>
							<ul class="list-group" id="available-variable">
								<?php foreach ($variables as $variable => $value): ?>
								<a href="javascript:return false;" class="active-variable list-group-item list-group-item-action border-0" data-field_name="<?php echo $variable; ?>" data-varname="<?php echo $variable; ?>">
									<?php echo $variable; ?>
								</a>
								<?php endforeach;  ?>
							</ul>
						</div>
					</label>

					<div class="col-md-9">
						<textarea name="body" name="" id="body" cols="30" rows="10">
							<?php echo $template->template_body; ?>
						</textarea>
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
<div class="modal fade" id="var_create_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content" id="modal-form" method="post" action="<?php echo base_url('document/variables'); ?>" autocomplete="off">
			<div class="modal-header bg-danger">
				<h5 class="modal-title m-0">Document Variable</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="" class="small">Field Name</label>
					<input type="text" name="field_name" value="" class="form-control" placeholder="Field Name" required>
				</div>
				<div class="form-group">
					<label for="" class="small">Variable</label>
					<input type="text" name="varname" placeholder="Variable" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="" class="small">Select Role</label>
					<select name="role_id" class="form-control">
						<?php foreach($roless as $role):?>
							<option value="<?= $role->{ROLE_ID}; ?>"><?= $role->{ROLE_NAME}; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="form_steps_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content form-horizontal" id="modal-form" method="post" action="" autocomplete="off">
			<div class="modal-header bg-danger">
				<h5 class="modal-title m-0">Assign Form Steps</h5>
			</div>
			<div class="modal-body">
				<div class="form-row align-items-center mb-3">
					<label for="" class="col-md-4 col-form-label text-right">Form Step</label>
					<div class="col-md-6">
						<select name="form_steps_role[]" class="form-control">
							<?php foreach($roless as $role):?>
								<option value="<?= $role->{ROLE_ID}; ?>"><?= $role->{ROLE_NAME}; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</form>
	</div>
</div>
<style>
	.margin-1 { margin: 1px 0 0 0; }
	.list-group .list-group-item { text-align: left; }
</style>