<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('category_model');
	}

	
	//list of category
	public function index()
	{
		$data['title'] = "Category";
		
		$data['categories'] = $this->category_model->getAll( CATEGORY );

		$this->load->view('common/header');
		$this->load->view('category/get_category', $data);
		$this->load->view('common/footer');
	}
	//list of category end

	//create category
	public function create_category()
	{
		$data['title'] = "Category";
		if( count($_POST) ) 
		{
			
			$this->form_validation->set_rules('category_name', 'Category', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('category_description', 'Category Description', 'trim|max_length[254]');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) 
			{

				if( $this->category_model->create_category( $this->input->post('category_name'), $this->input->post('category_description') ) ) 
				{
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Category has been created.');
				}
				else 
				{
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to create the category');
					redirect( '/admin_masters/category/create_category', $data );
					exit;
				}
			}
			else 
			{
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( 'admin_masters/category/create_category', $data );
				exit;
			}
			redirect( 'admin_masters/category', $data );
		}
		else
		{

			$this->load->view('common/header');
			$this->load->view('category/create_category', $data);
			$this->load->view('common/footer');
		}

	}
	//create category end

	//update category
	public function update_category($slag='')
	{
		$data['title'] = "Category";

		if( count($_POST) ) {
			$this->form_validation->set_rules('category_name', 'Category', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('category_description', 'Category Description', 'trim|max_length[254]');

			if( $this->form_validation->run() ) {

				if( $this->category_model->update_category( $this->input->post('category_name'), $this->input->post('category_description'), $this->input->post('category_id') ) ) {
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Category has been updated.');
					redirect( 'admin_masters/category', $data );
					exit;
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the category');
					redirect( 'admin_masters/category/update_category/'.$_POST['category_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( 'admin_masters/category/update_category/'.$_POST['category_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->category_model->getById( CATEGORY, CATEGORY_ID, $slag ) ) {

				$data['category_name'] = $row->{CATEGORY_NAME};
				$data['category_description'] = $row->{CATEGORY_DESCRIPTION};
				$data['category_id'] = $row->{CATEGORY_ID};
				
			}
		}

		$this->load->view('common/header');
		$this->load->view('category/update_category', $data);
		$this->load->view('common/footer');
	}
	//update category end

	//delete category
	public function delete_category($value='')
	{
		if( count($_POST) ) {
			
			
			if ( $this->category_model->delete_category( $_POST['category_id'] ) ) {
				//$data['message'] = "Role deleted successfuly";
			}

			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
	//dlete category end
}