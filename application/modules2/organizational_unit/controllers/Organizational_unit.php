<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organizational_unit extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('organizational_unit_model');
	}

	

	public function index()
	{

		$data['title'] = "Organizational Unit";
		
		$data['org_units'] = $this->organizational_unit_model->org_unit();

		$this->load->view('common/header');
		$this->load->view('organizational_unit', $data);
		$this->load->view('common/footer');
	}

}