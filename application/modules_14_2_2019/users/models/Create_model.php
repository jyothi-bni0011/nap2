<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_model extends MY_Model {

	public function get_roles()
	{
		$this->db->select('*');
		$this->db->from(ROLE);
		$query = $this->db->get();
		return $query->result();
	}

	public function create( $user_first_name, $user_last_name, $user_name, $user_email, $password/*, $user_role*/ )
	{
		
		if( empty($user_name) || empty($user_email) || empty($password) /*|| empty($user_role)*/ ) {
			return false;
		}

		$create = array(
			USER_FIRST_NAME	=>		$user_first_name,
			USER_LAST_NAME		=>		$user_last_name,
			USERNAME		=> 		$user_name,
			USER_EMAIL		=>		$user_email,
			USER_PASSWORD		=>		md5($password),
			//'role_id'		=>		$user_role,
			CREATED_ON	=>		date('Y-m-d H:i:s', now())
		);

		$this->db->insert(USER, $create);
		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}
		
		return FALSE;
	}	

	public function create_user_role( $user_role, $user_id )
	{
		
		if( empty($user_role) ) {
			return false;
		}

		//print_r($user_role); exit();

		foreach ($user_role as $value) {
			$create = array(
				
				ROLE_ID		=>		$value,
				USER_ID		=>		$user_id
			);

			
			$this->db->insert(USER_ROLE_MAPPING, $create);
		}

		return true;
	}	

}