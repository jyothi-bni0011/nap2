<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?= $title; ?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<form id="update_department" method="POST" action="<?php echo base_url('department/updatedepartment'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<input type="hidden" name="department_id" value="<?= $department_id; ?>">
						
						<div class="form-group row">
							<label class="control-label col-md-3">Organizational Unit
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select name="org_unit" class="form-control input-height" id="org_unit">
									<option value="">Select Organizational Unit</option>
									<?php foreach($org_units as $org_unit): ?>
			                           <option value="<?php echo $org_unit->{ORGANIZATIONAL_UNIT_ID}; ?>" <?php if( $selected_org_unit == $org_unit->{ORGANIZATIONAL_UNIT_ID} ) echo 'selected'; ?> > <?php echo $org_unit->{ORGANIZATIONAL_UNIT_NAME}; ?> </option>
		                       		<?php endforeach; ?>
								</select> 
							</div>
						</div>
						
						<div class="form-group row">
							<label class="control-label col-md-3">Functional Area
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select name="functional_area" class="form-control input-height" id="functional_area">
									<option value="">Select Functional Area</option>
									<?php foreach($fun_area_list as $fun_area): ?>
			                           <option value="<?php echo $fun_area->{FUNCTIONAL_AREA_ID}; ?>" <?php if( $selected_fun_area == $fun_area->{FUNCTIONAL_AREA_ID} ) echo 'selected'; ?> > <?php echo $fun_area->{FUNCTIONAL_AREA_NAME}; ?> </option>
		                       		<?php endforeach; ?>
								</select> 
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Department
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="department_name" data-required="1" placeholder="Enter Department Name" class="form-control input-height" value="<?= $department_name; ?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Department Description
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<textarea class="form-control" name="department_description" rows="3" placeholder="Enter Department Description"><?= $department_description; ?></textarea>
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
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#update_department" ).validate({
			rules: {
				org_unit: {
					required: true,
				},
				department_name: {
		      		required: true,
		      		maxlength: 50
		    	},
		    	department_description: {
		      		required: true,
		      		maxlength: 255
		    	},
		    	functional_area: {
		      		required: true,
		    	},
			}
			
		});
		
		$('#org_unit').on('change', function(){

          table   = 'functional_area';
          column  = 'org_unit_id';
          value   = $(this).val();
	          
	      $.ajax({
	        type: "POST",
	        url: '<?php echo base_url('new_associate/get_organizational_hierarchy');?>',
	        data: { table : table,
	                column : column,
	                id : value
	              },
	        success:function(data) {
	          console.log(data);
	          if(data.success == "1") {
	            var htm="";
                htm += "<option value=''>Select Functional Area</option>";
                $.each(data.result,function( i, fun_area ){  
                  htm += "<option value='"+ fun_area.fun_area_id +"'>"+ fun_area.fun_area_name +"</option>";
                });
                $('#functional_area').html(htm);
                
	          }
	        },
	        error:function()
	        {
	        }
	      });

	    });
	});
</script>