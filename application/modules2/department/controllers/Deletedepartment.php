<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deletedepartment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		$this->load->model('deletedepartment_model');
	}

	

	public function index()
	{

		if( count($_POST) ) {
			
			if ( $this->deletedepartment_model->delete( $_POST['department_id'] ) ) {
				//$data['message'] = "Role deleted successfuly";
			}

			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}