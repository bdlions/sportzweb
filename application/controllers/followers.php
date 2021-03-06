<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Followers extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->load->library('basic_profile');
        $this->load->library('follower');
        $this->load->library('notification');
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

        $visit_success = $this->visitors->store_page_visitor(VISITOR_PAGE_FOLLOWERS_ID);
        $this->show();
    }

    function show($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['user_id'] = $user_id;
        $this->data['follow_permission'] = $this->follower->get_acceptance_type();
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        $this->data['followers'] = $this->follower->get_user_followers($user_id);
        $this->template->load(null, "followers/show", $this->data);
    }

    /* function pending_followers(){
      $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
      $this->data['followers'] = $this->follower->get_pending_followers();
      $this->template->load("templates/business_tmpl", "followers/show_pending_users", $this->data);
      } */

    function pending_followers($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['follow_permission'] = $this->follower->get_acceptance_type();
        $this->data['user_id'] = $user_id;
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
        $this->data['followers'] = $this->follower->get_pending_followers($user_id);
        $this->template->load(null, "followers/show_pending_users", $this->data);
    }

    function blocked_followers($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['follow_permission'] = $this->follower->get_acceptance_type();
        $this->data['user_id'] = $user_id;
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
        $this->data['followers'] = $this->follower->get_blocked_followers($user_id);
        $this->template->load(null, "followers/show_blocked_users", $this->data);
    }

    /* function accept_request($follower_id){
      if($this->follower->accept_request($follower_id) == true){
      redirect("followers/pending_followers", "refresh");
      }
      } */

    /* function accept_request($follower_id){
      $user_id = $this->session->userdata('user_id');
      if($this->follower->accept_follower($user_id, $follower_id) == true){
      redirect("followers/pending_followers/".$user_id, "refresh");
      }
      } */

    function accept_follower() {
        $follower_id = $this->input->post('follower_id');
        $user_id = $this->session->userdata('user_id');
        if (!isset($follower_id) || !isset($user_id)) {
            echo FALSE;
        } else {
            $this->follower->accept_follower($user_id, $follower_id);
            //remove the notification if exists
            $this->notification->remove_notification(NOTIFICATION_WHILE_START_FOLLOWING, $follower_id, $user_id);
            echo TRUE;
        }
    }

    /* Remote call */

    function follow_user($follower_id) {
        echo $this->follower->follow_user($follower_id);
    }

    /*
     * Ajax Call
     * This method will add a follower and notification
     * @Author Rashida on 13th April 2015
     */

    function add_follower($follower_id) {
        $user_id = $this->session->userdata('user_id');
        $follower_add_result = $this->follower->add_follower($user_id, $follower_id);
        if ($follower_add_result != FALSE) {
            $current_time = now();
            $notification_info_list = new stdClass();
            $notification_info_list->id = '';
            $notification_info_list->created_on = $current_time;
            $notification_info_list->modified_on = $current_time;
            $notification_info_list->type_id = NOTIFICATION_WHILE_START_FOLLOWING;
            $notification_info_list->status = UNREAD_NOTIFICATION;
            $notification_info_list->reference_id = (int) $user_id; //user_id
            $notification_info_list->reference_id_list = array();
            $response = $this->notification->add_notification($follower_id, $notification_info_list);
            if($response != null){
                $response = TRUE ;
            }
        }
        
       echo $response;
    }

    /*
     * This method will remove a follower
     * @Author Nazmul on 20th september 2014
     */
    /* function remove_follower($follower_id){
      $user_id = $this->session->userdata('user_id');
      $this->follower->remove_follower($user_id, $follower_id);
      redirect("followers");
      } */

    /*
     * Ajax call
     * This method will remove a follower
     * @Author Nazmul modified on 20th October 2014
     */

    function remove_follower() {
        $follower_id = $this->input->post('follower_id');
        $user_id = $this->session->userdata('user_id');
        if (!isset($follower_id) || !isset($user_id)) {
            echo FALSE;
        } else {
            $this->follower->remove_follower($user_id, $follower_id);
            echo TRUE;
        }
    }

    /*
     * This method will block a follower
     * @Author Nazmul on 20th september 2014
     */
    /* function block_follower($follower_id){
      $user_id = $this->session->userdata('user_id');
      $this->follower->block_follower($user_id, $follower_id);
      redirect("followers");
      } */

    /*
     * Ajax call
     * This method will block a follower
     * @Author Nazmul modified on 20th October 2014
     */

    function block_follower() {
        $follower_id = $this->input->post('follower_id');
        $user_id = $this->session->userdata('user_id');
        if (!isset($follower_id) || !isset($user_id)) {
            echo FALSE;
        } else {
            $this->follower->block_follower($user_id, $follower_id);
            echo TRUE;
        }
    }

    /*
     * This method will unblock a follower
     * @Author Nazmul on 25th september 2014
     */
    /* function unblock_follower($follower_id){
      $user_id = $this->session->userdata('user_id');
      $this->follower->unblock_follower($user_id, $follower_id);
      redirect("followers");
      }*

      /*
     * Ajax Call
     * This method will unblock a follower
     * @Author Nazmul modified on 20th October 2014
     */

    function unblock_follower() {
        $follower_id = $this->input->post('follower_id');
        $user_id = $this->session->userdata('user_id');
        if (!isset($follower_id) || !isset($user_id)) {
            echo FALSE;
        } else {
            $this->follower->unblock_follower($user_id, $follower_id);
            echo TRUE;
        }
    }

    function user_follow($follower_id) {
        $this->follower->follow_user($follower_id);
        redirect('member_profile/show/' . $follower_id, 'refresh');
    }

    function unfollow_user($follower_id) {
        $this->follower->unfollow_user($follower_id);
        redirect("followers");
    }

    function user_unfollow($follower_id) {
        $this->follower->unfollow_user($follower_id);
        redirect('member_profile/show/' . $follower_id, 'refresh');
    }

    function invite($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['user_id'] = $user_id;
        $this->data['follow_permission'] = $this->follower->get_acceptance_type();
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        $result = array();
        for ($i = 1; $i <= 5; $i ++) {
            $result["email" . $i] = array('status' => '', 'message' => '', 'email' => '');
        }
        $senderList = array();
        if ($this->input->post()) {
            $emailList = $this->input->post();
            foreach ($emailList as $key => $email) {
                if ($email != '') {
                    if ($this->ion_auth->email_check($email) >= 1) {
                        $result[$key] = array('status' => 'has-error', 'message' => 'Member already exists', 'email' => $email);
                    } else {
                        $senderList[] = $email;
                        $result[$key] = array('status' => 'has-success', 'message' => 'sent', 'email' => $email);
                    }
                }
            }
        }
        if (count($senderList) > 0) {
            $message = "need a template for invition";
            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($senderList);
            $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . 'invitaion');
            $this->email->message($message);

            if (!$this->email->send()) {
                echo "Email cannot be sent. Sorry for your patience.";
            }
        }
        $this->data['emailList'] = $result;
        $this->template->load(null, "followers/invite", $this->data);
    }

    public function get_follower_info() {
        $response = array();
        $follower_id = $_POST['follower_id'];
        $user_info = array();
        $user_info_array = $this->follower->get_users(array($follower_id));
        if (!empty($user_info_array)) {
            $user_info = $user_info_array[0];
        }
        $response['user_info'] = $user_info;
        echo json_encode($response);
    }

    public function store_report() {
        $follower_id = $this->input->post('follower_id');
        $reported_id_list = $this->input->post('reported_id_list');
        if (!empty($reported_id_list)) {
            $report_list = array();
            foreach ($reported_id_list as $report_type_id) {
                $report_data = array(
                    'user_id' => $follower_id,
                    'report_type_id' => $report_type_id
                );
                $report_list[] = $report_data;
            }
            $this->report_users->add_report($report_list);
        }
    }

}

?>