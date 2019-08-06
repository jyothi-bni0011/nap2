<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatedocumentcategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('updatedocumentcategory_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Document Category";

		if( count($_POST) ) {
			$this->form_validation->set_rules('doc_category', 'Document Category', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('doc_description', 'Document Description', 'trim|required|max_length[254]');	

			if( $this->form_validation->run() ) {

				if( $this->updatedocumentcategory_model->update( $this->input->post('doc_category'), $this->input->post('doc_description'), $this->input->post('doc_cat_id') ) ) {
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Document category has been updated.');
					redirect( '/document_category/getdocumentcategory', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the document category');
					redirect( '/document_category/updatedocumentcategory/index/'.$_POST['doc_cat_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/document_category/updatedocumentcategory/index/'.$_POST['doc_cat_id'] );
			}

		}

		if( $slag ) {
			
			if( $row=$this->updatedocumentcategory_model->fetch_data( $slag ) ) {

				$data['doc_cat_name'] = $row->{DOCUMENT_CATEGORY_NAME};
				$data['doc_cat_description'] = $row->{DOCUMENT_CATEGORY_DESCRIPTION};
				$data['doc_cat_id'] = $row->{DOCUMENT_CATEGORY_ID};
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update_document_category', $data);
		$this->load->view('common/footer');
		
	}

}