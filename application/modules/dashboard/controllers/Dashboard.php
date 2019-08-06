<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends MY_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('document/document_update_model');
		$this->data['document_statuses'] = $this->document_update_model->document_statuses;
		
		$this->load->model('dashboard_model');
		$this->load->model('new_associate/create_model');
	}
	
	public function index() 
	{

		if( (int)$this->session->userdata('role_id') === 4 ) {
			redirect('new_associate/dashboard/');
			exit;
		}
		
		$this->data['title'] = "Dashboard";

		$this->data['hr_in_process'] = $this->dashboard_model->associate_status(3,4);
		$this->data['statistics_hr_in_process'] = $this->dashboard_model->statistics( 3 );
		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		$this->data['associate_email_sent'] = $this->dashboard_model->associate_status(1,4,$user_list);
		$this->data['statistics_associate_email_sent'] = $this->dashboard_model->statistics( 1, $user_list );

		
		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3,1]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		$this->data['associate_verify'] = $this->dashboard_model->associate_status(2,4,$user_list);
		$this->data['statistics_associate_verify'] = $this->dashboard_model->statistics( 2, $user_list );
		
		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3,1,2]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		$this->data['associate_verified'] = $this->dashboard_model->associate_status(4,4,$user_list);
		$this->data['statistics_associate_verified'] = $this->dashboard_model->statistics( 4, $user_list );

		$this->data['job_titles'] = $this->dashboard_model->getAll( JOB_POSITION );
		$this->data['org_units']  = $this->dashboard_model->getAll( ORGANIZATIONAL_UNIT );
		$this->data['fun_areas']  = $this->dashboard_model->getAll( FUNCTIONAL_AREA );
		$this->data['departments']  = $this->dashboard_model->getAll( DEPARTMENT );
		//echo "<pre>";print_r($this->data);exit();
		$this->load->view('common/header');
		$this->load->view('dashboard', $this->data);
		$this->load->view('common/footer');

	}

	public function hr_email_sent()
	{
		$this->data['title'] = "HR Email Sent";

		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		
		$this->data['associate_email_sent'] = $this->dashboard_model->associate_status(1,0,$user_list);

		$this->load->view('common/header');
		$this->load->view('hr_email_sent', $this->data);
		$this->load->view('common/footer');	
	}

	public function hr_to_verify()
	{
		$this->data['title'] = "HR To Verify";

		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3,1]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		
		$this->data['associate_verify'] = $this->dashboard_model->associate_status(2,0,$user_list);

		$this->load->view('common/header');
		$this->load->view('hr_to_verify', $this->data);
		$this->load->view('common/footer');	
	}

	public function hr_verified()
	{
		$this->data['title'] = "HR Verified";

		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3,1,2]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}

		$this->data['associate_verified'] = $this->dashboard_model->associate_status(4,0,$user_list);

		$this->load->view('common/header');
		$this->load->view('hr_verified', $this->data);
		$this->load->view('common/footer');	
	}

	public function hr_to_process()
	{
		$this->data['title'] = "HR To Process";
		
		$this->data['hr_to_process'] = $this->dashboard_model->associate_status(3);
		
		$this->load->view('common/header');
		$this->load->view('hr_to_process', $this->data);
		$this->load->view('common/footer');	
	}

	public function send_follow_up_email( $associate_id )
	{
		$associate_info = $this->create_model->get_data_for_new_associate( '', $associate_id );

		$this->dashboard_model->send_email( 'follow_up', $associate_info->email, $associate_info );//$associate_info->email
		
		redirect('dashboard','refresh');
		exit();
		
	}

	public function filter_by_job_title()
	{

		//$this->data['hr_in_process'] = $this->dashboard_model->associate_status(3,0);
		$hr_in_process = $this->dashboard_model->statistics_for_graph( 3, 0, $_POST['col_name'], $_POST['col_val'] );
		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		//$this->data['associate_email_sent'] = $this->dashboard_model->associate_status(1,0,$user_list);
		$email_sent = $this->dashboard_model->statistics_for_graph( 1, $user_list, $_POST['col_name'], $_POST['col_val']  );

		
		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3,1]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		//$this->data['associate_verify'] = $this->dashboard_model->associate_status(2,0,$user_list);
		$verify = $this->dashboard_model->statistics_for_graph( 2, $user_list, $_POST['col_name'], $_POST['col_val'] );
		
		$this->data['not_in_user'] = $this->dashboard_model->find_user_doc_status([3,1,2]);
		$user_list = [];
		if(is_array( $this->data['not_in_user'] )) 
		{
			foreach ($this->data['not_in_user'] as $key ) {
				$user_list[] = $key->{USER_ID};
			}
		}
		//$this->data['associate_verified'] = $this->dashboard_model->associate_status(4,0,$user_list);
		$verified = $this->dashboard_model->statistics_for_graph( 4, $user_list, $_POST['col_name'], $_POST['col_val'] );

		$data = ['hr_in_process' 	=> 	$hr_in_process, 
				 'email_sent' 		=> 	$email_sent,
				 'verify' 			=> 	$verify,
				 'verified' 		=> 	$verified,
				 'success' 			=> 	1
				]; 
		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		
	}
}