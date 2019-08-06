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
			$old_data = $this->delete_model->getById( FUNCTIONAL_AREA, FUNCTIONAL_AREA_ID, $_POST['fun_area_id'] );
			
			if ( ! $tmp = $this->delete_model->getById( DEPARTMENT, FUNCTIONAL_AREA_ID, $_POST['fun_area_id'] ) ) 
			{
				
				if ( ! $tmp1 = $this->delete_model->getById( NEW_ASSOCIATE, FUNCTIONAL_AREA_ID, $_POST['fun_area_id'] ) ) 
				{
					if ( ! $tmp1 = $this->delete_model->getById( HR_GROUP, FUNCTIONAL_AREA_ID, $_POST['fun_area_id'] ) ) 
					{
						if ( $this->delete_model->delete( $_POST['fun_area_id'] ) ) {
							//Insert in log
							$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Functional Area', 'Functional Area \''.$old_data->{FUNCTIONAL_AREA_NAME}.'\' is deleted' );
							//$data['message'] = "Role deleted successfuly";
							$message = 'Functional Area removed successfully.';
						}
					}
					else
					{
						$message = 'Functional Area is mapped with HR Group.';	
					}
				}
				else
				{
					$message = 'Functional Area is mapped with New Associate.';	
				}
			}
			else
			{
				$message = 'Functional Area is mapped with department.';
			}

			$this->session->set_flashdata('message', $message);
			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}