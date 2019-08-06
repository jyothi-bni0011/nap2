<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createdepartment_model extends MY_Model {

	public function create( $department_name, $department_description="" )
	{
		
		if( empty($department_name) || empty($department_description) ) {
			return false;
		}

		$create = array(
			DEPARTMENT_NAME			=>	$department_name,
			DEPARTMENT_DESCRIPTION	=>	$department_description,
		
			CREATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		if ($this->check_duplicate( DEPARTMENT, DEPARTMENT_NAME, $department_name )) {
			$this->db->insert( DEPARTMENT, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		

		return FALSE;

	}	

}