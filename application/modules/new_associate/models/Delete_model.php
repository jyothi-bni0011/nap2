<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_model extends MY_Model {

	

	public function delete( $associate_id )
	{
		
		if( empty($associate_id) ) {
			return false;
		}

		
		
		$this->db->trans_start();

		$this->db->where( USER_ID, $associate_id);
		$delete = $this->db->delete('user_document_mapping');

		$this->db->where( USER_ID, $associate_id);
		$delete = $this->db->delete('users_document_fields');

		$row = $this->db->get_where( 'users', array( 'associate_id' => $associate_id ) )->row();
		if ( $row ) 
		{
			$this->db->where( USER_ID, $row->user_id);
			$delete = $this->db->delete('log_history');

			$this->db->where( USER_ID, $row->user_id);
			$delete = $this->db->delete('hr_group_user_mapping');

			$this->db->where( USER_ID, $row->user_id);
			$delete = $this->db->delete('users_role_mapping');
			
			$this->db->where( USER_ID, $row->associate_id);
			$delete = $this->db->delete('document_reject_comment');

			$this->db->where( 'associate_id', $associate_id);
			$delete = $this->db->delete("users");
		}


		$this->db->where( NEW_ASSOCIATE_ID, $associate_id);
		$delete = $this->db->delete(NEW_ASSOCIATE);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
		    // generate an error... or use the log_message() function to log your error
		    return FALSE;
		}
		else
		{
			return true;
		}
		
		

		return FALSE;

	}	
	
	public function find_status_of_doc_by_associate($associate_id)
	{
		if( empty($associate_id) ) {
			return false;
		}

		$this->db->select('*');
		$this->db->from( 'user_document_mapping' );
		$this->db->where( 'user_id', $associate_id );
		$query = $this->db->get();
		$result = $query->result();

		foreach ($result as $value) 
		{
			if ( $value->status != 4 ) {
				return false;
			}
		}

		return true;
	}
	
}