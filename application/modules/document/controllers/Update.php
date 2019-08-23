<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://jsfiddle.net/szimek/jq9cyzuc/

class Update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('document_update_model');
		$this->load->model('variable_model');
		$this->load->model('document_create_model');
	}

	public function index( $document_id )
	{
            
		$this->data['title'] = "Document";
		if( count($_POST) ) 
		{ 
			//upload doc
			if ( $this->input->post('doc_type') == 'upload' ) 
			{
				$_POST['doc_type'] = 2;
				if ( ! $this->input->post('old_file_name') ) // if old file name is not exist
				{
					// check new file is inserted or not
					if ( ! $_FILES['upload_file']['error'] ) // If no error in $_FILEES
					{
						$full_path = $this->document_update_model->do_upload('upload_file','./assets/uploaded_documents/');
						$_POST['document'] = $full_path;
					}
					else
					{
						$this->session->set_flashdata('message', 'Please Select File');
                		redirect('/document/update/index/'.$this->input->post('document_id'));
					}
					
				}
				else //if old file name exist
				{
					if ( ! $_FILES['upload_file']['error'] ) {
						$full_path = $this->document_update_model->do_upload('upload_file','./assets/uploaded_documents/');
						$_POST['document'] = $full_path;	
					}
					else
					{
						$_POST['document'] = $this->input->post('old_file_name');
					}
					
				}
                                } else {
                                    $_POST['doc_type'] = 1;
                                }
                                if ($this->input->post('doc_password') != "" && $_POST['doc_type']==2) {
                                    $password = $this->input->post('doc_password');
                                    $origFile = 'assets/uploaded_documents/'.$_POST['document'];
                                    $destFile = 'assets/uploaded_documents/'.$_POST['document'];
                                    @pdfEncrypt($origFile, $password, $destFile);
                                }
            //Upload doc End
            if ($this->document_update_model->update($this->input->post('document_id'), $this->input->post('document_title'), $this->input->post('document', FALSE), $this->input->post('doc_folder'), $this->input->post('doc_category'), $this->input->post('status'), $this->input->post('form_steps'), $this->input->post('doc_password'), $this->input->post('doc_type'))) {

                if( ! empty($_POST['variables']) AND count($_POST['variables']) ) 
				{
//                                    print_r($this->input->post('variables'));exit;
					foreach ($this->input->post('variables') as $value) {
					
						$this->variable_model->create(
							$value['field_name'], 
							$value['varname'], 
							$this->input->post('document_id'), 
							$value['role_id'],
                                                        $value['type_id'] 
						);
                                                
					}
                                        
				}

				if( ! empty( $_POST['form_steps_role'] ) && 
					( count($this->input->post('form_steps_role')) == $this->input->post('form_steps') ) ) {

					$form_steps = [];
					foreach($this->input->post('form_steps_role') as $key => $role_id) {
						$form_steps[] = array(
							'document_id'		=> $document_id,
							'role_id'			=> $role_id,
							'form_step'			=> ($key+1)
						);
					}

					$this->document_create_model->delete_form_steps( $document_id );
					$this->document_create_model->create_form_steps( $form_steps );
				}
				//insert in log
				$this->document_create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document', 'Document template - \''.$this->input->post('document_title').'\' is updated' );
				
				$this->data['message'] = sprintf('<div class="alert alert-%s">%s</div>', "success", "Document has been saved.");
				$this->session->set_flashdata('message', 'Document has been updated.');
				redirect('document/');
				exit;
			}
		}

		if( $document_id ) {

			$this->data['document'] 	= $this->document_update_model->get( $document_id );
			$this->data['form_steps'] 	= $this->document_update_model->get_form_steps_details( $document_id );

			$this->data['variables'] 	= $this->document_update_model->getVariables( $document_id );
			
		}

		$this->data['doc_folders'] = $this->document_update_model->getAll( DOCUMENT_FOLDER );
		$this->data['doc_categories'] = $this->document_update_model->getAll( DOCUMENT_CATEGORY );
		$this->data['roless'] = $this->document_update_model->getAll( ROLE );
		

		$this->load->view('common/header');
		$this->load->view('update', $this->data);
		$this->load->view('common/footer');
	}
        

    
    public function test() {
        $password = 'Jyothi';
        $origFile = 'assets/uploaded_documents/smsc_relaving.pdf';
        $destFile = 'assets/uploaded_documents/smsc_relaving_lock.pdf';
        $res = pdfEncrypt($origFile, $password, $destFile);
        if ($res) {
            echo "Success" . "<br/>Unlock Pdf With password : $password";
        } else {
            echo "fail";
        }
    }

}