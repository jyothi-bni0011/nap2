<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createdocumentcategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('createdocumentcategory_model');
	}

	public function index()
	{

		$data['title'] = "Document Category";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('doc_category', 'Document Category', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('doc_description', 'Document Description', 'trim|required|max_length[254]');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $this->createdocumentcategory_model->create( $this->input->post('doc_category'), $this->input->post('doc_description') ) ) {
					//$data['message'] = "Document Category has been created.";
					//insert in log
					$this->createdocumentcategory_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document Category', 'New Document Category - \''.$this->input->post('doc_category').'\' is created' );
					$this->session->set_flashdata('message', 'Document category has been created.');
				}
				else {
					//$data['message'] = "Failed to crate the job position";
					$this->session->set_flashdata('message', 'Document Category already exists. Please try again.');
					redirect( '/document_category/createdocumentcategory', $data );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors() );
				redirect('/document_category/createdocumentcategory');
				exit;
			}
			redirect('/document_category/getdocumentcategory');
			exit;
		}
		
		$this->load->view('common/header');
		$this->load->view('create_document_category', $data);
		$this->load->view('common/footer');
	}

}