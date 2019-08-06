<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
	}

	public function index()
	{

		$data['title'] = "Document Folder";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('folder_name', 'Document Folder', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('folder_description', 'Description', 'trim|required|max_length[254]');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $this->create_model->create( $this->input->post('folder_name'), $this->input->post('folder_description') ) ) {
					//$data['message'] = "Document Category has been created.";
					$old_umask = umask(0);
					mkdir( dirname(APPPATH) . '/assets/documents/'.$this->input->post('folder_name'), 0777 );
					umask($old_umask);
					$this->session->set_flashdata('message', 'Document folder has been created.');
				}
				else {
					//$data['message'] = "Failed to crate the job position";
					$this->session->set_flashdata('message', 'Failed to crate the document folder.');
					redirect( '/document_folder/create', $data );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors() );
				redirect('/document_folder/create');
				exit;
			}
			redirect('/document_folder');
			exit;
		}
		
		$this->load->view('common/header');
		$this->load->view('create', $data);
		$this->load->view('common/footer');
	}

}