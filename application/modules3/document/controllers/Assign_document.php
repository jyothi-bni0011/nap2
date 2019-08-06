<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_document extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('assign_document_model');
	}

	public function index($slag=0)
	{

		$data['title'] = "Assign Document To New Associate";

		if( count($_POST) ) 
		{
			
			$this->form_validation->set_rules('documents', 'Documents', 'trim');
			if( $this->form_validation->run() ) 
			{

				if( $inserted_id = $this->assign_document_model->create( $this->input->post('documents'), $this->input->post('associate_id') ) ) {
						
					$this->session->set_flashdata('message', 'New Associate has been created.');
					redirect( '/new_associate'  );
				}
				else {
					$this->session->set_flashdata('message', 'Failed to create the user');
					redirect( '/document/assign_document/index/'.$_POST['associate_id'] );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/document/assign_document/index/'.$_POST['associate_id'] );
			}
			
			redirect( '/new_associate', $data );
		}
		
		$job_title = $this->assign_document_model->getById( NEW_ASSOCIATE, NEW_ASSOCIATE_ID, $slag );
		$data['documents'] = $this->assign_document_model->get_documents( $job_title->{JOB_POSITION_ID} );
		$data['associate_id'] = $slag;
		$this->load->view('common/header');
		$this->load->view('assign_document', $data);
		$this->load->view('common/footer');

	}

}