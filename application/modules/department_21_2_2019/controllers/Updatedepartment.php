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

			if( $this->form_validation->run() ) {

				if( $this->updatedepartment_model->update( $this->input->post('department_name'), $this->input->post('department_description'), $this->input->post('department_id') ) ) {
					//$data['message'] = "Role has been created.";
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

				$data['department_name'] = $row->{DEPARTMENT_NAME};
				$data['department_description'] = $row->{DEPARTMENT_DESCRIPTION};
				$data['department_id'] = $row->{DEPARTMENT_ID};
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update_department', $data);
		$this->load->view('common/footer');
		
	}

}