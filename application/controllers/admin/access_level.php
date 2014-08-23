<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Access_level extends CI_Controller{
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation'); 
        $this->load->library('org/admin/access_level/admin_access_level_library');  
        $this->load->helper('url'); 

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

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
        if (!in_array(ADMIN, $this->user_group_array)) {
            redirect('admin/auth/login', 'refresh');
        }
    }

    function index()
    {
        if($this->input->post('submit_create_user'))
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $group_id[] = $this->input->post('user_type_list');
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );
            $user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group_id);
            if ($user_id !== FALSE) {
                $form_post_array = $this->input->post();
                $access_level_mapping = $this->access_level_input_process($form_post_array);
                
                $this->admin_access_level_library->store_access_level_info($user_id, $access_level_mapping);
                //$this->session->set_flashdata('message', $this->ion_auth->messages());
                $update_data = array(
                    'account_status_id' => 1
                );
                //activating the created user
                $this->ion_auth->update($user_id, $update_data);
                redirect('admin/access_level/show_users','refresh');
            } 
            else {
                $this->session->set_flashdata('message', "Unsuccessful to register a user.");
            }
            redirect('admin/access_level','refresh');
        }
        $this->data['user_type_list'][ACCESS_LEVEL_PUBLISHER_ID] = 'Publisher';
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'value' => ''
        );
        
        $this->data = array_merge($this->data, $this->get_access_level_items());
        
        $this->data['submit_create_user'] = array(
            'name' => 'submit_create_user',
            'id' => 'submit_create_user',
            'type' => 'submit',
            'value' => 'Create User',
        );
        $user_info = array();
        $user_info_array = $this->admin_access_level_library->get_user_info()->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
        }
        $this->data['user_info'] = $user_info;
        $this->data['message'] = $this->session->flashdata('message');
        $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/access_level/index", $this->data);
    }
    
    public function get_access_level_items($access_level_mapping = array())
    {
        $accesss_map = $this->get_access_map();
        $result['overview_view'] = array(
            'name' => $accesss_map['overview_view_map_id'],
            'id' => $accesss_map['overview_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_view_map_id'], $access_level_mapping))
        {
            $result['overview_view']['checked'] = 'checked';
        }
        
        $result['overview_access'] = array(
            'name' => $accesss_map['overview_access_map_id'],
            'id' => $accesss_map['overview_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['overview_access_map_id'], $access_level_mapping))
        {
            $result['overview_access']['checked'] = 'checked';
        }
        
        $result['user_overview_view'] = array(
            'name' => $accesss_map['user_overview_view_map_id'],
            'id' => $accesss_map['user_overview_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_view_map_id'], $access_level_mapping))
        {
            $result['user_overview_view']['checked'] = 'checked';
        }
        
        $result['user_overview_access'] = array(
            'name' => $accesss_map['user_overview_access_map_id'],
            'id' => $accesss_map['user_overview_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_overview_access_map_id'], $access_level_mapping))
        {
            $result['user_overview_access']['checked'] = 'checked';
        }
        
        $result['user_manage_view'] = array(
            'name' => $accesss_map['user_manage_view_map_id'],
            'id' => $accesss_map['user_manage_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_view_map_id'], $access_level_mapping))
        {
            $result['user_manage_view']['checked'] = 'checked';
        }
        
        $result['user_manage_access'] = array(
            'name' => $accesss_map['user_manage_access_map_id'],
            'id' => $accesss_map['user_manage_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['user_manage_access_map_id'], $access_level_mapping))
        {
            $result['user_manage_access']['checked'] = 'checked';
        }
        
        //xstream_banter checkbox
        $result['xstream_banter_view'] = array(
            'name' => $accesss_map['xstream_banter_view_map_id'],
            'id' => $accesss_map['xstream_banter_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_view_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_view']['checked'] = 'checked';
        }
        
        $result['xstream_banter_access'] = array(
            'name' => $accesss_map['xstream_banter_access_map_id'],
            'id' => $accesss_map['xstream_banter_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['xstream_banter_access_map_id'], $access_level_mapping))
        {
            $result['xstream_banter_access']['checked'] = 'checked';
        }
        
        //Healthy Recipe checkbox
        $result['healthy_recipes_view'] = array(
            'name' => $accesss_map['healthy_recipes_view_map_id'],
            'id' => $accesss_map['healthy_recipes_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_view_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_view']['checked'] = 'checked';
        }
        
        $result['healthy_recipes_access'] = array(
            'name' => $accesss_map['healthy_recipes_access_map_id'],
            'id' => $accesss_map['healthy_recipes_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['healthy_recipes_access_map_id'], $access_level_mapping))
        {
            $result['healthy_recipes_access']['checked'] = 'checked';
        }
        
        //Service Directory checkbox
        $result['service_directory_view'] = array(
            'name' => $accesss_map['service_directory_view_map_id'],
            'id' => $accesss_map['service_directory_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_view_map_id'], $access_level_mapping))
        {
            $result['service_directory_view']['checked'] = 'checked';
        }
        
        $result['service_directory_access'] = array(
            'name' => $accesss_map['service_directory_access_map_id'],
            'id' => $accesss_map['service_directory_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['service_directory_access_map_id'], $access_level_mapping))
        {
            $result['service_directory_access']['checked'] = 'checked';
        }
        
        //News checkbox
        $result['news_view'] = array(
            'name' => $accesss_map['news_view_map_id'],
            'id' => $accesss_map['news_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_view_map_id'], $access_level_mapping))
        {
            $result['news_view']['checked'] = 'checked';
        }
        
        $result['news_access'] = array(
            'name' => $accesss_map['news_access_map_id'],
            'id' => $accesss_map['news_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['news_access_map_id'], $access_level_mapping))
        {
            $result['news_access']['checked'] = 'checked';
        }
        
        //Blogs checkbox
        $result['blogs_view'] = array(
            'name' => $accesss_map['blogs_view_map_id'],
            'id' => $accesss_map['blogs_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_view_map_id'], $access_level_mapping))
        {
            $result['blogs_view']['checked'] = 'checked';
        }
        
        $result['blogs_access'] = array(
            'name' => $accesss_map['blogs_access_map_id'],
            'id' => $accesss_map['blogs_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['blogs_access_map_id'], $access_level_mapping))
        {
            $result['blogs_access']['checked'] = 'checked';
        }
        
        //BMI calculator checkbox
        $result['bmi_calculator_view'] = array(
            'name' => $accesss_map['bmi_calculator_view_map_id'],
            'id' => $accesss_map['bmi_calculator_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_view_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_view']['checked'] = 'checked';
        }
        
        $result['bmi_calculator_access'] = array(
            'name' => $accesss_map['bmi_calculator_access_map_id'],
            'id' => $accesss_map['bmi_calculator_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['bmi_calculator_access_map_id'], $access_level_mapping))
        {
            $result['bmi_calculator_access']['checked'] = 'checked';
        }
        
        //Photography checkbox
        $result['photography_view'] = array(
            'name' => $accesss_map['photography_view_map_id'],
            'id' => $accesss_map['photography_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_view_map_id'], $access_level_mapping))
        {
            $result['photography_view']['checked'] = 'checked';
        }
        
        $result['photography_access'] = array(
            'name' => $accesss_map['photography_access_map_id'],
            'id' => $accesss_map['photography_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['photography_access_map_id'], $access_level_mapping))
        {
            $result['photography_access']['checked'] = 'checked';
        }
        
        //Business Profile checkbox
        $result['business_profile_view'] = array(
            'name' => $accesss_map['business_profile_view_map_id'],
            'id' => $accesss_map['business_profile_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_view_map_id'], $access_level_mapping))
        {
            $result['business_profile_view']['checked'] = 'checked';
        }
        
        $result['business_profile_access'] = array(
            'name' => $accesss_map['business_profile_access_map_id'],
            'id' => $accesss_map['business_profile_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['business_profile_access_map_id'], $access_level_mapping))
        {
            $result['business_profile_access']['checked'] = 'checked';
        }
        
        //visitor pages checkbox
        $result['visitor_page_view'] = array(
            'name' => $accesss_map['visitor_page_view_map_id'],
            'id' => $accesss_map['visitor_page_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_view_map_id'], $access_level_mapping))
        {
            $result['visitor_page_view']['checked'] = 'checked';
        }
        
        $result['visitor_page_access'] = array(
            'name' => $accesss_map['visitor_page_access_map_id'],
            'id' => $accesss_map['visitor_page_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_page_access_map_id'], $access_level_mapping))
        {
            $result['visitor_page_access']['checked'] = 'checked';
        }
        
        //visitor Applications checkbox
        $result['visitor_applications_view'] = array(
            'name' => $accesss_map['visitor_applications_view_map_id'],
            'id' => $accesss_map['visitor_applications_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_view_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_view']['checked'] = 'checked';
        }
        
        $result['visitor_applications_access'] = array(
            'name' => $accesss_map['visitor_applications_access_map_id'],
            'id' => $accesss_map['visitor_applications_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_applications_access_map_id'], $access_level_mapping))
        {
            $result['visitor_applications_access']['checked'] = 'checked';
        }
        
        
        
        //visitor business_profile checkbox
        $result['visitor_busines_profile_view'] = array(
            'name' => $accesss_map['visitor_business_profile_view_map_id'],
            'id' => $accesss_map['visitor_business_profile_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_view_map_id'], $access_level_mapping))
        {
            $result['visitor_busines_profile_view']['checked'] = 'checked';
        }
        
        $result['visitor_business_profile_access'] = array(
            'name' => $accesss_map['visitor_business_profile_access_map_id'],
            'id' => $accesss_map['visitor_business_profile_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['visitor_business_profile_access_map_id'], $access_level_mapping))
        {
            $result['visitor_business_profile_access']['checked'] = 'checked';
        }
        
        //visitor Applications checkbox
        $result['log_view'] = array(
            'name' => $accesss_map['log_view_map_id'],
            'id' => $accesss_map['log_view_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_view_map_id'], $access_level_mapping))
        {
            $result['log_view']['checked'] = 'checked';
        }
        
        $result['log_access'] = array(
            'name' => $accesss_map['log_access_map_id'],
            'id' => $accesss_map['log_access_map_id'],
            'type' => 'checkbox'
        );
        if(array_key_exists($accesss_map['log_access_map_id'], $access_level_mapping))
        {
            $result['log_access']['checked'] = 'checked';
        }
        return $result;
    }
    
    public function get_access_map()
    {
        $accesss_map = array();
        $accesss_map['overview_view_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['overview_access_map_id'] = ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['user_overview_view_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['user_overview_access_map_id'] = ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['user_manage_view_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['user_manage_access_map_id'] = ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['xstream_banter_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['xstream_banter_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['healthy_recipes_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['healthy_recipes_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['service_directory_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['service_directory_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['news_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['news_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['blogs_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['blogs_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['bmi_calculator_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['bmi_calculator_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['photography_view_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['photography_access_map_id'] = ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['business_profile_view_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['business_profile_access_map_id'] = ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['visitor_page_view_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['visitor_page_access_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['visitor_applications_view_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['visitor_applications_access_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['visitor_business_profile_view_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['visitor_business_profile_access_map_id'] = ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;
        
        $accesss_map['log_view_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW;
        $accesss_map['log_access_map_id'] = ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS;   
        
        return $accesss_map;
    }
    
    public function access_level_input_process($form_post_array)
    {
        $accesss_map = $this->get_access_map();
        $access_level_mapping = array();
        if(array_key_exists($accesss_map['overview_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['overview_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['overview_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['user_overview_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_overview_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_overview_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_overview_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['user_manage_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_manage_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['user_manage_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['user_manage_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['xstream_banter_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['xstream_banter_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['xstream_banter_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['xstream_banter_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['healthy_recipes_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['healthy_recipes_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['healthy_recipes_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['healthy_recipes_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['service_directory_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['service_directory_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['service_directory_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['service_directory_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['news_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['news_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['news_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['news_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['blogs_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['blogs_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['blogs_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['blogs_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['bmi_calculator_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['bmi_calculator_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['bmi_calculator_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['bmi_calculator_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['photography_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['photography_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['photography_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['photography_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['business_profile_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['business_profile_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['business_profile_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['business_profile_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['visitor_page_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_page_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_page_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_page_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_applications_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_applications_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_applications_access_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_business_profile_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['visitor_business_profile_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['visitor_business_profile_access_map_id']] = 1;
        }
        
        if(array_key_exists($accesss_map['log_view_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['log_view_map_id']] = 1;
        }
        if(array_key_exists($accesss_map['log_access_map_id'], $form_post_array))
        {
            $access_level_mapping[$accesss_map['log_access_map_id']] = 1;
        }
        return $access_level_mapping;
    }
    
    public function show_users()
    {
        $this->data['message'] = $this->session->flashdata('message');
        
        $this->data['user_list'] = $this->admin_access_level_library->get_all_users_groups(array(ACCESS_LEVEL_PUBLISHER_ID))->result_array();
        
        $user_info = array();
        $user_info_array = $this->admin_access_level_library->get_user_info()->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
        }
        $this->data['user_info'] = $user_info;
        $this->data['title'] = ADMIN_TITLE;
        $this->data['message'] = $this->session->flashdata('message');
        $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/access_level/users", $this->data);
    }
    
    public function edit_user($user_id)
    {
        if($this->input->post('submit_update_user'))
        {
            $user_info_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );
            //update user info
            $form_post_array = $this->input->post();
            $access_level_mapping = $this->access_level_input_process($form_post_array);
            $this->admin_access_level_library->store_access_level_info($user_id, $access_level_mapping, $user_info_data);
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('admin/access_level/show_users','refresh');
        }
        $access_level_mapping = $this->admin_access_level_library->get_access_level_info($user_id);
        $user_info = array();
        $user_info_array = $this->admin_access_level_library->get_user_info($user_id)->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
        }
        
        $this->data['user_type_list'][ACCESS_LEVEL_PUBLISHER_ID] = 'Publisher';
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $user_info['first_name']
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $user_info['last_name']
        );
        
        $this->data = array_merge($this->data, $this->get_access_level_items($access_level_mapping));
        
        $this->data['submit_update_user'] = array(
            'name' => 'submit_update_user',
            'id' => 'submit_update_user',
            'type' => 'submit',
            'value' => 'Edit User',
        );
        $current_user_info = array();
        $current_user_info_array = $this->admin_access_level_library->get_user_info()->result_array();
        if(!empty($current_user_info_array))
        {
            $current_user_info = $current_user_info_array[0];
        }
        $this->data['current_user_info'] = $current_user_info;
        $this->data['user_id'] = $user_id;
        $this->data['message'] = $this->session->flashdata('message');
        $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/access_level/edit_user", $this->data);
    }
    
    public function delete_user($user_id)
    {
        $this->admin_access_level_library->delete_user($user_id);
        redirect('admin/access_level/show_users','refresh');
    }
}