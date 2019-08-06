<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {


	public function users( )
	{
		/*$this->db->select('users.*, role.role_name');
		$this->db->from('users');
		$this->db->join('role', 'role.role_id = users.role_id', 'left');
		$query = $this->db->get();
		return $query->result();*/

/*		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();*/

		$this->db->select('users_role_mapping.*, role.role_name, users.*, GROUP_CONCAT(users_role_mapping.role_id SEPARATOR ",") as user_roles');
		$this->db->from('users_role_mapping');
		$this->db->join('role', 'role.role_id = users_role_mapping.role_id', 'left');
		$this->db->join('users', 'users.user_id = users_role_mapping.user_id', 'right');
		$this->db->group_by('users.user_id');
		$query = $this->db->get();
		return $query->result();
		//echo "<pre>";
		//print_r($query->result()); exit();
	}	

}