<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- <div class="row">
	<div class="col-md-3">
		<div class="card">
			<div class="card-body">
				<div class="form-group">
				    <label for="template">Template</label>
				    <select name="template" class="form-control">
				    	<option value="0">Select</option>
				    	<?php //if( ! empty($documents) ): foreach ($documents as $document): ?>
				    	<option value="<?php //echo $document->document_id; ?>">
				    		<?php //echo $document->document_title; ?>
			    		</option>
					    <?php //endforeach; endif; ?>
				    	<option value="new">New Template</option>
					</select>
				</div>
				<div class="form-group">
					<label for="document_title">Document Title</label>
					<input type="text" class="form-control" name="document_title" placeholder="Document Title">
				</div>
				<div class="form-group mb-0">
					<button type="submit" class="btn btn-primary btn-block">Create Template</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		
	</div>
</div> -->

<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?= $title; ?></div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url();?>/Dashboard">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>

                                <!--<li><a class="parent-item" href="<?php //echo base_url();?>/Sites/manage/1">HR Admin</a>&nbsp;<i class="fa fa-angle-right"></i>

                                </li> -->

                                <li class="active"><?= $title; ?></li>

                            </ol>

                        </div>

                    </div>

                    <div><?php echo $this->session->flashdata('message');?></div>

                    <div class="row">

                    	<div class="col-md-12">

                    		<div class="card  card-box">

                    			<div class="card-body ">

                    				<a href="<?php echo base_url('document/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Create Documents </button></a>

                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th>Sr No</th>
                    								<th width="25%"> Document Category </th>
                    								<th> Document Folder   </th>
                    								<th> Document Name   </th>
                                                 	<th> Status   </th>
                                                 	<th> Action </th> 
                                             </tr>
                                         </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($documents as $document): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++;?></td>
                                         			<td><?php echo $document->{DOCUMENT_CATEGORY_NAME}; ?></td>
                                         			<td><?php echo $document->{DOCUMENT_FOLDER_NAME}; ?></td>
                                         			<td><?php echo $document->{DOCUMENT_TITLE}; ?></td>
                                         			<td><?php if($document->{STATUS} == 1) echo 'Active'; else echo "In-active"; ?> </td>
                                         			<td>
                                         				<a href="<?php echo base_url('document/update/index/').$document->{DOCUMENT_ID};?>" class="btn btn-success btn-tbl-edit btn-xs">
                                         					<i class="fa fa-pencil"></i>
                                         				</a>
                                     					<button class="btn btn-tbl-delete btn-circle del_doc_folder" data-doc_folder_id="<?php echo $document->{DOCUMENT_ID}; ?>" >
                                     						<i class="fa fa-trash-o "></i>
                                     					</button>
                                         			</td>
                                         		</tr>
                                         	<?php endforeach; ?>

                                         </tbody>
                                     </table>

                                 </div>

                             </div>

                         </div>

                     </div>

                 

             <!-- end page content -->

             <!-- start chat sidebar -->

         </div>

         <!-- end page container -->



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

         <div class="modal fade" id="delete_role" tabindex="-1" role="dialog">
         	<div class="modal-dialog modal-dialog-centered" role="document">
         		<div class="modal-content">
         			<div class="modal-body">
         				Are you sure you want to delete this record?
         			</div>
         			<div class="modal-footer">
         				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         				<button type="button" class="btn btn-danger doc_folder_id" data-id="">Delete</button>
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

         </script>



         <script type="text/javascript" >







         	$(document).ready(function(){


         		$('.del_doc_folder').on('click', function(){
         			
         			var id = $(this).attr('data-doc_folder_id');
         			
         			$('#delete_role').modal('show');

         			$('.doc_folder_id').attr('data-id', id);
         		});


         		$('.doc_folder_id').on('click', function(){
         			
         			var id = $(this).attr('data-id');
         			
         			$.ajax({
         				type: "POST",
         				url: '<?php echo base_url('document/delete');?>',
         				data: {doc_folder_id:id},
         				success:function(data) {
         					console.log(data);
         					if(data.success == "1") {
         						window.location.href = "<?php echo base_url('document'); ?>";
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



         					}

         					else {





         					}

         				},

         				error:function()

         				{

		//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");

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

		//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");

	}

});



         		});

         	});





         </script>						

		