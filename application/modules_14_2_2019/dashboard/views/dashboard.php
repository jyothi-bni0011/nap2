<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Dashboard</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
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