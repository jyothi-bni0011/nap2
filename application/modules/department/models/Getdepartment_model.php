<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getdepartment_model extends MY_Model {


	public function departments( )
	{
		$this->db->select('department.*, functional_area.fun_area_name');
		$this->db->from( DEPARTMENT );
		$this->db->join( FUNCTIONAL_AREA, 'functional_area.fun_area_id = department.fun_area_id', 'left' );
		$query = $this->db->get();
		return $query->result();
	}	

}