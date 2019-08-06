<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organizational_unit_model extends CI_Model {


	public function org_unit( )
	{
		$this->db->select('*');
		$this->db->from(ORGANIZATIONAL_UNIT);
		$query = $this->db->get();
		return $query->result();
	}	

}