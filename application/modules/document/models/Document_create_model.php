<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_create_model extends MY_Model {

	public function create( $document_title, $document="", $doc_folder, $doc_category, $status, $form_steps=1, $doc_password='', $doc_type=1 )
	{
		
		$insert = array(
			DOCUMENT_TITLE			=> $document_title,
			DOCUMENT_TEMPLATE		=> $document,
			DOCUMENT_FOLDER_ID		=> $doc_folder,
			DOCUMENT_CATEGORY_ID	=> $doc_category,
			'document_type'			=> $doc_type,
			STATUS 					=> $status,
			CREATED_ON				=> date('Y-m-d H:i:s', now()),
			'form_steps'			=> $form_steps
		);
		
		if ( $doc_password != '' ) {
			$insert['document_password'] = $this->encrypt->encode( $doc_password );
		}
		else
		{
			$insert['document_password'] = null;
		}
		
		$this->db->insert('document', $insert);

		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}

		return false;
	}

	public function create_form_steps( $form_steps=array() )
	{
		
		if( ! is_array( $form_steps) ) {
			return FALSE;
		}

		foreach ($form_steps as $form_step) {
			$this->db->insert('document_form_steps', $form_step);
		}

		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}

		return false;
	}

	public function delete_form_steps( $document_id )
	{
		
		if( empty($document_id) ) {
			return FALSE;
		}

		$this->db->where('document_id', $document_id);
		$this->db->delete('document_form_steps');

		if( $this->db->affected_rows() ) {
			return TRUE;
		}


	}

}
