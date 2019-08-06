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
			$old_data = $this->delete_model->getById( DOCUMENT, DOCUMENT_ID, $_POST['doc_id'] );
			$message = '';
			if ( ! $tmp = $this->delete_model->getById( USER_DOCUMENT_MAPPING, DOCUMENT_ID, $_POST['doc_id'] ) ) 
			{
				if ( $this->delete_model->delete( $_POST['doc_id'] ) ) {
					//$data['message'] = "Role deleted successfuly";
					$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document', 'Document template - \''.$old_data->{DOCUMENT_TITLE}.'\' is deleted' );
					$message = 'Document removed successfully.';
				}
			}
			else
			{
				$message = 'Document is mapped with New Associate.';
			}

			$this->session->set_flashdata('message', $message);
			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}