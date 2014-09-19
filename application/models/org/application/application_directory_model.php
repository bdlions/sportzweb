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
class Application_directory_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function test()
    {
        echo "application directory model";
    }
}
