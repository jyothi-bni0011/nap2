<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends MY_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('document/document_update_model');
		$this->data['document_statuses'] = $this->document_update_model->document_statuses;
	}
	
	public function index() {

		$this->data['title'] = "Dashboard";

		$this->data['statistics'] = $this->dashboard_model->statistics();
		$this->data['associate_email_sent'] = $this->dashboard_model->associate_status(1);
		$this->data['associate_verify'] = $this->dashboard_model->associate_status(2);

		$this->load->view('common/header');
		$this->load->view('dashboard', $this->data);
		$this->load->view('common/footer');
	}
}