<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_move extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('new_associate/new_associate_model');
	}

	public function index()
	{

		$dest_folder = $this->input->post('folder_url') . 'documents/';

		if( count($_POST) ) 
		{
			
			$user_documents = $this->new_associate_model->get_all_document_of_user( $this->input->post('user_ids[]') );
			foreach ($user_documents as $user_document) 
			{
				$move_to = $dest_folder . $user_document->associate_username . '/';
				if( ! is_dir($move_to) ) {
					@mkdir($move_to, 0777, TRUE);
				}

				if( file_exists( dirname( APPPATH ) . $user_document->file_url ) ) {
					@copy( dirname( APPPATH ) . $user_document->file_url, $move_to . basename(dirname( APPPATH ) . $user_document->file_url));
					
					
				}

			}
			//insert in log
			$this->dashboard_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Move Document', 'Documents moved' );
					
			$this->data['message'] = '<div class="alert alert-success">Selected files have been moved.</div>';
		}

		$not_in_user = $this->dashboard_model->find_user_doc_status([3,1,2]);
		$user_list = array_ids( $not_in_user, USER_ID );

		$this->data['documents'] = [];
		if( $user_list ) {
			$this->data['documents'] = $this->dashboard_model->associate_status(4, 0, $user_list);
		}

		$this->load->view('common/header');
		$this->load->view('index', $this->data);
		$this->load->view('common/footer');
	}

}
