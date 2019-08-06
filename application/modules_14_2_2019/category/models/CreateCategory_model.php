<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateCategory_model extends MY_Model {

	public function create( $category_name, $category_description="" )
	{
		
		if( empty($category_name) || empty($category_description) ) {
			return false;
		}

		$create = array(
			CATEGORY_NAME			=>	$category_name,
			CATEGORY_DESCRIPTION	=>	$category_description,
		
			CREATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		if ($this->check_duplicate( CATEGORY, CATEGORY_NAME, $category_name )) {
			$this->db->insert( CATEGORY, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		

		return FALSE;

	}	

}