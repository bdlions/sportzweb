<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gympro extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('org/application/gympro_library');
        $this->load->helper('language');
        $this->load->helper('url');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        //$this->data['message'] = '';        
        //$this->template->load(null,'applications/gympro/index', $this->data);
        $user_id = $this->session->userdata('user_id');
        $gympro_user_info = array();
        $gympro_user_info_array = $this->gympro_library->get_gympro_user_info($user_id)->result_array();
        if(!empty($gympro_user_info_array))
        {
            $gympro_user_info = $gympro_user_info_array[0];
            if(!isset($gympro_user_info['account_type_id']) || $gympro_user_info['account_type_id'] < 0)
            {
                $this->account($gympro_user_info['user_id']);
            }
            else if(!isset($gympro_user_info['height_unit_id']) || $gympro_user_info['height_unit_id'] < 0)
            {
                $this->preference($gympro_user_info['user_id']);
            }
            else
            {
                $this->manage_clients();
            }            
        }
        else
        {
            $data = array(
                'user_id' => $user_id,
                'account_type_id' => APP_GYMPRO_ACCOUNT_TYPE_ID_LIGHTWEIGHT
            );
            $gympro_user_id = $this->gympro_library->create_gympro_user($data);
            if($gympro_user_id !== FALSE)
            {
                $this->account($user_id);
            }
        }
    }
    //----------------------------------- Client Module --------------------------------//
    public function manage_clients()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/client/clients', $this->data);
        
    }
    
    public function create_client()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/client/create_client', $this->data);
    }
    //----------------------------------- Group Module ---------------------------------//
    public function manage_groups()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/groups', $this->data);
        
    }
    
    //-----------------------------------Account Type Module-------------------------------//
    /*
     * This method will load account info of a client
     * @Author Nazmul on 17th November 2014
     */
    public function account($user_id = 0)
    {        
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['message'] = '';   
        $this->data['application_id'] = 1;        
        if($this->input->post('submit_update_account'))
        {
            $data = array(
                'account_type_id' => $this->input->post('account_type_list')
            );
            $status = $this->gympro_library->update_gympro_user_info($user_id, $data);
            if($status)
            {
                $this->data['message'] = $this->gympro_library->messages();   
            }
            else
            {
                $this->data['message'] = $this->gympro_library->errors();  
            }
        }
        $account_type_list = array();
        $account_types_array = $this->gympro_library->get_all_account_types()->result_array();
        foreach($account_types_array as $account_type)
        {
            $account_type_list[$account_type['account_type_id']] =  $account_type['title'];
        }
        $this->data['account_type_list'] = $account_type_list;  
        $this->data['selected_account_type'] = APP_GYMPRO_ACCOUNT_TYPE_ID_LIGHTWEIGHT;
        $gympro_user_info = array();
        $gympro_user_info_array = $this->gympro_library->get_gympro_user_info($user_id)->result_array();
        if(!empty($gympro_user_info_array))
        {
            $gympro_user_info = $gympro_user_info_array[0];
            $this->data['selected_account_type'] = $gympro_user_info['account_type_id'];
        }
        $this->data['user_id'] = $user_id; 
        
        $this->data['submit_update_account'] = array(
            'name' => 'submit_update_account',
            'id' => 'submit_update_account',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null,'applications/gympro/account', $this->data);
    }
    //----------------------------------- Preference Module ---------------------------------//
    /*
     * This method will load preference info of a client
     * @Author Nazmul on 17th November 2014
     */
    public function preference($user_id = 0)
    {
        $this->data['application_id'] = 1; 
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['message'] = ''; 
        if($this->input->post('submit_update_preference'))
        {
            $data = array(
                'height_unit_id' => $this->input->post('height_unit_list'),
                'weight_unit_id' => $this->input->post('weight_unit_list'),
                'girth_unit_id' => $this->input->post('girth_unit_list'),
                'time_zone_id' => $this->input->post('time_zone_list'),
                'hourly_rate_id' => $this->input->post('hourly_rate_list'),
                'currency_id' => $this->input->post('currency_list')
            );
            $status = $this->gympro_library->update_gympro_user_info($user_id, $data);
            if($status)
            {
                $this->data['message'] = $this->gympro_library->messages();   
            }
            else
            {
                $this->data['message'] = $this->gympro_library->errors();  
            }
        }
        $height_unit_list = array();
        $height_unit_array = $this->gympro_library->get_all_height_units()->result_array();
        foreach($height_unit_array as $height_unit)
        {
            $height_unit_list[$height_unit['height_unit_id']] =  $height_unit['title'];
        }
        $this->data['height_unit_list'] =$height_unit_list; 
        
        $weight_unit_list = array();
        $weight_unit_array = $this->gympro_library->get_all_weight_units()->result_array();
        foreach($weight_unit_array as $weight_unit)
        {
            $weight_unit_list[$weight_unit['weight_unit_id']] =  $weight_unit['title'];
        }
        $this->data['weight_unit_list'] =$weight_unit_list;
        
        $girth_unit_list = array();
        $girth_unit_array = $this->gympro_library->get_all_girth_units()->result_array();
        foreach($girth_unit_array as $girth_unit)
        {
            $girth_unit_list[$girth_unit['girth_unit_id']] =  $girth_unit['title'];
        }
        $this->data['girth_unit_list'] =$girth_unit_list;
        
        //$this->data['time_zone_list'] = array(); 
        $time_zone_list = array();
        $time_zone_array = $this->gympro_library->get_all_time_zones()->result_array();
        foreach($time_zone_array as $time_zone)
        {
            $time_zone_list[$time_zone['time_zone_id']] =  $time_zone['title'];
        }
        $this->data['time_zone_list'] =$time_zone_list;
        
        $hourly_rate_list = array();
        $hourly_rate_array = $this->gympro_library->get_all_hourly_rates()->result_array();
        foreach($hourly_rate_array as $hourly_rate)
        {
            $hourly_rate_list[$hourly_rate['hourly_rate_id']] =  $hourly_rate['title'];
        }
        $this->data['hourly_rate_list'] =$hourly_rate_list;
        
        $currency_list = array();
        $currency_array = $this->gympro_library->get_all_hourly_currencies()->result_array();
        foreach($currency_array as $currency)
        {
            $currency_list[$currency['currency_id']] =  $currency['title'];
        }
        $this->data['currency_list'] =$currency_list;
        
        $this->data['selected_height_unit_id'] = '';
        $this->data['selected_weight_unit_id'] = '';
        $this->data['selected_girth_unit_id'] = '';
        $this->data['selected_time_zone_id'] = '';
        $this->data['selected_hourly_rate_id'] = '';
        $this->data['selected_currency_id'] = '';
        $gympro_user_info = array();
        $gympro_user_info_array = $this->gympro_library->get_gympro_user_info($user_id)->result_array();
        if(!empty($gympro_user_info_array))
        {
            $gympro_user_info = $gympro_user_info_array[0];
            $this->data['selected_height_unit_id'] = $gympro_user_info['height_unit_id'];
            $this->data['selected_weight_unit_id'] = $gympro_user_info['weight_unit_id'];
            $this->data['selected_girth_unit_id'] = $gympro_user_info['girth_unit_id'];
            $this->data['selected_time_zone_id'] = $gympro_user_info['time_zone_id'];
            $this->data['selected_hourly_rate_id'] = $gympro_user_info['hourly_rate_id'];
            $this->data['selected_currency_id'] = $gympro_user_info['currency_id'];
        }
        
        $this->data['user_id'] = $user_id; 
        $this->data['submit_update_preference'] = array(
            'name' => 'submit_update_preference',
            'id' => 'submit_update_preference',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null,'applications/gympro/preference', $this->data);
    }
    //---------------------------------------Program Module---------------------------------------//
    public function programs()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/programs', $this->data);
    }
    public function create_program()
    {
        $this->data['message'] = '';       
        $this->template->load(null,'applications/gympro/program_create', $this->data);
    }
    public function exercises()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/exercises', $this->data);
    }
    public function create_exercise()
    {
        $this->data['message'] = '';       
        $this->template->load(null,'applications/gympro/exercise_create', $this->data);
    }
    //----------------------------------------Assessment Module------------------------------------//
    public function assessments()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/assessments', $this->data);
    }
    public function create_assessment()
    {
        $this->data['message'] = '';       
        $this->template->load(null,'applications/gympro/assessment_create', $this->data);
    }
    //-----------------------------------------Nutrition Module------------------------------------//
    public function nutrition()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/nutrition', $this->data);
    }
    public function create_nutrition()
    {
        $meal_time_list = array();
        $meal_time_array = $this->gympro_library->get_all_meal_times()->result_array();
        foreach($meal_time_array as $meal_time)
        {
            $meal_time_list[$meal_time['meal_time_id']] =  $meal_time['title'];
        }
        $this->data['meal_time_list'] =$meal_time_list;
        
        $workout_list = array();
        $workout_array = $this->gympro_library->get_all_workouts()->result_array();
        foreach($workout_array as $workout)
        {
            $workout_list[$workout['workout_id']] =  $workout['title'];
        }
        $this->data['workout_list'] =$workout_list;
        
        $this->template->load(null,'applications/gympro/nutrition_create', $this->data);
    }
    
    //-----------------------------------------Mission Module------------------------------------//
    public function missions()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/missions', $this->data);
    }
    public function create_mission()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/mission_create', $this->data);
    }
}

