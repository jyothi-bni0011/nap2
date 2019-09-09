<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	
	//This function check duplicate entry in database. If entry is duplicate then it return false and if no duplicate entry then return true.
	public function check_duplicate( $table, $column, $value, $notin=0, $notincolunm='' )
	{
		$this->db->where($column, $value);
		
		if ($notin != 0) {
			$this->db->where_not_in( $notincolunm, $notin );
		}

		$res = $this->db->get($table);
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}
	//Function end

	//This function get all data from the table and return object formated data
	public function getAll( $table )
	{
		$this->db->select('*');
		$this->db->from( $table );
		$query = $this->db->get();
		return $query->result();
	}
	//function end

	//This function get data from table by ID
	public function getById( $table, $column, $value )
	{
		if( empty($value) ) {
			return false;
		}

		$row = $this->db->get_where( $table, array( $column => $value ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;
	}
	//Function end

	//This function sends email 
	public function send_email( $email_type, $to, $data )
	{
		if ( $email_template = $this->getById( EMAIL_TEMPLATE, EMAIL_TEMPLATE_NAME, $email_type ) ) 
		{

			// $msg = $this->load->view( 'forgot.php', $data, true );
			$this->load->library('email', config_item('email_config'));
			$this->email->set_newline("\r\n");
			$this->email->from('nap.support@bluenettech.com'); // change it to yours
			$this->email->to( $to );// change it to yours rahul.deo@talentserv.co.in
			$this->email->subject( $email_template->{EMAIL_TEMPLATE_SUBJECT} );

			// $data['first_name'] = "Rahul Deo";
			$email_body = $email_template->{EMAIL_TEMPLATE_BODY};

			foreach ($data as $key => $value) {
				$email_body = str_replace("{" .$key . "}", $value, $email_body);
			}
			
			$this->email->message( $email_body );
			if($this->email->send())
			{
//				echo 'Email sent.';
				return true;
			}
			else
			{
				show_error($this->email->print_debugger());
			} 
		
		}
		else{
			return false;
		} 

		return false;
	}
	//Function End
	
	public function get_data_for_new_associate( $email_id='', $id=0 )
	{
		$this->db->select('new_associate.associate_username as user_name, new_associate.associate_email as email, new_associate.associate_first_name as first_name, new_associate.associate_middle_name as middle_name, new_associate.associate_last_name as last_name,new_associate.associate_start_date as start_date ,job_position.position_code as job_title, organizational_unit.org_unit_name as organizational_unit, functional_area.fun_area_name as functional_area, department.department_name as department, associate_manager_name as manager_name, associate_manager_title as manager_title')
			->from( NEW_ASSOCIATE )
			->join( JOB_POSITION, 'job_position.position_id = new_associate.position_id', 'left' )
			->join( ORGANIZATIONAL_UNIT, 'organizational_unit.org_unit_id = new_associate.org_unit_id', 'left' )
			->join( FUNCTIONAL_AREA, 'functional_area.fun_area_id = new_associate.fun_area_id', 'left' )
			->join( DEPARTMENT, 'department.department_id = new_associate.department_id', 'left' );
			
			if ( $email_id != '' ) {
				$this->db->where( 'new_associate.associate_email', $email_id );
			}
			if ( $id ) {
				$this->db->where( 'new_associate.associate_id', $id );	
			}
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_doc_list_of_associate( $email_id='', $id=0 )
	{
		$this->db->select('document.document_title')
			->from( USER_DOCUMENT_MAPPING )
			->join( DOCUMENT, 'document.document_id = user_document_mapping.document_id', 'left' )
			->join( NEW_ASSOCIATE, 'new_associate.associate_id = user_document_mapping.user_id', 'left' );

		if ( $id ) {
			$this->db->where( 'user_document_mapping.user_id', $id );	
		}

		$query = $this->db->get();

		$doc_name_array = [];

		foreach ($query->result() as $list) {
			$doc_name_array[] = $list->{DOCUMENT_TITLE};	
		}
		$doc_names;
		$doc_names = implode( '<br>', $doc_name_array );

		return $doc_names;
	}
	
	public function insert_log_history( $user_id, $action, $description )
	{
		if ( empty( $user_id ) || empty( $action ) || empty( $description ) ) {
			return false;
		}

		$create = array(
			USER_ID					=>	$user_id,
			LOG_EVENT				=>	$action,
			LOG_EVENT_DESCRIPTION	=>	$description,
			LOG_DATE				=>	date('Y-m-d H:i:s', now())
		);

		$this->db->insert( LOG_HISTORY, $create );
		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}

		return false;
	}
	
	public function do_upload($userfile,$upload_path,$rename_file=0)
    {
//            echo $upload_path;exit;
        $config['upload_path']          = $upload_path;
        $config['allowed_types']        = 'jpg|pdf|jpeg|png';
        $config['max_size']             = 0;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        if ( $rename_file ) 
        {
        	$config['file_name']		= $rename_file;
        }

        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($userfile))
        {
                $error = array('error' => $this->upload->display_errors());
                // $this->session->set_flashdata('message', $error);
                // redirect('/document/create');
                print_r($error);exit();
                //$this->load->view('upload_form', $error);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                // print_r( $data['upload_data'] );
                // exit();
                return( $data['upload_data']['orig_name'] );
                //$this->load->view('upload_success', $data);
        }
    }
    public function adminUsers()
	{
		$this->db->select('users_role_mapping.*, role.role_name, users.*, GROUP_CONCAT(users_role_mapping.role_id SEPARATOR ",") as user_roles');
		$this->db->from('users_role_mapping');
		$this->db->join('role', 'role.role_id = users_role_mapping.role_id', 'left');
		$this->db->join('users', 'users.user_id = users_role_mapping.user_id', 'right');
                $this->db->where('role.role_id',1);
		$this->db->group_by('users.user_id');
		$query = $this->db->get();
		return $query->result();
		
	}
}