<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_group extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('hr_group_model');
	}

	
	//list of category
	public function index()
	{

		$hr_members 	= [];
		$hr_groups 		= $this->hr_group_model->get();
		if( $hr_groups ) {
			$hr_group_ids 	= array_ids( $hr_groups, HR_GROUP_ID );
			$hr_members 	= $this->hr_group_model->get_hr_members( $hr_group_ids );
			$hr_members 	= map_id_key( $hr_members, HR_GROUP_ID );
		}

		$data['title'] 	= "HR Group";
		$data['hr_groups'] = $hr_groups;
		$data['hr_members'] = $hr_members;

		$this->load->view('common/header');
		$this->load->view('hr_group/get_hr_group', $data);
		$this->load->view('common/footer');
	}

	//create category
	public function create_hr_group()
	{
		$data['title'] = "HR Group";
		if( count($_POST) ) 
		{
			
			$this->form_validation->set_rules('group_name', 'HR Group', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('group_description', 'HR Group Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('functional_area', 'Functional Area', 'trim|required|numeric');
			$this->form_validation->set_rules('members', 'Members', 'trim|numeric');

			if( $this->form_validation->run() ) 
			{

				if( $inserted_id = $this->hr_group_model->create_hr_group( $this->input->post('group_name'), $this->input->post('group_description'), $this->input->post('functional_area') ) ) 
				{
					if ($this->hr_group_model->create_hr_group_mapping( $inserted_id, $this->input->post('members') ) )
					{
						$this->session->set_flashdata('message', 'HR Group has been created.');
					}
				}
				else 
				{
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to create the HR Group');
					redirect( '/admin_masters/hr_group/create_hr_group', $data );
					exit;
				}
			}
			else 
			{
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( 'admin_masters/hr_group/create_hr_group', $data );
				exit;
			}
			redirect( 'admin_masters/hr_group', $data );
		}
		else
		{
			$data['functional_areas'] = $this->hr_group_model->getAll( FUNCTIONAL_AREA );
			//$data['members'] = $this->hr_group_model->getAll( USER );
			//$data['members'] = $this->hr_group_model->get_all_hr_associate();
			$data['members'] = $this->hr_group_model->get_user_by_role(2);

			$this->load->view('common/header');
			$this->load->view('hr_group/create_hr_group', $data);
			$this->load->view('common/footer');
		}

	}
	//create category end

	//update category
	public function update_hr_group($slag='')
	{
		$data['title'] = "HR Group";

		if( count($_POST) ) {
			$this->form_validation->set_rules('group_name', 'HR Group', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('group_description', 'HR Group Description', 'trim|max_length[254]');
			$this->form_validation->set_rules('functional_area', 'Functional Area', 'trim|required|numeric');
			$this->form_validation->set_rules('members', 'Members', 'trim|numeric');

			if( $this->form_validation->run() ) {

				if( $this->hr_group_model->update_hr_group( $this->input->post('group_name'), $this->input->post('group_description'), $this->input->post('functional_area'), $this->input->post('group_id') ) ) {
						
					if ( !empty( $this->input->post('members') ) ) {
						//echo $_POST['group_id'];die();
						$this->hr_group_model->delete_and_insert_new_mapping( $this->input->post('group_id'), $this->input->post('members') ); 
						$this->session->set_flashdata('message', 'HR Group has been updated.');
						redirect( 'admin_masters/hr_group', $data );
						exit;
					}
					else {
						
						$this->session->set_flashdata('message', 'HR Group has been updated.');
						redirect( 'admin_masters/hr_group', $data );
						exit;
					}
				}
				else {
					//$data['message'] = "Failed to crate the role";
					$this->session->set_flashdata('message', 'Failed to update the HR Group');
					redirect( 'admin_masters/hr_group/update_hr_group/'.$_POST['group_id'] );
					exit;
				}
			}
			else {
				//$data['message'] = validation_errors();
				$this->session->set_flashdata('message', validation_errors());
				redirect( 'admin_masters/hr_group/update_hr_group/'.$_POST['group_id'] );
				exit;
			}

		}

		if( $slag ) {
			
			if( $row=$this->hr_group_model->getById( HR_GROUP, HR_GROUP_ID, $slag ) ) {
				$data['group_name'] = $row->{HR_GROUP_NAME};
				$data['group_description'] = $row->{HR_GROUP_DESCRIPTION};
				$data['group_id'] = $row->{HR_GROUP_ID};
				$data['fun_area'] = $row->{FUNCTIONAL_AREA_ID};

				$data['mapped_members'] = $this->hr_group_model->get_hr_group_members( $data['group_id'] );
			}
		}

		$data['functional_areas'] = $this->hr_group_model->getAll( FUNCTIONAL_AREA );
		//$data['members'] = $this->hr_group_model->getAll( USER );
		//$data['members'] = $this->hr_group_model->get_all_hr_associate();
		$data['members'] = $this->hr_group_model->get_user_by_role(2);

		$this->load->view('common/header');
		$this->load->view('hr_group/update_hr_group', $data);
		$this->load->view('common/footer');
	}
	//update category end

	//delete category
	public function delete_hr_group()
	{
		if( count($_POST) ) {
			
			
			if ( $this->hr_group_model->delete_hr_group( $_POST['group_id'] ) ) {
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