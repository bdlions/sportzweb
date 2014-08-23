<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  dataprovider Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Chat_app_model extends Ion_auth_model {
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will add a new message
     * @param $chat_category_id, category id 1 is room, 2 is group 
     * @param $reference_id, chat room id/group id
     * @param $data, chat message data. Message is stored into a json object with
     * sender_user_id, receiver_user_id, message, date, type:public/private
     */
    public function add_chat_message($chat_category_id, $reference_id, $data)
    {
        
    }
    public function update_chat_message()
    {
        
    }
    public function get_chat_messages()
    {
        
    }
}
?>
