<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UpdateCategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('updatecategory_model');
	}

	

	public function index($slag="")
	{

		$data['title'] = "Category";

		if( count($_POST) ) {
			$this->form_validation->set_rules('category_name', 'Category', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('category_description', 'Category Description', 'trim|max_length[254]');

			if( $this->form_validation->run() ) {

				if( $this->updatecategory_model->update( $this->input->post('category_name'), $this->input->post('category_description'), $this->input->post('category_id') ) ) {
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Category has been updated.');
					redirect( '/category/getcategory', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the category');
					redirect( '/category/updatecategory/index/'.$_POST['category_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/category/update_category/index/'.$_POST['category_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->updatecategory_model->fetch_data( $slag ) ) {

				$data['category_name'] = $row->{CATEGORY_NAME};
				$data['category_description'] = $row->{CATEGORY_DESCRIPTION};
				$data['category_id'] = $row->{CATEGORY_ID};
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('update_category', $data);
		$this->load->view('common/footer');
		
	}

}