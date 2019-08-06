<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('login/login_model');
		// Load session library
		$this->load->library('session');
	}

	public function index() {
		
		$data = $this->login_model->getById( USER, USER_ID, $this->session->userdata('user_id') );
		
		if ( $data ) 
		{		
			//Insert Log 
			$this->login_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Logout','\'' . $this->session->userdata('username').'\' is logged out' );
		}
		//Insert Log 
		//$this->login_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Logout','\''. $this->session->userdata('username').'\' is logged out' );
		
		//destroy session
    	$this->session->sess_destroy();
		
		redirect('/');
	}
}
?>