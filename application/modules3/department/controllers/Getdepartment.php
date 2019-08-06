<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getdepartment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('getdepartment_model');
	}

	

	public function index()
	{

		$data['title'] = "Department";
		
		$data['departments'] = $this->getdepartment_model->departments();

		$this->load->view('common/header');
		$this->load->view('get_department', $data);
		$this->load->view('common/footer');
	}

}