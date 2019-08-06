<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_permission extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('module_permission_model');
	}

	
	
	public function assign_module_permissions( $role_id )
	{
		
		if ( count($_POST) ) 
		{
			
			if( empty($this->input->post('role_id') ) || empty($this->input->post('menu') ) ) {
				return false;
			}

			if ( $this->module_permission_model->assign_module_permissions( $this->input->post('role_id'), $this->input->post('menu') ) ) {

				$this->session->set_flashdata('message', 'Role has been created.');
				redirect( 'roles' );
				exit;

			}
			else 
			{
				$this->session->set_flashdata('message', 'Something went wrong.');
				redirect( 'admin_masters/module_permission/assign_module_permissions/'.$role_id );
				exit;				
			}
			
		}

		$data['title'] = "Assign Module Permission";
		
		$data['menues'] = $this->module_permission_model->get_menu_by_order();
		$data['role_id'] = $role_id;
		
		$this->load->view('common/header');
		$this->load->view('module_permission/module_permission', $data);
		$this->load->view('common/footer');
	}

	public function update_module_permissions( $role_id )
	{
		
		if ( count($_POST) ) 
		{
			
			if( empty($this->input->post('role_id') ) || empty($this->input->post('menu') ) ) {
				return false;
			}

			if ( $this->module_permission_model->update_module_permissions( $this->input->post('role_id'), $this->input->post('menu') ) ) {
				
				$role_info = $this->module_permission_model->getById( ROLE, ROLE_ID, $this->input->post('role_id') );
				//insert log
				$this->module_permission_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Module Permission', 'Module permission for \''.$role_info->{ROLE_NAME}.'\' role is updated' );
				
				$this->session->set_flashdata('message', 'Permissions has been changed.');
				redirect( 'roles' );
				exit;

			}
			else 
			{
				$this->session->set_flashdata('message', 'Something went wrong.');
				redirect( 'admin_masters/module_permission/assign_module_permissions/'.$role_id );
				exit;				
			}
			
		}

		$data['title'] = "Update Module Permission";
		
		$data['menues'] = $this->module_permission_model->get_menu_by_order();
		$data['assigned_menues'] = $this->module_permission_model->get_assigned_menues_for_role( $role_id );
		$data['role_id'] = $role_id;
		
		$this->load->view('common/header');
		$this->load->view('module_permission/update_module_permission', $data);
		$this->load->view('common/footer');
	}

}