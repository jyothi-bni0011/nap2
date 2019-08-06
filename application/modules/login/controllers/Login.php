<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('login_model');
	}
	
	public function index() 
	{

		if( (int)$this->session->userdata('logged_in') ) {
			redirect('/dashboard');
			exit;
		}
		
		$this->data['message'] = "";
		if( count($_POST) ) 
		{
				
			$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[49]');
			//$this->form_validation->set_rules('user_role', 'User Role', 'trim|required|numeric');
			if( $this->form_validation->run() ) 
			{
		
				$data['username']	= $this->input->post('username');
				$data['email_id']	= $this->input->post('username');
				if( $user = $this->login_model->user( $data ) ) {
						
					if ( $this->login_model->authenticate( $this->input->post('username'), $this->input->post('password')/*, (int)$this->input->post('user_role')*/ ) ) {
						
						//Insert Log 
						$this->login_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Login','\''. $this->session->userdata('username').'\' is logged in' );
						
						//only for demo
						if ($this->session->userdata( 'is_associate' )) {
							redirect( base_url('new_associate/dashboard') );
							exit;
						}
						//only for demo end
						if ( $this->session->userdata( 'role_id' ) ) {
							redirect( base_url('dashboard') );
							exit;
						}
						else {
							redirect( base_url('select_user_role') );
						}
					}
					else {
						$this->data['message'] = "<div class='alert alert-success text-center' style='color: red;font-size:15px;'>Invalid username or password.</div>";
					}
		
				}
				else {
					$this->data['message'] = "<div class='alert alert-success text-center' style='color: red;font-size:15px;'>Invalid username or password.</div>";
				}
			}
			else {
				$this->data['message'] = validation_errors();
			}
		}
		
		$this->data['roles'] = $this->login_model->get_roles();
		$this->load->view('login', $this->data);
	}
}