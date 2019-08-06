<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateCategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('createcategory_model');
	}

	

	public function index()
	{

		$data['title'] = "Category";

		if( count($_POST) ) {
			
			$this->form_validation->set_rules('category_name', 'Category', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('category_description', 'Category Description', 'trim|max_length[254]');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) {

				if( $this->createcategory_model->create( $this->input->post('category_name'), $this->input->post('category_description') ) ) {
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Category has been created.');
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to create the category');
					redirect( '/category/createcategory', $data );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/category/createcategory', $data );
				exit;
			}
			redirect( '/category/getcategory', $data );
		}
		else{

			$this->load->view('common/header');
			$this->load->view('create_category', $data);
			$this->load->view('common/footer');
		}

	}

}