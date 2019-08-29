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
    <?php if(!empty($message)) echo $message;?>
    <div><?php echo $this->session->flashdata('message');?></div>
    <div class="card card-box">
      <div class="card-body" id="bar-parent">
        <form action="<?php echo base_url('document/assign_document') ?>" method="post" id="create_associate" class="form-horizontal" autocomplete="off">
                    <?php if(isset($_POST['user_id'])): ?>
                      <input type="hidden" name="user" value="<?=$_POST['user_id']?>">
                    <?php endif; ?>
                   <div class="form-body">
                         <div class="form-group row">
                              <label class="control-label col-md-3">Username
                                     <span class="required"> * </span>
                              </label>
                              <div class="col-md-5">
                                   <input type="text" name="username" id="username" data-required="1" placeholder="Enter Username" class="form-control input-height check_unique" data-msg-required="Username is required." <?php if(isset($_POST['user_name'])) echo 'value="'.$_POST['user_name'].'"'?>/> 
                              </div>
                              <span id="username_error" class="error" style="padding: 10px;display: none; color: red;">This Username already exists.</span>
                         </div>
                         <div class="form-group row">
                              <label class="control-label col-md-3">Email
                                     <span class="required"> * </span>
                              </label>
                           <div class="col-md-5">
                                <input type="text" name="email" id="email" data-required="1" placeholder="Enter Email ID" class="form-control input-height check_unique" data-msg-required="Email is required." <?php if(isset($_POST['user_email'])) echo 'value="'.$_POST['user_email'].'"'?>  /> 
                           </div>
                           <span id="email_error" class="error" style="padding: 10px;display: none; color: red;">This Email already exists.</span>
                         </div>
                          <div class="form-group row">
                              <label class="control-label col-md-3">First Name
                                <span class="required"> * </span>
                              </label>
                                <div class="col-md-5">
                                    <input type="text" name="first_name" id="first_name" data-required="1" placeholder="Enter First Name" class="form-control input-height" data-msg-required="First Name is required." <?php if(isset($_POST['user_first_name'])) echo 'value="'.$_POST['user_first_name'].'"'?>/> 
                                </div>
                          </div>
                          <div class="form-group row">
                           <label class="control-label col-md-3">Middle Name 
                            
                           </label>
                              <div class="col-md-5">
                                   <input type="text" name="middle_name" id="middle_name" data-required="1" placeholder="Enter Middle Name" class="form-control input-height" />
                              </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-md-3">Last Name
                              <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <input type="text" name="last_name" id="last_name" data-required="1" placeholder="Enter Last Name" class="form-control input-height" data-msg-required="Last Name is required." <?php if(isset($_POST['user_last_name'])) echo 'value="'.$_POST['user_last_name'].'"'?>/>
                            </div>
                          </div>
                       
                          <div class="form-group row">
                           <label class="control-label col-md-3">Job Title 
                                  <span class="required"> * </span>
                           </label>
                           <!-- <div class="col-md-5">
                                <select class="form-control input-height" name="job_title" id="job_title">
                                   <option value="">Select Job Title </option>
                                    <?php //foreach($job_titles as $job_title): ?>
                                      
                                      <option value="<?php //echo $job_title->{JOB_POSITION_ID}; ?>" > <?php //echo $job_title->{JOB_POSITION_CODE}; ?> </option>
                                  
                                    <?php //endforeach; ?>
                                </select> 
                            </div> -->
                            <div class="col-md-5">
                                <input type="text" name="job_title" id="job_title" data-required="1" placeholder="Enter Job Title" class="form-control input-height" data-msg-required="Job Title is required."/>
                            </div>
                          </div>
                          <div class="form-group row">
                           <label class="control-label col-md-3">Organizational Unit 
                                  <span class="required"> * </span>
                           </label>
                           <div class="col-md-5">
                                <select class="form-control input-height hierarchy" name="organizational_unit" id="organizational_unit" data-msg-required="Organizational Unit is required.">
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
                                <select class="form-control input-height hierarchy" name="functional_area" id="functional_area" data-msg-required="Functional Area is required.">
                                    <option value="">Select Functional Area</option>
                                    
                                  </select> 
                             </div>
                          </div>
                          
                         
                      
                        <div class="form-group row">
                           <label class="control-label col-md-3">Department
                                  <span class="required"> * </span>
                          </label>
                          <div class="col-md-5">
                                <select class="form-control input-height" name="department" id="department" data-msg-required="Department is required.">
                                      <option value="">Select Department</option>
                                      
                                </select> 
                            </div>
                        </div>
                        
                        <div class="form-group row">
                           <label class="control-label col-md-3">Manager 
                                  <span class="required"> * </span>
                           </label>
                           <div class="col-md-5">
                                <input type="text" name="manager_id" id="manager_id" data-required="1" placeholder="Enter Manager Name" class="form-control input-height" data-msg-required="Manager is required."/>
                            </div>
                          </div>
						
						<div class="form-group row">
                          <label class="control-label col-md-3">Manager Title 
                                  <span class="required"> * </span>
                          </label>
                          <div class="col-md-5">
                                <input type="text" name="manager_title" id="manager_title" data-required="1" placeholder="Enter Manager Title" class="form-control input-height" data-msg-required="Manager Title is required."/>
                          </div>
                        </div>
						
                         <div class="form-group row">
                            <label class="col-md-3 control-label">Start Date
                                <span class="required"> * </span>
                            </label>
                            <div class="input-group date form_date col-md-5" data-date="" data-date-format="MM dd,yyyy" data-link-field="dtp_input1" style="flex-wrap: nowrap;">
                                 <div class="col-md-12" style="padding: 0px;"><input class="form-control" size="16" type="text" id="start_date" name="start_date1" readonly data-msg-required="Start Date is required." data-msg-required="Start Date is required."></div>
                                 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                 <span class="glyphicon glyphicon-plus"></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" name="start_date"/>
                        </div>
                        <div class="form-group row" style="margin-top: -13px">
                            <label class="col-md-3 control-label">
                                
                            </label>
                            <div class="col-md-5">   
                              <span id="start_date_error" style="color: red; display: none;">This field is required.</span>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                             <label class="control-label col-md-3">Status
                                   <span class="required"> * </span>
                             </label>
                             <div class="col-md-5">
                                  <select class="form-control input-height" name="status" id="status" data-msg-required="Status is required.">
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
                            <textarea class="form-control" rows="3" placeholder="Enter Contact Info" name="contact_info" id="contact_info" data-msg-required="Contact Info is required."></textarea> 
                         </div>
                        </div>
                   
                       <div class="form-group row">
                         <label class="control-label col-md-3">Address
                            <span class="required"> * </span>
                         </label>
                         <div class="col-md-5">
                              <textarea class="form-control" rows="3" placeholder="Enter Address" name="address" id="address" data-msg-required="Address is required."></textarea> 
                         </div>
                      </div>
                  
                      <div class="form-actions">
                        <div class="row">
                           <div class="offset-md-3 col-md-9">
                                  <button type="button" class="btn btn-danger" id="submit_form">Continue</button>
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
    var valid= $( "#create_associate" ).validate({
      rules: {
          username: {
              required: true,
              maxlength: 50,
              minlength: 4
          },
          email: {
            required: true,
            email: true
          },
          first_name: {
            required: true,
            maxlength: 50
          },
          middle_name: {
            
            maxlength: 50
          },
          last_name: {
            required: true,
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
          manager_id: {
            required: true
          },
		  manager_title: {
            required: true
          },
          start_date1: {
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

    $('.hierarchy').on('change', function(){
      
      var id = $(this).attr('id');
      var table, column, value;

      switch (id) {

          case "organizational_unit":
              table   = 'functional_area';
              column  = 'org_unit_id';
              value   = $(this).val();
              break;

          case "functional_area":
              table   = 'department';
              column  = 'fun_area_id';
              value   = $(this).val();
              break;

          default:
      }

      $.ajax({
        type: "POST",
        url: '<?php echo base_url('new_associate/get_organizational_hierarchy');?>',
        data: { table : table,
                column : column,
                id : value
              },
        success:function(data) {
         
          if(data.success == "1") {
            var htm="";
            
            
            switch (id) {

                case "organizational_unit":
                    htm += "<option value=''>Select Functional Area</option>";
                    $.each(data.result,function( i, fun_area ){  
                      htm += "<option value='"+ fun_area.fun_area_id +"'>"+ fun_area.fun_area_name +"</option>";
                    });
                    $('#functional_area').html(htm);
                    $('#department').html("<option value=''>Select Department</option>");
                    break;

                case "functional_area":
                    htm += "<option value=''>Select Department</option>";
                    $.each(data.result,function( i, dept ){  
                      htm += "<option value='"+ dept.department_id +"'>"+ dept.department_name +"</option>";
                    });
                    $('#department').html(htm);
                    break;

                default:
            }
            
          }
        },
        error:function()
        {
        }
      });

    });
  
    $('.check_unique').on('blur',function(){

      var table = 'new_associate';
      var id = $(this).attr('id');
      var column, value;

      switch (id) {

          case "username":
              column  = 'associate_username';
              value   = $(this).val();
              break;

          case "email":
              column  = 'associate_email';
              value   = $(this).val();
              break;

          default:
      }
      

      $.ajax({
        type: "POST",
        url: '<?php echo base_url('new_associate/check_duplicate_by_ajax');?>',
        data: { table : table,
                column : column,
                id : value,
                associate_id : 0
              },
        success:function(data) {
          
          if(data.success == "0") {
            if ( id == "username" ) 
            {
              $('#username_error').show();
            }
            else
            {
              $('#email_error').show(); 
            }
          }
          else
          {
            if ( id == "username" ) 
            {
              $('#username_error').hide();
            }
            else
            {
              $('#email_error').hide(); 
            }
          }
        },
        error:function()
        {
        }
      });

    });

    $('#submit_form').on('click', function(){
      if ( ! $('#username_error').is(":visible") && ! $('#email_error').is(":visible") /*&& $('#start_date').val() != ''*/ ) {
        $('#create_associate').submit();
        console.log(valid);
      }
      else{
        if ( $('#username_error').is(":visible") ) {
          $('#username').focus();
        }
        else if( $('#email_error').is(":visible") ){
          $('#email').focus(); 
        }
        else {
          $('#start_date_error').show();
          $('#start_date').focus(); 
        }
      }
    });

    $('#start_date').on('change',function(){

      if ( ! $('#start_date').val() ) {
        $('#start_date_error').show();
      }
      else
      {
        $('#start_date-error').hide(); 
      }
    });

  });
</script>