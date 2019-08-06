<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getdocumentcategory_Model extends CI_Model {


	public function doc_category( )
	{
		$this->db->select('*');
		$this->db->from( DOCUMENT_CATEGORY );
		$query = $this->db->get();
		return $query->result();
	}	

}