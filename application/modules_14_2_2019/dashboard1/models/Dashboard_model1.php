<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function statistics()
	{
		
		$query = $this->db->select('(SELECT COUNT(status) FROM user_document_mapping WHERE status = 1) as hr_email_sent, (SELECT COUNT(status) FROM user_document_mapping WHERE status = 2) as hr_to_verify, (SELECT COUNT(status) FROM user_document_mapping WHERE status = 3) as hr_in_process, (SELECT COUNT(status) FROM user_document_mapping WHERE status = 4) as hr_verified', FALSE)
			->get();

		if( $query->num_rows() ) {
			return $query->row();
		}

		return FALSE;

	}

	public function associate_status( $status=1, $limit=0, $except=0 )
	{
		
		$this->db->select('user_document_mapping.*, CONCAT(new_associate.associate_first_name, " ", new_associate.associate_last_name) as associate_full_name, new_associate.associate_username, job_position.position_code, department.department_name, document.document_title, functional_area.fun_area_name, organizational_unit.org_unit_name, COUNT(user_document_mapping.status) as status_count', FALSE)
			->from('user_document_mapping')
			->join('new_associate', 'new_associate.associate_id = user_document_mapping.user_id', 'left')
			->join('document', 'document.document_id = user_document_mapping.document_id', 'left')
			->join('job_position', 'job_position.position_id = new_associate.position_id', 'left')
			->join('department', 'department.department_id = new_associate.department_id', 'left')
			->join('functional_area', 'functional_area.fun_area_id = new_associate.fun_area_id', 'left')
			->join('organizational_unit', 'organizational_unit.org_unit_id = new_associate.org_unit_id', 'left')
			->where('user_document_mapping.status', $status);
		if ( $except ) {
			$this->db->where_not_in('user_document_mapping.user_id', $except);
		}
		if ( $limit ) {
			$this->db->limit( $limit );
		}

		$this->db->group_by('user_document_mapping.user_id');
		$query = $this->db->order_by('user_document_mapping.assigned_date', 'DESC')->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return FALSE;
	}


	public function find_user_doc_status($status)
	{
		$this->db->select('*')
			->from('user_document_mapping')
			->where_in('status', $status);

		$query = $this->db->group_by('user_id')->get();

		
		return $query->result();
	}

}
