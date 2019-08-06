<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends CI_Model {

	

	public function delete( $org_unit_id )
	{
		
		if( empty($org_unit_id) ) {
			return false;
		}

		
		
		$this->db->where(ORGANIZATIONAL_UNIT_ID, $org_unit_id);
		$delete = $this->db->delete(ORGANIZATIONAL_UNIT);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}