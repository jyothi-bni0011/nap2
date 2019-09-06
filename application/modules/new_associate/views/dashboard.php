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
								<th width="50%">Document/Form</th>
                                                                <th>Document Category</th>
								<th>Status</th>
								<th>Document</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; foreach($associate_docs as $associate_doc): ?>
							<tr class="odd gradeX">
								<td><?= $i++; ?></td>
								<td>
									<?php if( $associate_doc->form_step_role_id === $this->session->userdata('role_id') ): ?>
										
											<a href="<?php echo base_url('document/generate/index/' . $associate_doc->document_id . '/' . $associate_doc->user_id ); ?>"><?php echo $associate_doc->document_title; ?></a>
										
									<?php else: ?>
										<?php echo $associate_doc->document_title; ?>
									<?php endif; ?>
								</td>
                                                                <td><?php echo $associate_doc->doc_category_name;?></td>
								<td>
									<?php if( array_key_exists($associate_doc->status, $document_statuses) ): ?>
										<?php echo $document_statuses[$associate_doc->status]; ?>
									<?php else: ?>
										Unknown	
									<?php endif; ?>
								</td>
								<td>
									
									<?php if( $associate_doc->status == 2 & $associate_doc->document_type == 1 || $associate_doc->status == 4 && $associate_doc->file_url || $associate_doc->status == 2 & $associate_doc->document_type == 2 ): ?>
										<a title="Document" href="<?php echo base_url('new_associate/view/' . $associate_doc->user_id . '/' . $associate_doc->document_id); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                                                                <?php if($associate_doc->variable_types !=""){
                                                                                    $var_type_arr=explode(',',$associate_doc->variable_types);
//                                                                                    print_r($var_type_arr);
                                                                                    if(in_array(2,$var_type_arr)){ ?>
                                                                                   <a title="Document Attachments" href="<?php echo base_url('new_associate/docAttachments/' . $associate_doc->document_id . '/' . $associate_doc->user_id); ?>" class="btn bg-primary p-2 btn-circle"><i class="fa fa-paperclip" aria-hidden="true"></i></a>

                                                                                   
                                                                                 <?php } }?>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Are you sure you want to deactivate this record?
			</div>
			<div class="modal-footer">
				<form method="post">
					<input type="hidden" name="site_id" id="site_id" value="">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" id="site_submit" class="btn btn-danger">Deactivate</button>
				</form>
			</div>
		</div>
	</div>
</div>	

<div class="modal fade" id="act_exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Are you sure you want to activate this record?
			</div>
			<div class="modal-footer">
				<form method="post">
					<input type="hidden" name="act_site_id" id="act_site_id" value="">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" id="act_site_submit" class="btn btn-success">Activate</button>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="delete_user" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Are you sure you want to delete this record?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger associate_id" data-id="">Delete</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" >

	function getproductid(id){	
		$("#site_id").val(id);	
	}

	function act_getproductid(id){	
		$("#act_site_id").val(id);	
	}

	function call_upload_file()
	{
		$("#upload_file").click();
	}

	$(document).ready(function(){
		var file_msg = '<i>(Max file size : <?php echo ini_get('upload_max_filesize'); ?> )<i/>';
		
		$("#upload_file").change(function(){
			if ( this.files[0].size < 36700160 ) 
	    	{	
		        $('#file_info').html(file_msg);
				$("#upload_file_form").submit();
	    	}
	    	else
	    	{
	    		$('#file_info').html('<i style="color:red;">(Max file size exceeded.)<i/>');
	    	}
		});

		$('.del_associate').on('click', function(){
			var id = $(this).attr('data-associate_id');
			$('#delete_user').modal('show');
			$('.associate_id').attr('data-id', id);
		});
	
		$('.associate_id').on('click', function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type: "POST",
				url: '<?php echo base_url('new_associate/delete');?>',
				data: {associate_id:id},
				success:function(data) {
					console.log(data);
					if(data.success == "1") {
						window.location.href = "<?php echo base_url('new_associate'); ?>";
					}
				},
				error:function()
				{
					
				}
			});
		});

		$("#site_submit").click(function(e){
			e.preventDefault();
			var site_id= $("#site_id").val();
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>Sites/delete',
				data: {site_id:site_id},
				success:function(data)
				{
					if(data == "1")
					{
						window.location.href = "<?php echo base_url(); ?>Sites/manage/1";
					}
					else {
					}
				},
				error:function()
				{
				}
			});
		});

		$("#act_site_submit").click(function(e){
			e.preventDefault();
			var site_id= $("#act_site_id").val();
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>Sites/activate',
				data: {site_id:site_id},
				success:function(data)
				{
					if(data == "1")
					{
						window.location.href = "<?php echo base_url(); ?>Sites/manage/1";
					}
					else {
					}
				},
				error:function()
				{
					
				}
			});

		});
	});


</script>						