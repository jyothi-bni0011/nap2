<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends MY_Controller {

	private $pdf_dir;

	private $image_dir;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->model('document_update_model');

		$this->pdf_dir		= '/assets/documents/';
		$this->image_dir 	= '/assets/files/tmp/';

		$this->__dirs_checks();

	}
 
	public function index( $document_id=0, $associate_id=0 )
	{

		if( ! (int)$document_id ) {
			redirect('/document');
			exit;
		}

		if( $document_id ) 
		{

			$document 		= $this->document_update_model->get( $document_id );
			if( empty($document) ) {
				redirect('/document');
				exit;
			}

			$data['roles'] = $this->document_update_model->getAll( ROLE );

			$signature_variables = [];
			foreach ($data['roles'] as $role) 
			{
				$signature_variables['var_signature_' . url_title($role->role_name, 'underscore', TRUE)] = '{signature_' . url_title($role->role_name, 'underscore', TRUE) . '}';
			}
			
			
			$associate_document = $this->document_update_model->associate_document( $document_id, $associate_id );
			if( empty($associate_document) ) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">You are not authorized to edit this document.');
				redirect('/dashboard');
				exit;
			}

			$file_name 		= url_title($associate_document->associate_username . '-' . $document->document_title . '-' . time(), 'dash', TRUE); 
			$image_path 	= dirname( APPPATH ) . $this->image_dir . $file_name . '.png';
			$document_path  = dirname( APPPATH ) . $this->pdf_dir . $document->doc_folder_name . '/';
			$pdf_path		= $document_path . $file_name . '.pdf';

			if( ! is_dir( $document_path ) ) {
				@mkdir( $document_path, 0777, TRUE );
			}

			$variables 	= $this->document_update_model->getVariables( $document_id, (int)$this->session->userdata('role_id') );
			$this->data['document']		= $document;
			$this->data['variables']	= $variables;
                        
			$variables_ = $this->document_update_model->getVariables( $document_id, 0,(int)$this->session->userdata('role_id') );

			// Converting variables in HTML format, so it can be referrenced by jquery Highlighting Feature
			$template = $document->document_template;
			if( isset($variables) AND count($variables) ) {
				foreach ($variables as $variable) {
                                        if($variable->type_id==1){
                                        $replace = sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $variable->varname), $variable->field_name);
                                        }
                                        else{
                                        $replace = sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $variable->varname), $variable->varname);
                                        }
					if( in_array($variable->varname, $signature_variables) ) {
                                            if($variable->type_id==1){
						$replace 	= sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $variable->varname), $variable->field_name);
                                        }
                                        else{
						$replace 	= sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $variable->varname), $variable->varname);
                                        }
					}

					$template = str_replace($variable->varname, $replace, $template);
				}
			}

			//Give not accessible a diffrent color
			if( isset($variables_) AND count($variables_) ) {
				foreach ($variables_ as $variable) {
				
					$replace 		= sprintf('<span class="bg-light p-2">%s</span>', $variable->varname);

					if( in_array($variable->varname, $signature_variables) ) {
						$replace 	= sprintf('<span class="bg-light p-2">%s</span>', $variable->varname);
					}

					$template = str_replace($variable->varname, $replace, $template);
				}
			}

			// Replacing with the existing values from users_documents_fields
			$document_values = $this->document_update_model->get_document_values( $document_id, $associate_id );
