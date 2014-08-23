<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin About Us Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Admin_about_us_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_about_us_info()
    {
        return $this->db->select('*')
                ->from($this->tables['footer_about_us'])
                ->get();
    }
    
    public function add_about_us_info($additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_about_us'], $additional_data);
        $this->db->insert($this->tables['footer_about_us'], $data);
    }
    
    public function update_about_us_info($additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_about_us'], $additional_data);
        $this->db->update($this->tables['footer_about_us'], $data);
    }
}
?>
