<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_document_model extends MY_Model {

	public function get_documents( $job )
	{
		if( empty($job) ) {
			return false;
		}

		$this->db->select('*, document.document_title');
		$this->db->from( DOCUMENT_JOB_POSITION_MAPPING );
		$this->db->join( 'document','document.document_id = document_job_position_mapping.document_id', 'left' );
		$this->db->where( 'document_job_position_mapping.position_id', $job );
		$row = $this->db->get();
		  		
		if( $row ) {
			return $row->result();
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

}