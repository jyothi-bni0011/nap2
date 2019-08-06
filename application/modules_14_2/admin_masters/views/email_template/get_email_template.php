<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url();?>/Dashboard">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
                        <li class="active"><?= $title; ?></li>
        </ol>
    </div>
</div>
<div><?php echo $this->session->flashdata('message');?></div>
<div class="row">
	<div class="col-md-12">
		<div class="card  card-box">
			<div class="card-body ">
				
				<div class="table-scrollable">
					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
						<thead>
							<tr>
                                <th>Sr No</th>
								<th width="25%"> Subject </th>
								<th> Description </th>
                                <th> Action </th> 
                            </tr>
                        </thead>
                        <tbody>
                     	<?php $i=1; foreach($templates as $template): ?>
                     		<tr class="odd gradeX">
                                <td><?= $i++;?></td>
                     			<td><?php echo $template->{EMAIL_TEMPLATE_SUBJECT}; ?></td>
                     			<td><?php echo $template->{EMAIL_TEMPLATE_DESCRIPTION}; ?></td>
                     			<td>
                     				<a href="<?php echo base_url('admin_masters/email_template/update_email_template/').$template->{EMAIL_TEMPLATE_ID};?>" class="btn btn-success btn-tbl-edit btn-xs">
                     					<i class="fa fa-pencil"></i>
                     				</a>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog">
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
<div class="modal fade" id="act_exampleModalCenter" tabindex="-1" role="dialog">
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
<div class="modal fade" id="delete_role" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Are you sure you want to delete this record?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger category_id" data-id="">Delete</button>
			</div>
		</div>
	</div>
</div>

<script>
	
    function getproductid(id){	
		$("#site_id").val(id);	
	}
	function act_getproductid(id){	
		$("#act_site_id").val(id);	
	}

	$(document).ready(function(){
		$('.del_category').on('click', function(){
			var id = $(this).attr('data-category_id');
			$('#delete_role').modal('show');
			$('.category_id').attr('data-id', id);
		});

		$('.category_id').on('click', function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type: "POST",
				url: '<?php echo base_url('admin_masters/category/delete_category');?>',
				data: {category_id:id},
				success:function(data) {
					console.log(data);
					if(data.success == "1") {
						window.location.href = "<?php echo base_url('admin_masters/category'); ?>";
					}
				},
				error:function()
				{
				    //$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
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
					} else {

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
					} else {

					}
				},
				error:function()
				{
        		  //$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
            	}
            });
		});
	});
</script>						