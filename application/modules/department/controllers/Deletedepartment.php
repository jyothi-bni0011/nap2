<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deletedepartment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		$this->load->model('deletedepartment_model');
	}

	

	public function index()
	{

		if( count($_POST) ) {
			$old_data = $this->deletedepartment_model->getById( DEPARTMENT, DEPARTMENT_ID, $_POST['department_id'] );
			$message = '';
			if ( ! $tmp = $this->deletedepartment_model->getById( NEW_ASSOCIATE, DEPARTMENT_ID, $_POST['department_id'] ) ) 
			{
				
				if ( $this->deletedepartment_model->delete( $_POST['department_id'] ) ) {
					//$data['message'] = "Role deleted successfuly";
					//Insert in log
					$this->deletedepartment_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Department', 'Department \''.$old_data->{DEPARTMENT_NAME}.'\' is deleted' );
					$message = 'Department removed successfully.';
				}
				
			}
			else
			{
				$message = 'Department is mapped with New Associate.';
			}

			$this->session->set_flashdata('message', $message);
			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}