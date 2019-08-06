<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('document_model');
	}
	
	public function index() {
		$this->data['title'] = "Document";
		$this->data['documents'] = $this->document_model->get();
		$this->data['documents'] = $this->document_model->get1();

		$this->load->view('common/header');
		$this->load->view('document', $this->data);
		$this->load->view('common/footer');
	}
}