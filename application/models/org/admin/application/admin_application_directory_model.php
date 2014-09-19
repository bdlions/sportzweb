<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Application Directory Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Admin_application_directory_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will check identity of an application
     * @Author Nazmul on 19th September 2014
     */
    public function identity_check($identity = '') {
        
    }
    
    /*
     * This method will return all application for application directory feature
     * @Author Nazmul on 19th September 2014
     */
    public function get_all_applications()
    {
        
    }
    
    /*
     * This method will create a new application
     * @Author Nazmul on 19th September 2014
     */
    public function create_application()
    {
        
    }
    
    /*
     * This method will update an application
     * @Author Nazmul on 19th September 2014
     */
    public function update_application()
    {
        
    }
    
    
}
