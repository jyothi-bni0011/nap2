<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createdepartment_model extends MY_Model {

	public function create( $department_name, $department_description="", $functional_id )
	{
		
		if( empty($department_name) || empty($department_description) || empty($functional_id) ) {
			return false;
		}

		$create = array(
			DEPARTMENT_NAME			=>	$department_name,
			DEPARTMENT_DESCRIPTION	=>	$department_description,
			FUNCTIONAL_AREA_ID		=>	$functional_id,
			CREATED_ON				=>	date('Y-m-d H:i:s', now())
		);

		// if ($this->check_duplicate( DEPARTMENT, DEPARTMENT_NAME, $department_name )) {
			$this->db->insert( DEPARTMENT, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		// }
		

		return FALSE;

	}	

	public function check_department_duplicate( $value, $value1 )
	{
		$this->db->where('department_name', $value);
		$this->db->where('fun_area_id', $value1);

		$res = $this->db->get(DEPARTMENT);
		
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}

}