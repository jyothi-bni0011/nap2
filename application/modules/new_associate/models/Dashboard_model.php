<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function find_document_ststus( $associate_id )
	{
		$this->db->select('*');
		$this->db->from( USER_DOCUMENT_MAPPING );
		$this->db->where( 'user_id', $associate_id );
		$this->db->where( 'status', 3 );
		$query = $this->db->get();
		
		return $query->result();		
	}

	public function associate_docs( $associate_id )
	{

		$this->db->select('user_document_mapping.*,document_category.doc_category_name,document.document_title, document.document_id, document.document_type, document.document_template, document.form_steps, ( SELECT role_id FROM document_form_steps WHERE document_id = user_document_mapping.document_id AND form_step = user_document_mapping.form_step) as form_step_role_id, user_document_mapping.file_url,(SELECT GROUP_CONCAT(type_id) FROM document_variables WHERE document_id = user_document_mapping.document_id) AS variable_types', FALSE);
		$this->db->from( USER_DOCUMENT_MAPPING );
		$this->db->join( 'document','document.document_id = user_document_mapping.document_id', 'left' );
		$this->db->join( 'document_category','document_category.doc_category_id = document.doc_category_id', 'left' );
		$this->db->where( 'user_document_mapping.user_id', $associate_id );
                $this->db->order_by('document.document_order','ASC');
		$query = $this->db->get();
		
		return $query->result();

		}

	}
        

