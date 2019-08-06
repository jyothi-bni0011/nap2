<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function create( $fun_area_name, $fun_area_description="" )
	{
		
		if( empty($fun_area_name) || empty($fun_area_description) ) {
			return false;
		}

		$create = array(
			FUNCTIONAL_AREA_NAME			=>	$fun_area_name,
			FUNCTIONAL_AREA_DESCRIPTION	=>	$fun_area_description,
		
			CREATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		if ($this->check_duplicate( FUNCTIONAL_AREA, FUNCTIONAL_AREA_NAME, $fun_area_name ) ) {
			$this->db->insert( FUNCTIONAL_AREA, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		

		return FALSE;

	}	

}