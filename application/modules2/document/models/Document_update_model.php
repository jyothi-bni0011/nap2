<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_update_model extends MY_Model {

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

}