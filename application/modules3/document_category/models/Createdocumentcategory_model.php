<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createdocumentcategory_model extends MY_Model {

	public function create( $doc_category, $doc_description="" )
	{
		
		if( empty($doc_category) || empty($doc_description) ) {
			return false;
		}

		$create = array(
			DOCUMENT_CATEGORY_NAME			=>	$doc_category,
			DOCUMENT_CATEGORY_DESCRIPTION	=>	$doc_description,
			//'department_id'			=> (int)$department,
			CREATED_ON			=>	date('Y-m-d H:i:s', now())
		);

		if( $this->check_duplicate( DOCUMENT_CATEGORY, DOCUMENT_CATEGORY_NAME, $doc_category ) ){
			$this->db->insert( DOCUMENT_CATEGORY, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}
		}
		return FALSE;

	}	

}