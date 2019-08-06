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

		$this->pdf_dir		= '/assets/files/';
		$this->image_dir 	= '/assets/files/tmp/';

		$this->__dirs_checks();

	}

	public function index( $document_id=0 )
	{

		if( ! (int)$document_id ) {
			redirect('/document');
			exit;
		}

		if( $document_id ) {
			
			$document 	= $this->document_update_model->get( $document_id );

			if( empty($document) ) {
				redirect('/new_associate/document');
				exit;
			}

			$associate_document = $this->document_update_model->associate_has_document( $document_id, $this->session->userdata('associate_id') );

			if( empty($associate_document) OR (int)$associate_document->status !== 1 ) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">You are not authorized to edit this document.');
				redirect('/new_associate/dashboard');
				exit;
			}

			$variables 	= $this->document_update_model->getVariables( $document_id );
			$this->data['document']		= $document;
			$this->data['variables']	= $variables;

			// Converting variables in HTML format, so it can be referrenced by jquery Highlighting Feature
			$template = $document->document_template;
			foreach ($variables as $variable) {
			
				$replace 		= sprintf('<span class="var_%s">%s</span>', str_replace(['{','}'], "", $variable->varname), $variable->varname);

				if( $variable->varname == '{signature}' ) {
					$replace 	= sprintf('<button type="button" class="var_%s" id="signature">Click to Signature</button>', str_replace(['{','}'], "", $variable->varname));
				}

				$template = str_replace($variable->varname, $replace, $template);
			}

			// If some data is posted, Patch the variables with posted data and regenerate the document
			if( count($_POST) ) {

				$file_name 		= time(); 
				$image_path 	= dirname( APPPATH ) . $this->image_dir . $file_name . '.png';
				$pdf_path		= dirname( APPPATH ) . $this->pdf_dir . $file_name . '.pdf';
				$posted_data 	= $this->input->post(NULL, TRUE);
				$users_document_fields			= [];

				foreach ($variables as $variable) 
				{

					$varname = sprintf('var_%s', str_replace(['{','}'], "", $variable->varname));
					if( array_key_exists($varname, $posted_data) ) {

						$users_document_fields[$varname] 	= array(
							'user_id'		=> $this->session->userdata('associate_id'),
							'document_id'	=> $this->input->post('document_id'),
							'variable_id'	=> $variable->variable_id,
							'varname_value'	=> $posted_data[$varname],
						);

						$replace  = ($posted_data[$varname])? $posted_data[$varname]:$variable->varname;
						$template = str_replace($variable->varname, $replace, $template);
						
						if( $varname === 'var_signature' && 
							( $posted_signature = $this->input->post('var_signature', FALSE) ) ) {

							$users_document_fields[$varname]['varname_value'] = $posted_signature;
							file_put_contents($image_path, file_get_contents($posted_signature));
							$search 			= sprintf('<button type="button" class="var_%s" id="signature">Click to Signature</button>', str_replace(['{','}'], "", $variable->varname));
							$image 				= 'assets/files/tmp/' . $file_name . '.png';
							$template 			= str_replace($search, '<img class="' . $varname . '" src="' . base_url($image) . '" width="125" />', $template);

						}
					}
				}

				{
					$this->load->library('Pdf');
					$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
					$pdf->SetTitle('My Title');
					$pdf->SetHeaderMargin(30);
					$pdf->SetTopMargin(20);
					$pdf->setFooterMargin(20);
					$pdf->SetAutoPageBreak(true);
					$pdf->SetAuthor('Author');
					$pdf->SetDisplayMode('real', 'default');
					$pdf->AddPage();
					$pdf->writeHTML($template, true, false, true, false, '');
					$pdf->Output( $pdf_path, 'F');
					unlink( $image_path );

					$pdf_file = $this->pdf_dir . $file_name . '.pdf';
				}

				if( is_array($users_document_fields) ) {
					
					$this->document_update_model->create_document_fields( $users_document_fields );

					$update_document = array(
						'file_url'			=> $pdf_file,
						'status'			=> 2,
						'submitted_date'	=> date('Y-m-d H:i:s', now())
					);
					$this->document_update_model->update_document( $update_document, $this->session->userdata('associate_id'), $document_id );

					redirect( base_url('/new_associate/dashboard') );
				}

			}

			$this->data['template'] = $template;

		}

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