//			print_r($document_values);exit;
                        if( $document_values ) 
			{
				foreach ($document_values as $document_value) {
					
					$varname 		= sprintf('var_%s', str_replace(['{','}'], "", $document_value->varname));
					$replace 		= sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $document_value->varname), $document_value->varname_value);
					$template 		= str_replace($document_value->varname, $replace, $template);

					if( in_array($document_value->varname, $signature_variables) || $document_value->type_id== 2 ) {

						$signature_path = dirname( APPPATH ) . $this->image_dir . $document_id . $associate_id . $varname;

						file_put_contents($signature_path, file_get_contents($document_value->varname_value));
						$image 		= $this->image_dir . $document_id . $associate_id . $varname;
						$template 	= preg_replace( sprintf('/<span class=\"%s\">.*?<\/span>/', $varname), '<img class="' . $varname . ' img-responsive" src="' . base_url($image) . '"/>', $template);
						
					}
				}
			}

			// If some data is posted, Patch the variables with posted data and regenerate the document
			if( count($_POST) ) 
			{
//                            print_r($_POST);exit;
                            $posted_data=[];
                            $posted_data 	= $this->input->post(NULL, TRUE);
                                if ( count($_FILES) && ! $_FILES['variable_file']['error'] ) {
                                    
                                    $file_name 		= url_title($associate_document->associate_username . '-' . $document->document_title . '-' . time(), 'dash', TRUE); 

                                    $pdf_file = '.' . $this->pdf_dir . "variable_files" . '/';
                                    $posted_data['variable_file'] = $this->document_update_model->do_upload( 'variable_file', $pdf_file , $file_name);
                                
//                                    print_r($posted_data['variable_file']);exit;
                                }
				$form_step = $this->document_update_model->get_form_steps( $document_id, $associate_document->form_step );
				if( ! empty( $form_step ) 
					&& ( $form_step->role_id !== $this->session->userdata('role_id') ) ) 
				{
					$this->session->set_flashdata('message', '<div class="alert alert-danger">You are not authorized to fill this form.</div>');
					redirect('/new_associate/documents/' . $associate_id);
					exit;
				}

				if( $associate_document->file_url ) {
					$pdf_path	= dirname( APPPATH ) . $associate_document->file_url;
				}

				
//                                print_r($posted_data);
//                                print_r($variables);exit;
                                $json  = json_encode($variables);
                                $var_array = json_decode($json, true);
				$users_document_fields			= [];
				if( isset($variables) AND count($variables) ) 
				{
                                   
                                   
					foreach ($variables as $variable) 
					{
                                                if($variable->type_id==1){
                                                 //updated on 23/08/2019
                                                     $findKey = search_revisions($var_array,$posted_data['var_feild_radio'], 'varname');
                                                    $findKey=implode(',',$findKey);
                                                    $var_feild_radio_id=$var_array[$findKey]['variable_id'];
                                                    $var_feild_radio_varname=sprintf('var_%s', str_replace(['{','}'], "", $var_array[$findKey]['varname']));
                                                //end
						$varname ="var_feild_radio";
                                                $variable_id=$var_feild_radio_id;
                                                }
                                                
                                                if($variable->type_id==0){
						$varname = sprintf('var_%s', str_replace(['{','}'], "", $variable->varname));
                                                $variable_id=$variable->variable_id;
                                                }
                                                
                                                if($variable->type_id==2 && isset($pdf_file)){
                                                    
						$varname = sprintf('var_%s', str_replace(['{','}'], "", $variable->varname));
                                                $variable_id=$variable->variable_id;
                                                $image 		= base_url().$pdf_file . $posted_data['variable_file'];
                                                
                                                }
//                                                print_r($image);exit;
						if( array_key_exists($varname, $posted_data) && ! array_key_exists($varname, $signature_variables) && $variable->type_id !=2 ) {
							$users_document_fields[$varname] 	= array(
								'user_id'			=> $associate_id,
								'document_id'		=> $document_id,
								'variable_id'		=> $variable_id,
								'varname_value'		=> $posted_data[$varname],
							);
                                                        
//                                                       print_r($template);exit;
                                                        
                                                        $tick='(selected)';
							$replace  		= ($posted_data[$varname])? ($variable->type_id==1)?$var_array[$findKey]['field_name'].' '.$tick:$posted_data[$varname] : $variable->varname;
                                                        
                                                        $where_text=sprintf('var_%s', str_replace(['{','}'], "", ($variable->type_id==1)?$var_array[$findKey]['varname']:$variable->varname));
							$template 		= preg_replace( sprintf('/<span class=\"%s\">.*?<\/span>/', $where_text), $replace, $template);
//							$template 		= preg_replace( sprintf('/<span class=\"%s\">.*?<\/span>/', $test), $replace, $template);
						}
                                                
						if( array_key_exists($varname, $signature_variables) && 
							( $posted_signature = $this->input->post($varname, FALSE) )) {
//                                                       
							$users_document_fields[$varname] 	= array(
								'user_id'			=> $associate_id,
								'document_id'		=> $document_id,
								'variable_id'		=> $variable->variable_id,
								'varname_value'		=> $posted_signature);

							$signature_path = dirname( APPPATH ) . $this->image_dir . $document_id . $associate_id . $varname;

							file_put_contents($signature_path, file_get_contents($posted_signature));
							echo $image 		= $this->image_dir . $document_id . $associate_id . $varname;
							$template 	= preg_replace( sprintf('/<span class=\"%s\">.*?<\/span>/', $varname), '<img class="' . $varname . ' img-responsive" src="' . base_url($image) . '" />', $template);
						
						}
                                                if( array_key_exists($varname, $posted_data) && $variable->type_id ==2 && isset($pdf_file)) {
//                                                       
							$users_document_fields[$varname] 	= array(
								'user_id'			=> $associate_id,
								'document_id'		=> $document_id,
								'variable_id'		=> $variable->variable_id,
								'varname_value'		=> $image,
                                                                );

							$attachment_path = dirname( APPPATH ) . $this->image_dir . $document_id . $associate_id . $varname;
                                                        $path=base_url().$pdf_file . $posted_data['variable_file'];
                                                        
							file_put_contents($attachment_path, file_get_contents($path));
//                                                        unlink($path);
							echo $image 		= $this->image_dir . $document_id . $associate_id . $varname;
							$template 	= preg_replace( sprintf('/<span class=\"%s\">.*?<\/span>/', $varname),'<img  class="' . $varname . ' img-responsive" src="' . base_url($image) . '" width="125" style="width:80%;"/>', $template);
//						print_r($template);exit;
						}
//                                                echo "repalce ".$replace."<br/>";
//                                                echo $variable->variable_id. "-" .$variable->varname."<br/>";
					}
//                                        exit;
				}
//                                echo '<pre>';
//print_r($template);echo '</pre>';exit;
				{
                                    set_time_limit(0);
					$this->load->library('Pdf');
					//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
					$pdf = new Pdf();
					$pdf->setFormat('P', 'mm', 'NAP_DOC', true, 'UTF-8', false, false);
					if ( $document->document_password != null ) 
					{	
						$pdf->SetProtection(array(), $this->encrypt->decode( $document->document_password ), $this->encrypt->decode( $document->document_password ) );
					}
					$pdf->SetTitle( $document->document_title );
					//Remove header and footer
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
					//Remove header and footer end
					$pdf->SetHeaderMargin(30);
					$pdf->SetTopMargin(20);
					$pdf->setFooterMargin(20);
					$pdf->SetAutoPageBreak(true);
					$pdf->SetAuthor('Author');
					$pdf->SetDisplayMode('real', 'default');
					$pdf->AddPage();
					$pdf->writeHTML($template, true, false, true, false, '');
//                                        echo $pdf_path;exit;
					if( file_exists($pdf_path) ) {
						unlink( $pdf_path );
					}

					$pdf->Output( $pdf_path, 'F');

					if( file_exists($image_path) ) {
						unlink( $image_path );
					}

					$pdf_file = $this->pdf_dir . $document->doc_folder_name . '/' . $file_name . '.pdf';
					if( $associate_document->file_url ) {
						$pdf_file	= $associate_document->file_url;
					}
				}
//                                print_r($users_document_fields);exit;
				if( is_array($users_document_fields) ) {

					$this->document_update_model->create_document_fields( $users_document_fields );
					
					$next_step = $this->document_update_model->get_form_steps( $document_id, $associate_document->form_step+1 );
					$next_form_step = 0;
					if( $next_step ) {
						$next_form_step = $next_step->form_step;
					}

					$update_document = array(
						'file_url'			=> $pdf_file,
						'status'			=> ( $associate_document->status == 3 )? 1:2,
						'form_step'			=> $next_form_step,
						'submitted_date'	=> date('Y-m-d H:i:s', now())
					);

					$this->document_update_model->update_document( $update_document, $associate_id, $document_id );
					
					//Notification email to HR Admin when status is change
					$result = $this->document_update_model->check_all_doc_status( $associate_id );
					
					switch ( $result ) {
						case 1:
							//HR to verify to HR email sent
							
							$associate_info = $this->document_update_model->get_data_for_new_associate( '',$associate_id );

							$document_list = $this->document_update_model->get_doc_list_of_associate( '',$associate_id );
							
							$document_list_name = ['document_list' => $document_list];

							$asso_doc_info = (object)array_merge( (array)$associate_info, $document_list_name );
							
//							$this->document_update_model->send_email( 'status_change_from_hr_to_process_to_hr_email_sent', $asso_doc_info->email, $asso_doc_info );

							break;
						
						case 2:
							//email sent to verify
							$associate_info = $this->document_update_model->get_data_for_new_associate( '',$associate_id );

							$document_list = $this->document_update_model->get_doc_list_of_associate( '',$associate_id );
							
							$document_list_name = ['document_list' => $document_list];

							$asso_doc_info = (object)array_merge( (array)$associate_info, $document_list_name );
							
//							$this->document_update_model->send_email( 'status_change_from_hr_email_sent_to_hr_to_verify', $associate_info->email, $asso_doc_info );
							break;
					}
					//Notification email to HR Admin when status is change end here
					
					//Insert log
					$doc_info = $this->document_update_model->getById( DOCUMENT, DOCUMENT_ID, $document_id );
					$assoc_info = $this->document_update_model->getById( NEW_ASSOCIATE, NEW_ASSOCIATE_ID, $associate_id );

					$this->document_update_model->insert_log_history( (int)$this->session->userdata('user_id'), 'Document Generation', 'Document \''.$doc_info->{DOCUMENT_TITLE}.'\' is submited to \''.$assoc_info->{NEW_ASSOCIATE_USERNAME}.'\'' );
					//Log end
					
					if ( $this->session->userdata('role_id') == 4 ) {
						redirect( base_url('/new_associate/dashboard') );	
					}
					
					if ( $_GET ) {
						if ( $_GET['r'] == 'view' ) {
							redirect( base_url('/dashboard/hr_to_process') );
							exit;	
						}
						elseif ( $_GET['r'] == 'dashboard' ) {
						
							redirect( base_url('/dashboard') );
							exit;	
						}
					}
					
					redirect( base_url('/new_associate') );
					exit;
				}

			}
