<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $role_id )
	{
		
		if( empty($role_id) ) {
			return false;
		}

		$row = $this->db->get_where(ROLE, array(ROLE_ID => $role_id))->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $role_name, $role_description="", $role_id )
	{
		
		if( empty($role_name) || empty($role_description) || empty($role_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			ROLE_DESCRIPTION	=>	$role_description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $role_id );
		
		if ( $result->role_name != $role_name ) {
			if ($this->check_duplicate( ROLE, ROLE_NAME, $role_name )) {
				$update[ROLE_NAME] = $role_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where(ROLE_ID, $role_id);  
		$this->db->update(ROLE, $update);  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}