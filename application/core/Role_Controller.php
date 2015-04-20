<?php

class Role_Controller extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library("org/profile/business/business_profile_library"); 
        $this->load->library('notification');
        $user_id = $this->session->userdata('user_id');
        $business_profile_info = $this->business_profile_library->get_profile_info();
        $this->data['business_profile_info'] = $business_profile_info;
        $this->data = array_merge($this->data, $this->notification->get_all_notification_list($user_id));
    }
}

class Admin_Controller extends CI_Controller{
    function __construct() {
        parent::__construct();
        //remove this library if not required.
        $this->load->library("org/profile/business/business_profile_library"); 
        $this->load->library('org/admin/application/admin_application_directory_library');
        $this->data['application_list'] = $this->admin_application_directory_library->get_all_applications()->result_array();
    }
}
?>
