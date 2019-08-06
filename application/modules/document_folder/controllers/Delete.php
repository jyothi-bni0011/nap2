<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		$this->load->model('delete_model');
	}

	

	public function index()
	{

		if( count($_POST) ) {
			$old_data = $this->delete_model->getById( DOCUMENT_FOLDER, DOCUMENT_FOLDER_ID, $_POST['doc_folder_id'] );
			$message = '';
			if ( ! $tmp = $this->delete_model->getById( DOCUMENT, DOCUMENT_FOLDER_ID, $_POST['doc_folder_id'] ) ) 
			{
				if ( $this->delete_model->delete( $_POST['doc_folder_id'] ) ) {
					//$data['message'] = "Role deleted successfuly";
					$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document Folder', 'Document Folder - \''.$old_data->{DOCUMENT_FOLDER_NAME}.'\' is deleted' );
						
					$message = 'Document Folder removed successfully.';
				}
			}
			else
			{
				$message = 'Document Folder is mapped with documents.';	
			}
			$this->session->set_flashdata('message', $message);
			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}