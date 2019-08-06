<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('document_create_model');
		$this->load->model('variable_model');
	}

	public function index() 
	{
		$data['title'] = "Document";
		if( count($_POST) ) {
			//upload doc
			if ( $this->input->post('doc_type') == 'upload' ) 
			{
					
				$full_path = $this->document_create_model->do_upload('upload_file','./assets/uploaded_documents/');
				$_POST['document'] = $full_path;

			}
			//upload doc end
			
			$this->form_validation->set_rules('document_title', 'Document Title', 'trim|required');
			$this->form_validation->set_rules('doc_folder', 'Document Folder', 'trim|required');
			$this->form_validation->set_rules('doc_category', 'Document Category', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('form_steps', 'Form Steps', 'trim|required');
			
			$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required');
			
			if ( $this->form_validation->run() ) 
			{
				if ( $this->input->post('doc_type') == 'upload' ) {
					$_POST['doc_type'] = 2;
				}
				else{
					$_POST['doc_type'] = 1;
				}
				$document_id = $this->document_create_model->create( 
					$this->input->post('document_title'), 
					$this->input->post('document', FALSE),
					$this->input->post('doc_folder'),
					$this->input->post('doc_category'),
					$this->input->post('status'),
					$this->input->post('form_steps'),
					$this->input->post('doc_password'),
					
					$this->input->post('doc_type')
				);

				if( $document_id ) {

					if( ! empty($_POST['variables']) AND count($_POST['variables']) ) 
					{

						foreach ($this->input->post('variables') as $value) {
							
							$this->variable_model->create( 
								$value['field_name'], 
								$value['varname'], 
								$document_id, 
								$value['role_id'] 
							);
						}
					}

					if( ! empty( $_POST['form_steps_role'] ) && 
						( count($this->input->post('form_steps_role')) == $this->input->post('form_steps') ) ) {

						$form_steps = [];
						foreach($this->input->post('form_steps_role') as $key => $role_id) {
							$form_steps[] = array(
								'document_id'		=> $document_id,
								'role_id'			=> $role_id,
								'form_step'			=> ($key+1)
							);
						}

						$this->document_create_model->delete_form_steps( $document_id );
						$this->document_create_model->create_form_steps( $form_steps );
					}
					//insert in log
					$this->document_create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document', 'New Document template - \''.$this->input->post('document_title').'\' is created' );
					$this->session->set_flashdata('message', 'Document has been created.');
					redirect('/document');
					exit;
				}
			}

		}

		$data['doc_folders'] = $this->document_create_model->getAll( DOCUMENT_FOLDER );
		$data['doc_categories'] = $this->document_create_model->getAll( DOCUMENT_CATEGORY );
		$data['roles'] = $this->document_create_model->getAll( ROLE );

		$this->load->view('common/header');
		$this->load->view('create',$data);
		$this->load->view('common/footer');
	}
}