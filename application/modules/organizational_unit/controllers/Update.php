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

		$data['title'] = "Organizational Unit";

		if( count($_POST) ) {
			$this->form_validation->set_rules('org_unit_name', 'Organizational Unit', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('org_unit_description', 'Organizational Unit Description', 'trim|max_length[254]');

			if( $this->form_validation->run() ) {

				if( $this->update_model->update( $this->input->post('org_unit_name'), $this->input->post('org_unit_description'), $this->input->post('org_unit_id') ) ) {
					//$data['message'] = "Role has been created.";
					
					//insert in log
					$this->update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Organizational Unit', 'Organizational Unit \''.$this->input->post('org_unit_name').'\' is updated' );
					
					$this->session->set_flashdata('message', 'Organizational unit has been updated.');
					redirect( '/organizational_unit', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the organizational unit');
					redirect( '/organizational_unit/update/index/'.$_POST['org_unit_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/organizational_unit/update/index/'.$_POST['org_unit_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->update_model->fetch_data( $slag ) ) {

				$data['org_unit_name'] = $row->{ORGANIZATIONAL_UNIT_NAME};
				$data['org_unit_description'] = $row->{ORGANIZATIONAL_UNIT_DESCRIPTION};
				$data['org_unit_id'] = $row->{ORGANIZATIONAL_UNIT_ID};
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update', $data);
		$this->load->view('common/footer');
		
	}

}