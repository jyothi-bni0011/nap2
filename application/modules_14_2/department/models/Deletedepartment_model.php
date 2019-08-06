<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deletedepartment_model extends CI_Model {

	

	public function delete( $department_id )
	{
		
		if( empty($department_id) ) {
			return false;
		}

		
		
		$this->db->where( DEPARTMENT_ID, $department_id );
		$delete = $this->db->delete( DEPARTMENT );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}