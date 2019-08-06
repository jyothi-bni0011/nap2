<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
		// Load session library
		$this->load->library('session');
	}

	public function index() {
		//destroy session
    	$this->session->sess_destroy();
		
		redirect('/');
	}
}
?>