<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends CI_Model {

	public function get()
	{
		
		$this->db->select('document.*, document_category.doc_category_name, document_folder.doc_folder_name');
		$this->db->from('document');
		$this->db->join('document_folder', 'document_folder.doc_folder_id = document.doc_folder_id', 'left');
		$this->db->join('document_category', 'document_category.doc_category_id = document.doc_category_id', 'left');
		
		$query = $this->db->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return [];
	}

	public function get_form_steps_of_document()
	{
		$this->db->select( 'document_form_steps.*, role.role_name, document.document_id as doc_id' );
		$this->db->from( 'document_form_steps' );
		$this->db->join( 'role', 'role.role_id = document_form_steps.role_id', 'left' );
		$this->db->join( 'document', 'document.document_id = document_form_steps.document_id', 'left' );

		$query = $this->db->get();

		$documents = [];	
		
		if( $query->num_rows() ) {
			
			foreach ($query->result() as $document) {
				$documents[$document->doc_id][] = $document;
			}

		}
		// print_r( $documents ); exit();
		return $documents;
			
	}

}
