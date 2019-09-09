<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Update_assign_document extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('assign_document_model');
        $this->load->model('new_associate/create_model');
    }

    public function index($associate_id = 0) {
//        echo $associate_id;exit;
        $data['title'] = "Assign Document To New Associate";
        
        if (count($_POST) && $associate_id != "") {
            $values = $this->create_model->get_data_for_new_associate( '',$associate_id );

	   
            $url = ['welcome_url' => anchor(base_url(), base_url())];
            $values = (object) array_merge( (array)$values, $url );
//            print_r($values);exit;
            if (array_key_exists('documents', $_POST)) {
                /* Insert document mapping for new associate */
                if ($this->assign_document_model->update($this->input->post('documents'), $associate_id)) {
                    $send_mail=$this->create_model->send_email( 'reassign_documents',$values, $values );
                   $this->session->set_flashdata('message', 'New Associate has been updated.');
                   redirect('/new_associate', $data);
                }else{
                    $this->session->set_flashdata('message', 'Something went wrong,Contact Developer');
                    redirect('/new_associate', $data);
                }
            }
        } else {
            redirect('/new_associate', $data);
        }
    }

    public function doc_by_category() {
        if (!empty($_POST)) {
            $this->db->select('*')->from(DOCUMENT);
            $this->db->where(STATUS, 1);
            if ($_POST['id']) {
                $this->db->where(DOCUMENT_CATEGORY_ID, $_POST['id']);
            }

            $query = $this->db->get();

            if (count($query->result())) {
                $htm = '';

                $htm .= '<div class="row">';
                $i = 1;
                foreach ($query->result() as $document) {
                    $htm .= '<div class="col-md-4">
			  			<div class="panel panel-default">
			    			<div class="panel-body">
			    				<div class="form-check">
								  <label class="form-check-label">
								    <input type="checkbox" class="form-check-input" name="documents[]" value="' . $document->{DOCUMENT_ID} . '">' . $document->{DOCUMENT_TITLE} . ' 
								  </label>
								</div>
			    			</div>
			  			</div><!-- end panal -->
			  		</div><!-- end col -->';
                    if ($i % 3 == 0) {
                        $htm .= '</div><!-- end row --><div class="row">';
                    }
                    $i++;
                }
                $htm .= '</div><!-- end row -->';

                $data = ['htm' => $htm, 'success' => 1];

                $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            } else {
                $data = ['success' => 0];
            }

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }
    }

}
