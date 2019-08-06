<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Dashboard</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Dashboard</li>
		</ol>
	</div>
</div>
<div class="state-overview">
	<div class="row">
		<div class="col-xl-3 col-md-3 col-12">
			<div class="info-box bg-white">
				<span class="info-box-icon push-bottom bg-orange"><i class="material-icons">tab</i></span>
				<div class="info-box-content">
					<span class="info-box-text">Email Sent</span>
					<span class="info-box-number"><?php echo number_format($statistics_associate_email_sent->total_count); ?></span>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-3 col-12">
			<div class="info-box bg-white">
				<span class="info-box-icon push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
				<div class="info-box-content">
					<span class="info-box-text">To Verify</span>
					<span class="info-box-number"><?php echo number_format($statistics_associate_verify->total_count); ?></span>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-3 col-12">
			<div class="info-box bg-white">
				<span class="info-box-icon push-bottom bg-info"><i class="material-icons">person</i></span>
				<div class="info-box-content">
					<span class="info-box-text">In Process</span>
					<span class="info-box-number"><?php echo number_format($statistics_hr_in_process->total_count); ?></span>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-3 col-12">
			<div class="info-box bg-white">
				<span class="info-box-icon push-bottom bg-success"><i class="material-icons">tab</i></span>
				<div class="info-box-content">
					<span class="info-box-text">Verified</span>
					<span class="info-box-number"><?php echo number_format($statistics_associate_verified->total_count); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-box">
            <div class="card-body " id="chartjs_bar_parent">
            	<div class="row">
            		<div class="col-md-6">
            			<select class="form-control" id="filter">
            				<option value="0">Select Filter</option>
            				<option value="1">Job Title</option>
            				<option value="2">Organizational Unit</option>
            				<option value="3">Functional Area</option>
            				<option value="4">Department</option>
            			</select>
            		</div>

            		<div class="col-md-6" id="job_title_drop" style="display: none;">
            			<select class="form-control column_name" id="position_id"><!-- ID IS COLUMN NAME IN DATABASE -->
            				<option value="0">Select Job Title</option>
            				<?php foreach ($job_titles as $job_title) : ?>
            					<option value="<?= $job_title->{JOB_POSITION_ID}; ?>"><?= $job_title->{JOB_POSITION_CODE}; ?></option>
            				<?php endforeach ?>
            			</select>
            		</div>

					<div class="col-md-6" id="org_unit_drop" style="display: none;">
            			<select class="form-control column_name" id="org_unit_id" ><!-- ID IS COLUMN NAME IN DATABASE -->
            				<option value="0">Select Organizational Unit</option>
            				<?php foreach ($org_units as $org_unit) : ?>
            					<option value="<?= $org_unit->{ORGANIZATIONAL_UNIT_ID}; ?>"><?= $org_unit->{ORGANIZATIONAL_UNIT_NAME}; ?></option>
            				<?php endforeach ?>
            			</select>
            		</div> 

					<div class="col-md-6" id="fun_area_drop" style="display: none;">
            			<select class="form-control column_name" id="fun_area_id" ><!-- ID IS COLUMN NAME IN DATABASE -->
            				<option value="0">Select Functional Area</option>
            				<?php foreach ($fun_areas as $fun_area) : ?>
            					<option value="<?= $fun_area->{FUNCTIONAL_AREA_ID}; ?>"><?= $fun_area->{FUNCTIONAL_AREA_NAME}; ?></option>
            				<?php endforeach ?>
            			</select>
            		</div>

            		<div class="col-md-6" id="dept_drop" style="display: none;">
            			<select class="form-control column_name" id="department_id" ><!-- ID IS COLUMN NAME IN DATABASE -->
            				<option value="0">Select Department</option>
            				<?php foreach ($departments as $department) : ?>
            					<option value="<?= $department->{DEPARTMENT_ID}; ?>"><?= $department->{DEPARTMENT_NAME}; ?></option>
            				<?php endforeach ?>
            			</select>
            		</div>

            	</div>
                <div class="row">
                    <canvas id="chartjs_bar" ></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-box">
	<div class="card-head">
		<header>HR To Process</header>
	</div>
	<div class="table-responsive">
		<table class="table display product-overview mb-30" id="support_table">
			<thead>
				<tr>
					<th class="pl-3">No.</th>
					
					<th>Username</th>
					<th>Job Title</th>
					<th>Department</th>
					<th>Functional Area</th>
					<th>Organizational Unit</th>
					<th>New Associate Progress</th>
					<th>Documents</th>
				</tr>
			</thead>
			<tbody>
				<?php if( ! empty($hr_in_process) ): ?>
				<?php $i=1; foreach ($hr_in_process as $associate): ?>
				<tr>
					<td class="pl-3"><?php echo $i++; ?></td>
					
					<td><?php echo $associate->associate_username; ?></td>
					<td><?php echo $associate->{JOB_POSITION_CODE}; ?></td>
					<td><?php echo $associate->{DEPARTMENT_NAME}; ?></td>
					<td><?php echo $associate->{FUNCTIONAL_AREA_NAME}; ?></td>
					<td><?php echo $associate->{ORGANIZATIONAL_UNIT_NAME}; ?></td>
					<td><?php echo $associate->total_documents-$associate->status_count.'/'.$associate->total_documents; ?></td>
					<td class="text-center">
						<?php if( $associate->status == 3 ): ?>
							<a href="<?php echo base_url('new_associate/documents/' . $associate->user_id . '?r=dashboard' ); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<div class="full-width text-center m-b-20">
		<a href="<?php echo base_url('dashboard/hr_to_process'); ?>" class="btn red btn-outline btn-circle margin-0">View All</a>
	</div>
