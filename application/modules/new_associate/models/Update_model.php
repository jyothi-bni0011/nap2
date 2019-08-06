<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function get_all_job_title()
	{
		$this->db->select('*');
		$this->db->from(JOB_POSITION);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_org_units()
	{
		$this->db->select('*');
		$this->db->from(ORGANIZATIONAL_UNIT);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_fun_areas( $org_unit_id )
	{
		$this->db->select('*');
		$this->db->from(FUNCTIONAL_AREA);
		$this->db->where( ORGANIZATIONAL_UNIT_ID, $org_unit_id );
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_departments( $fun_area_id )
	{
		$this->db->select('*');
		$this->db->from(DEPARTMENT);
		$this->db->where( FUNCTIONAL_AREA_ID, $fun_area_id );
		$query = $this->db->get();
		return $query->result();
	}

	public function fetch_data( $associate_id )
	{
		
		if( empty($associate_id) ) {
			return false;
		}

		$row = $this->db->get_where(NEW_ASSOCIATE, array(NEW_ASSOCIATE_ID => $associate_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	

	
	
	public function update( $field )
	{
		
		if( empty($field['username']) || empty($field['email']) /*|| empty($user_role)*/ ) {
			return false;
		}

		$update = array(
			//'associate_username'			=>		$field['username'],
			//'associate_email'				=>		$field['email'],
			NEW_ASSOCIATE_FIRST_NAME		=>		$field['first_name'],
			NEW_ASSOCIATE_LAST_NAME			=>		$field['last_name'],
			NEW_ASSOCIATE_MIDDLE_NAME		=>		$field['middle_name'],
			JOB_POSITION_ID					=>		$field['job_title'],
			ORGANIZATIONAL_UNIT_ID			=>		$field['organizational_unit'],
			FUNCTIONAL_AREA_ID				=>		$field['functional_area'],
			DEPARTMENT_ID					=>		$field['department'],
			NEW_ASSOCIATE_START_DATE		=>		$field['start_date'],
			STATUS							=>		$field['status'],
			NEW_ASSOCIATE_CONTACT_INFO		=>		$field['contact_info'],
			NEW_ASSOCIATE_ADDRESS			=>		$field['address'],
			'associate_manager_name'		=>		$field['manager'],
			'associate_manager_title'		=>		$field['manager_title'],
			UPDATED_ON						=>		date('Y-m-d H:i:s', now())
		);
		
		$result = $this->fetch_data($field['associate_id']);
		
		if ( $result->{NEW_ASSOCIATE_USERNAME} != $field['username'] ) {
			if ( $this->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_USERNAME, $field['username'] ) ) {
				$update[NEW_ASSOCIATE_USERNAME] = $field['username'];
			}
			else {
				return false;
			}
		}

		if ( $result->{NEW_ASSOCIATE_EMAIL} != $field['email'] ) {
			if ( $this->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_EMAIL, $field['email'] ) ) {
				$update[NEW_ASSOCIATE_EMAIL] = $field['email'];	
			}
			else {
				return false;
			}
		}

		$this->db->where(NEW_ASSOCIATE_ID, $field['associate_id']);  
		$this->db->update(NEW_ASSOCIATE, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;

	}	
	
	public function update_job_title( $job_code, $position_id )
	{
		if( empty($job_code) || empty($position_id) ) {
			return false;
		}

		$update = array(
			JOB_POSITION_CODE	=>	$job_code,
			UPDATED_ON			=>	date('Y-m-d H:i:s', now())
		);

		$this->db->where(JOB_POSITION_ID, $position_id);  
		$this->db->update(JOB_POSITION, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;
	}
	
	public function update_user( $field )
	{
		if( empty($field['username']) || empty($field['email']) /*|| empty($user_role)*/ ) {
			return false;
		}

		$update = array(
			USER_FIRST_NAME		=>		$field['first_name'],
			USER_LAST_NAME		=>		$field['last_name'],
			'username'			=> 		$field['username'],
			'email_id'			=>		$field['email'],
			UPDATED_ON			=>		date('Y-m-d H:i:s', now())
		);

		$this->db->where(NEW_ASSOCIATE_ID, $field['associate_id']);  
		$this->db->update(USER, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;
	}
}