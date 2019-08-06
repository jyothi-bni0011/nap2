<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetCategory_model extends CI_Model {


	public function categories( )
	{
		$this->db->select('*');
		$this->db->from( CATEGORY );
		$query = $this->db->get();
		return $query->result();
	}	

}