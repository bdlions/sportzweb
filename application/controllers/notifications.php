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
        $this->load->library('notification');

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
        $user_id = $this->session->userdata('user_id');
        $notification_info = $this->notification->get_all_notification_list($user_id);
        $this->data['notification_list'] = $notification_info['notification_list'];
        $this->template->load(null, "member/notification/notifications", $this->data);
    }

//    function create_notification($user_id = 0) {
//        $current_time = now();
//        $notification_info_list = new stdClass();
//        $notification_info_list->type_id = 1;
//        $notification_info_list->id = 2;
//        $notification_info_list->created_on = $current_time;
//        $notification_info_list->modified_on = $current_time;
//        $notification_info_list->status = UNREAD_NOTIFICATION;
//        $notification_info_list->reference_id = 2; //status_id
//        $notification_info_list->reference_id_list = array();
//        $user_id = 2;
//        $notification_id = $this->notification->add_notification($user_id, $notification_info_list);
//    }
   
    /*
     * Ajax call to update notifications status
     * @Author Nazmul Hasan on 30th April 2015
     */
    public function update_notifications_status(){
        
        $user_id = $this->session->userdata('user_id');
        $notification_type_id_list = $this->input->post('notification_type_id_list');
        $response = $this->notification->update_notifications_status($user_id, $notification_type_id_list, READ_NOTIFICATION);
        echo $response;
    }
    public function get_all_notification_list(){
        $user_id = $this->session->userdata('user_id');
        $response = $this->notification->get_all_notification_list($user_id);
//        var_dump($response);exit;
        echo json_encode($response);
        
    }
}

?>