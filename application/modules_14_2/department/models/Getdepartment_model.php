<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getdepartment_model extends CI_Model {


	public function departments( )
	{
		$this->db->select('*');
		$this->db->from( DEPARTMENT );
		$query = $this->db->get();
		return $query->result();
	}	

}