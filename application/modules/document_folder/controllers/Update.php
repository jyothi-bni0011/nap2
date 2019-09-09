<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Update Document Folder";

		if( count($_POST) ) {
			$this->form_validation->set_rules('folder_name', 'Document Folder', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('folder_description', 'Description', 'trim|required|max_length[254]');

			if( $this->form_validation->run() ) {

				if( $this->update_model->update( $this->input->post('folder_name'), $this->input->post('folder_description'), $this->input->post('folder_id') ) ) {
					//$data['message'] = "Role has been created.";
					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document Folder', 'Document Folder - \''.$this->input->post('folder_name').'\' is updated' );
					$this->session->set_flashdata('message', 'Document folder has been updated.');
					redirect( '/document_folder', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the document folder');
					redirect( '/document_folder/update/index/'.$_POST['folder_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/document_folder/update/index/'.$_POST['folder_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['doc_folder_name'] = $row->{DOCUMENT_FOLDER_NAME};
				$data['doc_folder_description'] = $row->{DOCUMENT_FOLDER_DESCRIPTION};
				$data['doc_folder_id'] = $row->{DOCUMENT_FOLDER_ID};
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}