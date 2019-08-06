<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetCategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('getcategory_model');
	}

	

	public function index()
	{

		$data['title'] = "Category";
		
		$data['categories'] = $this->getcategory_model->categories();

		$this->load->view('common/header');
		$this->load->view('category/get_category', $data);
		$this->load->view('common/footer');
	}

}