<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function find_document_ststus( $associate_id )
	{
		$this->db->select('*');
		$this->db->from( USER_DOCUMENT_MAPPING );
		$this->db->where( 'user_id', $associate_id );
		$this->db->where( 'status', 3 );
		$query = $this->db->get();
		
		return $query->result();		
	}

	public function associate_docs( $associate_id )
	{

		$this->db->select('user_document_mapping.*, document.document_title, document.document_id, ( SELECT role_id FROM document_form_steps WHERE document_id = user_document_mapping.document_id AND form_step = user_document_mapping.form_step) as form_step_role_id', FALSE);
		$this->db->from( USER_DOCUMENT_MAPPING );
		$this->db->join( 'document','document.document_id = user_document_mapping.document_id', 'left' );
		$this->db->where( 'user_document_mapping.user_id', $associate_id );
		$query = $this->db->get();
		
		return $query->result();

	}	

}