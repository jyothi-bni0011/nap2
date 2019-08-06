<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_position_model extends CI_Model {


	public function job_position( )
	{

		$this->db->select('*, functional_area.fun_area_name');
		$this->db->from( JOB_POSITION );
		$this->db->join( 'functional_area','functional_area.fun_area_id = job_position.fun_area_id', 'left' );
		$query = $this->db->get();
		return $query->result();

	}	

}