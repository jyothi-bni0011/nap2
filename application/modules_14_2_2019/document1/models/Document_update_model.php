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
		
		$result = $this->db->select('document.*, document_folder.doc_folder_name')
			->from('document')
			->join('document_folder', 'document_folder.doc_folder_id = document.doc_folder_id', 'left')
			->where('document_id', $document_id)
			->get();

		if( $result->num_rows() ) {
			return $result->row();
		}

	}

	public function associate_document( $document_id, $associate_id )
	{
		
		$result = $this->db->select('user_document_mapping.*, new_associate.associate_username')
			->from('user_document_mapping')
			->join('new_associate', 'user_document_mapping.user_id = new_associate.associate_id', 'left')
			->where('document_id', $document_id)
			->where('user_id', $associate_id)
			->get();

		if( $result->num_rows() ) {
			return $result->row();
		}

		return FALSE;

	}

	public function getVariables( $document_id, $role_id=0 )
	{
		
		$this->db->select('document_variables.*, role.role_name')
			->from('document_variables')
			->join('role', 'role.role_id = document_variables.role_id', 'left')
			->where('document_id', $document_id);

		if( $role_id ) {
			$this->db->where('document_variables.role_id', $role_id);
		}

		$result = $this->db->get();
		if( $result->num_rows() ) {
			return $result->result();
		}

	}

	public function get_document_values( $document_id, $associate_id )
	{
		
		$query = $this->db->select('users_document_fields.*, document_variables.varname')
			->from('users_document_fields')
			->join('document_variables', 'document_variables.variable_id = users_document_fields.variable_id', 'left')
			->where('users_document_fields.document_id', $document_id)
			->where('users_document_fields.user_id', $associate_id)
			->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return FALSE;

	}

	public function update( $document_id, $document_title, $document, $doc_folder, $doc_category, $status, $form_steps=1 )
	{
		
		$update = array(
			DOCUMENT_TITLE			=> $document_title,
			DOCUMENT_TEMPLATE		=> $document,
			DOCUMENT_FOLDER_ID		=> $doc_folder,
			DOCUMENT_CATEGORY_ID	=> $doc_category,
			STATUS 					=> $status,
			UPDATED_ON				=>	date('Y-m-d H:i:s', now()),
			'form_steps'			=> $form_steps
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

	public function verify_documents( $updates, $user_id, $document_ids )
	{
		
		
		if( empty($updates) || empty($user_id) || empty($document_ids) ) {
			return FALSE;
		}

		$this->db->where('user_id', $user_id);
		$this->db->where_in( 'document_id', implode( ',', $document_ids ), FALSE );
		$this->db->update('user_document_mapping', $updates);
		if( $this->db->affected_rows() >= 0 ) {
			return TRUE;
		}

		return FALSE;

	}

	public function get_form_steps( $document_id, $form_step )
	{
		
		$query = $this->db->select('*')
			->from('document_form_steps')
			->where('document_id', $document_id)
			->where('form_step', $form_step)
			->get();

		if( $query->num_rows() ) {
			return $query->row();
		}

		return FALSE;


	}

}