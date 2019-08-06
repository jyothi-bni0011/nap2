<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeleteCategory extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		$this->load->model('deletecategory_model');
	}

	

	public function index()
	{

		if( count($_POST) ) {
			
			if ( $this->deletecategory_model->delete( $_POST['category_id'] ) ) {
				//$data['message'] = "Role deleted successfuly";
			}

			$data = ['success' => 1]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
	}
}