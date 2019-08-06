<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function create( $org_name, $org_description="" )
	{
		
		if( empty($org_name) || empty($org_description) ) {
			return false;
		}

		$create = array(
			ORGANIZATIONAL_UNIT_NAME		=>	$org_name,
			ORGANIZATIONAL_UNIT_DESCRIPTION	=>	$org_description,
		
			CREATED_ON						=>	date('Y-m-d H:i:s', now())
		);

		if ($this->check_duplicate( ORGANIZATIONAL_UNIT, ORGANIZATIONAL_UNIT_NAME, $org_name )) {
			$this->db->insert(ORGANIZATIONAL_UNIT, $create);
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}
		

		return FALSE;

	}	

}