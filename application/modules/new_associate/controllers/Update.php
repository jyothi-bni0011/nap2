<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
		$this->load->model('admin_masters/hr_group_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Users";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('username', 'User Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('middle_name', 'User Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required');
			$this->form_validation->set_rules('organizational_unit', 'Organizational Unit', 'trim|required|numeric');
			$this->form_validation->set_rules('functional_area', 'Functional Area', 'trim|required|numeric');
			$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			$this->form_validation->set_rules('start_date', 'Start Date of Associate', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
			$this->form_validation->set_rules('contact_info', 'Contact_info', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[254]');

			if( $this->form_validation->run() ) {

				$update = array(
					'username'				=>		$this->input->post('username'),
					'email'					=>		$this->input->post('email'),
					'first_name'			=>		$this->input->post('first_name'),
					'last_name'				=>		$this->input->post('last_name'),
					'middle_name'			=>		$this->input->post('middle_name'),
					'job_title'				=>		$this->input->post('job_title_id'),
					'organizational_unit'	=>		$this->input->post('organizational_unit'),
					'functional_area'		=>		$this->input->post('functional_area'),
					'department'			=>		$this->input->post('department'),
					'start_date'			=>		$this->input->post('start_date'),
					'status'				=>		$this->input->post('status'),
					'contact_info'			=>		$this->input->post('contact_info'),
					'address'				=>		$this->input->post('address'),
					'associate_id'			=>		$this->input->post('associate_id'),
					'manager'				=>		$this->input->post('manager_id'),
					'manager_title'			=>		$this->input->post('manager_title')
				);

				$result = $this->update_model->fetch_data($this->input->post('associate_id'));
		
				if ( $result->{NEW_ASSOCIATE_USERNAME} != $this->input->post('username') ) {
					if ( $this->update_model->check_duplicate( USER, USERNAME, $this->input->post('username') ) ) {
						
					}
					else {
						$this->session->set_flashdata('message', 'Duplicate Username. Failed to update the associate.');
						redirect( '/new_associate/update/index/'.$_POST['associate_id'] );
					}
				}

				if ( $result->{NEW_ASSOCIATE_EMAIL} != $this->input->post('email') ) {
					if ( $this->update_model->check_duplicate( USER, USER_EMAIL, $this->input->post('email') ) ) {
							
					}
					else {
						$this->session->set_flashdata('message', 'Duplicate Email. Failed to update the associate.');
						redirect( '/new_associate/update/index/'.$_POST['associate_id'] );
					}
				}

				if( $this->update_model->update( $update ) ) {
					$this->update_model->update_user( $update ); //update user
					//update job title
					if ( $this->update_model->update_job_title( $this->input->post('job_title'), $this->input->post('job_title_id') ) ) {
						
					}
					
					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'New Associate', 'New Associate \''.$this->input->post('username').'\' is updated' );
					
					$this->session->set_flashdata('message', 'Associate has been updated.');
                                        redirect( '/document/assign_document/index/'.$result->{NEW_ASSOCIATE_ID}, $data );
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the associate');
					redirect( '/new_associate/update/index/'.$_POST['associate_id'] );
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/new_associate/update/index/'.$_POST['associate_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['job_titles'] = $this->update_model->getById( JOB_POSITION, JOB_POSITION_ID, $row->{JOB_POSITION_ID} );
				$data['org_units'] = $this->update_model->get_all_org_units();
				$data['fun_areas'] = $this->update_model->get_all_fun_areas( $row->{ORGANIZATIONAL_UNIT_ID} );
				$data['departments'] = $this->update_model->get_all_departments( $row->{FUNCTIONAL_AREA_ID} );
				$data['hr_managers'] = $this->hr_group_model->get_user_by_role(3);
				
				$data['associate_id'] = $row->{NEW_ASSOCIATE_ID};
				$data['username'] = $row->{NEW_ASSOCIATE_USERNAME};
				$data['email'] = $row->{NEW_ASSOCIATE_EMAIL};
				$data['first_name'] = $row->{NEW_ASSOCIATE_FIRST_NAME};
				$data['middle_name'] = $row->{NEW_ASSOCIATE_MIDDLE_NAME};
				$data['last_name'] = $row->{NEW_ASSOCIATE_LAST_NAME};
				$data['job_title'] = $row->{JOB_POSITION_ID};
				$data['organizational_unit'] = $row->{ORGANIZATIONAL_UNIT_ID};
				$data['functional_area'] = $row->{FUNCTIONAL_AREA_ID};
				//$data['category'] = $row->{CATEGORY_ID};
				$data['departmentss'] = $row->{DEPARTMENT_ID};
				$data['start_date'] = $row->{NEW_ASSOCIATE_START_DATE};
				$data['status'] = $row->{STATUS};
				$data['contact_info'] = $row->{NEW_ASSOCIATE_CONTACT_INFO};
				$data['address'] = $row->{NEW_ASSOCIATE_ADDRESS};
				$data['manager'] = $row->associate_manager_name;
				$data['manager_title'] = $row->associate_manager_title;
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}