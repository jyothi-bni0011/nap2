<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Variable extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('variable_model');
	}

	public function index()
	{

		$json['success'] = 0;
		$variable_id = $this->variable_model->create( 
			$this->input->post('field_name'), 
			$this->input->post('varname'),
			$this->input->post('document_id')
		);

		if( $variable_id ) {
			$json['href'] = '<a href="javascript:return false;" class="active-variable list-group-item list-group-item-action border-0" data-field_name="' . $this->input->post('field_name') . '" data-varname="' . $this->input->post('varname') . '">' . $this->input->post('varname') . '</a>';
			$json['success'] = 1;
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

}