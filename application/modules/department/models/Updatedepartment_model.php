<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatedepartment_model extends MY_Model {

	public function fetch_data( $department_id )
	{
		
		if( empty($department_id) ) {
			return false;
		}

		$row = $this->db->get_where( DEPARTMENT, array( DEPARTMENT_ID => $department_id ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $department_name, $department_description="", $functional_id,$department_id )
	{
		
		if( empty($department_name) || empty($department_description) || empty($functional_id) || empty($department_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			DEPARTMENT_DESCRIPTION	=>	$department_description,
			FUNCTIONAL_AREA_ID		=>	$functional_id,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $department_id );
		
		if ( $result->department_name != $department_name ) {
			if ($this->check_duplicate( DEPARTMENT, DEPARTMENT_NAME, $department_name )) {
				$update[ DEPARTMENT_NAME ] = $department_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where( DEPARTMENT_ID, $department_id );  
		$this->db->update( DEPARTMENT, $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	
	
	public function find_org_unit( $fun_id )
	{
		$query = $this->db->select( 'organizational_unit.org_unit_name, organizational_unit.org_unit_id' )
					->from( ORGANIZATIONAL_UNIT )
					->join( FUNCTIONAL_AREA, 'functional_area.org_unit_id = organizational_unit.org_unit_id' )
					->where( 'functional_area.fun_area_id', $fun_id )
					->get();

		$result = $query->row();

		return( $result->org_unit_id );
	}

	public function find_fun_areas( $org_unit_id )
	{
		$rows = $this->db->get_where( FUNCTIONAL_AREA, array( 'org_unit_id' => $org_unit_id ) )->result();
		  		
		if( $rows ) {
			return $rows;
		}	
	}

}