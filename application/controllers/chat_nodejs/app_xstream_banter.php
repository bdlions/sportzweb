<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class App_xstream_banter extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("org/application/xstream_banter_library");
        $this->load->library("org/utility/utils");
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
    
    /*
     * This method will store chat messages of a user
     * @param messageInfo with user id, room id and message
     * @Author Nazmul on 3rd November 2014
     */
    function store_chat_message()
    {   
        $response = array();
        $message_info = json_decode($this->input->post('messageInfo'));        
        $user_id = $message_info->userId;
        $xb_chat_room_id = $message_info->roomId;
        $message = $message_info->message;
        $data = array(
            'message' => $message
        );
        $this->xstream_banter_library->store_chat_room_message($xb_chat_room_id, $user_id, $data);
        $chat_room_message_list = array();
        $use_chat_room_map_info_array = $this->xstream_banter_library->get_user_chat_room_map_info($xb_chat_room_id, $user_id)->result_array();
        if(!empty($use_chat_room_map_info_array))
        {
            $message_info = $use_chat_room_map_info_array[0];
            $message_info['message'] = $message;
            $message_info['time'] = $this->utils->get_unix_to_human_time_xb_chat_room(now());
            $chat_room_message_list[] = $message_info;
        }
        
        $response['chat_room_message_list'] = $chat_room_message_list;
        echo json_encode($response);
    }
    
}
