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

		$data['title'] = "Job Position";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('job_code', 'Job Position Code', 'trim|required|min_length[2]|max_length[49]');
			$this->form_validation->set_rules('job_description', 'Job Position Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $this->create_model->create( $this->input->post('job_code'), $this->input->post('job_description'), $this->input->post('department') ) ) {
					$this->session->set_flashdata('message', 'Job Position has been created.');
					//$data['message'] = "Job Position has been created.";
				}
				else {
					$this->session->set_flashdata('message', 'Failed to crate the job position.');
					//$data['message'] = "Failed to crate the job position";
					redirect( '/job_position/create', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				//$data['message'] = validation_errors();
				redirect( '/job_position/create', $data );
			}
			redirect( '/job_position', $data );
		}
		
		$data['departments'] = $this->create_model->get_departments();
		$this->load->view('common/header', $data);
		$this->load->view('create', $data);
		$this->load->view('common/footer');
	}

}