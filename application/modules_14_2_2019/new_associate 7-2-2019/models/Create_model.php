<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function get_job_title()
	{
		$this->db->select('*');
		$this->db->from( JOB_POSITION );
		$query = $this->db->get();
		return $query->result();
	}

	public function get_org_units()
	{
		$this->db->select('*');
		$this->db->from( ORGANIZATIONAL_UNIT );
		$query = $this->db->get();
		return $query->result();
	}

	public function get_fun_areas()
	{
		$this->db->select('*');
		$this->db->from( FUNCTIONAL_AREA );
		$query = $this->db->get();
		return $query->result();
	}

	public function get_departments()
	{
		$this->db->select('*');
		$this->db->from( DEPARTMENT );
		$query = $this->db->get();
		return $query->result();
	}

	public function create( $field )
	{
		
		if( empty($field['username']) || empty($field['email']) || empty($field['department']) ) {
			return false;
		}

		$create = array(
			NEW_ASSOCIATE_USERNAME		=>		$field['username'],
			NEW_ASSOCIATE_EMAIL			=>		$field['email'],
			NEW_ASSOCIATE_FIRST_NAME	=>		$field['first_name'],
			NEW_ASSOCIATE_LAST_NAME		=>		$field['last_name'],
			NEW_ASSOCIATE_MIDDLE_NAME	=>		$field['middle_name'],
			JOB_POSITION_ID				=>		$field['job_title'],
			ORGANIZATIONAL_UNIT_ID		=>		$field['organizational_unit'],
			FUNCTIONAL_AREA_ID			=>		$field['functional_area'],
			DEPARTMENT_ID				=>		$field['department'],
			NEW_ASSOCIATE_START_DATE	=>		$field['start_date'],
			STATUS						=>		$field['status'],
			NEW_ASSOCIATE_CONTACT_INFO	=>		$field['contact_info'],
			NEW_ASSOCIATE_ADDRESS		=>		$field['address'],
			CREATED_ON					=>		date('Y-m-d H:i:s', now())
		);

		if ($this->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_EMAIL, $field['email'] )) {
			if ($this->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_USERNAME, $field['username'] )) {
				$this->db->insert(NEW_ASSOCIATE, $create);
				if( $this->db->affected_rows() ) {
					return $this->db->insert_id();
				}	
			}
		}
		
		return FALSE;
	}	

	public function create_same_user( $field, $associate_id )
	{
		
		if( empty($associate_id) ) {
			return false;
		}

		$create = array(
			USER_FIRST_NAME	=>		$field['first_name'],
			USER_LAST_NAME		=>	$field['last_name'],
			USERNAME		=> 		$field['username'],
			USER_EMAIL		=>		$field['email'],
			USER_PASSWORD		=>	md5(123456),
			NEW_ASSOCIATE_ID		=>	$associate_id,
			CREATED_ON	=>			date('Y-m-d H:i:s', now())
		);

		if ($this->check_duplicate( USER, USER_EMAIL, $field['email'] )) {
			if ($this->check_duplicate( USER, USERNAME, $field['username'] )) {
				$this->db->insert(USER, $create);
				if( $this->db->affected_rows() ) {
					return $this->db->insert_id();
				}	
			}
		}
		
		return FALSE;
	}	

	public function create_same_user_role_mapping( $user_role, $user_id )
	{
		
		if( empty($user_role) ) {
			return false;
		}

		//print_r($user_role); exit();

		
		$create = array(
			
			ROLE_ID		=>		$user_role,
			USER_ID		=>		$user_id
		);

		
		$this->db->insert(USER_ROLE_MAPPING, $create);
		

		return true;
	}	

	public function get_data_for_new_associate( $email_id )
	{
		$this->db->select('new_associate.associate_username as user_name, new_associate.associate_email as email, new_associate.associate_first_name as first_name, new_associate.associate_middle_name as middle_name, new_associate.associate_last_name as last_name, job_position.position_code as job_title, organizational_unit.org_unit_name as organizational_unit, functional_area.fun_area_name as functional_area, department.department_name as department')
			->from( NEW_ASSOCIATE )
			->join( JOB_POSITION, 'job_position.position_id = new_associate.position_id', 'left' )
			->join( ORGANIZATIONAL_UNIT, 'organizational_unit.org_unit_id = new_associate.org_unit_id', 'left' )
			->join( FUNCTIONAL_AREA, 'functional_area.fun_area_id = new_associate.fun_area_id', 'left' )
			->join( DEPARTMENT, 'department.department_id = new_associate.department_id' )
			->where( 'new_associate.associate_email', $email_id );
		$query = $this->db->get();

		return $query->row();
	}
}