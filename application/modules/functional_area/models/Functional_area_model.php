<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Functional_area_model extends CI_Model {


	public function fun_area( )
	{
		$this->db->select('functional_area.*, organizational_unit.org_unit_name');
		$this->db->from( FUNCTIONAL_AREA );
		$this->db->join( ORGANIZATIONAL_UNIT, 'functional_area.org_unit_id = organizational_unit.org_unit_id', 'left' );
		$query = $this->db->get();
		return $query->result();
	}	

}