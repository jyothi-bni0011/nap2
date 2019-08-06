<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title><?php echo !empty($title)? $title:'New Associate Portal'; ?>  
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
    <link href="<?php echo base_url('assets/css/select2.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css'); ?>">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
	<script type="text/javascript">
		var base_url = "<?php echo base_url(); ?>";
	</script>
	<link href="<?php echo base_url('assets/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />
    
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
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
                        <!--<li class="dropdown dropdown-extended dropdown-notification">
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
                        </li>-->
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
                                    <a href="<?php echo base_url('admin_masters/change_password'); ?>">
                                        <i class="fa fa-key"></i> Change Password
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
	                                    <p>
                                            <?php echo $this->session->userdata('username'); ?>
                                            <?php //print_r($_SESSION); ?>

                                            <?php 
                                                if ( $this->session->userdata('associate_id') ) 
                                                {
                                                    
                                                    $html = '<div class="small">Organizational Unit : <br/>'.$this->session->userdata('org_unit').'</div><br/><div class="small">Functional Area : <br/>'.$this->session->userdata('fun_area').'</div><br/><div class="small">Job Title : <br/>'.$this->session->userdata('job_title').'</div><br/><div class="small">Department : <br/>'.$this->session->userdata('dept').'</div>'; 
                                                }
                                                else
                                                {
                                                    $html = '<div class="small">Organizational Unit :<br/> None</div><br/><div class="small">Functional Area :<br/> None</div><br/><div class="small">Job Title :<br/> None</div><br/><div class="small">Department :<br/> None</div><br/>';
                                                }
                                            ?>
                                            <i id="user_info" class="fa fa-info-circle" data-container="body" data-toggle="popover" data-placement="left" data-content='<?php echo $html; ?>'></i>   

                                        </p>
	                                    <small><?php echo $this->session->userdata('role_name'); ?></small>
	                                </div>
	                            </div>
	                        </li>
                            <?php if( (int)$this->session->userdata('role_id') === 4 ):?>
                                <li class="nav-item <?php if($this->uri->segment(1)=='new_associate'){echo 'active';}?> ">
                                    <a href="<?php echo base_url('new_associate/dashboard'); ?>" class="nav-link nav-toggle"><i class="material-icons">recent_actors</i>
                                    <span class="title">Dashboard</span></a>
                                </li>
                            <?php else :?>    
                                <?php if( !empty($this->session->userdata('menu') ) ): ?>
                                    <?php foreach ($this->session->userdata('menu') as $menu) :?>
                                        <li class="nav-item <?php //if($this->uri->segment(1)=='dashboard'){echo 'active';}?> ">
                                            <a href="<?php echo base_url( $menu->{MENU_LINK} ); ?>" class="nav-link nav-toggle"><i class="material-icons"><?= $menu->{MENU_ICON}; ?></i>
                                            <span class="title"><?= $menu->{MENU_NAME} ?></span></a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif;?>
	                        
                        <?php endif?>
	                    </ul>
	                </div>
                </div>
            </div>
			<div class="page-content-wrapper">
				<div class="page-content">
											
		