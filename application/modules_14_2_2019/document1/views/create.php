<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?php echo base_url("assets/tinymce/tinymce.min.js"); ?>"></script>
<div class="row">
	<div class="col-md-12">
		<form class="card form-horizontal" method="post" action="<?php echo current_url(); ?>" id="create-template" autocomplete="off">
			<input type="hidden" name="variables[signature][field_name]" value="Signature">
			<input type="hidden" name="variables[signature][varname]" value="{signature}">
			<input type="hidden" name="variables[signature][role_id]" value="1">
			<div class="card-body">
				<div class="form-group row">
					<label class="control-label col-md-3">Document Category
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="doc_category" id="doc_category">
                           <option value="">Select Document Category </option>
                           <?php foreach($doc_categories as $doc_category): ?>
	                           <option value="<?php echo $doc_category->{DOCUMENT_CATEGORY_ID}; ?>"> <?php echo $doc_category->{DOCUMENT_CATEGORY_NAME}; ?> </option>
                       		<?php endforeach; ?>
                        </select> 
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Document Folder
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="doc_folder" id="doc_folder">
                           <option value="">Select Document Folder </option>
                           <?php foreach($doc_folders as $doc_folder): ?>
	                           <option value="<?php echo $doc_folder->{DOCUMENT_FOLDER_ID}; ?>"> <?php echo $doc_folder->{DOCUMENT_FOLDER_NAME}; ?> </option>
                       		<?php endforeach; ?>
                        </select> 
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-md-3">Status
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="status" id="status">
                           <option value="">Select Document Folder</option>
                           <option value="1">Active </option>
                           <option value="0">In-active </option>
                        </select> 
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Form Steps
						<span class="required">*</span>
					</label>
					<div class="col-md-9">
						<select class="form-control input-height" name="form_steps" id="status">
                           <option value="">Select Form Steps</option>
                           <option value="1">1 Step Form</option>
                           <option value="2">2 Step Form</option>
                        </select> 
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Document Name
						<span class="required"> * </span>
					</label>
					<div class="col-md-9">
						<input type="text" name="document_title" class="form-control input-height" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3 pt-0">
						<div class="card card-primary border-0">
							<div class="card-header bg-danger"><span class="card-title">System variables</span></div>
							<ul class="list-group border-0" id="system-variable">
								<a href="javascript:return false;" class="system-variable border-1 list-group-item list-group-item-action border-0" data-field_name="Signature" data-varname="{signature}">{signature}</a>
								<a href="javascript:return false;" class="system-variable border-1 list-group-item list-group-item-action border-0" data-field_name="Signature 2" data-varname="{signature_2}">{signature_2}</a>
							</ul>
						</div>
						<div class="card card-primary border-0">
							<div class="card-header bg-danger"><span class="card-title">Available variables</span></div>
							<ul class="list-group border-0" id="available-variable">
								<a href="#" class="no-variable border-0 list-group-item list-group-item-action">No variables are assigned for this document.</a>
								<a href="#" id="var_create" class="list-group-item list-group-item-action border-0">Create / Manage Variables</a>
							</ul>
						</div>
					</label>
					<div class="col-md-9">
						<textarea name="document" name="" id="" cols="30" rows="10" novalidate style="width:100%;"></textarea>
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
<div class="modal fade" id="var_create_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content" id="modal-form" method="post" action="" autocomplete="off">
			<div class="modal-header bg-danger">
				<h5 class="modal-title m-0">Document Variable</h5>
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
						<?php foreach($roles as $role):?>
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
							<?php foreach($roles as $role):?>
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