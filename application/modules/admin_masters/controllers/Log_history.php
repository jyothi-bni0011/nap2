<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_history extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('log_history_model');
	}

	
	//list of category
	public function index()
	{
		$data['title'] = 'Log History';

		$data['log_history'] = $this->log_history_model->get_log_history();

		$this->load->view('common/header');
		$this->load->view('log_history/log_history', $data);
		$this->load->view('common/footer');
	}

}