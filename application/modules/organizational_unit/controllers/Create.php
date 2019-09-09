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

		$data['title'] = "Create Organizational Unit";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('org_name', 'Organizational Unit', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('org_description', 'Organizational Unit Description', 'trim|max_length[254]');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $this->create_model->create( $this->input->post('org_name'), $this->input->post('org_description') ) ) {
					//$data['message'] = "Role has been created.";
					
					//insert in log
					$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Organizational Unit', 'New Organizational Unit \''.$this->input->post('org_name').'\' is created' );
					
					$this->session->set_flashdata('message', 'Organizational Unit has been created.');
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Organizational Unit already exists. Please try again.');
					redirect( '/organizational_unit/create', $data );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/organizational_unit/create', $data );
				exit;
			}
			redirect( '/organizational_unit', $data );
		}
		else{

			$this->load->view('common/header');
			$this->load->view('create', $data);
			$this->load->view('common/footer');
		}

	}

}