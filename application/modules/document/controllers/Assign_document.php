<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_document extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('assign_document_model');
		$this->load->model('new_associate/create_model');
	}

	public function index( $associate_id=0 )
	{
		// if( ! $associate_id AND ! count($_POST) ) 
		// {
		// 	$this->session->set_flashdata('message', error_message('Associate ID is required for assigning documents.'));
		// 	redirect('/new_associate');
		// }

		$data['title'] = "Assign Document To New Associate";
                if($associate_id){
                    $data['associate_id'] = $associate_id;
                    $data['documents'] = $this->assign_document_model->get_documents();
                    $data['doc_categories'] = $this->assign_document_model->getAll( DOCUMENT_CATEGORY );
                    $data['assigned_documents'] = $this->assign_document_model->get_documents($associate_id);
//                    print_r($data['assigned_documents']);exit;
                    $this->load->view('common/header');
                    $this->load->view('update_assign_document', $data);
                    $this->load->view('common/footer');
                }
		if( count($_POST) ) 
		{
			$this->form_validation->set_rules('username', 'User Name', 'trim|required|max_length[49]');
			$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('middle_name', 'User Name', 'trim|max_length[49]');
			$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required');
			$this->form_validation->set_rules('organizational_unit', 'Organizational Unit', 'trim|required|numeric');
			$this->form_validation->set_rules('functional_area', 'Functional Area', 'trim|required|numeric');
			$this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
			$this->form_validation->set_rules('start_date', 'Start Date of Associate', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
			$this->form_validation->set_rules('contact_info', 'Contact_info', 'trim|required');
			$this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[254]');

			if( $this->form_validation->run() ) 
			{

				$create = array(
					'username'				=>		$this->input->post('username'),
					'email'					=>		$this->input->post('email'),
					'first_name'			=>		$this->input->post('first_name'),
					'last_name'				=>		$this->input->post('last_name'),
					'middle_name'			=>		$this->input->post('middle_name'),
					'job_title'				=>		$this->input->post('job_title'),
					'organizational_unit'	=>		$this->input->post('organizational_unit'),
					'functional_area'		=>		$this->input->post('functional_area'),
					'department'			=>		$this->input->post('department'),
					'start_date'			=>		$this->input->post('start_date'),
					'status'				=>		$this->input->post('status'),
					'contact_info'			=>		$this->input->post('contact_info'),
					'address'				=>		$this->input->post('address'),
					'manager'				=>		$this->input->post('manager_id'),
					'manager_title'			=>		$this->input->post('manager_title')
				);

				
				$url = ['welcome_url' => anchor(base_url(), base_url())];
				
				if ($this->create_model->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_EMAIL, $this->input->post('email') )) 
				{
					if ($this->create_model->check_duplicate( NEW_ASSOCIATE, NEW_ASSOCIATE_USERNAME, $this->input->post('username') )) 
					{
						if ( array_key_exists('documents', $_POST) ) 
						{
							// create job title
							if ( $last_id = $this->assign_document_model->create_job_title( $this->input->post('job_title'), '', $this->input->post('functional_area') ) ) 
							{
								$create['job_title'] = $last_id;
							}
							

							/*Create new associate and user*/
							if( $inserted_id = $this->create_model->create( $create ) ) 
							{
									
								/*Insert document mapping for new associate*/
								if( $this->assign_document_model->create( $this->input->post('documents'), $inserted_id ) ) 
								{
									//insert in log for new associate
									$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'New Associate', 'New Associate \''.$this->input->post('username').'\' is created' );

									
									if ( array_key_exists('user', $_POST) ) {
										$this->create_model->map_user_new_associate( $_POST['user'], $inserted_id );
										
										$this->create_model->create_same_user_role_mapping( 4, $_POST['user'] );

										$this->session->set_flashdata('message', 'User has been mapped with New Associate.');
										redirect( '/users'  );		
									}
									elseif ( $user_inserted_id = $this->create_model->create_same_user( $create, $inserted_id ) ) 
									{
										$this->create_model->create_same_user_role_mapping( 4, $user_inserted_id );

										$values = $this->create_model->get_data_for_new_associate( $this->input->post('email') );

										$values = (object) array_merge( (array)$values, $url );

										if ( $send_mail=$this->create_model->send_email( 'welcome_associate',$this->input->post('email'), $values ) )//$this->input->post('email') 
										{
                                                                                    print_r($send_mail);exit;
											$this->session->set_flashdata('message', 'New Associate has been created.');
										}
										else
										{
											$this->session->set_flashdata('message', 'New Associate has been created. But Email not sent.');	
										}

										//insert in log for User
										$this->create_model->insert_log_history( (int)$this->session->userdata('user_id'), 'User', 'New User \''.$this->input->post('username').'\' is created' );
						
//										$this->session->set_flashdata('message', 'User has been created.');
										redirect( '/new_associate'  );
									}
									// else {
									// 	$this->session->set_flashdata('message', 'Failed to create the user');
									// 	redirect( '/document/assign_document/index/'.$inserted_id );
									// }
									// redirect( '/document/assign_document/index/'.$inserted_id  );
								}
							} 
							else {
								$this->session->set_flashdata('message', 'Failed to create the new associate');
								redirect( '/new_associate/create', $data );
							}
						}
						else
						{

							$data['documents'] = $this->assign_document_model->get_documents();
							$data['associate'] = $_POST;
							$data['doc_categories'] = $this->assign_document_model->getAll( DOCUMENT_CATEGORY );
							$this->load->view('common/header');
							$this->load->view('assign_document', $data);
							$this->load->view('common/footer');	
										
						}
						
					}
					else 
					{
						$this->session->set_flashdata('message', 'Duplicate Username. Failed to create new associate.');
						redirect( '/new_associate/create', $data );
					}

				}
				else 
				{
					$this->session->set_flashdata('message', 'Duplicate Email. Failed to create the user.');
					redirect( '/new_associate/create', $data );
				}
			}
			else {
				$this->session->set_flashdata('message', validation_errors());
				redirect( '/new_associate/create', $data );
			}
			
			/*redirect( '/new_associate', $data );*/
		}
		
		

	}
        public function document_order(){
        $data['title'] = "Documents Order";
        $data['documents'] = $this->assign_document_model->alldocuments();
        $data['doc_categories'] = $this->assign_document_model->getAll( DOCUMENT_CATEGORY );
        if(count($_POST)){
          $idArray = explode(",", $_POST['ids']);
          $update = $this->assign_document_model->updateOrder( $idArray );
          if($update){
              return "success";
              exit;
          }
        }
//                    print_r($data['assigned_documents']);exit;
        $this->load->view('common/header');
        $this->load->view('document_order', $data);
        $this->load->view('common/footer');
        }
	public function doc_by_category()
	{
		if ( !empty( $_POST ) ) {
			$this->db->select('*')->from( DOCUMENT );
			$this->db->where( STATUS, 1 );
			if ( $_POST['id'] ) {
				$this->db->where( DOCUMENT_CATEGORY_ID, $_POST['id'] );
			}
			
			$query = $this->db->get();

			if ( count( $query->result() ) ) {
				$htm = '';

				$htm.='<div class="row">';
				$i=1; 
				foreach( $query->result() as $document ){
			  		$htm.='<div class="col-md-4">
			  			<div class="panel panel-default">
			    			<div class="panel-body">
			    				<div class="form-check">
								  <label class="form-check-label">
								    <input type="checkbox" class="form-check-input" name="documents[]" value="'. $document->{DOCUMENT_ID} .'">'. $document->{DOCUMENT_TITLE}.' 
								  </label>
								</div>
			    			</div>
			  			</div><!-- end panal -->
			  		</div><!-- end col -->';
			  	if ( $i % 3 == 0 ){
			  	$htm.='</div><!-- end row --><div class="row">';
			  	} 
			  	$i++;
			  	}
			  	$htm.='</div><!-- end row -->';
			  	
			  	$data = ['htm' => $htm, 'success' => 1];

				$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
			}
			else
			{
				$data = [ 'success' => 0 ];
			}

			$this->output
				->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
		
	}
}