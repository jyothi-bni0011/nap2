<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('forgot_password_model');
	}
	
	public function index() {
		//echo "string";exit();
		$this->data['message'] = "";
		if( count($_POST) ) {
				
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[49]');
			
			if( $this->form_validation->run() ) {
		
				$data['email_id']	= $this->input->post('username');
				if( $user = $this->forgot_password_model->user( $data ) ) {
					if ( $this->forgot_password_model->authenticate( $this->input->post('username') ) ) 
					{
						
						$values = $this->forgot_password_model->get_data_for_forgot_password( $this->input->post('username') );

						$newpass = uniqid(rand(1, 10), false);
						$new_pass = ['password' => $newpass];

						$values = (object) array_merge( (array)$values, $new_pass );
						if ( $this->forgot_password_model->send_email( 'forgot_password',$this->input->post('username'), $values ) ) //$this->input->post('username')
						{
							$this->forgot_password_model->update_password( $newpass, $values->email );
                                                        $this->data['message'] = "Email sent succesfully, please login with updated credentials.";
//							redirect( base_url('login') );
//							exit;
                                                }else{
                                                    $this->data['message'] = "Email can not be send.";
                                                }
							
					}
					else {
						$this->data['message'] = "Unable to authenticate user. Please try again after sometime.";
					}
		
				}
				else {
					$this->data['message'] = "Invalid username or email provided.";
				}
			}
			else {
				$this->data['message'] = validation_errors();
			}
		}
		
		//$this->data['roles'] = $this->forgot_password->get_roles();
		$this->load->view('forgot_password', $this->data);
	}
}