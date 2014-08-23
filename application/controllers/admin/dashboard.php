<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('/org/admin/business_profile_library');
        $this->load->library('/org/admin/visitors');
        $this->load->library('user_logs');
        $this->load->helper('url');
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

    }
    
    function index()
    {
        redirect('admin/overview','refresh');
    }
    
    function overview()
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/index", $this->data);
    }
    
    function users_overview()
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/users/overview", $this->data);
    }
    
    function users_user_manage()
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/users/user_manage", $this->data);
    }
    
    function user($user_id)
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/users/user", $this->data);
    }
    
    function user_conversation($user1, $user2)
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/users/conversation", $this->data);
    }
    
    function applications()
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/applications/applications", $this->data);
    }
    
    function business_profiles()
    {
        $this->data['message'] = '';
        
        $business_profile_array = $this->business_profile_library->get_all_business_profile_list()->result_array();
        

        $len = count($business_profile_array);
        for($i=0;$i<$len;$i++)
        {
            
            $connection = $this->business_profile_library->get_business_profile_connection_list($business_profile_array[$i]['id']);            
            
            if(count($connection)>0)
            {
                $connection = $connection[0];
                $business_profile_array[$i]['total'] = $connection['connected_user_list'];
                $business_profile_array[$i]['male'] = $connection['male'];
                $business_profile_array[$i]['female'] = $connection['female'];
            }else{
                $business_profile_array[$i]['total'] = 0;
                $business_profile_array[$i]['male'] = 0;
                $business_profile_array[$i]['female'] = 0;
            }
        }
        
        $this->data['business_profile'] = $business_profile_array;
        
        $this->template->load(null, "admin/business_profiles/business_profiles", $this->data);
    }
    
    function visitors()
    {
        $this->data['message'] = '';
        $visited_page = $this->visitors->get_most_visited_pages(10);
        $this->data['visited_page'] = $visited_page;
        
        $this->template->load(null, "admin/visitors/page", $this->data);
    }
    
    function visitors_page()
    {
        $this->data['message'] = '';
        $visited_page = $this->visitors->get_most_visited_pages(10);
        $this->data['visited_page'] = $visited_page;
        $this->template->load(null, "admin/visitors/page", $this->data);
    }
    
    function visitors_application()
    {
        $this->data['message'] = '';
        $visited_application = $this->visitors->get_most_visited_applications(10);
        $this->data['application_list'] = $visited_application;
        $this->template->load(null, "admin/visitors/application", $this->data);
    }
    
    function visitors_business_profile()
    {
        $this->data['message'] = '';
        $visited_application = $this->visitors->get_most_visited_business_profiles(10);
        $this->data['business_list'] = $visited_application;
        $this->template->load(null, "admin/visitors/business_profile", $this->data);
    }
    
    function log()
    {
        
        $this->data['message'] = '';
        
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
        
        if($length>0)
        {
            $total_time = $total_time/$length;
        }
        
        $this->data['hour'] = round($total_time/3600);
        $total_time = $total_time%3600;
        $this->data['minute'] = round($total_time/60);
        
        
        $this->template->load(null, "admin/log/log", $this->data);
    }
    
}
?>
