<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatedepartment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('updatedepartment_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Department";

		if( count($_POST) ) {
			$this->form_validation->set_rules('department_name', 'Department', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('department_description', 'Department Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('functional_area', 'Functional Area', 'trim|required');

			if( $this->form_validation->run() ) {
				
				if( $this->updatedepartment_model->update( $this->input->post('department_name'), $this->input->post('department_description'), $this->input->post('functional_area'), $this->input->post('department_id') ) ) {
					//$data['message'] = "Role has been created.";
					
					//insert in log
					$this->updatedepartment_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Department', 'Department \''.$this->input->post('department_name').'\' is updated' );
					
					$this->session->set_flashdata('message', 'Department has been updated.');
					redirect( '/department/getdepartment', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the Department');
					redirect( '/department/updatedepartment/index/'.$_POST['department_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/department/updatedepartment/index/'.$_POST['department_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->updatedepartment_model->fetch_data( $slag ) ) {
				$data['selected_fun_area'] = $row->{FUNCTIONAL_AREA_ID};
				$data['department_name'] = $row->{DEPARTMENT_NAME};
				$data['department_description'] = $row->{DEPARTMENT_DESCRIPTION};
				$data['department_id'] = $row->{DEPARTMENT_ID};
				$data['selected_org_unit'] = $this->updatedepartment_model->find_org_unit( $row->{FUNCTIONAL_AREA_ID} );
				$data['fun_area_list'] = $this->updatedepartment_model->find_fun_areas( $data['selected_org_unit'] );
			}
		}

		//$data['functional_areas'] = $this->updatedepartment_model->getAll( FUNCTIONAL_AREA );
		$data['org_units'] = $this->updatedepartment_model->getAll( ORGANIZATIONAL_UNIT );

		$this->load->view('common/header');
		$this->load->view('update_department', $data);
		$this->load->view('common/footer');
		
	}

}