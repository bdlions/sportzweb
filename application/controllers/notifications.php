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
        $this->template->load(null, "member/notification/notifications", $this->data);
    }

    function create_notification($user_id = 0) {
        $current_time = now();
//        $reference_info_list = new stdClass();
//        $reference_info_list->user_id = 14; //reference id 
//        $reference_info_list->status_type = 1;
//        $reference_info_list->created_on = $current_time;

        $notification_info_list = new stdClass();
        $notification_info_list->type_id = 1;
        $notification_info_list->id = 2;
        $notification_info_list->created_on = $current_time;
        $notification_info_list->modified_on = $current_time;
        $notification_info_list->status = UNREAD_NOTIFICATION;
        $notification_info_list->reference_id = 2; //status_id
        $notification_info_list->reference_id_list = array();
//        $notification_info_list->reference_id_list[] = $reference_info_list;
        $user_id = 2;
        $notification_id = $this->notification->add_notification($user_id, $notification_info_list);
    }

    public function get_all_notification_list($user_id = 0, $type_id = 0, $status = 0) {
        $result_array = array();
        $result_array = $this->notification->get_all_notification_list($user_id);
        if (!empty($result_array)) {
            return $result_array;
        }
    }

    public function get_notification_list($user_id = 0, $type_id = 0, $status = 0) {
        $result_array = array();
        $result_array = $this->notification->get_notification_list($user_id);
    }
    public function update_notification_statuses(){
        $status_type_id_list = $_POST['notification_status_id_list'];
        $result_array = array();
        $user_id = $this->session->userdata('user_id');
        $result_array = $this->notification->get_notification_list($user_id);
        $result_notification_array = $result_array[0];
        $notification_list = json_decode($result_notification_array['list']);
        foreach ($notification_list as $notification_info) {
            if(in_array($notification_info->type_id, $status_type_id_list)){
                $notification_info->status = READ_NOTIFICATION ;
            }
            $modified_notification_list[] = $notification_info ;
            
        }
        $new_notification_list = array(
                'user_id' => $user_id,
                'list' => json_encode($modified_notification_list)
            );
        $response = $this->notification->update_notification($user_id,$new_notification_list);
        echo $response;
        }

  

}

?>