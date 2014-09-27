<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Report User Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Report_user_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function add_report($report_data)
    {
        if(!empty($report_data))
        {
            $this->db->insert_batch($this->tables['follower_report_list'], $report_data);
        }        
    }
}
