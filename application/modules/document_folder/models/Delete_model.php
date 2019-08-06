<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $doc_folder_id )
	{
		
		if( empty($doc_folder_id) ) {
			return false;
		}

		
		
		$this->db->where( DOCUMENT_FOLDER_ID, $doc_folder_id );
		$delete = $this->db->delete( DOCUMENT_FOLDER );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}