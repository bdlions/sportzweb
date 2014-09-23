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
class User_rpc_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getALlUsers() {
        $this->db->order_by('id', 'desc');
        return $this->db->select("*")
                    ->from($this->tables['users'])
                    ->get();
    }
    
}