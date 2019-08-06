<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Move Verified Documents</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Move Documents</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div class="card card-box">
			<div class="card-body">
				<?php if( is_array($documents) AND count($documents) ): ?>
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#move_verified_document"><i class="fa fa-folder"></i>Move Verified Documents</a>
				<?php endif; ?>
				<div class="table-scrollable">
					<table class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                		<thead>
							<tr>
                                <th class="pl-3">No.</th>
                                <th>Username</th>
                                <th>Job Title</th>
                                <th>Department</th>
                                <th>Functional Area</th>
                                <th>Organizational Unit</th>
                                <th>Documents</th>
                         	</tr>
						</thead>
                        <tbody>
                            <?php if( ! empty($documents) ): ?>
                            <?php $i=1; foreach ($documents as $document): ?>
                            <tr>
                                <td class="pl-3"><?php echo $i++; ?></td>
                                <td><?php echo $document->associate_username; ?></td>
                                <td><?php echo $document->{JOB_POSITION_CODE}; ?></td>
                                <td><?php echo $document->{DEPARTMENT_NAME}; ?></td>
                                <td><?php echo $document->{FUNCTIONAL_AREA_NAME}; ?></td>
                                <td><?php echo $document->{ORGANIZATIONAL_UNIT_NAME}; ?></td>
                                <td class="text-center">
                                    <?php if( $document->status == 4 ): ?>
                                        <a href="<?php echo base_url('new_associate/view/' . $document->user_id . "/" . $document->{DOCUMENT_ID}); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                                </td>
							</tr>
							<?php endforeach; ?>
							<?php endif; ?>
                     	</tbody>
                 	</table>
             	</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="move_verified_document" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content form-horizontal" id="modal-form" method="post" action="" autocomplete="off">
			<?php foreach ($documents as $document): ?>
				<input type="hidden" name="user_ids[]" value="<?php echo $document->user_id; ?>">
			<?php endforeach; ?>
			<div class="modal-header bg-danger">
				<h5 class="modal-title m-0">Move Verified Files</h5>
			</div>
			<div class="modal-body">
				<div class="form-row align-items-center mb-3">
					<label for="" class="col-md-4 col-form-label text-right">Move to Folder</label>
					<div class="col-md-6">
						<input type="text" name="folder_url" value="D:\" class="form-control">
					</div>
				</div>
			</div>
			<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Start Moving</button>
			</div>
		</form>
	</div>
</div>