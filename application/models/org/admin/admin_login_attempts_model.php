<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin login attemts model
 * Author:  Nazmul on 25th January 2015
 * Requirements: PHP5 or above
 *
 */
class Admin_login_attempts_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return all login attempts
     * @Author Nazmul on 25th January 2015
     */
    public function get_all_login_attempts()
    {
        
    }
    
    /*
     * This method will delete login attemtps
     * @param $id, login attemtps id
     * @Author Nazmul on 25th January 2015
     */
    public function delete_login_attempt($id)
    {
        
    }
}
