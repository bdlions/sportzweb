<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Users Report Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Users_report_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_reports()
    {
        $this->db->order_by($this->tables['follower_report_list'].'.created_on', 'desc');
        $result = $this->db->select($this->tables['users'] . '.id as user_id,'.$this->tables['users'] . '.first_name,'.$this->tables['users'] . '.last_name,'.$this->tables['follower_report_type'] . '.description')
                ->from($this->tables['follower_report_type'])
                ->join($this->tables['follower_report_list'], $this->tables['follower_report_list'].'.report_type_id='.$this->tables['follower_report_type'].'.id')
                ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['follower_report_list'].'.user_id')
                ->get();
        return $result;
    }
}
