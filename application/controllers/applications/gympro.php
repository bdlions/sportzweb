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
        $this->manage_clients();
        
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
    
    public function nutrition()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/nutrition', $this->data);
    }
    
    public function program()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/program', $this->data);
    }
    
    public function missions()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = 1;        
        $this->template->load(null,'applications/gympro/missions', $this->data);
    }
    //-----------------------------------Account Type Module-------------------------------//
    /*
     * This method will load account info of a client
     * @Author Nazmul on 17th November 2014
     */
    public function account($gympro_user_id = 0)
    {        
        $this->data['message'] = '';   
        $this->data['application_id'] = 1;        
        if($this->input->post('submit_update_account'))
        {
            return;
        }
        $account_type_list = array();
        $account_types_array = $this->gympro_library->get_all_account_types()->result_array();
        foreach($account_types_array as $account_type)
        {
            $account_type_list[$account_type['account_type_id']] =  $account_type['title'];
        }
        $this->data['account_type_list'] = $account_type_list;  
        $this->data['gympro_user_id'] = $gympro_user_id; 
        
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
    public function preference($gympro_user_id = 0)
    {
        $this->data['message'] = '';    
        $this->data['application_id'] = 1;
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
        
        $this->data['time_zone_list'] = array(); 
        
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
        
        $this->data['gympro_user_id'] = $gympro_user_id; 
        $this->data['submit_update_preference'] = array(
            'name' => 'submit_update_preference',
            'id' => 'submit_update_preference',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null,'applications/gympro/preference', $this->data);
    }
}

