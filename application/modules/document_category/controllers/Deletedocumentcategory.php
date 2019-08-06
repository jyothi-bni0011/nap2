<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deletedocumentcategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		$this->load->model('deletedocumentcategory_model');
	}

	

	public function index()
	{

		if( count($_POST) ) {
			$old_data = $this->deletedocumentcategory_model->getById( DOCUMENT_CATEGORY, DOCUMENT_CATEGORY_ID, $_POST['doc_category_id'] );
			
			$message = '';
			if ( ! $tmp = $this->deletedocumentcategory_model->getById( DOCUMENT, DOCUMENT_CATEGORY_ID, $_POST['doc_category_id'] ) ) {
				if ( $this->deletedocumentcategory_model->delete( $_POST['doc_category_id'] ) ) {
					//$data['message'] = "Role deleted successfuly";
					$this->deletedocumentcategory_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document Category', 'Document Category - \''.$old_data->{DOCUMENT_CATEGORY_NAME}.'\' is deleted' );
					$message = 'Document Category removed successfully.';
				}
			}
			else
			{
				$message = 'Document Category is mapped with documents.';	
			}
			$this->session->set_flashdata('message', $message);
			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}