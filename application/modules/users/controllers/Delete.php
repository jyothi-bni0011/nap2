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
			$old_data = $this->delete_model->getById( USER, USER_ID, $_POST['user_id'] );
			$message = '';
			if ( $old_data->associate_id ) 
			{
				if ( ! $tmp1 = $this->delete_model->getById( USER_DOCUMENT_MAPPING, USER_ID, $old_data->associate_id ) ) 
				{
					
						
						
							
							if ( $this->delete_model->delete( $_POST['user_id'] ) ) {
								//$data['message'] = "Role deleted successfuly";

								//insert log
								$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$old_data->{USERNAME}.'\' is deleted' );
								$message = 'User removed successfully.';
							}
						
					
				}
				elseif( $this->delete_model->find_status_of_doc_by_associate( $old_data->associate_id ) )
				{
					if ( $this->delete_model->delete( $_POST['user_id'] ) ) {
						//$data['message'] = "Role deleted successfuly";

						//insert log
						$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$old_data->{USERNAME}.'\' is deleted' );
						$message = 'User removed successfully.';
					}
				}
				else
				{
					$message = 'User is mapped with Documents.';
				}
			}
			else
			{
				
						
							if ( $this->delete_model->delete( $_POST['user_id'] ) ) 
							{
								//$data['message'] = "Role deleted successfuly";

								//insert log
								$this->delete_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$old_data->{USERNAME}.'\' is deleted' );
								$message = 'User removed successfully.';
							}
						
					
			}
			$this->session->set_flashdata('message', $message);
			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}