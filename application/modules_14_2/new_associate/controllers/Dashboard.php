<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('dashboard_model');
		$this->load->model('document/document_update_model');

		$this->data['document_statuses'] = $this->document_update_model->document_statuses;
	}

	public function index()
	{

		$this->data['title'] = "Dashboard";
		$this->data['doc_status'] = $this->dashboard_model->find_document_ststus( $this->session->userdata( 'associate_id' ) );
		if ( !count( $this->data['doc_status'] ) ) {
			
			$this->data['associate_docs'] = $this->dashboard_model->associate_docs( $this->session->userdata( 'associate_id' ) );

		}
		else
		{
			$this->data['associate_docs'] = [];
		}

		$this->load->view('common/header');
		$this->load->view('dashboard', $this->data);
		$this->load->view('common/footer');
	}

}