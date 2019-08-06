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

		$data['title'] = "Functional Area";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('fun_area_name', 'Functional Area', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('fun_area_description', 'Functional Area Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('org_unit', 'Organizational Unit', 'trim|required');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {
				if ($this->create_model->check_fun_area_duplicate( $this->input->post('fun_area_name'), $this->input->post('org_unit') ) ) 
				{
					if( $this->create_model->create( $this->input->post('fun_area_name'), $this->input->post('fun_area_description'), $this->input->post('org_unit') ) ) {
						//$data['message'] = "Role has been created.";
						
						//insert log
						$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Functional Area', 'New Functional Area \''.$this->input->post('fun_area_name').'\' is created' );
						
						$this->session->set_flashdata('message', 'Functional area has been created.');
					}
					else {
						//$data['message'] = "Failed to crate the role";
						$this->session->set_flashdata('message', 'Failed to create the functional area');
						redirect( '/functional_area/create', $data );
						exit;
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'Duplicate Functional Area Name. Failed to create the functional area');
					redirect( '/functional_area/create', $data );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/functional_area/create', $data );
				exit;
			}
			redirect( '/functional_area', $data );
		}
		else{

			$data['org_units'] = $this->create_model->getAll( ORGANIZATIONAL_UNIT );

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}