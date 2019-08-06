<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function create( $fun_area_name, $fun_area_description="", $org_unit )
	{
		
		if( empty($fun_area_name) || empty($fun_area_description) || empty($org_unit) ) {
			return false;
		}

		$create = array(
			FUNCTIONAL_AREA_NAME		=>	$fun_area_name,
			FUNCTIONAL_AREA_DESCRIPTION	=>	$fun_area_description,
			ORGANIZATIONAL_UNIT_ID			=>	$org_unit,
			CREATED_ON					=>	date('Y-m-d H:i:s', now())
		);

		//if ($this->check_duplicate( FUNCTIONAL_AREA, FUNCTIONAL_AREA_NAME, $fun_area_name ) ) {
			$this->db->insert( FUNCTIONAL_AREA, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		//}
		

		return FALSE;

	}	
	
	public function check_fun_area_duplicate( $value, $value1 )
	{
		$this->db->where('fun_area_name', $value);
		$this->db->where('org_unit_id', $value1);

		$res = $this->db->get(FUNCTIONAL_AREA);
		
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}	

}