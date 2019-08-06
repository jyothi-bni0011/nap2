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

	public function index() {

		if( count($_POST) ) {

			$document_id = $this->document_create_model->create( 
				$this->input->post('document_title'), 
				$this->input->post('document', FALSE),
				$this->input->post('doc_folder'),
				$this->input->post('doc_category'),
				$this->input->post('status')
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

				redirect('document/');
				exit;
			}

		}

		$data['doc_folders'] = $this->document_create_model->getAll( DOCUMENT_FOLDER );
		$data['doc_categories'] = $this->document_create_model->getAll( DOCUMENT_CATEGORY );

		$this->load->view('common/header');
		$this->load->view('create',$data);
		$this->load->view('common/footer');
	}
}