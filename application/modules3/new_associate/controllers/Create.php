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

		$data['title'] = "New Associate";

		if( count($_POST) ) {
			//print_r($_POST); exit();
			$this->form_validation->set_rules('username', 'User Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('middle_name', 'User Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|numeric');
			$this->form_validation->set_rules('organizational_unit', 'Organizational Unit', 'trim|required|numeric');
			$this->form_validation->set_rules('functional_area', 'Functional Area', 'trim|required|numeric');
			$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			$this->form_validation->set_rules('start_date', 'Start Date of Associate', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
			$this->form_validation->set_rules('contact_info', 'Contact_info', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[254]');

			if( $this->form_validation->run() ) {

				$create = array(
							'username'				=>		$this->input->post('username'),
							'email'					=>		$this->input->post('email'),
							'first_name'			=>		$this->input->post('first_name'),
							'last_name'				=>		$this->input->post('last_name'),
							'middle_name'			=>		$this->input->post('middle_name'),
							'job_title'				=>		$this->input->post('job_title'),
							'organizational_unit'	=>		$this->input->post('organizational_unit'),
							'functional_area'		=>		$this->input->post('functional_area'),
							'department'			=>		$this->input->post('department'),
							'start_date'			=>		$this->input->post('start_date'),
							'status'				=>		$this->input->post('status'),
							'contact_info'			=>		$this->input->post('contact_info'),
							'address'				=>		$this->input->post('address'),
						);

				if( $inserted_id = $this->create_model->create( $create ) ) {
					if ( $user_inserted_id = $this->create_model->create_same_user( $create, $inserted_id ) ) {
					//echo $user_inserted_id; exit();
						$this->create_model->create_same_user_role_mapping( 4, $user_inserted_id );
						
						$this->session->set_flashdata('message', 'User has been created.');
						redirect( '/document/assign_document/index/'.$inserted_id  );
					} 
						
							
					//$data['message'] = "Role has been created.";
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to create the user');
					redirect( '/new_associate/create', $data );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/new_associate/create', $data );
			}
			
			redirect( '/new_associate', $data );
		}
		else{

			$data['job_titles'] = $this->create_model->get_job_title();
			$data['org_units'] = $this->create_model->get_org_units();
			$data['fun_areas'] = $this->create_model->get_fun_areas();
			$data['departments'] = $this->create_model->get_departments();		
			//echo '<pre>';print_r($data['departments']);exit();

		}

		$this->load->view('common/header');
		$this->load->view('create', $data);
		$this->load->view('common/footer');

	}

}