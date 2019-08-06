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
		$this->load->model('create_model');
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

	public function documents( $associate_id=0 )
	{
		
		if( empty($associate_id) ) {
			return FALSE;
		}

		$this->data['message'] 		= $this->session->flashdata('message');
		$this->data['title'] 		= "New Associate Documents";
		$this->data['documents'] 	= $this->new_associate_model->documents( $associate_id );
		if ( !empty( $this->data['documents'] ) ) {
			foreach ($this->data['documents'] as $key => $value) {
				$this->data['field_steps'][$value->{DOCUMENT_ID}] =	$this->new_associate_model->find_form_steps( $value->{DOCUMENT_ID} );			
			}
		}
		$this->load->view('common/header');
		$this->load->view('documents', $this->data);
		$this->load->view('common/footer');

	}

	public function view( $associate_id, $document_id, $decline=0 )
	{
		
		if( empty($associate_id) 
			|| empty($document_id) 
			|| ! $associate_document = $this->document_update_model->associate_document( $document_id, $associate_id ) ) {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger">No such document found related to the associate.</div>');
			redirect ('/dashboard');
			exit;
		}

		if( count($_POST) ) {

			$document_info = $this->document_update_model->getById( DOCUMENT, DOCUMENT_ID, $this->input->post('document_id') );
			$associate_info = $this->create_model->get_data_for_new_associate( '',$this->input->post('associate_id') );
			$values = (object) array_merge( (array)$associate_info, (array)$document_info );
			//print_r( $values->email );exit();
			if ( $decline ) {

				if( empty( $this->input->post('comment') ) ) {
					$this->session->set_flashdata('message', '<div class="alert alert-success">Plese enter comment for rejection of document.</div>');
					redirect('new_associate/view/'.$this->input->post('associate_id').'/'.$this->input->post('document_id'));
					exit;
				}	
					
				
				if ( $this->document_update_model->insert_comment( $this->input->post('associate_id'),$this->input->post('document_id'), $this->input->post('comment') ) ) {
					$updated = $this->document_update_model->decline_documents( 
						$this->input->post('associate_id'),
						$this->input->post('document_id')
					);	

					if( $updated ) {
						
						//insert in log
						$assoc_info = $this->document_update_model->getById( NEW_ASSOCIATE, NEW_ASSOCIATE_ID, $this->input->post('associate_id') );
						
						$this->document_update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document Rejected', 'Document \''.$document_info->{DOCUMENT_TITLE}.'\' is rejected for \''.$assoc_info->{NEW_ASSOCIATE_USERNAME}.'\' fot the following reason : '.$this->input->post('comment') );
						
						$comment = [
							'rejection_comment' => $this->input->post('comment')
						];
						$values = (object) array_merge( (array)$values, $comment );						

						if ( $this->document_update_model->send_email( 'rejected_document', $values->email, $values ) ) {
							
						}
						$this->session->set_flashdata('message', '<div class="alert alert-success">The document has been declined.</div>');
						redirect('/dashboard');
						exit;
					}	
				}
				
			}
			else {
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
					
					//insert in log
					$assoc_info = $this->document_update_model->getById( NEW_ASSOCIATE, NEW_ASSOCIATE_ID, $this->input->post('associate_id') );
					
					$this->document_update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document Verified', 'Document \''.$document_info->{DOCUMENT_TITLE}.'\' is verified for \''.$assoc_info->{NEW_ASSOCIATE_USERNAME}.'\'' );
					
					if( $this->document_update_model->all_document_verified( $this->input->post('associate_id') ) )
					{

						if ( $this->document_update_model->send_email( 'verified_document', $values->email, $values ) )//for email address use $value->email variable
						{
							
						}
						
						//email send to admin
						if ( $this->document_update_model->send_email( 'status_change_from_hr_to_verify_to_hr_verified', $values->email, $values ) )//for email address use $value->email variable
						{
							
						}
						
					}
					$this->session->set_flashdata('message', '<div class="alert alert-success">The document has been verified.</div>');
					redirect('/dashboard');
					exit;
				}
			}

		}

		$data['verify'] = ((int)$associate_document->status === 4)? FALSE:TRUE;
		$data['associate_id'] = $associate_id;
		$data['document_id'] = $document_id;
		$this->load->view('common/header');
		$this->load->view('view', $data);
		$this->load->view('common/footer');

	}

	public function view_all_document( $associate_id, $decline=0 )
	{
		
		if( empty($associate_id) ) {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger">No such document found related to the associate.</div>');
			redirect ('/dashboard');
			exit;
		}

		if( count($_POST) ) {
			// print_r( $decline ); exit();
			if ( $decline ) {
				foreach ($this->input->post('document_id') as $doc) {

					$updated = $this->document_update_model->decline_documents( 
						$this->input->post('associate_id'),
						$doc 
					);	
				}

				if( $updated ) {
					$this->session->set_flashdata('message', '<div class="alert alert-success">The document has been declined.</div>');
					redirect('/dashboard');
					exit;
				}	
			}
			else
			{
				$update_document = array(
					STATUS		=> 4,
					'submitted_date'=> date('Y-m-d H:i:s', now())
				);
				

				$updated = $this->document_update_model->verify_documents( 
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

		}

		//$data['verify'] = ((int)$associate_document->status === 4)? FALSE:TRUE;
		$data['associate_id'] = $associate_id;
		$data['document_ids'] = $this->new_associate_model->get_all_document_of_user( $associate_id );
		//$data['document_id'] = $document_id;
		$this->load->view('common/header');
		$this->load->view('view_all_document', $data);
		$this->load->view('common/footer');

	}

	public function read( $associate_id, $document_id )
	{

		if( empty($associate_id) 
			|| empty($document_id) 
			|| ! $associate_document = $this->document_update_model->associate_document( $document_id, $associate_id ) ) {
			
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
	
	public function get_organizational_hierarchy()
	{
		if( count($_POST) ) {
			
			if ( $rows = $this->new_associate_model->get_organizational_hierarchy( $_POST['table'], $_POST['column'], $_POST['id'] ) ) {

			}

			$data = ['result' => $rows, 'success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
	
	public function check_duplicate_by_ajax()
	{
		if( count($_POST) ) {
			
			if ( $rows = $this->new_associate_model->check_duplicate_by_ajax( $_POST['table'], $_POST['column'], $_POST['id'], $_POST['associate_id'] ) ) 
			{
				$data = ['success' => 1]; // no duplicate entry found
			}
			else
			{
				$data = ['success' => 0];	// duplicate entry found
			}

		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
		
	}

}