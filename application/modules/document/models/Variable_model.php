<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Variable_model extends CI_Model {

	public function create($field_name, $varname, $document_id, $role_id, $type_id)
	{

		if( empty($field_name) || empty($varname) || empty($document_id) || empty($role_id) ) {
			return false;
		}

		$insert = array(
			'field_name'	=>	$field_name,
			'varname'		=>	$varname,
			'role_id'		=>	$role_id
		);

		if( $document_id ) {
			$insert['document_id'] = $document_id;
		}
                if( $type_id ) {
			$insert['type_id'] = $type_id;
		}
		$this->db->insert('document_variables', $insert);

		if($this->db->affected_rows()) {
			return $this->db->insert_id();
		}
//                echo $this->db->last_query();exit;
		return false;
	}	

}