</div>

<div class="card card-box">
	<div class="card-head">
		<header>HR Email Sent</header>
	</div>
	<div class="table-responsive">
		<table class="table display product-overview mb-30" id="support_table">
			<thead>
				<tr>
					<th class="pl-3">No.</th>
					
					<th>Username</th>
					<th>Job Title</th>
					<th>Department</th>
					<th>Functional Area</th>
					<th>Organizational Unit</th>
					<th>New Associate Progress</th>
					<th>Follow-Up Email</th>
				</tr>
			</thead>
			<tbody>
				<?php if( ! empty($associate_email_sent) ): ?>
				<?php $i=1; foreach ($associate_email_sent as $associate): ?>
				<tr>
					<td class="pl-3"><?php echo $i++; ?></td>
					
					<td><?php echo $associate->associate_username; ?></td>
					<td><?php echo $associate->{JOB_POSITION_CODE}; ?></td>
					<td><?php echo $associate->{DEPARTMENT_NAME}; ?></td>
					<td><?php echo $associate->{FUNCTIONAL_AREA_NAME}; ?></td>
					<td><?php echo $associate->{ORGANIZATIONAL_UNIT_NAME}; ?></td>
					<td><?php echo $associate->total_documents-$associate->status_count.'/'.$associate->total_documents; ?></td>
					<td class="text-center">
						<a href="<?php echo base_url('dashboard/send_follow_up_email/' . $associate->user_id ); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-envelope-o " aria-hidden="true"></i></a>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<div class="full-width text-center m-b-20">
		<a href="<?php echo base_url('dashboard/hr_email_sent'); ?>" class="btn red btn-outline btn-circle margin-0">View All</a>
	</div>
</div>

<div class="card card-box">
	<div class="card-head">
		<header>HR to Verify</header>
	</div>
	<div class="table-responsive">
		<table class="table display product-overview mb-30" id="support_table">
			<thead>
				<tr>
					<th class="pl-3">No.</th>
					
					<th>Username</th>
					<th>Job Title</th>
					<th>Department</th>
					<th>Functional Area</th>
					<th>Organizational Unit</th>
					<th>New Associate Progress</th>
					<th>Documents</th>
				</tr>
			</thead>
			<tbody>
				<?php if( ! empty($associate_verify) ): ?>
				<?php $i=1; foreach ($associate_verify as $associate): ?>
				<tr>
					<td class="pl-3"><?php echo $i++; ?></td>
					
					<td><?php echo $associate->associate_username; ?></td>
					<td><?php echo $associate->{JOB_POSITION_CODE}; ?></td>
					<td><?php echo $associate->{DEPARTMENT_NAME}; ?></td>
					<td><?php echo $associate->{FUNCTIONAL_AREA_NAME}; ?></td>
					<td><?php echo $associate->{ORGANIZATIONAL_UNIT_NAME}; ?></td>
					<td><?php echo $associate->total_documents-$associate->status_count.'/'.$associate->total_documents; ?></td>
					<td class="text-center">
						<?php if( $associate->status == 2 ): ?>
							<a href="<?php echo base_url('new_associate/documents/' . $associate->user_id ); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
						<?php endif; ?>
					</td>

					
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<div class="full-width text-center m-b-20">
		<a href="<?php echo base_url('dashboard/hr_to_verify'); ?>" class="btn red btn-outline btn-circle margin-0">View All</a>
	</div>
