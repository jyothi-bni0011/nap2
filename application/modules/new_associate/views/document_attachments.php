<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('/dashboard');?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?= $title; ?></li>
		</ol>
	</div>
</div>
<div><?php echo $this->session->flashdata('message');?></div>
<div class="row">
	<div class="col-md-12">
		<div class="card card-box">
			<div class="card-body ">
				<div class="table-scrollable">
					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
						<thead>
							<tr>
								<th>Sr No</th>
								<th>Attachment</th>
                                                               
							</tr>
						</thead>
						<tbody>
							<?php $i=1; foreach($doc_attachments as $doc_attachment): 
                                                            if($doc_attachment->type_id==2){?>
                                                                <tr class="odd gradeX">
								<td><?= $i++; ?></td>
                                                                <td><a href="<?php echo $doc_attachment->varname_value;?>"><?php echo $doc_attachment->varname;?></a></td>
								
							</tr>
                                                           <?php }?>
							
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

					