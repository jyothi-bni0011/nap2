<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Select_user_role extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('select_user_role_model');
	}

	public function index()
	{

		$data['title'] = "Roles";
		if ($_POST) {
			
			$this->form_validation->set_rules('user_role', 'Role Name', 'trim|required');
			if ( $this->form_validation->run() ) {
				if( $this->select_user_role_model->select_role( $this->input->post('user_role') ) ) {
					redirect( base_url('dashboard') );
					exit;
				}
			}
		}

		
		$data['roles'] = $this->select_user_role_model->users_roles( $this->session->userdata( 'user_id' ) );
		$this->load->view('common/header');
		$this->load->view('select_user_role', $data);
		$this->load->view('common/footer');

	}


}