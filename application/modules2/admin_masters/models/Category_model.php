<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {

	//create category
	public function create_category( $category_name, $category_description="" )
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
	//create category end

	//update category
	public function update_category( $category_name, $category_description="", $category_id )
	{
		if( empty($category_name) || empty($category_description) || empty($category_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			CATEGORY_DESCRIPTION	=>	$category_description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->getById( CATEGORY, CATEGORY_ID, $category_id );
		
		if ( $result->category_name != $category_name ) {
			if ($this->check_duplicate( CATEGORY, CATEGORY_NAME, $category_name )) {
				$update[ CATEGORY_NAME ] = $category_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where( CATEGORY_ID, $category_id );  
		$this->db->update( CATEGORY, $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;
	}
	//update category end

	//delete category
	public function delete_category($category_id)
	{
		
		if( empty($category_id) ) {
			return false;
		}
		$this->db->where( CATEGORY_ID, $category_id );
		$delete = $this->db->delete( CATEGORY );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;
	}
	//delete category end
}