<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_update_model extends MY_Model {

	public $document_statuses = array(
		1	=> 'HR Email Sent',
		2 	=> 'HR to Verify',
		3	=> 'HR in Process',
		4	=> 'HR Verified'
	);

	public function get( $document_id )
	{
		
		$result = $this->db->select('*')
			->from('document')
			->where('document_id', $document_id)
			->get();

		if( $result->num_rows() ) {
			return $result->row();
		}

	}

	public function associate_has_document( $document_id, $associate_id )
	{
		
		$result = $this->db->select('*')
			->from('user_document_mapping')
			->where('document_id', $document_id)
			->where('user_id', $associate_id)
			->get();

		if( $result->num_rows() ) {
			return $result->row();
		}

		return FALSE;

	}

	public function getVariables( $document_id )
	{
		
		$result = $this->db->select('*')
			->from('document_variables')
			->where('document_id', $document_id)
			->get();

		if( $result->num_rows() ) {
			return $result->result();
		}

	}

	public function update( $document_id, $document_title, $document, $doc_folder, $doc_category, $status )
	{
		
		$update = array(
			DOCUMENT_TITLE			=> $document_title,
			DOCUMENT_TEMPLATE		=> $document,
			DOCUMENT_FOLDER_ID		=> $doc_folder,
			DOCUMENT_CATEGORY_ID	=> $doc_category,
			STATUS 					=> $status,
			UPDATED_ON				=>	date('Y-m-d H:i:s', now())
		);

		$this->db->update('document', $update, array('document_id' => $document_id));

		if( $this->db->affected_rows() >= 0 ) {
			return $document_id;
		}

		return false;
	}

	// Expecting multidimensional array here
	public function create_document_fields( $users_document_fields )
	{
		
		if( ! is_array($users_document_fields) ) {
			return false;
		}

		foreach ($users_document_fields as $document_field) {
			$this->db->replace('users_document_fields', $document_field);
		}

		return TRUE;

	}

	public function update_document( $updates, $user_id, $document_id )
	{
		
		if( ! is_array($updates) || empty($user_id) || empty($document_id) ) {
			return FALSE;
		}

		$this->db->where('user_id', $user_id);
		$this->db->where('document_id', $document_id);
		$this->db->update('user_document_mapping', $updates);
		if( $this->db->affected_rows() >= 0 ) {
			return TRUE;
		}

		return FALSE;

	}

}