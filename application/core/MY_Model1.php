<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	
	//This function check duplicate entry in database. If entry is duplicate then it return false and if no duplicate entry then return true.
	public function check_duplicate( $table, $column, $value, $notin=0, $notincolunm='' )
	{
		$this->db->where($column, $value);
		
		if ($notin != 0) {
			$this->db->where_not_in( $notincolunm, $notin );
		}

		$res = $this->db->get($table);
		if (count($res->result()) == 0) {
			return true;
		}
		else {
			return false;
		}
	}
	//Function end

	//This function get all data from the table and return object formated data
	public function getAll( $table )
	{
		$this->db->select('*');
		$this->db->from( $table );
		$query = $this->db->get();
		return $query->result();
	}
	//function end

	//This function get data from table by ID
	public function getById( $table, $column, $value )
	{
		if( empty($value) ) {
			return false;
		}

		$row = $this->db->get_where( $table, array( $column => $value ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;
	}
	//Function end
}