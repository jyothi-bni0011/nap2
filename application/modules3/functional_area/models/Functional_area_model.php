<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Functional_area_model extends CI_Model {


	public function fun_area( )
	{
		$this->db->select('*');
		$this->db->from( FUNCTIONAL_AREA );
		$query = $this->db->get();
		return $query->result();
	}	

}