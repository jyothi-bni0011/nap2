<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function create( $folder_name, $folder_description="" )
	{
		
		if( empty($folder_name) || empty($folder_description) ) {
			return false;
		}

		$create = array(
			DOCUMENT_FOLDER_NAME			=>	$folder_name,
			DOCUMENT_FOLDER_DESCRIPTION		=>	$folder_description,
			//'department_id'			=> (int)$department,
			CREATED_ON				=>	date('Y-m-d H:i:s', now())
		);

		if( $this->check_duplicate( DOCUMENT_FOLDER, DOCUMENT_FOLDER_NAME, $folder_name ) ){
			$this->db->insert( DOCUMENT_FOLDER, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}
		}
		return FALSE;

	}	

}