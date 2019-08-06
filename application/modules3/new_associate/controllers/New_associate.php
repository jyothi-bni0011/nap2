<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_associate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('new_associate_model');
		$this->load->model('document/document_update_model');
		$this->data['document_statuses'] = $this->document_update_model->document_statuses;
	}

	public function index()
	{

		$data['title'] = "New Associate";
		$data['new_associates'] = $this->new_associate_model->new_associate();

		$this->load->view('common/header');
		$this->load->view('new_associate', $data);
		$this->load->view('common/footer');
	}

	public function documents( $associate_id )
	{
		
		if( empty($associate_id) ) {
			return FALSE;
		}

		$this->data['title'] = "New Associate Documents";
		$this->data['documents'] = $this->new_associate_model->documents( $associate_id );

		$this->load->view('common/header');
		$this->load->view('documents', $this->data);
		$this->load->view('common/footer');

	}

	public function view( $associate_id, $document_id )
	{
		
		if( empty($associate_id) 
			|| empty($document_id) 
			|| ! $associate_document = $this->document_update_model->associate_has_document( $document_id, $associate_id ) ) {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger">No such document found related to the associate.</div>');
			redirect ('/dashboard');
			exit;
		}

		if( count($_POST) ) {

			$update_document = array(
				'user_id'		=> $this->input->post('associate_id'),
				'document_id'	=> $this->input->post('document_id'),
				'status'		=> 4,
				'submitted_date'=> date('Y-m-d H:i:s', now())
			);

			$updated = $this->document_update_model->update_document( 
				$update_document, 
				$this->input->post('associate_id'), 
				$this->input->post('document_id') 
			);

			if( $updated ) {
				$this->session->set_flashdata('message', '<div class="alert alert-success">The document has been verified.</div>');
				redirect('/dashboard');
				exit;
			}

		}

		$data['verify'] = ((int)$associate_document->status === 4)? FALSE:TRUE;
		$data['associate_id'] = $associate_id;
		$data['document_id'] = $document_id;
		$this->load->view('common/header');
		$this->load->view('view', $data);
		$this->load->view('common/footer');

	}

	public function read( $associate_id, $document_id )
	{

		if( empty($associate_id) 
			|| empty($document_id) 
			|| ! $associate_document = $this->document_update_model->associate_has_document( $document_id, $associate_id ) ) {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger">No such document found in the associate history.</div>');
			redirect (( $this->session->userdata('role_id') )? 'new_associate':'new_associate/dashboard');
			exit;
		}

		if( file_exists( dirname( APPPATH ) . $associate_document->file_url ) ) {
			header("Content-type: application/pdf");
			@readfile(base_url( $associate_document->file_url ));
			exit;
		}

	}

}