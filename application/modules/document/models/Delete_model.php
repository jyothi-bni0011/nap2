<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $doc_id )
	{
		
		if( empty($doc_id) ) {
			return false;
		}

		$this->db->where( DOCUMENT_ID, $doc_id );
		$delete = $this->db->delete( 'document_form_steps' );
		
		$this->db->where( DOCUMENT_ID, $doc_id );
		$delete = $this->db->delete( 'document_variables' );
		
		$this->db->where( DOCUMENT_ID, $doc_id );
		$delete = $this->db->delete( DOCUMENT );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		

		return FALSE;

	}	

}