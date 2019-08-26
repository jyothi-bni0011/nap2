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

		$data['title'] = "Users";

		if( count($_POST) ) {
			//$this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required|max_length[49]');
			//$this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_email', 'User Email ID', 'trim|required|valid_email');
			//$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

			if( $this->form_validation->run() ) {

				$result = $this->update_model->fetch_data($this->input->post('user_id'));
				
				if ( $result->username != $this->input->post('user_name') ) {
					if ( $this->update_model->check_duplicate( USER, USERNAME, $this->input->post('user_name') ) ) {
						$update[USERNAME] = $this->input->post('user_name');
					}
					else {
						$this->session->set_flashdata('message', 'Duplicate Username. Failed to update the user');
						redirect( '/users/update/index/'.$_POST['user_id'] );	
					}
				}

				if ( $result->email_id != $this->input->post('user_email') ) {
					if ( $this->update_model->check_duplicate( USER, USER_EMAIL, $this->input->post('user_email') ) ) {
						$update[USER_EMAIL] = $this->input->post('user_email');
					}
					else {
						$this->session->set_flashdata('message', 'Duplicate Email. Failed to update the user');
						redirect( '/users/update/index/'.$_POST['user_id'] );
					}
				}

				if( $this->update_model->update( $this->input->post('user_first_name'), $this->input->post('user_last_name'), $this->input->post('user_name'), $this->input->post('user_email'), $this->input->post('user_id'), $this->input->post('user_role') ) ) {
					//$data['message'] = "Role has been created.";
					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'User \''.$this->input->post('user_name').'\' is updated' );
					
					$this->session->set_flashdata('message', 'User has been updated.');
					redirect( '/users', $data );
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the user');
					redirect( '/users/update/index/'.$_POST['user_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/users/update/index/'.$_POST['user_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['roles'] = $this->update_model->get_all_roles();
				$data['user_roles'] = $this->update_model->get_user_roles( $slag );
				$data['user_id'] = $row->{USER_ID};
				$data['user_name'] = $row->{USERNAME};
				$data['user_first_name'] = $row->{USER_FIRST_NAME};
				$data['user_last_name'] = $row->{USER_LAST_NAME};
				$data['email_id'] = $row->{USER_EMAIL};
				//$data['user_role'] = $row->role_id;

				/*$this->load->view('common/header');
				$this->load->view('update', $data);
				$this->load->view('common/footer');*/
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}