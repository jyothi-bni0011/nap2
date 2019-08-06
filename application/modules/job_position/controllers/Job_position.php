<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_position extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('job_position_model');
	}

	

	public function index()
	{

		$data['title'] = "Job Position";
		
		$data['job_positions'] = $this->job_position_model->job_position();

		$this->load->view('common/header');
		$this->load->view('job_position', $data);
		$this->load->view('common/footer');
	}

}