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
class Likes_model extends Ion_auth_model {

    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->current_user_id = $this->ion_auth->get_user_id();
    }
    
    public function get_status($status_id)
    {
        $this->db->where('id',$status_id);
        $this->response = $this->db->get($this->tables['users_statuses']);
        return $this;
    }
    
    public function get_status_list($status_id_list)
    {
        $this->db->where_in('id',$status_id_list);
        $this->response = $this->db->get($this->tables['users_statuses']);
        return $this;
    }
    
    public function store_like($additional_data)
    {
        $data = $this->_filter_data($this->tables['users_statuses'], $additional_data);
        $this->db->update($this->tables['users_statuses'], $data, array('id' => $data['id']));
    }
    
    public function get_like_user_list($status_id)
    {
        
    }
}
?>
