<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
	}

	

	public function index()
	{

		$data['title'] = "Users";

		if( count($_POST) ) {
			//print_r($_POST); exit();
			$this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('user_email', 'User Email ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
			if( $this->form_validation->run() ) {

				if ($this->create_model->check_duplicate( USER, USER_EMAIL, $this->input->post('user_email') )) 
				{
					if ($this->create_model->check_duplicate( USER, USERNAME, $this->input->post('user_name') )) 
					{
						if( $inserted_id = $this->create_model->create( $this->input->post('user_first_name'), $this->input->post('user_last_name'), $this->input->post('user_name'), $this->input->post('user_email'), $this->input->post('password')/*, $this->input->post('user_role')*/ ) ) 
						{
					
							if ( $this->create_model->create_user_role( $this->input->post('user_role'), $inserted_id ) ) {
								
								$this->session->set_flashdata('message', 'User has been created.');
							}
					
						}
						else {
							
							$this->session->set_flashdata('message', 'Failed to create the user');
							redirect( '/users/create', $data );
						}		
					}
					$this->session->set_flashdata('message', 'Duplicate Username.Failed to create the user');
					redirect( '/users/create', $data );
				}

				$this->session->set_flashdata('message', 'Duplicate Email.Failed to create the user');
				redirect( '/users/create', $data );
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/users/create', $data );
			}
			
			redirect( '/users', $data );
		}
		else{

			$data['roles'] = $this->create_model->get_roles();

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}