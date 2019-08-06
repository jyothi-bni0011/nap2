<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
  <div class="page-title-breadcrumb">
    <div class=" pull-left">
      <div class="page-title"><?= $title; ?></div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
      <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="new-associates.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
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
        <form action="<?php echo base_url('new_associate/create') ?>" method="post" id="create_associate" class="form-horizontal" autocomplete="off">
                   <div class="form-body">
                         <div class="form-group row">
                              <label class="control-label col-md-3">Username
                                     <span class="required"> * </span>
                              </label>
                              <div class="col-md-5">
                                   <input type="text" name="username" id="username" data-required="1" placeholder="Enter Username" class="form-control input-height" /> </div>
                         </div>
                         <div class="form-group row">
                              <label class="control-label col-md-3">Email
                                     <span class="required"> * </span>
                              </label>
                           <div class="col-md-5">
                                <input type="text" name="email" id="email" data-required="1" placeholder="Enter Email ID" class="form-control input-height" /> 
                           </div>
                         </div>
                          <div class="form-group row">
                              <label class="control-label col-md-3">First Name</label>
                                <div class="col-md-5">
                                    <input type="text" name="first_name" id="first_name" data-required="1" placeholder="Enter First Name" class="form-control input-height" /> 
                                </div>
                          </div>
                          <div class="form-group row">
                           <label class="control-label col-md-3">Middle Name </label>
                              <div class="col-md-5">
                                   <input type="text" name="middle_name" id="middle_name" data-required="1" placeholder="Enter Middle Name" class="form-control input-height" />
                              </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-5">
                                <input type="text" name="last_name" id="last_name" data-required="1" placeholder="Enter Last Name" class="form-control input-height" />
                            </div>
                          </div>
                       
                          <div class="form-group row">
                           <label class="control-label col-md-3">Job Position 
                                  <span class="required"> * </span>
                           </label>
                           <div class="col-md-5">
                                <select class="form-control input-height" name="job_title" id="job_title">
                                   <option value="">Select Job Position </option>
                                    <?php foreach($job_titles as $job_title): ?>
                                      
                                      <option value="<?php echo $job_title->{JOB_POSITION_ID}; ?>" > <?php echo $job_title->{JOB_POSITION_CODE}; ?> </option>
                                  
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                          </div>
                          <div class="form-group row">
                           <label class="control-label col-md-3">Organizational Unit 
                                  <span class="required"> * </span>
                           </label>
                           <div class="col-md-5">
                                <select class="form-control input-height" name="organizational_unit" id="organizational_unit">
                                   <option value="">Select Organizational Unit </option>
                                   <?php foreach($org_units as $org_unit): ?>
                                      
                                      <option value="<?php echo $org_unit->{ORGANIZATIONAL_UNIT_ID}; ?>" > <?php echo $org_unit->{ORGANIZATIONAL_UNIT_NAME}; ?> </option>
                                  
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                          </div>
                          <div class="form-group row">
                           <label class="control-label col-md-3">Functional Area
                                 <span class="required"> * </span>
                           </label>
                           <div class="col-md-5">
                                <select class="form-control input-height" name="functional_area" id="functional_area">
                                    <option value="">Select Functional Area</option>
                                    <?php foreach($fun_areas as $fun_area): ?>
                                      
                                      <option value="<?php echo $fun_area->{FUNCTIONAL_AREA_ID}; ?>" > <?php echo $fun_area->{FUNCTIONAL_AREA_NAME}; ?> </option>
                                  
                                    <?php endforeach; ?>
                                  </select> 
                             </div>
                          </div>
                          
                         
                      
                        <div class="form-group row">
                           <label class="control-label col-md-3">Department
                                  <span class="required"> * </span>
                          </label>
                          <div class="col-md-5">
                                <select class="form-control input-height" name="department" id="department">
                                      <option value="">Select Department</option>
                                      <?php foreach($departments as $department): ?>
                                      
                                      <option value="<?php echo $department->{DEPARTMENT_ID}; ?>" > <?php echo $department->{DEPARTMENT_NAME}; ?> </option>
                                  
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>
                      
                         <div class="form-group row">
                            <label class="col-md-3 control-label">Start Date of Associate
                                <span class="required"> * </span>
                            </label>
                            <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-dd-mm" data-link-field="dtp_input1">
                                 <input class="form-control" size="16" type="text" id="start_date" >
                                 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" name="start_date"/>
                        </div>
                        <div class="form-group row">
                             <label class="control-label col-md-3">Status
                                   <span class="required"> * </span>
                             </label>
                             <div class="col-md-5">
                                  <select class="form-control input-height" name="status" id="status">
                                       <option value="">Status</option>
                                 <option value="1">Active</option>
                                 <option value="0">Inactive</option>
                                   </select> 
                             </div>
                        </div>
                      
                        <div class="form-group row">
                         <label class="control-label col-md-3">Contact Info
                               <span class="required"> * </span>
                         </label>
                         <div class="col-md-5">
                            <textarea class="form-control" rows="3" placeholder="Enter Contact Info" name="contact_info" id="contact_info"></textarea> 
                         </div>
                        </div>
                   
                       <div class="form-group row">
                         <label class="control-label col-md-3">Address
                            <span class="required"> * </span>
                         </label>
                         <div class="col-md-5">
                              <textarea class="form-control" rows="3" placeholder="Enter Address" name="address" id="address"></textarea> 
                         </div>
                      </div>
                  
                      <div class="form-actions">
                        <div class="row">
                           <div class="offset-md-3 col-md-9">
                                  <button type="submit" class="btn btn-danger">Create</button>
                                  <button type="button" class="btn btn-default">Cancel</button>
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
    $( "#create_associate" ).validate({
      rules: {
          username: {
              required: true,
              maxlength: 50
          },
          email: {
            required: true,
            email: true
          },
          first_name: {
            maxlength: 50
          },
          middle_name: {
            maxlength: 50
          },
          last_name: {
            maxlength: 50
          },
          job_title: {
            required: true
          },
          organizational_unit: {
            required: true
          },
          functional_area: {
            required: true
          },
          category: {
            required: true
          },
          department: {
            required: true
          },
          start_date: {
            required: true
          },
          status: {
            required: true
          },
          contact_info: {
            required: true
          },
          address: {
            required: true,
            maxlength: 255
          },
      }
      
    });

    
  
  });
</script>