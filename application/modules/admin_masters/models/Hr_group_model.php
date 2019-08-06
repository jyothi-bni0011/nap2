<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_group_model extends MY_Model {

	public function get()
	{
		
		$query = $this->db->select( sprintf('*, %s.%s', FUNCTIONAL_AREA, FUNCTIONAL_AREA_NAME) )
			->from( HR_GROUP )
			->join( FUNCTIONAL_AREA, sprintf("%s.%s = %s.%s", HR_GROUP,FUNCTIONAL_AREA_ID, FUNCTIONAL_AREA,FUNCTIONAL_AREA_ID), 'left' )
			->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return [];

	}

	public function get_user_by_role( $role_id )
	{
		$query = $this->db->select( sprintf( '*, %s.%s, %s.%s, %s.%s', ROLE, ROLE_NAME, USER, USER_FIRST_NAME, USER, USER_LAST_NAME ) )
				->from( USER_ROLE_MAPPING )
				->join( ROLE, sprintf( "%s.%s = %s.%s", ROLE, ROLE_ID, USER_ROLE_MAPPING, ROLE_ID ) )
				->join( USER, sprintf( "%s.%s = %s.%s", USER, USER_ID, USER_ROLE_MAPPING, USER_ID ) )
				->where( sprintf( "%s.%s = %d", USER_ROLE_MAPPING, ROLE_ID, $role_id ) )
				->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return [];
	}

	public function get_hr_members( $hr_groupd_ids )
	{

		if( ! is_array($hr_groupd_ids) ) {
			return [];
		}
		
		$query = $this->db->select( '*, CONCAT( users.first_name, " ", users.last_name ) as full_name' )
			->from( HR_GROUP_USER_MAPPING )
			->join( USER, sprintf('%s.%s = %s.%s', HR_GROUP_USER_MAPPING, USER_ID, USER, USER_ID ), 'left' )
			->where_in( HR_GROUP_ID, $hr_groupd_ids, FALSE )
			->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return [];

	}

	//create category
	public function create_hr_group( $group_name, $group_description, $functional_area )
	{
		if( empty($group_name) || empty($group_description) || empty($functional_area) ) {
			return false;
		}

		$create = array(
			HR_GROUP_NAME			=>	$group_name,
			HR_GROUP_DESCRIPTION	=>	$group_description,
			FUNCTIONAL_AREA_ID		=>	$functional_area,
			CREATED_ON				=>	date('Y-m-d H:i:s', now())
		);

		if ($this->check_duplicate( HR_GROUP, HR_GROUP_NAME, $group_name )) {
			$this->db->insert( HR_GROUP, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		}

		return FALSE;
	}

	//create category end
	public function create_hr_group_mapping( $id, $members )
	{
		if( empty($id) || empty($members) ) {
			return false;
		}

		foreach ($members as $user) {
			$create = array(
				HR_GROUP_ID		=>	$id,
				USER_ID			=>	$user,
			);
			$this->db->insert( HR_GROUP_USER_MAPPING, $create );
		}

		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}	
		
		return FALSE;
	}
	
	//update category
	public function update_hr_group( $group_name, $group_description, $functional_area, $group_id )
	{
		if( empty($group_name) || empty($group_description) || empty($functional_area) || empty($group_id) ) 
		{
			return false;
		}

		$update = array(
			HR_GROUP_DESCRIPTION	=>	$group_description,
			FUNCTIONAL_AREA_ID		=>	$functional_area,
			UPDATED_ON				=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->getById( HR_GROUP, HR_GROUP_ID, $group_id );
		
		if ( $result->{HR_GROUP_NAME} != $group_name ) {
			if ($this->check_duplicate( HR_GROUP, HR_GROUP_NAME, $group_name, $group_id, HR_GROUP_ID ) ) {
				$update[ HR_GROUP_NAME ] = $group_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where( HR_GROUP_ID, $group_id );  
		$this->db->update( HR_GROUP, $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;
	}
	//update category end

	//get hr reoup members
	public function get_hr_group_members( $id )
	{
		if( empty($id) ) {
			return false;
		}

		$row = $this->db->get_where( HR_GROUP_USER_MAPPING, array( HR_GROUP_ID => $id ) );
	
		if( $row ) {
			return $row->result();
		}	
		
		return FALSE;
	}
	//get hr reoup members end

	//delete hr group and job title from hr_group_user_mapping table and insert new new 
	public function delete_and_insert_new_mapping( $group_id, $members )
	{
		if ( empty($group_id) || empty($members) ) {

			return false;
		}
		$this->db->where( HR_GROUP_ID, $group_id );
		$delete = $this->db->delete( HR_GROUP_USER_MAPPING );
		
		foreach ($members as $member) {
			$create = array(
				HR_GROUP_ID		=>	$group_id,
				USER_ID			=>	$member,
			);
			$this->db->insert( HR_GROUP_USER_MAPPING, $create );
		}
		
		return true;
	}
	//function end 

	//delete category
	public function delete_hr_group($group_id)
	{
		if( empty($group_id) ) {
			return false;
		}
		$this->db->where( HR_GROUP_ID, $group_id );
		$delete = $this->db->delete( HR_GROUP );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;
	}
	//delete category end
}