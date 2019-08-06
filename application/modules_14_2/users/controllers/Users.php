<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('users_model');
	}

	

	public function index()
	{

		$data['title'] = "Users";
		
		$data['users'] = $this->users_model->users();

		$this->load->view('common/header');
		$this->load->view('users', $data);
		$this->load->view('common/footer');
	}

}