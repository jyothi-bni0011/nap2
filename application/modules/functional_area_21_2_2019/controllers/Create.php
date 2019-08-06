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
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $this->create_model->create( $this->input->post('fun_area_name'), $this->input->post('fun_area_description') ) ) {
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Functional area has been created.');
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to create the functional area');
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

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}