<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visitors_businessprofile extends CI_Controller{
    public $user_group_array = array();
    public $allow_view = FALSE;
    public $allow_access = FALSE;
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('/org/admin/business_profile_library');
        $this->load->library('/org/admin/visitors');
        $this->load->library('user_logs');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->helper('url');
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $selected_user_group = $this->session->userdata('user_type');
        if(isset($selected_user_group ) && $selected_user_group != ""){
            $this->user_group_array = array($selected_user_group);
        }
        else
        {
            $this->user_group_array = $this->ion_auth->get_current_user_types();
        } 
        if (in_array(ADMIN, $this->user_group_array)) {
            $this->allow_view = TRUE;
            $this->allow_access = TRUE;
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            if(array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->allow_view = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->allow_access = TRUE;
            }
            if(!$this->allow_view)
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }
    }
    
    function index()
    {
        $this->visitors_business_profile();
    }    
   
    function visitors_business_profile()
    {
        $this->data['message'] = '';
        $visited_application = $this->visitors->get_most_visited_business_profiles(10);
        $this->data['business_list'] = $visited_application;
        $this->template->load(null, "admin/visitors/business_profile", $this->data);
    }
}
?>
