<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller{
    public $user_group_array = array();
    public $allow_view = FALSE;
    public $allow_access = FALSE;
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');        
        $this->load->helper('url');
        $this->load->library('org/admin/overview_library');  
        $this->load->library('org/admin/access_level/admin_access_level_library'); 
        $this->load->library('org/admin/users_library');
        $this->load->library('org/admin/visitors');      
        $this->load->library('user_logs');      
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
            if(array_key_exists(ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->allow_view = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->allow_access = TRUE;
            }
            if(!$this->allow_view)
            {
                redirect('admin/overview', 'refresh');
            }
        }
    }

    function index() {
        $this->user_manage();
    }
    
    public function overview()
    {
        $this->data['user_list_country'] = $this->users_library->get_users_country_age(0, 100);
        $this->data = array_merge($this->data, $this->overview_library->get_members_counter());
        $this->data['message'] = '';
        $this->template->load(null, "admin/users/overview", $this->data);
    }
    
    public function user_manage($id=0)
    {
        $this->data['allow_access'] = $this->allow_access;
        if($id==0)
        {
            $this->data['user_list'] = $this->users_library->get_all_users();

        }
        else if($id==1)
        {
            $date = date('Y-m-d');
            $today = $this->user_logs->get_total_user_log_by_day($date);
            $this->data['user_list'] = $today;
        }
        else if($id==2)
        {
            $yesterday = date("Y-m-d", strtotime("-1 day")); 
            $yesterday = $this->user_logs->get_total_user_log_by_day($yesterday);
            $this->data['user_list'] = $yesterday;
        }
        else if($id==3)
        {
            $dayofweek = strftime("%w");
            $dayofweek = date("Y-m-d", strtotime("-".$dayofweek." day"));
        
            $this_week = $this->user_logs->get_total_user_log_by_this_week($dayofweek);
            $this->data['user_list'] = $this_week;
        }
        else if($id==4)
        {
            $day_of_week = strftime("%w");
            $start_date = $day_of_week+7;
            $last_date = $day_of_week;
            $date1 = date("Y-m-d", strtotime("-".$start_date." day"));
            $date2 = date("Y-m-d", strtotime("-".$last_date." day"));

            $last_week = $this->user_logs->get_total_user_log_between_dates($date1,$date2);
            $this->data['user_list'] = $last_week;
        }
        else if($id==5)
        {
            $date = date('Y-m-d');
            $start_date = explode("-",$date);
            $start_date[2] = "01";
            $date1 = "".$start_date[0]."-".$start_date[1]."-".$start_date[2];
            $value = strtotime("1 day");
            $date2 = date("Y-m-d", $value);
            $this_month = $this->user_logs->get_total_user_log_between_dates($date1,$date2);
            $this->data['user_list'] = $this_month;
        }else if($id==6)
        {
            $date = date('Y-m-d');
            $date = explode("-",$date);
            $value = strtotime("-".($date[2]-1)." day");
            $date2 = date("Y-m-d", $value);
            $value = strtotime("-".$date[2]." day");
            $date = date("Y-m-d", $value);
            //echo '<pre/>';echo gettype($date);exit;
            $date = explode("-",$date);
            $date[2] = "01";
            $date1 = "".$date[0]."-".$date[1]."-".$date[2];
            $last_month = $this->user_logs->get_total_user_log_between_dates($date1,$date2);
            $this->data['user_list'] = $last_month;
        }
        $this->template->load(null, "admin/users/user_manage", $this->data);
    }
    
    public function display_user_info($user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['user_info'] = $this->users_library->get_user_info($user_id);
        $this->data['follower_list'] = $this->users_library->get_user_followers($user_id);
        $this->data['application_log_list'] = $this->users_library->get_user_application_log($user_id);
        $this->data['message_user_list'] = $this->users_library->get_user_list_of_messages($user_id);
        $this->data['sns_list'] = $this->visitors->get_page_visitors();
        
        $this->data['page_visit'] = $this->visitors->get_most_visited_pages(3,$user_id);
        $this->data['application_visit'] = $this->visitors->get_most_visited_applications(3,$user_id);
        $this->data['business_profile_visit'] = $this->visitors->get_most_visited_business_profiles(3,$user_id);
        
        $this->data['user_friends'] = $this->users_library->get_user_friends($user_id);
        $application_visit = count($this->visitors->get_application_visitor_list(0,$user_id)->result_array());
        $this->data['total_applications'] = $application_visit;
        
//        $total_business_connection = $this->business_profile_library->get_total_business_profile_connection_user($user_id);
//        $this->data['total_business_profile_connection'] = $total_business_connection;
        $this->data['total_business_profile_connection'] = 0;
        
        $user_log = $this->user_logs->user_login_info($user_id);
        
        $this->data['user_log'] = $user_log;
        
        $this->template->load(null, "admin/users/user", $this->data);
    }
    
    function user_conversation($user1, $user2)
    {
        $this->data['conversation_list'] = $this->users_library->get_user_conversation_messages($user1, $user2)->result_array();
        $this->template->load(null, "admin/users/conversation", $this->data);
    }
    
    public function display_user_overview()
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/users/overview", $this->data);
    }
    
    /*
     * Ajax call to get users group by country based on age
     */
    public function get_users_by_ages()
    {
        $start_age = $_POST['start_age'];
        $end_age = $_POST['end_age'];
        $user_list = array();
        $user_info_array = $this->users_library->get_users_country_age($start_age, $end_age);
        foreach($user_info_array as $user_info)
        {
            $user_list[] = $user_info;
        }
        $result['user_list'] = $user_list ;
        echo json_encode($result);
        
    }
}