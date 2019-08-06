<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends MY_Model {

	public function fetch_data( $doc_folder_id )
	{
		
		if( empty($doc_folder_id) ) {
			return false;
		}

		$row = $this->db->get_where( DOCUMENT_FOLDER, array( DOCUMENT_FOLDER_ID => $doc_folder_id ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $doc_folder_name, $doc_folder_description="", $doc_folder_id )
	{
		
		if( empty($doc_folder_name) || empty($doc_folder_description) || empty($doc_folder_id) ) {
			return false;
		}

		$update = array(
			//'role_name'			=>	$role_name,
			DOCUMENT_FOLDER_DESCRIPTION	=>	$doc_folder_description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $doc_folder_id );
		
		if ( $result->doc_folder_name != $doc_folder_name ) {
			if ($this->check_duplicate( DOCUMENT_FOLDER, DOCUMENT_FOLDER_NAME, $doc_folder_name ) ) {
				$update[ DOCUMENT_FOLDER_NAME ] = $doc_folder_name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where( DOCUMENT_FOLDER_ID, $doc_folder_id );  
		$this->db->update( DOCUMENT_FOLDER, $update );  		
		if( $this->db->affected_rows() ) {
			rename( dirname(APPPATH) . '/assets/documents/'.$result->doc_folder_name, dirname(APPPATH) . '/assets/documents/'.$doc_folder_name );
			return true;
		}	
		

		return FALSE;

	}	

}