//                        echo "no post data";exit;
			$this->data['document'] = $document;
			$this->data['template'] = $template;
			$this->data['associate_document'] = $associate_document;

		}

		$this->data['signature_variables'] = $signature_variables;
//                print_r($this->data['template']);exit;
		$this->load->view('common/header');
		$this->load->view('generate', $this->data);
		$this->load->view('common/footer');
	}

	private function __dirs_checks()
	{

		if( ! is_dir( dirname( APPPATH ) . $this->pdf_dir ) ) {
			@mkdir( dirname( APPPATH ) . $this->pdf_dir, 0777 );
		}

		if( ! is_dir( dirname( APPPATH ) . $this->image_dir ) ) {
			@mkdir( dirname( APPPATH ) . $this->image_dir, 0777 );
		}
		
		if( ! is_writable( dirname( APPPATH ) . $this->image_dir ) 
			|| ! is_writable( dirname( APPPATH ) . $this->pdf_dir) ) {
			
			$this->data['message'] = '<div class="alert alert-danger">The ' . $this->image_dir . ', ' . $this->pdf_dir . ' are not writtable.</div>';
			return false;
		}

	}

	public function upload_by_new_associate()
	{
		$document_id = $_POST['doc_id'];
		$associate_id = $_POST['associate_id'];
		//if ( ! $associate_id ) {
			//$associate_id = $_POST['associate_id'];
		//}
		
		if ( ! $_FILES['upload_file']['error'] ) 
		{
			$document = $this->document_update_model->get( $_POST['doc_id'] );

			$associate_document = $this->document_update_model->associate_document( $document_id, $associate_id );

			$document_path = dirname( APPPATH ) . '/' . $this->pdf_dir . $document->doc_folder_name . '/';

			if( ! is_dir( $document_path ) ) {
				@mkdir( $document_path, 0777, TRUE );
			}
				
			$form_step = $this->document_update_model->get_form_steps( $document_id, $associate_document->form_step );
			if( ! empty( $form_step ) 
				&& ( $form_step->role_id !== $this->session->userdata('role_id') ) ) 
			{
				$this->session->set_flashdata('message', '<div class="alert alert-danger">You are not authorized to fill this form.</div>');
				redirect('/new_associate/documents/' . $associate_id);
				exit;
			}

			if( $associate_document->file_url ) {
				$pdf_path	= dirname( APPPATH ) . $associate_document->file_url;
			}

			$file_name 		= url_title($associate_document->associate_username . '-' . $document->document_title . '-' . time(), 'dash', TRUE); 

			$pdf_file = '.' . $this->pdf_dir . $document->doc_folder_name . '/';
			// echo "PATH : " . $pdf_file;
			$saved_file_name = $this->document_update_model->do_upload( 'upload_file', $pdf_file , $file_name);

			$pdf_file = $this->pdf_dir . $document->doc_folder_name . '/' . $saved_file_name;
			//
			$next_step = $this->document_update_model->get_form_steps( $document_id, $associate_document->form_step+1 );
			$next_form_step = 0;
			if( $next_step ) {
				$next_form_step = $next_step->form_step;
			}

			$update_document = array(
				'file_url'			=> $pdf_file,
				'status'			=> ( $associate_document->status == 3 )? 1:2,
				'form_step'			=> $next_form_step,
				'submitted_date'	=> date('Y-m-d H:i:s', now())
			);

			$this->document_update_model->update_document( $update_document, $associate_id, $document_id );

			//Notification email to HR Admin when status is change
			$result = $this->document_update_model->check_all_doc_status( $associate_id );
			
			switch ( $result ) {
				case 1:
					//HR to verify to HR email sent
					
					$associate_info = $this->document_update_model->get_data_for_new_associate( '',$associate_id );

					$document_list = $this->document_update_model->get_doc_list_of_associate( '',$associate_id );
					
					$document_list_name = ['document_list' => $document_list];

					$asso_doc_info = (object)array_merge( (array)$associate_info, $document_list_name );
					
					$this->document_update_model->send_email( 'status_change_from_hr_to_process_to_hr_email_sent', $associate_info->email, $asso_doc_info );

					break;
				
				case 2:
					//email sent to verify
					$associate_info = $this->document_update_model->get_data_for_new_associate( '',$associate_id );

					$document_list = $this->document_update_model->get_doc_list_of_associate( '',$associate_id );
					
					$document_list_name = ['document_list' => $document_list];

					$asso_doc_info = (object)array_merge( (array)$associate_info, $document_list_name );
					
					$this->document_update_model->send_email( 'status_change_from_hr_email_sent_to_hr_to_verify', $associate_info->email, $asso_doc_info );
					break;
			}
			//Notification email to HR Admin when status is change end here
			//

			// print_r( $document );
			// print_r( $associate_document );
			// echo "PATH : " . dirname( APPPATH );
			// exit();

			$this->load->library('user_agent');
			if ($this->agent->is_referral())
			{
			    $refer =  $this->agent->referrer();
			}

			$this->session->set_flashdata('message', 'File uploaded successfuly.');	
		}
		else
		{
			$this->session->set_flashdata('message', 'Something is wrong. Please try again.');	
		}
		if ( array_key_exists( "from", $_POST ) )
		{
			redirect( 'new_associate/documents/'.$associate_id );
		}
		redirect( 'new_associate/dashboard/' );
	}
       
	
}