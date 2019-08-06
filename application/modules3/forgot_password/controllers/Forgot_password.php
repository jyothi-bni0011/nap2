<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('forgot_password_model');
	}
	
	public function index() {
		//echo "string";exit();
		$this->data['message'] = "";
		if( count($_POST) ) {
				
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[49]');
			//$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[49]');
			//$this->form_validation->set_rules('user_role', 'User Role', 'trim|required|numeric');
			if( $this->form_validation->run() ) {
		
				//$data['username']	= $this->input->post('username');
				$data['email_id']	= $this->input->post('username');
				if( $user = $this->forgot_password_model->user( $data ) ) {
						
					if ( $this->forgot_password_model->authenticate( $this->input->post('username') ) ) {
							
						redirect( base_url('login') );
						exit;
					}
					else {
						$this->data['message'] = "Unable to authenticate user. Please try again after sometime.";
					}
		
				}
				else {
					$this->data['message'] = "Invalid username or email provided.";
				}
			}
			else {
				$this->data['message'] = validation_errors();
			}
		}
		
		//$this->data['roles'] = $this->forgot_password->get_roles();
		$this->load->view('forgot_password', $this->data);
	}
}