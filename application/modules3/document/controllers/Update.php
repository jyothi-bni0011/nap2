<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://jsfiddle.net/szimek/jq9cyzuc/

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('document_update_model');
		$this->load->model('variable_model');
	}

	public function index( $document_id )
	{

		if( count($_POST) ) 
		{
			if( $this->document_update_model->update( $this->input->post('document_id'), $this->input->post('document_title'), $this->input->post('document', FALSE), $this->input->post('doc_folder'), $this->input->post('doc_category'), $this->input->post('status') ) )
			{

				if( ! empty($_POST['variables']) AND count($_POST['variables']) ) 
				{
					foreach ($this->input->post('variables') as $value) {
					
						$this->variable_model->create(
							$value['field_name'], 
							$value['varname'], 
							$this->input->post('document_id'), 
							$value['role_id'] 
						);
					}
				}

				$this->data['message'] = sprintf('<div class="alert alert-%s">%s</div>', "success", "Document has been saved.");
				redirect('document/');
				exit;
			}
		}

		if( $document_id ) {

			$this->data['document'] 	= $this->document_update_model->get( $document_id );
			$this->data['variables'] 	= $this->document_update_model->getVariables( $document_id );
		}

		$this->data['doc_folders'] = $this->document_update_model->getAll( DOCUMENT_FOLDER );
		$this->data['doc_categories'] = $this->document_update_model->getAll( DOCUMENT_CATEGORY );
		$this->data['roless'] = $this->document_update_model->getAll( ROLE );

		$this->load->view('common/header');
		$this->load->view('update', $this->data);
		$this->load->view('common/footer');
	}

}