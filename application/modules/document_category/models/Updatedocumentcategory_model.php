<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatedocumentcategory_model extends MY_Model {

	public function fetch_data( $doc_cat_id )
	{
		
		if( empty($doc_cat_id) ) {
			return false;
		}

		$row = $this->db->get_where( DOCUMENT_CATEGORY, array( DOCUMENT_CATEGORY_ID => $doc_cat_id ) )->row();
		  		
		if( $row ) {
			return $row;
		}	
		
		return FALSE;

	}	


	public function update( $name, $description="", $id )
	{
		
		if( empty($name) || empty($description) || empty($id) ) {
			return false;
		}

		$update = array(
			//'doc_category_name'			=>	$name,
			DOCUMENT_CATEGORY_DESCRIPTION	=>	$description,
			//'role_alice_name'	=> (int)$department,
			UPDATED_ON		=>	date('Y-m-d H:i:s', now())
		);

		$result = $this->fetch_data( $id );
		
		if ( $result->doc_category_name != $name ) {
			if ($this->check_duplicate( DOCUMENT_CATEGORY, DOCUMENT_CATEGORY_NAME, $name ) ) {
				$update[ DOCUMENT_CATEGORY_NAME ] = $name;
			}
			else {
				return false;
			}
		}

		//print_r($update); exit();
		$this->db->where( DOCUMENT_CATEGORY_ID, $id );  
		$this->db->update( DOCUMENT_CATEGORY , $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;

	}	

}