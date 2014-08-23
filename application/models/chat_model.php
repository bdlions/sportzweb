<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  dataprovider Model
 *
 * Author:  alamgir kabir
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Chat_model extends Ion_auth_model {
    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->current_user_id = $this->ion_auth->get_user_id();
        $this->load->model('tempdatabase_model');
    }
    
    public function add_new_message($data) {
        $additional_data = array('from' => $this->current_user_id, 'send_date' => now(), 'received_date' => now());
        $message_data = array_merge($this->_filter_data('users_messages', $data ), $additional_data);

        $this->db->insert('users_messages', $message_data);
        return $this->db->insert_id() > 0;
       
    }
    
    public function get_unread_messages(){
        $where = "to = {$this->current_user_id} AND received = FALSE";
        $query = $this->db->select('first_name, last_name, users_messages.*')
                          ->where($where)
                          ->join($this->tables['users'], $this->tables['users'].'.id=users_messages.from')
                          ->get('users_messages');
        $result = $query->result();
        $data = $this->_filter_data('users_messages', $result );

        if(count($result) > 0){
            $this->db->update('users_messages', array('received' => TRUE), $data);
        }
        return $query->result();
    }
    
    public function get_messages($user_id){
        $where = "(`to` = {$this->current_user_id} AND `from` = {$user_id}) OR (`to` = {$user_id} AND `from` = {$this->current_user_id})";
        $query = $this->db->select('*')
                          ->where($where)
                          ->order_by("received_date", "DESC")
                          ->get('users_messages');
        if($query -> num_rows() <= 0){
            return array();
        }
        return $query->result();
    }
}
?>
