<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_create_model extends MY_Model {

	public function create( $document_title, $document="", $doc_folder, $doc_category, $status )
	{
		
		$insert = array(
			DOCUMENT_TITLE			=> $document_title,
			DOCUMENT_TEMPLATE		=> $document,
			DOCUMENT_FOLDER_ID		=> $doc_folder,
			DOCUMENT_CATEGORY_ID	=> $doc_category,
			STATUS 					=> $status,
			CREATED_ON				=>	date('Y-m-d H:i:s', now())
		);

		$this->db->insert('document', $insert);

		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}

		return false;
	}

}
