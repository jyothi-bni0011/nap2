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

	public function associate_status( $status=1 )
	{
		
		$query = $this->db->select('user_document_mapping.*, CONCAT(new_associate.associate_first_name, " ", new_associate.associate_last_name) as associate_full_name, new_associate.associate_username, job_position.position_code, department.department_name, document.document_title', FALSE)
			->from('user_document_mapping')
			->join('new_associate', 'new_associate.associate_id = user_document_mapping.user_id', 'left')
			->join('document', 'document.document_id = user_document_mapping.document_id', 'left')
			->join('job_position', 'job_position.position_id = new_associate.position_id', 'left')
			->join('department', 'department.department_id = new_associate.department_id', 'left')
			->where('user_document_mapping.status', $status)
			->limit(4)
			->get();

		if( $query->num_rows() ) {
			return $query->result();
		}

		return FALSE;
	}

}
