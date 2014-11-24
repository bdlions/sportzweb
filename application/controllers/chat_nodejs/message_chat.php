<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_chat extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("org/utility/utils");
        $this->load->helper('url');
        $this->load->model("chat_model");

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');        
    }
    
    /*
     * This method will store chat messages of a user
     * @param messageInfo with user id, room id and message
     * @Author Nazmul on 3rd November 2014
     */
    function store_chat_message()
    {   
        $response = array();
        $message_info = json_decode($this->input->post('messageInfo'));        
        $this->session->set_userdata('user_id', $message_info->senderId);
        $user_id = $message_info->receiverId;
        $message = $message_info->message;
        $data = array(
            'message' => $message,
            'to' => $user_id,
            'received' => 0
        );
        $this->chat_model->add_new_message($data);
        //$chat_room_message_list = array();
        /*$use_chat_room_map_info_array = $this->xstream_banter_library->get_user_chat_room_map_info($xb_chat_room_id, $user_id)->result_array();
        if(!empty($use_chat_room_map_info_array))
        {
            $updated_message_info['userId'] =  $user_id;
            $updated_message_info['roomId'] =  $xb_chat_room_id;
            $updated_message_info['message'] =  $message;
            $updated_message_info = array_merge($updated_message_info, $use_chat_room_map_info_array[0]);
            //$message_info['message'] = $message;
            $updated_message_info['time'] = $this->utils->get_unix_to_human_time_xb_chat_room(now());
            //$chat_room_message_list[] = $message_info;
        }
        
        $response['messageInfo'] = $updated_message_info;*/
        $sender_user_info_array = $this->chat_model->get_user_info($message_info->senderId)->result_array();
        if(!empty($sender_user_info_array))
        {
            $sender_user_info = $sender_user_info_array[0];
            $message_info->senderFirstName = $sender_user_info['first_name'];
            $message_info->senderLastName = $sender_user_info['last_name'];
        }
        $message_info->time = $this->utils->get_unix_to_human_time_xb_chat_room(now());        
        $response['messageInfo'] = $message_info;
        echo json_encode($response);
    }
    
}
