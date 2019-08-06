<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UpdateCategory_model extends MY_Model {

	public function fetch_data( $category_id )
	{
		
		if( empty($category_id) ) {
			return false;
		}

		$row = $this->db->get_where( CATEGORY, array( CATEGORY_ID => $category_id ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $category_name, $category_description="", $category_id )
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

		$result = $this->fetch_data( $category_id );
		
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

}