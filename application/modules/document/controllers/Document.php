<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('document_model');
	}
	
	public function index() {
		$this->data['title'] = "Document";
		$this->data['documents'] = $this->document_model->get();
		$this->data['field_steps'] = $this->document_model->get_form_steps_of_document();

		$this->load->view('common/header');
		$this->load->view('document', $this->data);
		$this->load->view('common/footer');
	}

	public function tiny_img_upload()
	{
		
		/***************************************************
	   * Only these origins are allowed to upload images *
	   ***************************************************/
	  $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://nap.bluenettech.com");

	  /*********************************************
	   * Change this line to set the upload folder *
	   *********************************************/
	  $imageFolder = "assets/img/";

	  reset ($_FILES);
	  $temp = current($_FILES);
	  if (is_uploaded_file($temp['tmp_name'])){
	    if (isset($_SERVER['HTTP_ORIGIN'])) {
	      // same-origin requests won't set an origin. If the origin is set, it must be valid.
	      if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
	        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
	      } else {
	        header("HTTP/1.1 403 Origin Denied");
	        return;
	      }
	    }

	    /*
	      If your script needs to receive cookies, set images_upload_credentials : true in
	      the configuration and enable the following two headers.
	    */
	    // header('Access-Control-Allow-Credentials: true');
	    // header('P3P: CP="There is no P3P policy."');

	    // Sanitize input
	    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
	        header("HTTP/1.1 400 Invalid file name.");
	        return;
	    }

	    // Verify extension
	    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
	        header("HTTP/1.1 400 Invalid extension.");
	        return;
	    }

	    // Accept upload if there was no origin, or if it is an accepted origin
	    $filetowrite =  $imageFolder . $temp['name'];
	    move_uploaded_file($temp['tmp_name'], $filetowrite);

	    // Respond to the successful upload with JSON.
	    // Use a location key to specify the path to the saved image resource.
	    // { location : '/your/uploaded/image/file'}
	    echo json_encode(array('location' => $temp['name']));
	  } else {
	    // Notify editor that the upload failed
	    header("HTTP/1.1 500 Server Error");
	  }
	}
	
	public function check_duplicate_document_by_ajax()
	{
		if( count($_POST) ) {
			
			if ( $rows = $this->document_model->check_duplicate_document_by_ajax( $_POST['table'], $_POST['column'], $_POST['id'], $_POST['doc_id'] ) ) 
			{
				$data = ['success' => 1]; // no duplicate entry found
			}
			else
			{
				$data = ['success' => 0];	// duplicate entry found
			}

		
			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
		
	}
}