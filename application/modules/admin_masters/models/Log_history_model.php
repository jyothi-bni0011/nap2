<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_history_model extends MY_Model {

	public function get_log_history( $date=0 )
	{
			
		$this->db->select('log_history.*, CONCAT(users.first_name, " ", users.last_name) as full_name')
						->from( LOG_HISTORY )
						->join( USER, 'users.user_id = log_history.user_id', 'left' );

		if ( $date ) 
		{
			$this->db->where( 'DATE(log_history.log_date) = ', date( 'Y-m-d', strtotime( $date ) ) );
		}
		$query = $this->db->order_by( 'log_history.log_id', 'desc' );
		$query = $this->db->get();
		if ( $query->result() ) 
		{
			return $query->result();
		}

		return [];
	}

}