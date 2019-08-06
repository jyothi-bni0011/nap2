<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_document extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('assign_document_model');
		$this->load->model('new_associate/create_model');
	}

	public function index( $associate_id=0 )
	{
		$data['title'] = "Assign Document To New Associate";
		if( count($_POST) ) 
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

				
				$url = ['welcome_url' => anchor(base_url(), base_url())];
				
				if ($this->create_model->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_EMAIL, $this->input->post('email') )) 
				{
					if ($this->create_model->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_USERNAME, $this->input->post('username') )) 
					{
						if ( array_key_exists('documents', $_POST) ) 
						{
							/*Create new associate and user*/
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

									/*Insert document mapping for new associate*/
									if( $inserted_id = $this->assign_document_model->create( $this->input->post('documents'), $inserted_id ) ) 
									{
						
										$this->session->set_flashdata('message', 'New Associate has been created.');
										redirect( '/new_associate'  );
									}
									else {
										$this->session->set_flashdata('message', 'Failed to create the user');
										redirect( '/document/assign_document/index/'.$inserted_id );
									}
									redirect( '/document/assign_document/index/'.$inserted_id  );
								}
							} 
							else {
								$this->session->set_flashdata('message', 'Failed to create the new associate');
								redirect( '/new_associate/create', $data );
								exit();
							}
						}
						else
						{

							$data['documents'] = $this->assign_document_model->get_documents( $this->input->post('job_title') );
							$data['associate'] = $_POST;
						 // print_r( $data ); exit();
							$this->load->view('common/header');
							$this->load->view('assign_document', $data);
							$this->load->view('common/footer');	
										
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
			
			/*redirect( '/new_associate', $data );*/
		}
		else
		{
			redirect( '/new_associate/create' );	
			exit();
		}
		// print_r( $_POST ); exit();
		
		// if( ! $associate_id AND ! count($_POST) ) {
		// 	$this->session->set_flashdata('message', error_message('Associate ID is required for assigning documents.'));
		// 	redirect('/new_associate');
		// }


		// if( count($_POST) ) 
		// {
		// 	if ( !isset( $_POST['documents'] ) ) {
		// 		$this->session->set_flashdata('message', 'Please select at least 1 document.');
		// 		redirect( '/document/assign_document/index/'.$_POST['associate_id'] ); 
		// 	}
			
			
		// 	$this->form_validation->set_rules('documents', 'Documents', 'trim');
		// 	if( $this->form_validation->run() ) 
		// 	{

		// 		if( $inserted_id = $this->assign_document_model->create( $this->input->post('documents'), $this->input->post('associate_id') ) ) {
						
		// 			$this->session->set_flashdata('message', 'New Associate has been created.');
		// 			redirect( '/new_associate'  );
		// 		}
		// 		else {
		// 			$this->session->set_flashdata('message', 'Failed to create the user');
		// 			redirect( '/document/assign_document/index/'.$_POST['associate_id'] );
		// 		}
		// 	}
		// 	else {
		// 		$this->session->set_flashdata('message', validation_errors());
		// 		redirect( '/document/assign_document/index/'.$_POST['associate_id'] );
		// 	}
			
		// 	redirect( '/new_associate', $data );
		// }
		
		// $job_title = $this->assign_document_model->getById( NEW_ASSOCIATE, NEW_ASSOCIATE_ID, $associate_id );
		// $data['documents'] = $this->assign_document_model->get_documents( $job_title->{JOB_POSITION_ID} );
		// $data['associate_id'] = $associate_id;
		// $this->load->view('common/header');
		// $this->load->view('assign_document', $data);
		// $this->load->view('common/footer');

	}

}