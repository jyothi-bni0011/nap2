<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_associate_model extends MY_Model {

	public function new_associate( )
	{

		$table[0] = "`" . NEW_ASSOCIATE . "` na";
		$table[1] = "`" . JOB_POSITION . "` jp";
		$table[2] = "`" . DEPARTMENT . "` de";
		$table[3] = "`" . FUNCTIONAL_AREA . "` fa";
		$table[4] = "`" . ORGANIZATIONAL_UNIT . "` ou";

		$selectfield[0] = "*";
		$selectfield[1] = "IFNULL (jp.`" . JOB_POSITION_CODE . "`,'') as ".JOB_POSITION_CODE;
		$selectfield[2] = "IFNULL (de.`" . DEPARTMENT_NAME . "`,'') as ".DEPARTMENT_NAME;
		$selectfield[3] = "IFNULL (fa.`" . FUNCTIONAL_AREA_NAME . "`,'') as ".FUNCTIONAL_AREA_NAME;
		$selectfield[4] = "IFNULL (ou.`" . ORGANIZATIONAL_UNIT_NAME . "`,'') as ".ORGANIZATIONAL_UNIT_NAME;

		$join_condition[0] = "jp.".JOB_POSITION_ID."="."na.".JOB_POSITION_ID."";
		$join_condition[1] = "de.".DEPARTMENT_ID."="."na.".DEPARTMENT_ID."";
		$join_condition[2] = "fa.".FUNCTIONAL_AREA_ID."="."na.".FUNCTIONAL_AREA_ID."";
		$join_condition[3] = "ou.".ORGANIZATIONAL_UNIT_ID."="."na.".ORGANIZATIONAL_UNIT_ID."";

		$this->db->select($selectfield);
		$this->db->from($table[0]);
		$this->db->join($table[1],$join_condition[0],'left');
		$this->db->join($table[2],$join_condition[1],'left');
		$this->db->join($table[3],$join_condition[2],'left');
		$this->db->join($table[4],$join_condition[3],'left');

		$query = $this->db->get();
		
		return $query->result();

		// $this->db->select(NEW_ASSOCIATE.*, JOB_POSITION.JOB_POSITION_CODE, DEPARTMENT.DEPARTMENT_NAME, FUNCTIONAL_AREA.FUNCTIONAL_AREA_NAME, ORGANIZATIONAL_UNIT.ORGANIZATIONAL_UNIT_NAME);

		// $this->db->from(NEW_ASSOCIATE);

		// $this->db->join(JOB_POSITION, JOB_POSITION.JOB_POSITION_ID = NEW_ASSOCIATE.JOB_POSITION_ID, 'left');

		// $this->db->join(DEPARTMENT, DEPARTMENT.DEPARTMENT_ID = NEW_ASSOCIATE.DEPARTMENT_ID, 'left');

		// $this->db->join(FUNCTIONAL_AREA, FUNCTIONAL_AREA.FUNCTIONAL_AREA_ID = NEW_ASSOCIATE.FUNCTIONAL_AREA_ID, 'left');

		// $this->db->join(ORGANIZATIONAL_UNIT, ORGANIZATIONAL_UNIT.ORGANIZATIONAL_UNIT_ID = NEW_ASSOCIATE.ORGANIZATIONAL_UNIT_ID, 'left');


	}

	public function documents( $associate_id )
	{
		
		if( empty($associate_id) ) {
			return FALSE;
		}

		$query = $this->db->select('user_document_mapping.*, document.document_title, ( SELECT role_id FROM document_form_steps WHERE document_id = user_document_mapping.document_id AND form_step = user_document_mapping.form_step) as form_step_role_id, document.document_template, document.document_type,(SELECT GROUP_CONCAT(type_id) FROM document_variables WHERE document_id = user_document_mapping.document_id) AS variable_types', FALSE)
			->from('user_document_mapping')
			->join('document', 'document.document_id = user_document_mapping.document_id', 'left')
			->where('user_id', $associate_id )
			->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return FALSE;

	}

	public function get_all_document_of_user($associate_id)
	{
		if ( empty( $associate_id ) ) {
			return [];
		}

		$query = $this->db->select('user_document_mapping.*, new_associate.associate_username')
			->where_in( 'user_document_mapping.user_id', $associate_id, FALSE )
			->join('new_associate', 'new_associate.associate_id = user_document_mapping.user_id', 'left')
			->get( USER_DOCUMENT_MAPPING );

		return $query->result();
	}
	
	public function get_organizational_hierarchy( $table, $column, $id )
	{
		
		$query = $this->db->get_where( $table, array( $column => $id ) );
		  		
		if( $rows = $query->result() ) {
			return $rows;
		}	
		
		return FALSE;
	}
	
	public function check_duplicate_by_ajax( $table, $column, $value, $associate_id=0 )
	{
		$query = $this->db->select('*')
							->from( $table )
							->where( $column, $value )
							->get();

		if ( empty( $query->result() ) ) {
			return true;
		}
		else{
			$result = 0;
			if ( $associate_id ) {
				$result = $query->row();
				if ( $result->associate_id == $associate_id ) {
					return true;			
				}
				//echo $value; print_r( $query->row() );
			}
		}

		return false;
	}
	
	public function find_form_steps( $doc_id )
	{
		$this->db->select( 'document_form_steps.*, role.role_name, document.document_id as doc_id' );
		$this->db->from( 'document_form_steps' );
		$this->db->join( 'role', 'role.role_id = document_form_steps.role_id', 'left' );
		$this->db->join( 'document', 'document.document_id = document_form_steps.document_id', 'left' );
		$this->db->where( 'document_form_steps.document_id', $doc_id );
		$query = $this->db->get();

		$documents = [];	
		
		if( $query->num_rows() ) {
			
			foreach ($query->result() as $document) {
				$documents[$document->doc_id][] = $document;
			}

		}
		 //print_r( $documents ); exit();
		return $documents;
	}

}