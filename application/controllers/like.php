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
        $this->load->library('notification');

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

    public function store_status_like() {
        $user_id = $this->session->userdata('user_id');
        $status_id = $_POST['status_id'];
        $referenced_user_id = $_POST['referenced_user_id'];
        $result = $this->likes->store_status_like($status_id, $user_id);
        if ($result != FALSE) {
            $current_time = now();
            $reference_info_list = new stdClass();
            $reference_info_list->user_id = $user_id; //reference id 
            $reference_info_list->status_type = UNREAD_NOTIFICATION;
            $reference_info_list->created_on = $current_time;

            $notification_info_list = new stdClass();
            $notification_info_list->id = '';
            $notification_info_list->created_on = $current_time;
            $notification_info_list->modified_on = $current_time;
            $notification_info_list->type_id = NOTIFICATION_WHILE_LIKE_ON_CREATED_POST;
            $notification_info_list->reference_id = (int) $status_id; //status_id
            $notification_info_list->reference_id_list = array();
            $notification_info_list->reference_id_list[] = $reference_info_list;
            $response = $this->notification->add_notification($referenced_user_id, $notification_info_list);
        }
        echo $response;
    }

    /*
     * Ajax call
     * This methoed will store user given like under a post
     */

    public function remove_status_like() {
        $user_id = $this->session->userdata('user_id');
        $status_id = $_POST['status_id'];
        $this->likes->remove_status_like($status_id, $user_id);
        echo 1;
    }

    /*
     * Ajax call
     * This methoed will store user given like under a post
     */

    public function get_status_liked_user_list() {
        $user_id = $this->session->userdata('user_id');
        $status_id = 6;
        //$status_id = $_POST['status_id'];
        $status_liked_user_list_array = $this->likes->get_status_liked_user_list($status_id, $user_id);
        echo json_encode($status_liked_user_list_array);
    }

}
