<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_model extends CI_Model {


	public function roles( )
	{
		$this->db->select('*');
		$this->db->from(ROLE);
		$query = $this->db->get();
		return $query->result();
	}	

}