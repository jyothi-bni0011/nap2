<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Functional_area extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('functional_area_model');
	}

	

	public function index()
	{

		$data['title'] = "Functional Area";
		
		$data['fun_areas'] = $this->functional_area_model->fun_area();

		$this->load->view('common/header');
		$this->load->view('functional_area', $data);
		$this->load->view('common/footer');
	}

}