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
					<span class="info-box-number">10</span>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-3 col-12">
			<div class="info-box bg-white">
				<span class="info-box-icon push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
				<div class="info-box-content">
					<span class="info-box-text">To Verify</span>
					<span class="info-box-number">155</span>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-3 col-12">
			<div class="info-box bg-white">
				<span class="info-box-icon push-bottom bg-info"><i class="material-icons">person</i></span>
				<div class="info-box-content">
					<span class="info-box-text">In Process</span>
					<span class="info-box-number">52</span>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-3 col-12">
			<div class="info-box bg-white">
				<span class="info-box-icon push-bottom bg-success"><i class="material-icons">tab</i></span>
				<div class="info-box-content">
					<span class="info-box-text">Verified</span>
					<span class="info-box-number">10</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card card-box">
			<div class="card-body " id="chartjs_bar_parent">
				<div class="row"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
					<canvas id="chartjs_bar" width="1054" height="527" style="display: block; width: 1054px; height: 527px;"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card card-box">
			<div class="card-head">
				<header>New Associates</header>
			</div>
			<div class="card-body ">
				<div class="table-wrap">
					<div class="table-responsive">
						<table class="table display product-overview mb-30" id="support_table">
							<thead>
								<tr>
									<th>No</th>
									<th>Name</th>
									<th>Username</th>
									<th>Department - Category</th>
									<th>Job Position</th>
									<th>Documents</th>
									<th>Action</th>
									<th>Stage</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>Jeffrey Thompson</td>
									<td>JeffreyThompson</td>
									<td>Sales</td>
									<td>Manager</td>
									<td>PDF image</td>
									<td>
										<a href="#" class="btn btn-success btn-tbl-edit btn-xs">
											<i class="fa fa-pencil"></i>
										</a>
										
										<button class="btn btn-tbl-delete btn-circle" data-toggle="modal" data-target="#exampleModalCenter">
											<i class="fa fa-trash-o "></i>
										</button>
										<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-body">
														Are you sure you want to delete this record?
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-danger">Delete</button>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td>In-Progress</td>
								</tr>
								<tr>
									<td>2</td>
									<td>Jeffrey Thompson</td>
									<td>JeffreyThompson</td>
									<td>Sales</td>
									<td>Manager</td>
									<td>PDF image</td>
									<td>
										<a href="#" class="btn btn-success btn-tbl-edit btn-xs">
											<i class="fa fa-pencil"></i>
										</a>

										<button class="btn btn-tbl-delete btn-circle" data-toggle="modal" data-target="#exampleModalCenter">
											<i class="fa fa-trash-o "></i>
										</button>
										<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-body">
														Are you sure you want to delete this record?
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-danger">Delete</button>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td>In-Progress</td>
								</tr>
								<tr>
									<td>3</td>
									<td>Jeffrey Thompson</td>
									<td>JeffreyThompson</td>
									<td>Sales</td>
									<td>Manager</td>
									<td>PDF image</td>
									<td>
										<a href="#" class="btn btn-success btn-tbl-edit btn-xs">
											<i class="fa fa-pencil"></i>
										</a>

										<button class="btn btn-tbl-delete btn-circle" data-toggle="modal" data-target="#exampleModalCenter">
											<i class="fa fa-trash-o "></i>
										</button>
										<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-body">
														Are you sure you want to delete this record?
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-danger">Delete</button>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td>In-Progress</td>
								</tr>
								<tr>
									<td>4</td>
									<td>Jeffrey Thompson</td>
									<td>JeffreyThompson</td>
									<td>Sales</td>
									<td>Manager</td>
									<td>PDF image</td>
									<td>
										<a href="#" class="btn btn-success btn-tbl-edit btn-xs">
											<i class="fa fa-pencil"></i>
										</a>

										<button class="btn btn-tbl-delete btn-circle" data-toggle="modal" data-target="#exampleModalCenter">
											<i class="fa fa-trash-o "></i>
										</button>
										<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-body">
														Are you sure you want to delete this record?
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-danger">Delete</button>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td>In-Progress</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>	
			</div>
			<div class="full-width text-center m-b-20">
				<a href="#" class="btn red btn-outline btn-circle margin-0">View All</a>
			</div>
		</div>
	</div>
</div>