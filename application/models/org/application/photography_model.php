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
class Photography_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_images()
    {
        return $this->db->select('*')
                    ->from($this->tables['photography'])
                    ->get();
    }
    
}
