<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $fun_area_id )
	{
		
		if( empty($fun_area_id) ) {
			return false;
		}

		
		
		$this->db->where( FUNCTIONAL_AREA_ID, $fun_area_id );
		$delete = $this->db->delete( FUNCTIONAL_AREA );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}