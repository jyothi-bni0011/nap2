<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_associate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('new_associate_model');
	}

	

	public function index()
	{

		$data['title'] = "New Associate";
		
		$data['new_associates'] = $this->new_associate_model->new_associate();

		$this->load->view('common/header');
		$this->load->view('new_associate', $data);
		$this->load->view('common/footer');
	}

}