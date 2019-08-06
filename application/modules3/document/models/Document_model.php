<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends CI_Model {

	public function get()
	{
		
		$query = $this->db->select('*')
			->from('document')
			->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return [];
	}

	public function get1()
	{
		
		$this->db->select('*, document_category.doc_category_name, document_folder.doc_folder_name');
		$this->db->from('document');
		$this->db->join('document_folder', 'document_folder.doc_folder_id = document.doc_folder_id', 'left');
		$this->db->join('document_category', 'document_category.doc_category_id = document.doc_category_id', 'left');
		
		$query = $this->db->get();
		//return $query->result();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return [];
	}

}
