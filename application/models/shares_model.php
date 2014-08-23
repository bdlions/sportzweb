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
class Shares_model extends Ion_auth_model {

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
    
    public function share_status($data)
    {
        $this->db->insert_batch($this->tables['users_comments'], $data);
    }
    
}
?>
