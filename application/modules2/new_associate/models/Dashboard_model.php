<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {


	public function associate_docs( $id )
	{

		$this->db->select('*, document.document_title');
		$this->db->from( USER_DOCUMENT_MAPPING );
		$this->db->join( 'document','document.document_id = user_document_mapping.document_id', 'left' );
		$this->db->where( 'user_document_mapping.user_id', $id );
		$query = $this->db->get();
		
		return $query->result();

	}	

}