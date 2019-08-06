<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getdocumentcategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('getdocumentcategory_model');
	}

	

	public function index()
	{

		$data['title'] = "Document Category";
		
		$data['doc_categories'] = $this->getdocumentcategory_model->doc_category();

		$this->load->view('common/header');
		$this->load->view('get_document_category', $data);
		$this->load->view('common/footer');
	}

}