<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('update_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Job Position";

		if( count($_POST) ) {
			$this->form_validation->set_rules('job_code', 'Job Position Code', 'trim|required|min_length[2]|max_length[49]');
			$this->form_validation->set_rules('job_description', 'Job Position Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');	

			if( $this->form_validation->run() ) {

				if( $this->update_model->update( $this->input->post('job_code'), $this->input->post('job_description'), $this->input->post('department'), $this->input->post('position_id') ) ) {
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Job position has been updated.');
					redirect( '/job_position', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the job position');
					redirect( '/job_position/update/index/'.$_POST['position_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/job_position/update/index/'.$_POST['position_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['job_code'] = $row->{JOB_POSITION_CODE};
				$data['job_description'] = $row->{JOB_POSITION_DESCRIPTION};
				$data['departmentss'] = $row->{FUNCTIONAL_AREA_ID};
				$data['position_id'] = $row->{JOB_POSITION_ID};

			}
		}

		$data['departments'] = $this->update_model->get_departments();
		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}