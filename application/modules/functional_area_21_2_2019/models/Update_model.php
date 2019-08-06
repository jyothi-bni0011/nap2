<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $fun_area_id )
	{
		
		if( empty($fun_area_id) ) {
			return false;
		}

		$row = $this->db->get_where( FUNCTIONAL_AREA, array( FUNCTIONAL_AREA_ID => $fun_area_id ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $fun_area_name, $fun_area_description="", $fun_area_id )
	{
		
		if( empty($fun_area_name) || empty($fun_area_description) || empty($fun_area_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			FUNCTIONAL_AREA_DESCRIPTION	=>	$fun_area_description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $fun_area_id );
		
		if ( $result->fun_area_name != $fun_area_name ) {
			if ($this->check_duplicate( FUNCTIONAL_AREA, FUNCTIONAL_AREA_NAME, $fun_area_name )) {
				$update[FUNCTIONAL_AREA_NAME] = $fun_area_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where(FUNCTIONAL_AREA_ID, $fun_area_id);  
		$this->db->update(FUNCTIONAL_AREA, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}