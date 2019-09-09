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

		$data['title'] = "Update Roles";

		if( count($_POST) ) {
			$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('role_description', 'Role Description', 'trim|max_length[254]');	

			if( $this->form_validation->run() ) {

				if( $this->update_model->update( $this->input->post('role_name'), $this->input->post('role_description'), $this->input->post('role_id') ) ) {
					//$data['message'] = "Role has been created.";
					
					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Role', 'Role \''.$this->input->post('role_name').'\' is updated' );
					
					$this->session->set_flashdata('message', 'Role has been updated.');
					redirect( '/roles', $data );
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the role');
					redirect( '/roles/update/index/'.$_POST['role_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/roles/update/index/'.$_POST['role_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['role_name'] = $row->{ROLE_NAME};
				$data['role_description'] = $row->{ROLE_DESCRIPTION};
				$data['role_id'] = $row->{ROLE_ID};
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}