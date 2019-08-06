<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends CI_Model {

	

	public function delete( $position_id )
	{
		
		if( empty($position_id) ) {
			return false;
		}

		
		
		$this->db->where( JOB_POSITION_ID, $position_id );
		$delete = $this->db->delete( JOB_POSITION );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}