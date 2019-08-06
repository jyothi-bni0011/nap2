<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map_document_job_position_model extends MY_Model {

	//Display(get) all data
	public function get_maping_data( $position_ids )
	{
		
		if( !is_array($position_ids) ) {
			return [];
		}

		$this->db->select('*');
		$this->db->from( DOCUMENT_JOB_POSITION_MAPPING );
		$this->db->join('document','document.document_id = document_job_position_mapping.document_id');
		$this->db->join('job_position','job_position.position_id = document_job_position_mapping.position_id');
		$this->db->where_in( 'document_job_position_mapping.position_id', implode(",", $position_ids), FALSE );
		$query = $this->db->get();

		$documents = [];
		foreach ($query->result() as $document) {
			$documents[$document->position_id][] = $document;
		}

		return $documents;

	}
	//Display(get) all data end

	public function position_having_documents()
	{
		$this->db->select( '*' );
		$this->db->from( DOCUMENT_JOB_POSITION_MAPPING );
		$this->db->join( 'job_position', 'document_job_position_mapping.position_id = job_position.position_id', 'left' );
		$this->db->group_by( 'document_job_position_mapping.position_id' );
		$query = $this->db->get();
		return $query->result(); 
	}

	public function position_not_having_documents()
	{

		$sql = "SELECT * FROM job_position WHERE position_id NOT IN ( SELECT position_id FROM document_job_position_mapping GROUP BY position_id )";
		$result = $this->db->query( $sql );

		
		return $result->result();	
	}


	//create 
	public function create_map_document_job_position( $job_title, $doc_folder, $doc_name )
	{
		if( empty($job_title) || empty($doc_name) ) {
			return false;
		}

		foreach ($doc_name as $doc) {
			
			$create = array(
				JOB_POSITION_ID	=>	$job_title,
				DOCUMENT_ID		=>	$doc,
				DOCUMENT_FOLDER_ID => $doc_folder
			);
			$this->db->insert( DOCUMENT_JOB_POSITION_MAPPING, $create );
		}

		//if ($this->check_duplicate( CATEGORY, CATEGORY_NAME, $category_name )) {
			if( $this->db->affected_rows() ) {
				return $this->db->insert_id();
			}	
		//}
		

		return FALSE;
	}
	//create end

	//update category
	public function update_category( $category_name, $category_description="", $category_id )
	{
		if( empty($category_name) || empty($category_description) || empty($category_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			CATEGORY_DESCRIPTION	=>	$category_description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->getById( CATEGORY, CATEGORY_ID, $category_id );
		
		if ( $result->category_name != $category_name ) {
			if ($this->check_duplicate( CATEGORY, CATEGORY_NAME, $category_name )) {
				$update[ CATEGORY_NAME ] = $category_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where( CATEGORY_ID, $category_id );  
		$this->db->update( CATEGORY, $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;
	}
	//update category end

	public function get_mapping_by_position_id($position_id)
	{

		$this->db->select( '*' );
		$this->db->from( DOCUMENT_JOB_POSITION_MAPPING );
		$this->db->join( 'document_folder', 'document_job_position_mapping.doc_folder_id = document_folder.doc_folder_id', 'left' );
		$this->db->join( 'document', 'document_job_position_mapping.document_id = document.document_id', 'left' );
		$this->db->where( 'document_job_position_mapping.position_id', $position_id );
		$query = $this->db->get();
		return $query->result(); 

	}

	//delete category
	public function delete_map_document_job_position($position_id)
	{
		
		if( empty($position_id) ) {
			return false;
		}
		$this->db->where( JOB_POSITION_ID, $position_id );
		$delete = $this->db->delete( DOCUMENT_JOB_POSITION_MAPPING );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;
	}
	//delete category end

	public function find_docs_in_folder($folder_id)
	{

		$query = $this->db->get_where( DOCUMENT, array( DOCUMENT_FOLDER_ID => $folder_id ) );
		  		
		if( $rows = $query->result() ) {
			return $rows;
		}	
		
		return FALSE;
	}
}