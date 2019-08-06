<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $org_unit_id )
	{
		
		if( empty($org_unit_id) ) {
			return false;
		}

		$row = $this->db->get_where(ORGANIZATIONAL_UNIT, array(ORGANIZATIONAL_UNIT_ID => $org_unit_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $org_unit_name, $org_unit_description="", $org_unit_id )
	{
		
		if( empty($org_unit_name) || empty($org_unit_description) || empty($org_unit_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			ORGANIZATIONAL_UNIT_DESCRIPTION	=>	$org_unit_description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $org_unit_id );
		
		if ( $result->org_unit_name != $org_unit_name ) {
			if ($this->check_duplicate( ORGANIZATIONAL_UNIT, ORGANIZATIONAL_UNIT_NAME, $org_unit_name )) {
				$update[ORGANIZATIONAL_UNIT_NAME] = $org_unit_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where(ORGANIZATIONAL_UNIT_ID, $org_unit_id);  
		$this->db->update(ORGANIZATIONAL_UNIT, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}