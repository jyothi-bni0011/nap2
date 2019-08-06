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
			$message = '';
			$old_data = $this->delete_model->getById( ORGANIZATIONAL_UNIT, ORGANIZATIONAL_UNIT_ID, $_POST['org_unit_id'] );
			
			if ( ! $tmp = $this->delete_model->getById( FUNCTIONAL_AREA, ORGANIZATIONAL_UNIT_ID, $_POST['org_unit_id'] ) ) 
			{
				if ( ! $tmp1 = $this->delete_model->getById( NEW_ASSOCIATE, ORGANIZATIONAL_UNIT_ID, $_POST['org_unit_id'] ) ) 
				{
					if ( $this->delete_model->delete( $_POST['org_unit_id'] ) ) {
						//$data['message'] = "Role deleted successfuly";
						
						$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Organizational Unit', 'Organizational Unit \''.$old_data->{ORGANIZATIONAL_UNIT_NAME}.'\' is deleted' );
						$message = 'Organizational Unit removed successfully.';
					}
				}
				else
				{
					$message = 'Organizational Unit is mapped with New Associate.';
				}
			}
			
			else
			{
				$message = 'Organizational Unit is mapped with Functional Area.';
			}
			
			$this->session->set_flashdata('message', $message);
			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}