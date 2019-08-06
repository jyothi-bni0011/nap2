<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deletedocumentcategory_model extends MY_Model {

	

	public function delete( $doc_cat_id )
	{
		
		if( empty($doc_cat_id) ) {
			return false;
		}

		
		
		$this->db->where( DOCUMENT_CATEGORY_ID, $doc_cat_id );
		$delete = $this->db->delete( DOCUMENT_CATEGORY );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}