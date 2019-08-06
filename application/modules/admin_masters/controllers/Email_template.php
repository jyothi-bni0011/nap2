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
					
					//insert in log
					$this->email_template_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Email Template', 'Email Template \''.$this->input->post('subject').'\' is updated' );
					
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


	
}