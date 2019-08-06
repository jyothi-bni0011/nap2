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

		$data['title'] = "Functional Area";

		if( count($_POST) ) {
			$this->form_validation->set_rules('fun_area_name', 'Functional Area', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('fun_area_description', 'Functional Area Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('org_unit', 'Organizational Unit', 'trim|required');

			if( $this->form_validation->run() ) {

				if( $this->update_model->update( $this->input->post('fun_area_name'), $this->input->post('fun_area_description'), $this->input->post('org_unit'), $this->input->post('fun_area_id') ) ) {
					//$data['message'] = "Role has been created.";
					
					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Functional Area', 'Functional Area \''.$this->input->post('fun_area_name').'\' is updated' );
					
					$this->session->set_flashdata('message', 'Functional area has been updated.');
					redirect( '/functional_area', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the functional area');
					redirect( '/functional_area/update/index/'.$_POST['fun_area_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/functional_area/update/index/'.$_POST['fun_area_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['org_unit'] = $row->{ORGANIZATIONAL_UNIT_ID};
				$data['fun_area_name'] = $row->{FUNCTIONAL_AREA_NAME};
				$data['fun_area_description'] = $row->{FUNCTIONAL_AREA_DESCRIPTION};
				$data['fun_area_id'] = $row->{FUNCTIONAL_AREA_ID};
				
			}
		}

		$data['org_units'] = $this->update_model->getAll( ORGANIZATIONAL_UNIT );

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}