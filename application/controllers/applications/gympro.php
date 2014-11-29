<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gympro extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('form_validation');
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
        $client_list = $this->gympro_library->get_all_clients($this->session->userdata('user_id'))->result_array();
        $this->data['client_list'] = $client_list;
        $this->data['message'] = '';        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/client/clients', $this->data);
    }
    
    public function create_client()
    {
        $this->data['message'] = ''; 
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        if ($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
//                    'gender_id' => $this->input->post('gender_id'),
                    'email' => $this->input->post('email'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'birth_date' => $this->input->post('birth_date'),
                    'status_id' => $this->input->post('status_id'),
                    'occupation' => $this->input->post('occupation'),
                    'company_name' => $this->input->post('company_name'),
                    'picture' => $this->input->post('picture'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'address' => $this->input->post('address'),
                    'emergyncy_contact' => $this->input->post('emergyncy_contact'),
                    'emergyncy_phone' => $this->input->post('emergyncy_phone'),
                    'qestion_list' => $this->input->post('qestion_list'),
                    'height' => $this->input->post('height'),
                    'reseting_heart_rate' => $this->input->post('reseting_heart_rate'),
                    'blood_pressure' => $this->input->post('blood_pressure'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $this->session->userdata('user_id')
                );
                $client_create_id = $this->gympro_library->create_client($data);
                if ($client_create_id !== FALSE) {
                    $this->data['message'] = "Client is created successfully.";
                    redirect('applications/gympro/create_client','refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
//        CLIENT INFO
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text'
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text'
        );
        $this->data['gender_id'] = array(
            'name' => 'gender_id',
            'id' => 'gender_id',
            'type' => 'text'
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text'
        );
        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text'
        );
        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text'
        );
        $this->data['birth_date'] = array(
            'name' => 'birth_date',
            'id' => 'birth_date',
            'type' => 'text'
        );
        $this->data['status_id'] = array(
            'name' => 'status_id',
            'id' => 'status_id',
            'type' => 'text'
        );
        $this->data['occupation'] = array(
            'name' => 'occupation',
            'id' => 'occupation',
            'type' => 'text'
        );
        $this->data['company_name'] = array(
            'name' => 'company_name',
            'id' => 'company_name',
            'type' => 'text'
        );
        $this->data['picture'] = array(
            'name' => 'picture',
            'id' => 'picture',
            'type' => 'file'
        );
        
//        CONTACT DETAILS
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text'
        );
        $this->data['mobile'] = array(
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'text'
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text'
        );
        $this->data['emergency_contact'] = array(
            'name' => 'emergency_contact',
            'id' => 'emergency_contact',
            'type' => 'text'
        );
        $this->data['emergency_phone'] = array(
            'name' => 'emergency_phone',
            'id' => 'emergency_phone',
            'type' => 'text'
        );
        
//        HEALTH Q
        $this->data['smoker_txt'] = array(
            'name' => 'smoker_txt',
            'id' => 'smoker_txt',
            'type' => 'text'
        );
        $this->data['cardiov_txt'] = array(
            'name' => 'cardiov_txt',
            'id' => 'cardiov_txt',
            'type' => 'text'
        );
        $this->data['injury_txt'] = array(
            'name' => 'injury_txt',
            'id' => 'injury_txt',
            'type' => 'text'
        );
        $this->data['medication_txt'] = array(
            'name' => 'medication_txt',
            'id' => 'medication_txt',
            'type' => 'text'
        );
        $this->data['medicalcondition_txt'] = array(
            'name' => 'medicalcondition_txt',
            'id' => 'medicalcondition_txt',
            'type' => 'text'
        );
        $this->data['height'] = array(
            'name' => 'height',
            'id' => 'height',
            'type' => 'text'
        );
        $this->data['reseting_heart_rate'] = array(
            'name' => 'reseting_heart_rate',
            'id' => 'reseting_heart_rate',
            'type' => 'text'
        );
        $this->data['blood_pressure'] = array(
            'name' => 'blood_pressure',
            'id' => 'blood_pressure',
            'type' => 'text'
        );
        
        
//        NOTES
        $this->data['notes'] = array(
            'name' => 'notes',
            'id' => 'notes',
            'type' => 'text'
        );
        
        
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Create Client'
        );
        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->data['question_list'] = $this->gympro_library->get_all_health_questions()->result_array();;
        $this->template->load(null,'applications/gympro/client/create_client', $this->data);
    }
    public function update_client($client_id = 1)
    {
        $client_list = $this->gympro_library->get_all_clients($this->session->userdata('user_id'))->result_array();
        $client = $client_list[$client_id-1];
        $this->data['message'] = ''; 
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        if ($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
//                    'gender_id' => $this->input->post('gender_id'),
                    'email' => $this->input->post('email'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'birth_date' => $this->input->post('birth_date'),
                    'status_id' => $this->input->post('status_id'),
                    'occupation' => $this->input->post('occupation'),
                    'company_name' => $this->input->post('company_name'),
                    'picture' => $this->input->post('picture'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'address' => $this->input->post('address'),
                    'emergyncy_contact' => $this->input->post('emergyncy_contact'),
                    'emergyncy_phone' => $this->input->post('emergyncy_phone'),
                    'qestion_list' => $this->input->post('qestion_list'),
                    'height' => $this->input->post('height'),
                    'reseting_heart_rate' => $this->input->post('reseting_heart_rate'),
                    'blood_pressure' => $this->input->post('blood_pressure'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $this->session->userdata('user_id')
                );
                $client_create_id = $this->gympro_library->update_client($data);
                if ($client_create_id !== FALSE) {
                    $this->data['message'] = "Client is created successfully.";
                    redirect('applications/gympro/create_client','refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
//        CLIENT INFO
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $client['first_name']
            
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $client['last_name']
        );
        $this->data['gender_id'] = array(
            'name' => 'gender_id',
            'id' => 'gender_id',
            'type' => 'text',
            'value' => $client['gender_id']
        );
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $client['email']
        );
        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text',
            'value' => $client['start_date']
        );
        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text',
            'value' => $client['end_date']
        );
        $this->data['birth_date'] = array(
            'name' => 'birth_date',
            'id' => 'birth_date',
            'type' => 'text',
            'value' => $client['birth_date']
        );
        $this->data['status_id'] = array(
            'name' => 'status_id',
            'id' => 'status_id',
            'type' => 'text',
            'value' => $client['status_id']
        );
        $this->data['occupation'] = array(
            'name' => 'occupation',
            'id' => 'occupation',
            'type' => 'text',
            'value' => $client['occupation']
        );
        $this->data['company_name'] = array(
            'name' => 'company_name',
            'id' => 'company_name',
            'type' => 'text',
            'value' => $client['company_name']
        );
        $this->data['picture'] = array(
            'name' => 'picture',
            'id' => 'picture',
            'type' => 'file',
            'value' => $client['picture']
        );
        
//        CONTACT DETAILS
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $client['phone']
        );
        $this->data['mobile'] = array(
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'text',
            'value' => $client['mobile']
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text',
            'value' => $client['address']
        );
        $this->data['emergency_contact'] = array(
            'name' => 'emergency_contact',
            'id' => 'emergency_contact',
            'type' => 'text',
//            'value' => $client['emergency_contact']
        );
        $this->data['emergency_phone'] = array(
            'name' => 'emergency_phone',
            'id' => 'emergency_phone',
            'type' => 'text',
//            'value' => $client['emergency_phone']
        );
        
//        HEALTH Q
        $this->data['smoker_txt'] = array(
            'name' => 'smoker_txt',
            'id' => 'smoker_txt',
            'type' => 'text',
//            'value' => $client['smoker_txt']
        );
        $this->data['cardiov_txt'] = array(
            'name' => 'cardiov_txt',
            'id' => 'cardiov_txt',
            'type' => 'text',
//            'value' => $client['cardiov_txt']
        );
        $this->data['injury_txt'] = array(
            'name' => 'injury_txt',
            'id' => 'injury_txt',
            'type' => 'text',
//            'value' => $client['injury_txt']
        );
        $this->data['medication_txt'] = array(
            'name' => 'medication_txt',
            'id' => 'medication_txt',
            'type' => 'text',
//            'value' => $client['medication_txt']
        );
        $this->data['medicalcondition_txt'] = array(
            'name' => 'medicalcondition_txt',
            'id' => 'medicalcondition_txt',
            'type' => 'text',
//            'value' => $client['medicalcondition_txt']
        );
        $this->data['height'] = array(
            'name' => 'height',
            'id' => 'height',
            'type' => 'text',
            'value' => $client['height']
        );
        $this->data['reseting_heart_rate'] = array(
            'name' => 'reseting_heart_rate',
            'id' => 'reseting_heart_rate',
            'type' => 'text',
            'value' => $client['reseting_heart_rate']
        );
        $this->data['blood_pressure'] = array(
            'name' => 'blood_pressure',
            'id' => 'blood_pressure',
            'type' => 'text',
            'value' => $client['blood_pressure']
        );
        
        
//        NOTES
        $this->data['notes'] = array(
            'name' => 'notes',
            'id' => 'notes',
            'type' => 'text',
            'value' => $client['notes']
        );
        
        
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Create Client'
        );
        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->data['question_list'] = $this->gympro_library->get_all_health_questions()->result_array();
        $this->template->load(null,'applications/gympro/client/edit_client', $this->data);
    }
    //----------------------------------- Group Module ---------------------------------//
    public function manage_groups()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/groups', $this->data);
    }
    public function create_group()
    {
        $this->data['message'] = '';
//        $this->form_validation->set_rules('title', 'First Name', 'xss_clean|required');
//        $this->form_validation->set_rules('phone', 'First Name', 'xss_clean|required');
//        $this->form_validation->set_rules('mobile', 'First Name', 'xss_clean|required');
//        $this->form_validation->set_rules('notes', 'First Name', 'xss_clean|required');
        
        if ($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $data = array(
                    'title' => $this->input->post('title'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'notes' => $this->input->post('notes')
                );
                $create_id = $this->gympro_library->create_client_group($data);
                if ($create_id !== FALSE) {
                    $this->data['message'] = "Client group is created successfully.";
                    redirect('applications/gympro/create_group','refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text'
        );
        $this->data['mobile'] = array(
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'text'
        );
        $this->data['notes'] = array(
            'name' => 'notes',
            'id' => 'notes',
            'type' => 'text'
        );
        
        
        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->template->load(null,'applications/gympro/group_create', $this->data);
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID; 
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/missions', $this->data);
    }
    public function create_mission()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/mission_create', $this->data);
    }
    
    
    //-----------------------------------------Earnings Module------------------------------------//
    public function earnings()
    {
        $this->data['message'] = '';        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/earnings', $this->data);
    }
    public function create_session()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/earning_create', $this->data);
    }
}

