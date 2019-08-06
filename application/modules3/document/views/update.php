<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?php echo base_url("assets/tinymce/tinymce.min.js"); ?>"></script>
<div class="row">
	
	<div class="col-md-12">
		<?php if( $message ) echo $message; ?>
		<form class="card" method="post" action="<?php echo current_url(); ?>" autocomplete="off" id="create-template" autocomplete="off">
			<input type="hidden" name="document_id" value="<?php echo $document->document_id; ?>">
			<div class="card-body">
				<div class="form-group row">
					<label class="control-label col-md-3">Document Category
						<span class="required"> * </span>
					</label>
					<div class="col-md-5">
						<select class="form-control input-height" name="doc_category" id="doc_category">
                           <option value="">Select Document Category </option>
                           <?php foreach($doc_categories as $doc_category): ?>
	                           <option value="<?php echo $doc_category->{DOCUMENT_CATEGORY_ID}; ?>" <?php if($doc_category->{DOCUMENT_CATEGORY_ID} == $document->{DOCUMENT_CATEGORY_ID}) echo 'selected'; ?> > <?php echo $doc_category->{DOCUMENT_CATEGORY_NAME}; ?> </option>
                       		<?php endforeach; ?>
                        </select> 
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Document Folder
						<span class="required"> * </span>
					</label>
					<div class="col-md-5">
						<select class="form-control input-height" name="doc_folder" id="doc_folder">
                           <option value="">Select Document Folder </option>
                           <?php foreach($doc_folders as $doc_folder): ?>
	                           <option value="<?php echo $doc_folder->{DOCUMENT_FOLDER_ID}; ?>" <?php if($doc_folder->{DOCUMENT_FOLDER_ID} == $document->{DOCUMENT_FOLDER_ID}) echo 'selected'; ?> > <?php echo $doc_folder->{DOCUMENT_FOLDER_NAME}; ?> </option>
                       		<?php endforeach; ?>
                        </select> 
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-md-3">Status
						<span class="required"> * </span>
					</label>
					<div class="col-md-5">
						<select class="form-control input-height" name="status" id="status">
                           <option value="">Select Document Folder </option>
                           <option value="1" <?php if($document->{STATUS} == 1) echo 'selected'; ?> >Active </option>
                           <option value="0" <?php if($document->{STATUS} == 0) echo 'selected'; ?>>In-active </option>
                        </select> 
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-3">Document Name
						<span class="required"> * </span>
					</label>
					<div class="col-md-5">
						<input type="text" name="document_title" class="form-control" value="<?php echo $document->document_title; ?>" required>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-12">Document Form / Template
						<span class="required"> * </span>
					</label>
					<div class="col-md-3">
						<div class="card card-primary border-0">
							<div class="card-header bg-danger"><span class="card-title">Available variables</span></div>
							<ul class="list-group" id="available-variable">
								<?php if( ! empty($variables) ): foreach ($variables as $variable): ?>
								<a href="javascript:return false;" class="active-variable list-group-item list-group-item-action border-0" data-field_name="<?php echo $variable->field_name; ?>" data-varname="<?php echo $variable->varname; ?>">
									<?php echo $variable->varname; ?><span class="badge badge-primary badge-pill"><?php echo $roles[$variable->role_id]; ?></span>
								</a>
								<?php endforeach; endif; ?>
								<a href="javascript:return false;" id="var_create" class="list-group-item list-group-item-action border-0">Create / Manage Variables</a>
							</ul>
						</div>
					</div>
					<div class="col-md-8">
						<textarea name="document" name="" id="" cols="30" rows="10">
							<?php echo $document->document_template; ?>
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
						<!-- <option value="1">HR Admin</option>
						<option value="2">HR Manager</option>
						<option value="3">HR Associate</option>
						<option value="4">New Associate</option> -->
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