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

		if( count($_POST) ) {

			$document_id = $this->document_create_model->create( 
				$this->input->post('document_title'), 
				$this->input->post('document', FALSE),
				$this->input->post('doc_folder'),
				$this->input->post('doc_category'),
				$this->input->post('status'),
				$this->input->post('form_steps')
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

				redirect('/document');
				exit;
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