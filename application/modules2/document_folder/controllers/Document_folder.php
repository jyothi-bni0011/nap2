<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_folder extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('document_folder_model');
	}

	

	public function index()
	{

		$data['title'] = "Document Folder";
		
		$data['document_folders'] = $this->document_folder_model->document_folders();

		$this->load->view('common/header');
		$this->load->view('document_folder', $data);
		$this->load->view('common/footer');
	}

}