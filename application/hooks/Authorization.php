<?php

class Authorization {
	
	private $CI;
	
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	public function auth() {
	
		$class 		= ucfirst($this->CI->router->fetch_class());
		$method 	= $this->CI->router->fetch_method();
		$exclude 	= ['Login','Forgot_password'];
		
		if( in_array($class, $exclude) ) {
			return;
		}
		
		// TODO: Recheck users existance every n minutes
		
		if( ! (int)$this->CI->session->userdata('logged_in') ) {
			redirect('/login');
			exit;
		}

		if (! (int)$this->CI->session->userdata( 'is_associate' ) ) {
			
			if ( ! (int)$this->CI->session->userdata( 'role_id' ) AND strtolower($class) !== 'select_user_role' ) {
				redirect('select_user_role');
				exit;
			}
		}
		
	}
	
}