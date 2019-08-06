<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('email_template_model');
	}

	
	//list of category
	public function index()
	{
		$data['title'] = "Email Template";
		
		$data['templates'] = $this->email_template_model->getAll( EMAIL_TEMPLATE );

		$this->load->view('common/header');
		$this->load->view('admin_masters/email_template/get_email_template', $data);
		$this->load->view('common/footer');
	}
	//list of category end

	//create category
	public function update_email_template( $slag )
	{
		$data['title'] = "Email Setting";
		if( count($_POST) ) 
		{
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('body', 'Body', 'trim|required');
			//$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			if( $this->form_validation->run() ) 
			{

				if( $this->email_template_model->update_email_template( $this->input->post('subject'), $this->input->post('body'), $this->input->post('template_id') ) )
				{
					//$data['message'] = "Role has been created.";
					$this->session->set_flashdata('message', 'Email template has been updated.');
				}
				else 
				{
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the email template');
					redirect( '/admin_masters/email_template/update_email_template/'.$slag);
					exit;
				}
			}
			else 
			{
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/admin_masters/email_template/update_email_template/'.$slag );
				exit;
			}
			redirect( '/admin_masters/email_template', $data );
		}
		else
		{
			$data['variables'] = $this->email_template_model->get_veriables();
			$data['template']  = $this->email_template_model->getById( EMAIL_TEMPLATE, EMAIL_TEMPLATE_ID, $slag );
			$this->load->view('common/header');
			$this->load->view('admin_masters/email_template/update_email_template', $data);
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