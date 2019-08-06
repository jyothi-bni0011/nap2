<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('reports_model');
		$this->load->model('new_associate/new_associate_model');
	}

	
	//list of category
	public function index()
	{

		$data['title'] = "New Associate Reports";

		$data['new_associates'] = $this->new_associate_model->new_associate();
		$data['departments']	= $this->reports_model->getAll( DEPARTMENT );

		// print_r( $data ); exit();

		$this->load->view('common/header');
		$this->load->view('reports/report', $data);
		$this->load->view('common/footer');
	}

	
}