<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_document_model extends MY_Model {

	public function get_documents()
	{
		
		$this->db->select('document_category.doc_category_name, document_category.doc_category_id as cat_id, document.*');
		$this->db->from( DOCUMENT_CATEGORY );
		$this->db->join( DOCUMENT, 'document_category.doc_category_id = document.doc_category_id', 'left' );
		$this->db->where( 'document.status', 1 );
		$this->db->or_where( 'document.document_title', NULL );
		$row = $this->db->get();
		  		// print_r($row->result());exit();
		if( $row ) {
			$documents = [];
			foreach ($row->result() as $document) {
				$documents[$document->cat_id][] = $document;
			}
			return $documents;
		}	
		
		return FALSE;
	}

	public function create( $document, $associate_id )
	{

		if( empty($document) ) {
			return false;
		}

		foreach ($document as $doc) {
			
			// status ( Refer Document_update_model->document_statuses )
			//    form_steps = 2, then status is HR in Process
			//    form_steps = 1, then status is HR Email Sent
			$create = array(
				DOCUMENT_ID			=>	$doc,
				USER_ID				=>	$associate_id,
				ASSIGNED_DATE		=>	'"' . date('Y-m-d H:i:s', now()) . '"',
				'status'			=>	'(SELECT IF(form_steps = 2, 3, 1) FROM document WHERE document_id = ' . $doc . ' LIMIT 1)',
			);

			$this->db->insert( USER_DOCUMENT_MAPPING, $create, FALSE );

		}

		if( $this->db->affected_rows() ) {
			return $this->db->insert_id();
		}
		
		return FALSE;

	}	

	public function create_job_title( $job_code, $job_description="", $fun_area_id )
	{
		if( empty($job_code) || empty($fun_area_id) ) {
			return false;
		}

		$create = array(
			JOB_POSITION_CODE			=>	$job_code,
			JOB_POSITION_DESCRIPTION	=>	$job_description,
			FUNCTIONAL_AREA_ID			=> (int)$fun_area_id,
			CREATED_ON					=>	date('Y-m-d H:i:s', now())
		);

		
			$this->db->insert( JOB_POSITION, $create );
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}
		
		return FALSE;
	}

}