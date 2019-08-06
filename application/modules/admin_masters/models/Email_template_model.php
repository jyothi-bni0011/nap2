<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template_model extends MY_Model {

	//get veriable
	public function get_veriables()
	{
		$this->db->select('associate_username as {user_name}, associate_email as {email}, associate_first_name as {first_name}, associate_middle_name as {middle_name}, associate_last_name as {last_name}, position_id as {job_title}, org_unit_id as {organizational_unit}, fun_area_id as {functional_area}, department_id as {department}, associate_start_date as {start_date}, user_id as {manager_name}, associate_manager_title as {manager_title}')
			->from( NEW_ASSOCIATE )
			->limit( 1 );
		$query = $this->db->get();

		return $query->row();
	}
	// end

	//update category
	public function update_email_template( $subject, $body, $template_id )
	{
		if( empty($subject) || empty($body) || empty($template_id) ) {
			return false;
		}

		$update = array(
			EMAIL_TEMPLATE_SUBJECT	=>	$subject,
			EMAIL_TEMPLATE_BODY		=>	$body,
			UPDATED_ON				=>	date('Y-m-d H:i:s', now())
		);
		
		//print_r($update); exit();
		$this->db->where( EMAIL_TEMPLATE_ID, $template_id );  
		$this->db->update( EMAIL_TEMPLATE, $update );  		
		if( $this->db->affected_rows() ) {
			return true;
		}	
		

		return FALSE;
	}
	//update category end

	//delete category
	public function delete_category($category_id)
	{
		
		if( empty($category_id) ) {
			return false;
		}
		$this->db->where( CATEGORY_ID, $category_id );
		$delete = $this->db->delete( CATEGORY );
		if( $this->db->affected_rows() ) {
			return true;
		}	
		
		return FALSE;
	}
	//delete category end
}