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
			$old_data = $this->delete_model->getById( NEW_ASSOCIATE, NEW_ASSOCIATE_ID, $_POST['associate_id'] );
			$message='';
			
			if ( ! $tmp = $this->delete_model->getById( USER_DOCUMENT_MAPPING, USER_ID, $_POST['associate_id'] ) )
			{
				if ( $this->delete_model->delete( $_POST['associate_id'] ) ) {
					//$data['message'] = "Role deleted successfuly";
					//insert in log
					$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'New Associate', 'New Associate \''.$old_data->{NEW_ASSOCIATE_USERNAME}.'\' is deleted' );
					$message = 'New Associate removed successfully.';
				}
			}
			elseif ( $this->delete_model->find_status_of_doc_by_associate( $_POST['associate_id'] ) ) 
			{
				if ( $this->delete_model->delete( $_POST['associate_id'] ) ) {
					//$data['message'] = "Role deleted successfuly";

					//insert in log
					$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'New Associate', 'New Associate \''.$old_data->{NEW_ASSOCIATE_USERNAME}.'\' is deleted' );
					$message = 'New Associate removed successfully.';
				}
			}
			else
			{
				$message = 'New Associate is mapped with Documents.';
			}

			$this->session->set_flashdata('message', $message);

			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}