<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatedepartment_model extends MY_Model {

	public function fetch_data( $department_id )
	{
		
		if( empty($department_id) ) {
			return false;
		}

		$row = $this->db->get_where( DEPARTMENT, array( DEPARTMENT_ID => $department_id ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $department_name, $department_description="", $department_id )
	{
		
		if( empty($department_name) || empty($department_description) || empty($department_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			DEPARTMENT_DESCRIPTION	=>	$department_description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $department_id );
		
		if ( $result->department_name != $department_name ) {
			if ($this->check_duplicate( DEPARTMENT, DEPARTMENT_NAME, $department_name )) {
				$update[ DEPARTMENT_NAME ] = $department_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where( DEPARTMENT_ID, $department_id );  
		$this->db->update( DEPARTMENT, $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}