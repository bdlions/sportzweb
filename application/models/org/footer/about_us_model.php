<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  About Us Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class About_us_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_about_us_info()
    {
        return $this->db->select('*')
                ->from($this->tables['footer_about_us'])
                ->get();
    }
}
?>
