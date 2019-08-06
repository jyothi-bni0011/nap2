<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createdepartment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('createdepartment_model');
	}

	

	public function index()
	{

		$data['title'] = "Department";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('department_name', 'Department', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('department_description', 'Department Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('functional_area', 'Functional Area', 'trim|required');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {
				
				if ($this->createdepartment_model->check_department_duplicate($this->input->post('department_name'), (int)$this->input->post('functional_area') )) 
				{
					if( $this->createdepartment_model->create( $this->input->post('department_name'), $this->input->post('department_description'), $this->input->post('functional_area') ) ) 
					{
						//$data['message'] = "Role has been created.";
						
						//insert in log
						$this->createdepartment_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Department', 'New Department \''.$this->input->post('department_name').'\' is created' );
						
						$this->session->set_flashdata('message', 'Department has been created.');
					}
					else 
					{
						//$data['message'] = "Failed to crate the role";
						$this->session->set_flashdata('message', 'Failed to create the department');
						redirect( '/department/createdepartment', $data );
						exit;
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'Department already exists. Please try again.');
					redirect( '/department/createdepartment', $data );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/department/createdepartment', $data );
				exit;
			}
			redirect( '/department/getdepartment', $data );
		}
		else{

			//$data['functional_areas'] = $this->createdepartment_model->getAll( FUNCTIONAL_AREA );
			$data['org_units'] = $this->createdepartment_model->getAll( ORGANIZATIONAL_UNIT );
			$this->load->view('common/header');
			$this->load->view('create_department', $data);
			$this->load->view('common/footer');
		}

	}

}