<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Like extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('likes');
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

    }

    /*
     * Ajax call
     * This methoed will store user given like under a post
     */
    public function store_status_like()
    {
        $user_id = $this->session->userdata('user_id');
        $status_id = $_POST['status_id'];
        $this->likes->store_status_like($status_id, $user_id);
        echo 1;
    }
    
    /*
     * Ajax call
     * This methoed will store user given like under a post
     */
    public function remove_status_like()
    {
        $user_id = $this->session->userdata('user_id');
        $status_id = $_POST['status_id'];
        $this->likes->remove_status_like($status_id, $user_id);
        echo 1;
    }
    
    /*
     * Ajax call
     * This methoed will store user given like under a post
     */
    public function get_status_liked_user_list()
    {
        $user_id = $this->session->userdata('user_id');
        $status_id = 6;
        //$status_id = $_POST['status_id'];
        $status_liked_user_list_array = $this->likes->get_status_liked_user_list($status_id, $user_id);
        echo json_encode($status_liked_user_list_array);        
    }

}
