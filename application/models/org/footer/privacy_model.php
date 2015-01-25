<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Privacy Model
 * Author:  Nazmul Hasan
 * Requirements: PHP5 or above
 *
 */
class Privacy_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return privacy info
     * @Author Nazmul on 25th January 2015
     */
    public function get_privacy_info()
    {
     return $this->db->select($this->tables['footer_privacy'] . '.*')
                        ->from($this->tables['footer_privacy'])
                        ->get();
    }
}