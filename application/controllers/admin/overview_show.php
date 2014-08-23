<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Overview_show extends Role_Controller{
    public $user_group_array = array();
    public $allow_view = FALSE;
    public $allow_access = FALSE;
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');        
        $this->load->helper('url'); 
        //$this->load->library('org/admin/admin_business_profile_library');
        $this->load->library('org/admin/overview_library');  
        $this->load->library('org/admin/visitors');  
        $this->load->library('user_logs');  
        $this->load->library('org/admin/access_level/admin_access_level_library'); 
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
            if(array_key_exists(ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->allow_view = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->allow_access = TRUE;
            }
            if(!$this->allow_view)
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }
    }

    function index() {
        
        $this->data['message'] = '';
        $this->data = array_merge($this->data, $this->overview_library->get_members_counter());
        $this->data = array_merge($this->data, $this->overview_library->get_user_logs());
        $this->data['total_applications'] = $this->overview_library->get_total_applications();
        $this->data['total_business_profiles'] = $this->overview_library->get_total_business_profiles();
        $this->data['most_visited_pages'] = $this->visitors->get_most_visited_pages(3);
        $this->data['most_visited_applications'] = $this->visitors->get_most_visited_applications(3);
        $this->data['most_visited_business_profiles'] = $this->visitors->get_most_visited_business_profiles(3);
        
        //count for today
        $date = date('Y-m-d');
        $today = count($this->user_logs->get_total_user_log_by_day($date));
        $this->data['today_count'] = $today;
        
        
        //count for yesterday
        $yesterday = date("Y-m-d", strtotime("-1 day")); 
        $yesterday = count($this->user_logs->get_total_user_log_by_day($yesterday));
        $this->data['yesterday'] = $yesterday;
        
        
        //count for this week
        $day_of_week = strftime("%w");
        $dayofweek = date("Y-m-d", strtotime("-".$day_of_week." day"));
        $this_week = count($this->user_logs->get_total_user_log_by_this_week($dayofweek));
        $this->data['this_week'] = $this_week;
        
        //count for last week
        $day_of_week = strftime("%w");
        $start_date = $day_of_week+7;
        $last_date = $day_of_week;
        $date1 = date("Y-m-d", strtotime("-".$start_date." day"));
        $date2 = date("Y-m-d", strtotime("-".$last_date." day"));
        
        $last_week = count($this->user_logs->get_total_user_log_between_dates($date1,$date2));
        $this->data['last_week'] = $last_week;
        
        //count for this month
        $date = date('Y-m-d');
        $start_date = explode("-",$date);
        $start_date[2] = "01";
        $date1 = "".$start_date[0]."-".$start_date[1]."-".$start_date[2];
        $date2 = date("Y-m-d", strtotime("1 day"));
        $this_month = count($this->user_logs->get_total_user_log_between_dates($date1,$date2));
        $this->data['this_month'] = $this_month;
        
        //count for last month
        $date = date('Y-m-d');
        $date = explode("-",$date);
        $date2 = date("Y-m-d", strtotime("-".($date[2]-1)." day"));
        $date = date("Y-m-d", strtotime("-".$date[2]." day"));
        $date = explode("-",$date);
        $date[2] = "01";
        $date1 = "".$date[0]."-".$date[1]."-".$date[2];
        $last_month = count($this->user_logs->get_total_user_log_between_dates($date1,$date2));
        $this->data['last_month'] = $last_month;
        
        $total_array = $this->user_logs->get_total_user_log_by_day();

        $total_time = 0;
        $length = count($total_array);
       
        for($i=0;$i<$length;$i++)
        {
            $log_history = json_decode($total_array[$i]['log_history']);
            $len = count($log_history);
            for($j=0;$j<$len;$j++)
            {
                if(property_exists($log_history[$j],'logout_time'))
                {
                    $total_time+=$log_history[$j]->logout_time - $log_history[$j]->login_time;
                }
            }
        }
        
        if($length>0){
            $total_time = $total_time/$length;
        }
        $this->data['hour'] = round($total_time/3600);
        $total_time = $total_time%3600;
        $this->data['minute'] = round($total_time/60);
        
        
        //connected business_profile
        
        $business_profile_array = $this->business_profile_library->get_all_business_profile();
        $len = count($business_profile_array);
        $total = 0;
        for($i=0;$i<$len;$i++)
        {
            $connection = $this->business_profile_library->get_total_business_connections($business_profile_array[$i]->id);            
            $total += $connection;

        }

        $this->data['business_profile'] = $total;
        
        $this->template->load(null, "admin/index", $this->data);
    }
}