<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeleteCategory_model extends CI_Model {

	

	public function delete( $category_id )
	{
		
		if( empty($category_id) ) {
			return false;
		}

		
		
		$this->db->where( CATEGORY_ID, $category_id );
		$delete = $this->db->delete( CATEGORY );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}