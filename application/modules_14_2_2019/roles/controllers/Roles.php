<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('roles_model');
	}

	

	public function index()
	{

		$data['title'] = "Roles";
		
		$data['roles'] = $this->roles_model->roles();

		$this->load->view('common/header');
		$this->load->view('roles', $data);
		$this->load->view('common/footer');
	}

}