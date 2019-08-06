<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function get_departments()
	{
		$this->db->select('*');
		$this->db->from( FUNCTIONAL_AREA );
		$query = $this->db->get();
		return $query->result();
	}

	public function create( $job_code, $job_description="", $department )
	{
		
		if( empty($job_code) || empty($department) ) {
			return false;
		}

		$create = array(
			JOB_POSITION_CODE			=>	$job_code,
			JOB_POSITION_DESCRIPTION	=>	$job_description,
			DEPARTMENT_ID				=> (int)$department,
			CREATED_ON					=>	date('Y-m-d H:i:s', now())
		);

		if( $this->check_duplicate( JOB_POSITION, JOB_POSITION_CODE, $job_code ) ){
			$this->db->insert( JOB_POSITION, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}
		}
		return FALSE;

	}	

}