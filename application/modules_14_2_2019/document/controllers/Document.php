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
		$this->data['field_steps'] = $this->document_model->get_form_steps_of_document();

		$this->load->view('common/header');
		$this->load->view('document', $this->data);
		$this->load->view('common/footer');
	}
}