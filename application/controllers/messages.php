<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends Role_Controller{

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
        $this->load->library("follower");
        $this->load->model("chat_model");
        $this->load->library("profile");
        $this->load->library("visitors");
        $this->load->library("org/utility/utils");

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    public function index(){
        
        $user_id = $this->session->userdata('user_id');
        $this->data['followers'] = $this->follower->get_user_followers($user_id);
        $this->data['messages'] = array();
        $this->data['me'] = $this->profile->get_user();
        
        $visit_success = $this->visitors->store_page_visitor(VISITOR_PAGE_MESSAGE_ID);
        $this->template->load("templates/member_tmpl", "member/messages/show", $this->data);
    }
    
    public function user($user_id){
        $this->data['me'] = $this->profile->get_user();
        
        //$this->data['followers'] = $this->follower->get_followers();
        $this->data['followers'] = $this->follower->get_user_followers($this->session->userdata('user_id'));
        $this->data['follower'] = $this->profile->get_user($user_id);
        $this->data['to'] = $user_id;
        
        $user_info = $this->ion_auth->get_user_info();
        $message_list = array();
        $message_list_array = $this->chat_model->get_messages( $user_id );
        foreach($message_list_array as $message_info)
        {
            $message_info->received_date = $this->utils->get_unix_to_human_date($message_info->received_date, 1,  $user_info['country_code']);
            $message_list[] = $message_info;
        }
        $this->data['messages'] = $message_list;
        
        $this->template->load("templates/member_tmpl", "member/messages/show", $this->data);
    }
    
    public function new_message($user_id = 0){
        $this->data['me'] = $this->profile->get_user();
        
        $this->data['followers'] = $this->follower->get_user_followers($this->session->userdata('user_id'));
        $this->data['follower'] = $this->profile->get_user($user_id);
        $this->data['to'] = $user_id;
        
        $user_info = $this->ion_auth->get_user_info();
        $message_list = array();
        $message_list_array = $this->chat_model->get_messages( $user_id );
        foreach($message_list_array as $message_info)
        {
            $message_info->received_date = $this->utils->get_unix_to_human_local($message_info->received_date, $user_info['country_code']);
            $message_list[] = $message_info;
        }
        $this->data['messages'] = $message_list;
        $this->template->load("templates/member_tmpl", "member/messages/new_message", $this->data);
    }
        

    public function send_message(){
        echo json_encode($this->chat_model->add_new_message($this->input->post()));
    }
}
?>
