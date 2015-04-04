<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->load->library('basic_profile');
        $this->load->library('follower');
        $this->load->library('permission');
        $this->load->library('report_users');
        $this->load->library('visitors');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $this->data['current_user_id'] = $this->session->userdata('user_id');
        $this->data['my_user_id'] = $this->session->userdata('user_id');
    }

    function index() {
        $this->template->load(null, "member/notification/notifications", $this->data);
    }

}

?>