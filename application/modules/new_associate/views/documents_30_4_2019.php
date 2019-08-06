<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">New Associate Documents</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">New Associate Documents</li>
		</ol>
	</div>
</div>
<?php echo $message; ?>
<div class="card card-box">
	<div class="card-body ">
		<div class="table-scrollable">
			<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20">
				<thead>
					<tr>
						<th width="50">Sr No</th>
						<th width="25%">Document/Form</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if( ! empty($documents) ): ?>
					<?php $i=1; foreach ($documents as $document): ?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td width="50%">
							<?php if( $document->form_step_role_id === $this->session->userdata('role_id') ): ?>
								<?php if( $_GET ): ?>
									<?php if ( $_GET['r'] == 'view' ): ?>
										<a href="<?php echo base_url('document/generate/index/' . $document->document_id . '/' . $document->user_id .'?r=view' ); ?>"><?php echo $document->document_title; ?></a>
									<?php else : ?>
										<a href="<?php echo base_url('document/generate/index/' . $document->document_id . '/' . $document->user_id .'?r=dashboard' ); ?>"><?php echo $document->document_title; ?></a>
									<?php endif; ?>
								<?php else: ?>
									<a href="<?php echo base_url('document/generate/index/' . $document->document_id . '/' . $document->user_id ); ?>"><?php echo $document->document_title; ?></a>
								<?php endif; ?>
							<?php else: ?>
								<?php echo $document->document_title; ?>
							<?php endif; ?>
							
							<div style="font-size: 13px;">
                                <?php if( array_key_exists( $document->{DOCUMENT_ID}, $field_steps ) ) : ?>
                                <strong>Form Steps:</strong>
                                    <?php foreach($field_steps[$document->{DOCUMENT_ID}] as $field): ?>    <?php foreach($field as $fields): 	?>
                                        	<?php echo $fields->form_step.'. '.$fields->role_name; ?> | 
                                    	<?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
							
						</td>
						<td>
							<?php if( array_key_exists($document->status, $document_statuses) ): ?>
								<?php echo $document_statuses[$document->status]; ?>
							<?php else: ?>
								Unknown	
							<?php endif; ?>
						</td>
						<td>
							<?php if( $document->status == 2 || $document->status == 4 && $document->file_url ): ?>
								<a href="<?php echo base_url('new_associate/view/' . $document->user_id . '/' . $document->document_id); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
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