</div>

<div class="card card-box">
	<div class="card-head">
		<header>HR Verified</header>
	</div>
	<div class="table-responsive">
		<table class="table display product-overview mb-30" id="support_table">
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
				<?php if( ! empty($associate_verified) ): ?>
				<?php $i=1; foreach ($associate_verified as $associate): ?>
				<tr>
					<td class="pl-3"><?php echo $i++; ?></td>
					
					<td><?php echo $associate->associate_username; ?></td>
					<td><?php echo $associate->{JOB_POSITION_CODE}; ?></td>
					<td><?php echo $associate->{DEPARTMENT_NAME}; ?></td>
					<td><?php echo $associate->{FUNCTIONAL_AREA_NAME}; ?></td>
					<td><?php echo $associate->{ORGANIZATIONAL_UNIT_NAME}; ?></td>
					<td class="text-center">
						<?php if( $associate->status == 4 ): ?>
							<a href="<?php echo base_url('new_associate/documents/' . $associate->user_id ); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
						<?php endif; ?>
					</td>

					
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<div class="full-width text-center m-b-20">
		<a href="<?php echo base_url('dashboard/hr_verified'); ?>" class="btn red btn-outline btn-circle margin-0">View All</a>
	</div>
</div>

<script type="text/javascript">
	
	var chart;

	$(document).ready(function() {

		$('#filter').val(0);

		chart = draw_chart("<?php echo number_format($statistics_associate_email_sent->total_count); ?>", 
							"<?php echo number_format($statistics_associate_verify->total_count); ?>", 
							"<?php echo number_format($statistics_hr_in_process->total_count); ?>", 
							"<?php echo number_format($statistics_associate_verified->total_count); ?>"
				);
	});

	$('#filter').on('change',function(){
		var filter_val = $('#filter').val();
		
		chart.destroy();
		chart = draw_chart("<?php echo number_format($statistics_associate_email_sent->total_count); ?>", 
							"<?php echo number_format($statistics_associate_verify->total_count); ?>", 
							"<?php echo number_format($statistics_hr_in_process->total_count); ?>", 
							"<?php echo number_format($statistics_associate_verified->total_count); ?>"
				);

		if ( filter_val == 0 ) {
			$('#job_title_drop').hide();
			$('#org_unit_drop').hide();
			$('#fun_area_drop').hide();
			$('#dept_drop').hide();
		}

		if ( filter_val == 1 ) {
			$('#job_title_drop').show();
			$('#org_unit_drop').hide();
			$('#fun_area_drop').hide();
			$('#dept_drop').hide();
		}

		if ( filter_val == 2 ) {
			$('#job_title_drop').hide();
			$('#org_unit_drop').show();
			$('#fun_area_drop').hide();
			$('#dept_drop').hide();
		}

		if ( filter_val == 3 ) {
			$('#job_title_drop').hide();
			$('#org_unit_drop').hide();
			$('#fun_area_drop').show();
			$('#dept_drop').hide();
		}

		if ( filter_val == 4 ) {
			$('#job_title_drop').hide();
			$('#org_unit_drop').hide();
			$('#fun_area_drop').hide();
			$('#dept_drop').show();
		}		
		
	});

	$('.column_name').on('change',function(){

		var col_name = $(this).attr('id');
		//	alert(col_name);
		var col_name_id = '#'+col_name;
		var col_val = $(col_name_id).val();
		if ( col_val == 0 ) 
		{
			chart.destroy();
			chart = draw_chart("<?php echo number_format($statistics_associate_email_sent->total_count); ?>", 
							"<?php echo number_format($statistics_associate_verify->total_count); ?>", 
							"<?php echo number_format($statistics_hr_in_process->total_count); ?>", 
							"<?php echo number_format($statistics_associate_verified->total_count); ?>"
				);
		}
		else
		{
			
			$.ajax({
				type: "POST",
				url: '<?php echo base_url('dashboard/filter_by_job_title');?>',
				data: {col_name:col_name, col_val:col_val},
				success:function(data) {
					if(data.success == "1") {
						//console.log(data.hr_in_process['total_count']);
						
						chart.destroy();

						chart = draw_chart( 
							data.email_sent['total_count'],
							data.verify['total_count'],
							data.hr_in_process['total_count'],
							data.verified['total_count']
						);
						console.log(chart);


					}
				},
				error:function()
				{
					alert('Something is wrong.');
					//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
				}
			});

		}
	});
</script>