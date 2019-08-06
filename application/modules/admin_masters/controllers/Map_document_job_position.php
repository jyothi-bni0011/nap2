<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map_document_job_position extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('map_document_job_position_model');
	}

	
	//list of category
	public function index()
	{
		$data['title'] = "Map Document to Job Title";

		$positions = $this->map_document_job_position_model->position_having_documents();
		
		$position_id = array();
		foreach ( $positions as $tmp ) {
			array_push($position_id, $tmp->{JOB_POSITION_ID});
		}
		
		$data['positions'] = $positions;
		$data['documents'] = [];

		if( $position_id ) {
			$data['documents'] = $this->map_document_job_position_model->get_maping_data( $position_id );
		}

		$this->load->view('common/header');
		$this->load->view('map_document_job_position/get_map_document_job_position', $data);
		$this->load->view('common/footer');
	}
	//list of category end

	//create category
	public function create_map_document_job_position()
	{
		$data['title'] = "Map Document to Job Title";
		if( count($_POST) ) 
		{
			//print_r($_POST);exit();
			$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|numeric');
			$this->form_validation->set_rules('doc_folder', 'Document Folder', 'trim|required|numeric');
			//$this->form_validation->set_rules('doc_name', 'Document Name', 'trim|required');
			
			if( $this->form_validation->run() ) 
			{

				if( $this->map_document_job_position_model->create_map_document_job_position( $this->input->post('job_title'), $this->input->post('doc_folder'), $this->input->post('doc_name') ) ) 
				{
					//$data['message'] = "Role has been created.";
					
					$job_title = $this->map_document_job_position_model->getById( JOB_POSITION, JOB_POSITION_ID, $this->input->post('job_title') );
					//insert in log
					$this->map_document_job_position_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Map Document To Job Title', 'New document mapping for \''.$job_title->{JOB_POSITION_CODE}.'\' is created' );
					
					$this->session->set_flashdata('message', 'Document to Job Title has been mapped.');
				}
				else 
				{
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to map Document to Job Title');
					redirect( '/admin_masters/map_document_job_position/create_map_document_job_position', $data );
					exit;
				}
			}
			else 
			{
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( 'admin_masters/map_document_job_position/create_map_document_job_position', $data );
				exit;
			}
			redirect( 'admin_masters/map_document_job_position', $data );
		}
		else
		{
			$data['doc_names'] = $this->map_document_job_position_model->getAll( DOCUMENT );
			$data['job_titles'] = $this->map_document_job_position_model->position_not_having_documents();
			$data['doc_folders'] = $this->map_document_job_position_model->getAll( DOCUMENT_FOLDER );

			$this->load->view('common/header');
			$this->load->view('map_document_job_position/create_map_document_job_position', $data);
			$this->load->view('common/footer');
		}

	}
	//create category end

	//update category
	public function update_map_document_job_position($slag='')
	{
		$data['title'] = "Map Document to Job Title";

		if( count($_POST) ) {
				 
			//$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|numeric');
			$this->form_validation->set_rules('doc_folder', 'Document Folder', 'trim|required|numeric');
			
			if( $this->form_validation->run() ) {

				if( $this->map_document_job_position_model->delete_map_document_job_position( $_POST['position_id'] ) ) 
				{
					if ( $this->map_document_job_position_model->create_map_document_job_position( $this->input->post('position_id'), $this->input->post('doc_folder'), $this->input->post('doc_name') ) ) 
					{
						$job_title = $this->map_document_job_position_model->getById( JOB_POSITION, JOB_POSITION_ID, $this->input->post('position_id') );
						//insert in log
						$this->map_document_job_position_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Map Document To Job Title', 'Document mapping for \''.$job_title->{JOB_POSITION_CODE}.'\' is updated' );
						
						$this->session->set_flashdata('message', 'Document to Job Title has been mapped.');
						redirect( 'admin_masters/map_document_job_position', $data );
					}
				}
				
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( 'admin_masters/map_document_job_position/update_map_document_job_position'.$_POST['position_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $data['rows'] = $this->map_document_job_position_model->get_mapping_by_position_id( $slag ) ) 
			{
				$data['doc_folders'] = $this->map_document_job_position_model->getAll( DOCUMENT_FOLDER );
				
				// $data['doc_names'] = $this->map_document_job_position_model->find_docs_in_folder( $data['rows'][0]->{DOCUMENT_FOLDER_ID} );

				$data['doc_names'] = $this->map_document_job_position_model->get_maping_data( explode(',', $slag) );
				
				$data['job_titles'] = $this->map_document_job_position_model->getById( JOB_POSITION, JOB_POSITION_ID, $slag );

				// print_r($data['doc_names']);exit();
			}
		}

		$this->load->view('common/header');
		$this->load->view('map_document_job_position/update_map_document_job_position', $data);
		$this->load->view('common/footer');
	}
	//update category end

	//delete category
	public function delete_map_document_job_position($value='')
	{
		if( count($_POST) ) {
			
			if ( $this->map_document_job_position_model->delete_map_document_job_position( $_POST['position_id'] ) ) {
				//$data['message'] = "Role deleted successfuly";
				
				$job_title = $this->map_document_job_position_model->getById( JOB_POSITION, JOB_POSITION_ID, $_POST['position_id'] );
				//insert in log
				$this->map_document_job_position_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Map Document To Job Title', 'Document mapping for \''.$job_title->{JOB_POSITION_CODE}.'\' is deleted' );
				
			}

			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
	//dlete category end

	public function find_docs_in_folder()
	{
	 	if( count($_POST) ) {
			
			if ( $rows = $this->map_document_job_position_model->find_docs_in_folder( $_POST['folder_id'] ) ) {
				
			}

			$data = ['documents' => $rows, 'success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	} 
}