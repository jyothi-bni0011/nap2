<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Select_user_role_model extends CI_Model {


	public function users_roles( $user_id )
	{
		$this->db->select( 'users_role_mapping.*, role.role_name, users.user_id' );
		$this->db->from( 'users_role_mapping' );
		$this->db->join( 'role', 'role.role_id = users_role_mapping.role_id' );
		$this->db->join( 'users', 'users.user_id = users_role_mapping.user_id' );
		$this->db->where( 'users_role_mapping.user_id', $user_id );
		$query = $this->db->get();
		return $query->result();
	}	

	public function select_role( $role_id )
	{
		if ( empty($role_id) ) {
			return false;
		}

		$this->db->where( 'role_id', $role_id );
		$result = $this->db->get( 'role' );
		$role = $result->row();

		
		$init_session['role_id'] = $role->role_id;
		$init_session['role_name'] = $role->role_name;

		$this->session->set_userdata( $init_session );

		return true;
	}
}