<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function get_departments()
	{
		$this->db->select('*');
		$this->db->from( FUNCTIONAL_AREA );
		$query = $this->db->get();
		return $query->result();
	}
	
	public function fetch_data( $position_id )
	{
		
		if( empty($position_id) ) {
			return false;
		}

		$row = $this->db->get_where( JOB_POSITION, array( JOB_POSITION_ID => $position_id ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $job_code, $job_description="", $job_department, $position_id )
	{
		
		if( empty($job_code) || empty($job_department) || empty($position_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			JOB_POSITION_DESCRIPTION	=>	$job_description,
			FUNCTIONAL_AREA_ID		=> (int)$job_department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $position_id );
		
		if ( $result->{JOB_POSITION_CODE} != $job_code ) {
			if ($this->check_duplicate( JOB_POSITION, JOB_POSITION_CODE, $job_code, $position_id, JOB_POSITION_ID )) {
				$update[JOB_POSITION_CODE] = $job_code;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where(JOB_POSITION_ID, $position_id);  
		$this->db->update(JOB_POSITION, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}