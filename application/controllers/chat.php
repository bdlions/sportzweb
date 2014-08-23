<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chat extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model("chat_model");
        $this->load->library("follower");

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

    }
    function startChatSession(){
        /**
         * If chat session is empty send empty json
         * else chat hisotry
         */
        /*if(!empty($this->session->userdata('openChatBoxes'))){
            
        }
        else{
            $user = new stdClass();
            $user->user_id = 'alamgir';
            $user->user_name = 'Alamgir kabir';
            
            $user->messages = array('what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir','what is your name?', 'I am alamgir');
            $users = array();
            //array_push($users, $user);
            
            echo json_encode($users);
        }*/
        echo true;
    }
    
    function send_message(){
        if($this->chat_model->add_new_message($this->input->post())){
            return json_encode($this->input->post());
        }
    }
    
    function chat_heartbeat(){
        $messages = $this->chat_model->get_unread_messages();
        $response[] = array();
        foreach ($messages as $message) {
            $response[ $message -> from ][] = $message;
        }
        echo json_encode($response);
    }
    
    function get_followers_heartbeat(){
        echo json_encode($this->follower->get_followers());
    }
}
?>
