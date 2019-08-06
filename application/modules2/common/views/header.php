<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title><?php echo !empty($title)? $title:'New Associcate Portal'; ?>  
    </title>
	<link href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/plugins/material/material.min.css'); ?>" rel="stylesheet" >
	<link href="<?php echo base_url('assets/css/material_style.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url('assets/css/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/page.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/jquery.growl.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Select2 -->
    <link href="<?php echo base_url('assets/css/select2.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    
	<script type="text/javascript">
		var base_url = "<?php echo base_url(); ?>";
	</script>
	<link href="<?php echo base_url('assets/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />
   

   <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

    <!-- Slim scroll -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.js"></script> -->

</head>
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-color logo-dark">
	<div class="page-wrapper">
		<div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="<?php echo base_url('dashboard'); ?>">
                    <span class="logo-default"><img alt="" src="<?php echo base_url('assets/img/logo.png'); ?>"></span>
                    </a>
                </div>
				<ul class="nav navbar-nav navbar-left in">
					<li><a href="#" class="menu-toggler sidebar-toggler font-size-20"><i class="fa fa-exchange" aria-hidden="true"></i></a></li>
				</ul>
                <ul class="nav navbar-nav navbar-left in">
                    <li><a href="javascript:;" class="fullscreen-click font-size-20"><i class="fa fa-arrows-alt"></i></a></li>
                </ul>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
				<div class="p-t-05 p-l-20 float-left">
					<h4><strong>New Associate Portal</strong></h4>
				</div>
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-extended dropdown-notification">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="material-icons">notifications</i>
                                <span class="notify"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3><span class="bold">Notifications</span></h3>
                                    <span class="notification-label red-bgcolor">New 6</span>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">just now</span>
                                                <span class="details">
                                                <span class="notification-icon circle deepPink-bgcolor"><i class="fa fa-check"></i></span> Congratulations!. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">3 mins</span>
                                                <span class="details">
                                                <span class="notification-icon circle red-bgcolor"><i class="fa fa-user o"></i></span>
                                                <b>John Micle </b>is now following you. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">7 mins</span>
                                                <span class="details">
                                                <span class="notification-icon circle blue-bgcolor"><i class="fa fa-comments-o"></i></span>
                                                <b>Sneha Jogi </b>sent you a message. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">12 mins</span>
                                                <span class="details">
                                                <span class="notification-icon circle pink"><i class="fa fa-heart"></i></span>
                                                <b>Ravi Patel </b>like your photo. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">15 mins</span>
                                                <span class="details">
                                                <span class="notification-icon circle yellow"><i class="fa fa-warning"></i></span> Warning! </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">10 hrs</span>
                                                <span class="details">
                                                <span class="notification-icon circle red"><i class="fa fa-times"></i></span> Application error. </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="dropdown-menu-footer">
                                        <a href="javascript:void(0)"> All notifications </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
 						<li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle " src="<?php echo base_url('assets/img/prof.png'); ?>">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user"></i> My Account </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-cogs"></i> Change Password
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('select_user_role'); ?>">
                                        <i class="fa fa-cogs"></i> Change Role
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                             <a href="<?php echo (base_url('logout')) ?>" id="headerSettingButton" class="mdl-button mdl-js-button mdl-button--icon pull-right" data-upgraded=",MaterialButton">
	                           <i class="material-icons">logout</i>
	                        </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
		<div class="page-container">
			<div class="sidebar-container">
 				<div class="sidemenu-container navbar-collapse collapse fixed-menu">
	                <div id="remove-scroll" class="left-sidemenu">
	                    <ul class="sidemenu  page-header-fixed slimscroll-style" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
	                        <li class="sidebar-toggler-wrapper hide">
	                            <div class="sidebar-toggler">
	                                <span></span>
	                            </div>
	                        </li>
	                        <li class="sidebar-user-panel">
	                            <div class="user-panel">
	                                <div class="pull-left image">
	                                    <img src="<?php echo base_url('assets/img/prof.png'); ?>" class="img-circle user-img-circle" alt="User Image">
	                                </div>
	                                <div class="pull-left info">
	                                    <p><?php echo $this->session->userdata('full_name'); ?></p>
	                                    <small><?php echo $this->session->userdata('role_name'); ?></small>
	                                </div>
	                            </div>
	                        </li>
                            <?php if( $this->session->userdata('is_associate') ):?>
                                <li class="nav-item <?php if($this->uri->segment(1)=='new_associate'){echo 'active';}?> ">
                                    <a href="<?php echo base_url('new_associate/dashboard'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                    <span class="title">Dashboard</span></a>
                                </li>
                            <?php else :?>    
	                        <!-- active open -->
                            <li class="nav-item <?php if($this->uri->segment(1)=='roles'){echo 'active';}?> ">
                                <a href="<?php echo base_url('roles'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                <span class="title">Roles</span></a>
                            </li>
                            <li class="nav-item <?php if($this->uri->segment(1)=='users'){echo 'active';}?> ">
                                <a href="<?php echo base_url('users'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                <span class="title">Users</span></a>
                            </li>
	                        <li class="nav-item <?php if($this->uri->segment(1)=='new_associate'){echo 'active';}?> ">
	                            <a href="<?php echo base_url('new_associate'); ?>" class="nav-link nav-toggle">
	                                <i class="material-icons">how_to_reg</i>
	                                <span class="title">New Associates</span>
	                                <span class="selected"></span>
	                            </a>
	                        </li>
	                        <li class="nav-item <?php if($this->uri->segment(1)=='hr_group'){echo 'active';}?> ">
	                            <a href="<?php echo base_url('admin_masters/hr_group'); ?>" class="nav-link nav-toggle">
	                                <i class="material-icons">group</i>
	                                <span class="title">HR Group</span>
	                            </a>
	                        </li>
	                        <li class="nav-item <?php if($this->uri->segment(1)=='job_position'){echo 'active';}?>">
	                            <a href="<?php echo base_url('job_position'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
	                            <span class="title">Job Title</span></a>
	                        </li>
                            <!-- <li class="nav-item <?php //if($this->uri->segment(1)=='category'){echo 'active';}?> ">
                                <a href="<?php //echo base_url('category'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                <span class="title">Category</span></a>
                            </li> -->
                            <li class="nav-item <?php if($this->uri->segment(1)=='organizational_unit'){echo 'active';}?> ">
                                <a href="<?php echo base_url('organizational_unit'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                <span class="title">Organizational Unit</span></a>
                            </li>
                            <li class="nav-item <?php if($this->uri->segment(1)=='functional_area'){echo 'active';}?> ">
                                <a href="<?php echo base_url('functional_area'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                <span class="title">Functional Area</span></a>
                            </li>
                            <li class="nav-item <?php if($this->uri->segment(1)=='department'){echo 'active';}?> ">
                                <a href="<?php echo base_url('department/getdepartment'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                <span class="title">Department</span></a>
                            </li>
							<li class="nav-item <?php if($this->uri->segment(1)=='document_category'){echo 'active';}?>">
	                            <a href="<?php echo base_url('document_category/getdocumentcategory'); ?>" class="nav-link nav-toggle"><i class="material-icons">filter_none</i>
	                            <span class="title">Document Category</span></a>
	                        </li> 
							<li class="nav-item <?php if($this->uri->segment(1)=='document_folder'){echo 'active';}?>">
	                            <a href="<?php echo base_url('document_folder'); ?>" class="nav-link nav-toggle"><i class="material-icons">create_new_folder</i>
	                            <span class="title">Document Folder</span></a>
	                        </li>
							<li class="nav-item <?php if($this->uri->segment(1)=='document'){echo 'active';}?>">
	                            <a href="<?php echo base_url('document'); ?>" class="nav-link nav-toggle"><i class="material-icons">library_books</i>
	                            <span class="title">Documents</span></a>
	                        </li>
                            <li class="nav-item <?php if($this->uri->segment(1)==''){echo 'active';}?>">
                                <a href="<?php echo base_url('admin_masters/map_document_job_position'); ?>" class="nav-link nav-toggle"><i class="material-icons">trending_up</i>
                                <span class="title">Map Document To Job Position</span></a>
                            </li>
							<!-- <li class="nav-item">
	                            <a href="map-documents-to-job-position.php" class="nav-link nav-toggle"><i class="material-icons">trending_up</i>
	                            <span class="title">Map Documents to Job Position</span></a>
	                        </li> -->
							<!-- <li class="nav-item <?php //if($this->uri->segment(1)=='log_history'){echo 'active';}?>">
	                            <a href="#" class="nav-link nav-toggle"><i class="material-icons">visibility</i>
	                            <span class="title">Log History</span></a>
	                        </li> -->
                        <?php endif?>
	                    </ul>
	                </div>
                </div>
            </div>
			<div class="page-content-wrapper">
				<div class="page-content">
											
			