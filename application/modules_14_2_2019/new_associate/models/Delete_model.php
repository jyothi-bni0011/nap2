<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends CI_Model {

	

	public function delete( $associate_id )
	{
		
		if( empty($associate_id) ) {
			return false;
		}

		
		
		$this->db->where( NEW_ASSOCIATE_ID, $associate_id);
		$delete = $this->db->delete(NEW_ASSOCIATE);
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}