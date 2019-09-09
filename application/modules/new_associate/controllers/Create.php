<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('create_model');
		$this->load->model('admin_masters/hr_group_model');
	}

	public function index()
	{
		if ( array_key_exists("user_id",$_POST) ) 
		{
			$data = $_POST;
		}
		
		$data['title'] = "Create New Associate";

		if( count($_POST) AND ! array_key_exists("user_id",$_POST) ) 
		{
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

			if( $this->form_validation->run() ) 
			{

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
					'manager'				=>		$this->input->post('manager_id')
				);

				//$values = $this->create_model->get_data_for_new_associate( $this->input->post('email') );
				$url = ['welcome_url' => anchor(base_url(), base_url())];
				//$values = (object) array_merge( (array)$values, $url );	
				//print_r($values); exit();
				if ($this->create_model->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_EMAIL, $this->input->post('email') )) 
				{
					if ($this->create_model->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_USERNAME, $this->input->post('username') )) 
					{
						if( $inserted_id = $this->create_model->create( $create ) ) 
						{
							if ( $user_inserted_id = $this->create_model->create_same_user( $create, $inserted_id ) ) 
							{
								$this->create_model->create_same_user_role_mapping( 4, $user_inserted_id );

								//insert in log for new associate
								$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'New Associate', 'New Associate \''.$this->input->post('username').'\' is created' );

								//insert in log for User
								$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'New User \''.$this->input->post('username').'\' is created' );
								
								$values = $this->create_model->get_data_for_new_associate( $this->input->post('email') );

								$values = (object) array_merge( (array)$values, $url );

								if ( $this->create_model->send_email( 'welcome_associate', $this->input->post('email'), $values ) )//$this->input->post('email') 
								{
									$this->session->set_flashdata('message', 'User has been created.');
								}
								else
								{
									$this->session->set_flashdata('message', 'User has been created. But Email not sent.');	
								}

								redirect( '/document/assign_document/index/'.$inserted_id  );
							}
						} 
						else {
							$this->session->set_flashdata('message', 'Failed to create the new associate');
							redirect( '/new_associate/create', $data );
						}
						
					}
					else 
					{
						$this->session->set_flashdata('message', 'Duplicate Username. Failed to create new associate.');
						redirect( '/new_associate/create', $data );
					}

				}
				else 
				{
					$this->session->set_flashdata('message', 'Duplicate Email. Failed to create the user.');
					redirect( '/new_associate/create', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/new_associate/create', $data );
			}
			
			redirect( '/new_associate', $data );
		}
		
		$data['org_units'] = $this->create_model->get_org_units();
		$data['fun_areas'] = $this->create_model->get_fun_areas();
		$data['departments'] = $this->create_model->get_departments();		

		$this->load->view('common/header');
		$this->load->view('create', $data);
		$this->load->view('common/footer');

	}

}