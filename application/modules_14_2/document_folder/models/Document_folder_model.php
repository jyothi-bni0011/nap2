<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_folder_model extends CI_Model {


	public function document_folders( )
	{
		$this->db->select('*');
		$this->db->from( DOCUMENT_FOLDER );
		$query = $this->db->get();
		return $query->result();
	}	

}