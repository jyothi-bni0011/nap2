<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->model('document_update_model');
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
				redirect('/document');
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
				
				$image_path 	= 'assets/files/tmp/' . time() . '.png';
				$pdf_path		= 'assets/files/' . time() . '.pdf';
				$posted_data 	= $this->input->post(NULL, TRUE);
				foreach ($variables as $variable) {
					
					$varname = sprintf('var_%s', str_replace(['{','}'], "", $variable->varname), $variable->varname);
					if( array_key_exists($varname, $posted_data) ) {

						$template = str_replace($variable->varname, $posted_data[$varname], $template);
						if( $varname === 'var_signature' ) {

							$posted_signature   = $this->input->post('var_signature', FALSE);
							file_put_contents($image_path, file_get_contents($posted_signature));

							$search 			= sprintf('<button type="button" class="var_%s" id="signature">Click to Signature</button>', str_replace(['{','}'], "", $variable->varname));
							$template 			= str_replace($search, '<img src="' . base_url($image_path) . '" width="125" />', $template);

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
					$pdf->Output( dirname(APPPATH) . '/' . $pdf_path, 'F');
					unlink($image_path);
					redirect( base_url($pdf_path) );
				}

			}

			$this->data['template'] = $template;

		}

		$this->load->view('common/header');
		$this->load->view('generate', $this->data);
		$this->load->view('common/footer');
	}

}
