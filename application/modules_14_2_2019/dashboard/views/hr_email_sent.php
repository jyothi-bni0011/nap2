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

                    				

                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th class="pl-3">No.</th>
                                                    
                                                    <th>Username</th>
                                                    <th>Job Title</th>
                                                    <th>Department</th>
                                                    <th>Functional Area</th>
                                                    <th>Organizational Unit</th>
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
													<td class="text-center">
                                                        <a href="<?php echo base_url('dashboard/send_follow_up_email/' . $associate->user_id ); ?>" class="btn bg-danger p-2 btn-circle"><i class="fa fa-envelope-o " aria-hidden="true"></i></a>
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

            

         <!-- end page container -->