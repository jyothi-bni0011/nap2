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

			$signature_variables = array(
				'var_signature'			=> '{signature}',
				'var_signature_2'		=> '{signature_2}',
			);
			
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
				$old_umask = umask(0);
				@mkdir( $document_path, 0777, TRUE );
				umask($old_umask);
			}

			$variables 	= $this->document_update_model->getVariables( $document_id, (int)$this->session->userdata('role_id') );
			$this->data['document']		= $document;
			$this->data['variables']	= $variables;

			// Converting variables in HTML format, so it can be referrenced by jquery Highlighting Feature
			$template = $document->document_template;
			if( isset($variables) AND count($variables) ) {
				foreach ($variables as $variable) {
				
					$replace 		= sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $variable->varname), $variable->varname);

					if( in_array($variable->varname, $signature_variables) ) {
						$replace 	= sprintf('<span class="var_%s" id="signature">%s</span>', str_replace(['{','}'], "", $variable->varname), $variable->varname);
					}

					$template = str_replace($variable->varname, $replace, $template);
				}
			}

			// Replacing with the existing values from users_documents_fields
			$document_values = $this->document_update_model->get_document_values( $document_id, $associate_id );
			if( $document_values ) 
			{
				foreach ($document_values as $document_value) {
					
					$varname 		= sprintf('var_%s', str_replace(['{','}'], "", $document_value->varname));
					$replace 		= sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $document_value->varname), $document_value->varname_value);
					$template 		= str_replace($document_value->varname, $replace, $template);

					if( in_array($document_value->varname, $signature_variables) ) {

						$signature_path = dirname( APPPATH ) . $this->image_dir . $document_id . $associate_id . $varname;

						file_put_contents($signature_path, file_get_contents($document_value->varname_value));
						$image 		= $this->image_dir . $document_id . $associate_id . $varname;
						$template 	= preg_replace( sprintf('/<span class=\"%s\">.*?<\/span>/', $varname), '<img class="' . $varname . '" src="' . base_url($image) . '" width="125" />', $template);
						
					}
				}
			}

			// If some data is posted, Patch the variables with posted data and regenerate the document
			if( count($_POST) ) 
			{

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

				$posted_data 	= $this->input->post(NULL, TRUE);
				$users_document_fields			= [];
				foreach ($variables as $variable) 
				{

					$varname = sprintf('var_%s', str_replace(['{','}'], "", $variable->varname));
					if( array_key_exists($varname, $posted_data) && ! array_key_exists($varname, $signature_variables) ) {

						$users_document_fields[$varname] 	= array(
							'user_id'			=> $associate_id,
							'document_id'		=> $document_id,
							'variable_id'		=> $variable->variable_id,
							'varname_value'		=> $posted_data[$varname],
						);

						$replace  		= ($posted_data[$varname])? $posted_data[$varname]:$variable->varname;
						$template 		= preg_replace( sprintf('/<span class=\"%s\">.*?<\/span>/', $varname), $replace, $template);
					}

					if( array_key_exists($varname, $signature_variables) && 
						( $posted_signature = $this->input->post($varname, FALSE) ) ) {

						$users_document_fields[$varname] 	= array(
							'user_id'			=> $associate_id,
							'document_id'		=> $document_id,
							'variable_id'		=> $variable->variable_id,
							'varname_value'		=> $posted_signature,
						);

						$signature_path = dirname( APPPATH ) . $this->image_dir . $document_id . $associate_id . $varname;

						file_put_contents($signature_path, file_get_contents($posted_signature));
						echo $image 		= $this->image_dir . $document_id . $associate_id . $varname;
						$template 	= preg_replace( sprintf('/<span class=\"%s\" id="signature">.*?<\/span>/', $varname), '<img class="' . $varname . '" src="' . base_url($image) . '" width="125" />', $template);
					
					}
				}

				{
					$this->load->library('Pdf');
					$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
					$pdf->SetProtection(array(), 'abcd', 'abcd');
					$pdf->SetTitle( $document->document_title );
					$pdf->SetHeaderMargin(30);
					$pdf->SetTopMargin(20);
					$pdf->setFooterMargin(20);
					$pdf->SetAutoPageBreak(true);
					$pdf->SetAuthor('Author');
					$pdf->SetDisplayMode('real', 'default');
					$pdf->AddPage();
					$pdf->writeHTML($template, true, false, true, false, '');

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
					if ( $this->session->userdata('role_id') == 4 ) {
						redirect( base_url('/new_associate/dashboard') );	
					}
					redirect( base_url('/new_associate') );
					exit;
				}

			}

			$this->data['template'] = $template;

		}

		$this->data['signature_variables'] = $signature_variables;
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

}