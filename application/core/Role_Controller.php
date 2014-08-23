<?php

class Role_Controller extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library("org/profile/business/business_profile_library");        
        
        $business_profile_info = $this->business_profile_library->get_profile_info();
        $this->data['business_profile_info'] = $business_profile_info;
       
    }
}
?>
