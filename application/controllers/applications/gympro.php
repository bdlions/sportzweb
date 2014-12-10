<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gympro extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('form_validation');
        $this->load->library('org/application/gympro_library');
        $this->load->library('org/utility/Utils');
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
    
//    public function image_upload($file_info) {
//        $data = null;
//        if (isset($file_info)) {
//            $config['image_library'] = 'gd2';
//            $config['upload_path'] = CLIENT_PROFILE_PIC_IMAGEPATH;
//            $config['allowed_types'] = 'gif|jpg|png|jpeg';
//            $config['max_size'] = '10240';
//            $config['maintain_ratio'] = FALSE;
//            $config['width'] = 120;
//            $config['height'] = 120;
//            $config['create_thumb'] = TRUE;
//
//            $this->load->library('upload', $config);
//
//            if (!$this->upload->do_upload()) {
//                $error = array('error' => $this->upload->display_errors());
//                return $data = $error;
//            } else {
//                $upload_data = $this->upload->data();
//                $data = array('upload_data' => $upload_data);
//                return $data;
//            }
//        }
//        return $data;
//    }

    public function create_client()
    {
        //CHECK IF THE CLIENT CREATE LIMIT HAS EXCEED
        
        
        $this->data['message'] = '';
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        
        $question_list = $this->gympro_library->get_all_health_questions()->result_array();
        $this->data['question_list'] = $question_list;
        $question_list_length = count($question_list);        
        $answer_list = array();
        
        if ($this->input->post())
        {
            $result = array();
            $result['message'] = '';
            $picture = "";
            if (isset($_FILES["userfile"]))
            {
                $result = $this->utils->upload_image($_FILES["userfile"], CLIENT_PROFILE_PIC_IMAGEPATH);
                if($result['status'] == 1)
                {
//                    RESIZE IMAGE
                    $source_path = CLIENT_PROFILE_PIC_IMAGEPATH.$result['upload_data']['file_name'];
                    $destination_path = CLIENT_PROFILE_PICTURE_PATH_W50_H50.$result['upload_data']['file_name'];
                    
                    $this->utils->resize_image($source_path, $destination_path, CLIENT_PROFILE_PICTURE_H50, CLIENT_PROFILE_PICTURE_W50);
                    $picture = $result['upload_data']['file_name'];
                }                
            }
            
            for($i = 0; $i < $question_list_length; $i++)
            {
                $answer_list[$i] = array(
                    'id' => $this->input->post('question_additional_info_'.$i),
                    'answer' => $this->input->post('question_radio_'.$i),
//                    'additional_info' => (isset($this->input->post('question_additional_info_'.$i)) ? $this->input->post('question_additional_info_'.$i) : NULL),
                    'additional_info' => $this->input->post('question_additional_info_'.$i)
                );
            }
            
            if($this->form_validation->run() == true)
            {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'gender_id' => $this->input->post('gender_id'),
                    'email' => $this->input->post('email'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'birth_date' => $this->input->post('birth_date'),
                    'status_id' => $this->input->post('status_id'),
                    'occupation' => $this->input->post('occupation'),
                    'company_name' => $this->input->post('company_name'),
                    'picture' => $picture,
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'address' => $this->input->post('address'),
                    'emergyncy_contact' => $this->input->post('emergyncy_contact'),
                    'emergyncy_phone' => $this->input->post('emergyncy_phone'),
                    'height' => $this->input->post('height'),
                    'reseting_heart_rate' => $this->input->post('reseting_heart_rate'),
                    'blood_pressure' => $this->input->post('blood_pressure'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $this->session->userdata('user_id'),
                    
                    'question_list' => serialize($answer_list)
                );
                $client_create_id = $this->gympro_library->create_client($data);
                if ($client_create_id !== FALSE) {
                    $result['message'] = 'Client is added successfully.';
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
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
//        $this->data['smoker_txt'] = array(
//            'name' => 'smoker_txt',
//            'id' => 'smoker_txt',
//            'type' => 'text'
//        );
//        $this->data['cardiov_txt'] = array(
//            'name' => 'cardiov_txt',
//            'id' => 'cardiov_txt',
//            'type' => 'text'
//        );
//        $this->data['injury_txt'] = array(
//            'name' => 'injury_txt',
//            'id' => 'injury_txt',
//            'type' => 'text'
//        );
//        $this->data['medication_txt'] = array(
//            'name' => 'medication_txt',
//            'id' => 'medication_txt',
//            'type' => 'text'
//        );
//        $this->data['medicalcondition_txt'] = array(
//            'name' => 'medicalcondition_txt',
//            'id' => 'medicalcondition_txt',
//            'type' => 'text'
//        );
//        $this->data['height'] = array(
//            'name' => 'height',
//            'id' => 'height',
//            'type' => 'text'
//        );
//        $this->data['reseting_heart_rate'] = array(
//            'name' => 'reseting_heart_rate',
//            'id' => 'reseting_heart_rate',
//            'type' => 'text'
//        );
//        $this->data['blood_pressure'] = array(
//            'name' => 'blood_pressure',
//            'id' => 'blood_pressure',
//            'type' => 'text'
//        );
        
        
//        NOTES
        $this->data['notes'] = array(
            'name' => 'notes',
            'id' => 'notes',
            'type' => 'text'
        );
        
        
        $this->data['btnSubmit'] = array(
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'type' => 'submit',
            'value' => 'Save'
        );
        
        
        
        
        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->data['gender_info'] = $this->gympro_library->get_all_gender_info()->result_array();
        $this->data['status_info'] = $this->gympro_library->get_all_status_info()->result_array();
        $this->template->load(null,'applications/gympro/client/create_client', $this->data);
    }
    public function update_client($client_id = 1)
    {
        $client = $this->gympro_library->get_client_info($client_id)->result_array();
        $client = $client[0];
//        var_dump($client);
//        exit();
        $this->data['message'] = ''; 
        $this->form_validation->set_rules('first_name', 'First Name', 'xss_clean|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'xss_clean');
        
        $question_list = $this->gympro_library->get_all_health_questions()->result_array();
        $this->data['question_list'] = $question_list;
        $question_list_length = count($question_list);        
        $answer_list = array();
        if ($this->input->post())
        {
            $result = array();
            $result['message'] = '';
            $picture = "";
            if (isset($_FILES["userfile"]))
            {
                $result = $this->utils->upload_image($_FILES["userfile"], CLIENT_PROFILE_PIC_IMAGEPATH);
                if($result['status'] == 1)
                {
                    $source_path = CLIENT_PROFILE_PIC_IMAGEPATH.$result['upload_data']['file_name'];
                    $destination_path = CLIENT_PROFILE_PICTURE_PATH_W50_H50.$result['upload_data']['file_name'];
                    
                    $this->utils->resize_image($source_path, $destination_path, CLIENT_PROFILE_PICTURE_H50, CLIENT_PROFILE_PICTURE_W50);
                    $picture = $result['upload_data']['file_name'];
                }                
            }
            
            for($i = 0; $i < $question_list_length; $i++)
            {
                $answer_list[$i] = array(
                    'id' => $this->input->post('question_additional_info_'.$i),
                    'answer' => $this->input->post('question_radio_'.$i),
//                    'additional_info' => (isset($this->input->post('question_additional_info_'.$i)) ? $this->input->post('question_additional_info_'.$i) : NULL),
                    'additional_info' => $this->input->post('question_additional_info_'.$i)
                );
            }
            
            if($this->form_validation->run() == true)
            {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'gender_id' => $this->input->post('gender_id'),
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
                    'height' => $this->input->post('height'),
                    'reseting_heart_rate' => $this->input->post('reseting_heart_rate'),
                    'blood_pressure' => $this->input->post('blood_pressure'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $this->session->userdata('user_id'),
                    'qestion_list' => serialize($answer_list)
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
        
        
        $this->data['btnSubmit'] = array(
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'type' => 'submit',
            'value' => 'Save'
        );
        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->data['gender_info'] = $this->gympro_library->get_all_gender_info()->result_array();
        $this->data['status_info'] = $this->gympro_library->get_all_status_info()->result_array();
        $this->template->load(null,'applications/gympro/client/edit_client', $this->data);
    }
    //----------------------------------- Group Module ---------------------------------//
    public function manage_groups()
    {
        $this->data['message'] = '';
        $this->data['group_list'] = $this->gympro_library->get_all_groups($this->session->userdata('user_id'));
        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->template->load(null,'applications/gympro/groups', $this->data);
    }
    public function create_group()
    {
        $this->data['message'] = '';        
        if ($this->input->post())
        {
            $this->form_validation->set_rules('title', 'title', 'xss_clean|required'); 
            if($this->form_validation->run() == true)
            {
                $data = array(
                    'title' => $this->input->post('title'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $this->session->userdata('user_id')
                    
                );
                $create_id = $this->gympro_library->create_group($data);
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
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save Changes'
        );
        
        
        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->template->load(null,'applications/gympro/group_create', $this->data);
    }
    
    public function edit_group($group_id = 0)
    {
        $this->data['message'] = '';        
        if ($this->input->post())
        {
            $this->form_validation->set_rules('title', 'title', 'xss_clean|required'); 
            if($this->form_validation->run() == true)
            {
                $data = array(
                    'title' => $this->input->post('title'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $this->session->userdata('user_id')
                    
                );
                $create_id = $this->gympro_library->update_group($group_id, $data);
                if ($create_id !== FALSE) {
                    $this->data['message'] = "Client group is created successfully.";
                    redirect('applications/gympro/manage_groups','refresh');
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
        $group_data = $this->gympro_library->get_group_info($group_id)->result_array();
        $group_data = $group_data[0];
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $group_data['title']
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $group_data['phone']
        );
        $this->data['mobile'] = array(
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'text',
            'value' => $group_data['mobile']
        );
        $this->data['notes'] = array(
            'name' => 'notes',
            'id' => 'notes',
            'type' => 'text'
        );
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save Changes'
        );
        
        $this->data['gr_notes'] = $group_data['notes'];
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->template->load(null,'applications/gympro/group_edit', $this->data);
    }
    
    public function delete_group()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->gympro_library->delete_group($delete_id))
        {
            $result['message'] = $this->gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
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
    //-----------------------------------------Program Module------------------------------------//
    /*
     * This method will show all programs of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function programs()
    {
        $program_list = $this->gympro_library->get_all_programs($this->session->userdata('user_id'));
        $this->data['program_list'] = $program_list;
        $this->data['message'] = '';        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/programs', $this->data);
    }
    /*
     * This method will creae a new nutrition
     * @Author Nazmul on 7th December 2014
     */
    public function create_program()
    {
        $this->form_validation->set_rules('focus', 'Focus', 'xss_clean|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'xss_clean');
        
        if ($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $exercise_list = array(
                    'ex_name' => $this->input->post('ex_name'),
                    'ex_description' => $this->input->post('ex_description'),
                    'ex_sets' => $this->input->post('ex_sets'),
                    'ex_reps' => $this->input->post('ex_reps'),
                    'ex_weights' => $this->input->post('ex_weights'),
                    'ex_reps2' => $this->input->post('ex_reps2'),
                    'ex_tempo' => $this->input->post('ex_tempo')
                );

                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'focus' => $this->input->post('focus'),
                    'start_date' => $this->input->post('start_date'),
                    'review_id' => $this->input->post('review_id'),
                    'description' => $this->input->post('description'),
                    'warm_up' => $this->input->post('warm_up'),
                    'cool_down' => $this->input->post('cool_down'),
                    
                    'exercise_list' => json_encode($exercise_list)
                );
                $create_program_id = $this->gympro_library->create_program($data);
                if ($create_program_id !== FALSE) {
                    $result['message'] = 'Programme is added successfully.';
                    redirect('applications/gympro/programs', 'refresh');
                    } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $this->data['review_array'] = $this->gympro_library->get_all_reviews()->result_array();
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->data['message'] = '';       
        $this->template->load(null,'applications/gympro/program_create', $this->data);
    }
    /*
     * This method will edit program
     * @param $program_id, program id
     * @Author Nazmul on 7th December 2014
     */
    public function edit_program($program_id = 0)
    {
        $this->form_validation->set_rules('focus', 'First Name', 'xss_clean|required');
        $this->form_validation->set_rules('start_date', 'Last Name', 'xss_clean');
        
        if ($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $exercise_list = array(
                    'ex_name' => $this->input->post('ex_name'),
                    'ex_description' => $this->input->post('ex_description'),
                    'ex_sets' => $this->input->post('ex_sets'),
                    'ex_reps' => $this->input->post('ex_reps'),
                    'ex_weights' => $this->input->post('ex_weights'),
                    'ex_reps2' => $this->input->post('ex_reps2'),
                    'ex_tempo' => $this->input->post('ex_tempo')
                );

                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'focus' => $this->input->post('focus'),
                    'start_date' => $this->input->post('start_date'),
                    'review_id' => $this->input->post('review_id'),
                    'description' => $this->input->post('description'),
                    'warm_up' => $this->input->post('warm_up'),
                    'cool_down' => $this->input->post('cool_down'),
                    'warm_up' => $this->input->post('warm_up'),
                    
                    'exercise_list' => json_encode($exercise_list)
                );
                $update_program_id = $this->gympro_library->update_program($program_id, $data);
                if ($update_program_id !== FALSE) {
                    $result['message'] = 'Programme is updated successfully.';
                    redirect('applications/gympro/programs', 'refresh');
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $program_info = $this->gympro_library->get_program_info($program_id)->result_array();
        $this->data['program'] = $program_info[0];
        $this->data['exercise'] = json_decode( $program_info[0]['exercise_list'], TRUE );
        $this->data['review_array'] = $this->gympro_library->get_all_reviews()->result_array();
        $this->data['program_id'] = $program_id;
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->data['message'] = '';       
        $this->template->load(null,'applications/gympro/program_edit', $this->data);
    }
    /*
     * Ajax call to delete program
     * @param $program_id, program id
     * @Author Nazmul on 7th December 2014
     */
    public function delete_program()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->gympro_library->delete_program($delete_id))
        {
            $result['message'] = $this->gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    //---------------------------------------Exercise Module---------------------------------------//
    /*
     * This method will show all exercises of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function exercises()
    {
        $exercise_list = $this->gympro_library->get_all_exercises($this->session->userdata('user_id'));
        $this->data['exercise_list'] = $exercise_list;
        $this->data['message'] = '';        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/exercises', $this->data);
    }
    /*
     * This method will creae a new exercise
     * @Author Nazmul on 7th December 2014
     */
    public function create_exercise()
    {
        $this->form_validation->set_rules('name', 'name', 'xss_clean|required');
        if ($this->input->post()) {
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'category_id' => $this->input->post('category_id'),
                    'picture' => $this->input->post('picture'),
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'user_id' => $this->session->userdata('user_id')
                );
                $newValue = $this->gympro_library->create_exercise($additional_data);
                if ($newValue) {
                    $this->data['message'] = $this->gympro_library->messages();
                    redirect('applications/gympro/exercises', 'refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            }
        }
        $this->data['category_array'] = $this->gympro_library->get_all_exercise_categories()->result_array();
        
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text'
        );

        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text'
        );

        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );

        $this->data['message'] = '';
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null, 'applications/gympro/exercise_create', $this->data);

    }
    /*
     * This method will edit exercise
     * @param $exercise_id, exercise id
     * @Author Nazmul on 7th December 2014
     */
    public function edit_exercise($exercise_id = 0)
    {   
        if($exercise_id == 0)
        {
            redirect('applications/gympro/exercise_edit', 'refresh');
        }
        $exercise_info = array();
        $exercise_array = $this->gympro_library->get_exercise_info($exercise_id)->result_array();
        if(!empty($exercise_array))
        {
            $exercise_info = $exercise_array[0];            
        }
       
        $this->form_validation->set_rules('name', 'name', 'xss_clean|required');
        if ($this->input->post()) {
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'category_id' => $this->input->post('category_id'),
                    'picture' => $this->input->post('picture'),
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'user_id' => $this->session->userdata('user_id')
                );
                $newValue = $this->gympro_library->update_exercise($exercise_id, $additional_data);
                if ($newValue) {
                    $this->data['message'] = $this->gympro_library->messages();
                    redirect('applications/gympro/exercises', 'refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            }
        }
        $this->data['category_array'] = $this->gympro_library->get_all_exercise_categories()->result_array();
        
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $exercise_info['name']
        );

        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $exercise_info['description']
        );

        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );

        $this->data['message'] = '';
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->data['exercise_id'] = $exercise_id;        
        $this->template->load(null, 'applications/gympro/exercise_edit', $this->data);

    }
    
    public function delete_exercise()
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->gympro_library->delete_exercise($delete_id))
        {
            $result['message'] = $this->gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    //-----------------------------------------Nutrition Module------------------------------------//
    /*
     * This method will show all nutritions of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function nutrition()
    {
        $nutrition_list = $this->gympro_library->get_all_nutritions($this->session->userdata('user_id'));
        $this->data['nutrition_list'] = $nutrition_list;
        $this->data['message'] = '';        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/nutrition', $this->data);
    }
    /*
     * This method will creae a new nutrition
     * @Author Nazmul on 7th December 2014
     */
    public function create_nutrition()
    {
        $this->form_validation->set_rules('label', 'Focus', 'xss_clean|required');
        $this->form_validation->set_rules('quan', 'Start Date', 'xss_clean');
        
        if ($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $meal_list = array(
                    'meal_time' => $this->input->post('meal_time'),
                    'work_out' => $this->input->post('work_out'),
                    'label' => $this->input->post('label'),
                    'quan' => $this->input->post('quan'),
                    'unit' => $this->input->post('unit'),
                    'cal' => $this->input->post('cal'),
                    'prot' => $this->input->post('prot'),
                    'carb' => $this->input->post('carb'),
                    'fats' => $this->input->post('fats')
                );

                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    
                    'meal_list' => json_encode($meal_list)
                );
                $create_program_id = $this->gympro_library->create_nutrition($data);
                if ($create_program_id !== FALSE) {
                    $result['message'] = 'Nutrition is added successfully.';
                    redirect('applications/gympro/nutrition', 'refresh');
                    } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
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
    /*
     * This method will edit nutrition
     * @param $nutrition_id, nutrition id
     * @Author Nazmul on 7th December 2014
     */
    public function edit_nutrition($nutrition_id = 0)
    {
        $this->form_validation->set_rules('label', 'Focus', 'xss_clean|required');
        $this->form_validation->set_rules('quan', 'Start Date', 'xss_clean');
        
        if ($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $meal_list = array(
                    'meal_time' => $this->input->post('meal_time'),
                    'work_out' => $this->input->post('work_out'),
                    'label' => $this->input->post('label'),
                    'quan' => $this->input->post('quan'),
                    'unit' => $this->input->post('unit'),
                    'cal' => $this->input->post('cal'),
                    'prot' => $this->input->post('prot'),
                    'carb' => $this->input->post('carb'),
                    'fats' => $this->input->post('fats')
                );

                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    
                    'meal_list' => json_encode($meal_list)
                );
                $update_id = $this->gympro_library->update_nutrition($nutrition_id, $data);
                if ($update_id !== FALSE) {
                    $result['message'] = 'Nutrition is updated successfully.';
                    redirect('applications/gympro/nutrition', 'refresh');
                    } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $meal_time_list = array();
        $meal_time_array = $this->gympro_library->get_all_meal_times()->result_array();
        foreach($meal_time_array as $meal_time)
        {
            $meal_time_list[$meal_time['meal_time_id']] = $meal_time['title'];
        }
        $this->data['meal_time_list'] = $meal_time_list;
        
        $workout_list = array();
        $workout_array = $this->gympro_library->get_all_workouts()->result_array();
        foreach($workout_array as $workout)
        {
            $workout_list[$workout['workout_id']] = $workout['title'];
        }
        
        $nutrition_info = $this->gympro_library->get_nutrition_info($nutrition_id)->result_array();
        $this->data['nutrition'] = json_decode($nutrition_info[0]['meal_list'], TRUE);
        $this->data['workout_list'] = $workout_list;
        $this->template->load(null,'applications/gympro/nutrition_edit', $this->data);
    }
    /*
     * Ajax call to delete nutrition
     * @param $nutrition_id, nutrition id
     * @Author Nazmul on 7th December 2014
     */
    public function delete_nutrition($nutrition_id = 0)
    {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->gympro_library->delete_nutrition($delete_id))
        {
            $result['message'] = $this->gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    //----------------------------------------Assessment Module------------------------------------//
     /*
     * This method will show all assessments of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function assessments()
    {
        $this->data['assessment_list'] = $this->gympro_library->get_all_assessments($this->session->userdata('user_id'));
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/assessments', $this->data);
    }
    /*
     * This method will create an assessment
     * @Author Nazmul on 7th December 2014
     */
    public function create_assessment()
    {
        $this->form_validation->set_rules('date', 'date', 'xss_clean|required');
        if ($this->input->post()) {
            
            if ($this->form_validation->run() == true) {
                
                $additional_data = array(
                    'date' => $this->input->post('date'),
                    'weight' => $this->input->post('weight'),
                    'head' => $this->input->post('head'),
                    'neck' => $this->input->post('neck'),
                    'chest' => $this->input->post('chest'),
                    'reassess_id' => $this->input->post('reassess_list'),
                    'body_fat' => $this->input->post('body_fat'),
                    'abdominal' => $this->input->post('abdominal'),
                    'waist' => $this->input->post('waist'),
                    'hip' => $this->input->post('hip'),
                    'user_id' => $this->session->userdata('user_id'),
                    'ls_arm_relaxed' => $this->input->post('ls_arm_relaxed'),
                    'ls_arm_flexed' => $this->input->post('ls_arm_flexed'),
                    'ls_forearm' => $this->input->post('ls_forearm'),
                    'ls_wrist' => $this->input->post('ls_wrist'),
                    'ls_thigh_gluteal' => $this->input->post('ls_thigh_gluteal'),
                    'ls_thigh_mid' => $this->input->post('ls_thigh_mid'),
                    'ls_calf' => $this->input->post('ls_calf'),
                    'ls_ankle' => $this->input->post('ls_ankle'),
                    'rs_arm_relaxed' => $this->input->post('rs_arm_relaxed'),
                    'rs_arm_flexed' => $this->input->post('rs_arm_flexed'),
                    'rs_forearm' => $this->input->post('rs_forearm'),
                    'rs_wrist' => $this->input->post('rs_wrist'),
                    'rs_thigh_gluteal' => $this->input->post('rs_thigh_gluteal'),
                    'rs_thigh_mid' => $this->input->post('rs_thigh_mid'),
                    'rs_calf' => $this->input->post('rs_calf'),
                    'rs_ankle' => $this->input->post('rs_ankle')
                   
                );
                $newValue = $this->gympro_library->create_assessment($additional_data);
                if ($newValue) {
                    $this->data['message'] = $this->gympro_library->messages();
                    redirect('applications/gympro/create_assessment', 'refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            }
        }
        $reassess_array = $this->gympro_library->get_all_reassess()->result_array();
        $this->data['reassess_list'] = array();
        foreach ($reassess_array as $reassess_info) {
            $this->data['reassess_list'][$reassess_info['id']] = $reassess_info['title'];
        }
        
        $this->data['date'] = array(
            'name' => 'date',
            'id' => 'date',
            'type' => 'text'
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text'
        );
        $this->data['head'] = array(
            'name' => 'head',
            'id' => 'head',
            'type' => 'text'
        );
        $this->data['neck'] = array(
            'name' => 'neck',
            'id' => 'neck',
            'type' => 'text'
        );
        $this->data['chest'] = array(
            'name' => 'chest',
            'id' => 'chest',
            'type' => 'text'
        );

        $this->data['body_fat'] = array(
            'name' => 'body_fat',
            'id' => 'body_fat',
            'type' => 'text'
        );
        $this->data['abdominal'] = array(
            'name' => 'abdominal',
            'id' => 'abdominal',
            'type' => 'text'
        );
        $this->data['waist'] = array(
            'name' => 'waist',
            'id' => 'waist',
            'type' => 'text'
        );
        $this->data['hip'] = array(
            'name' => 'hip',
            'id' => 'hip',
            'type' => 'text'
        );
        $this->data['ls_arm_relaxed'] = array(
            'name' => 'ls_arm_relaxed',
            'id' => 'ls_arm_relaxed',
            'type' => 'text'
        );
        $this->data['ls_arm_flexed'] = array(
            'name' => 'ls_arm_flexed',
            'id' => 'ls_arm_flexed',
            'type' => 'text'
        );
        $this->data['ls_forearm'] = array(
            'name' => 'ls_forearm',
            'id' => 'ls_forearm',
            'type' => 'text'
        );
        $this->data['ls_wrist'] = array(
            'name' => 'ls_wrist',
            'id' => 'ls_wrist',
            'type' => 'text'
        );
        $this->data['ls_thigh_gluteal'] = array(
            'name' => 'ls_thigh_gluteal',
            'id' => 'ls_thigh_gluteal',
            'type' => 'text'
        );
        $this->data['ls_thigh_mid'] = array(
            'name' => 'ls_thigh_mid',
            'id' => 'ls_thigh_mid',
            'type' => 'text'
        );
        $this->data['ls_calf'] = array(
            'name' => 'ls_calf',
            'id' => 'ls_calf',
            'type' => 'text'
        );
        $this->data['ls_ankle'] = array(
            'name' => 'ls_ankle',
            'id' => 'ls_ankle',
            'type' => 'text'
        );
        $this->data['rs_arm_relaxed'] = array(
            'name' => 'rs_arm_relaxed',
            'id' => 'rs_arm_relaxed',
            'type' => 'text'
        );
        $this->data['rs_arm_flexed'] = array(
            'name' => 'rs_arm_flexed',
            'id' => 'rs_arm_flexed',
            'type' => 'text'
        );
        $this->data['rs_forearm'] = array(
            'name' => 'rs_forearm',
            'id' => 'rs_forearm',
            'type' => 'text'
        );
        $this->data['rs_wrist'] = array(
            'name' => 'rs_wrist',
            'id' => 'rs_wrist',
            'type' => 'text'
        );
        $this->data['rs_thigh_gluteal'] = array(
            'name' => 'rs_thigh_gluteal',
            'id' => 'rs_thigh_gluteal',
            'type' => 'text'
        );
        $this->data['rs_thigh_mid'] = array(
            'name' => 'rs_thigh_mid',
            'id' => 'rs_thigh_mid',
            'type' => 'text'
        );
        $this->data['rs_calf'] = array(
            'name' => 'rs_calf',
            'id' => 'rs_calf',
            'type' => 'text'
        );
        $this->data['rs_ankle'] = array(
            'name' => 'rs_ankle',
            'id' => 'rs_ankle',
            'type' => 'text'
        );
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );
        
        $this->data['message'] = '';       
        $this->template->load(null,'applications/gympro/assessment_create', $this->data);
    }
    
    /*
     * This method will edit an assessment
     * @param $assessment_id, assessment id
     * @Author Nazmul on 7th December 2014
     */
    public function edit_assessment($assessment_id = 0)
    {            
        $this->form_validation->set_rules('date', 'date', 'xss_clean|required');
        if ($this->input->post()) {            
            if ($this->form_validation->run() == true) {
                
                $additional_data = array(
                    'date' => $this->input->post('date'),
                    'weight' => $this->input->post('weight'),
                    'head' => $this->input->post('head'),
                    'neck' => $this->input->post('neck'),
                    'chest' => $this->input->post('chest'),
                    'reassess_id' => $this->input->post('reassess_list'),
                    'body_fat' => $this->input->post('body_fat'),
                    'abdominal' => $this->input->post('abdominal'),
                    'waist' => $this->input->post('waist'),
                    'hip' => $this->input->post('hip'),
                    'user_id' => $this->session->userdata('user_id'),
                    'ls_arm_relaxed' => $this->input->post('ls_arm_relaxed'),
                    'ls_arm_flexed' => $this->input->post('ls_arm_flexed'),
                    'ls_forearm' => $this->input->post('ls_forearm'),
                    'ls_wrist' => $this->input->post('ls_wrist'),
                    'ls_thigh_gluteal' => $this->input->post('ls_thigh_gluteal'),
                    'ls_thigh_mid' => $this->input->post('ls_thigh_mid'),
                    'ls_calf' => $this->input->post('ls_calf'),
                    'ls_ankle' => $this->input->post('ls_ankle'),
                    'rs_arm_relaxed' => $this->input->post('rs_arm_relaxed'),
                    'rs_arm_flexed' => $this->input->post('rs_arm_flexed'),
                    'rs_forearm' => $this->input->post('rs_forearm'),
                    'rs_wrist' => $this->input->post('rs_wrist'),
                    'rs_thigh_gluteal' => $this->input->post('rs_thigh_gluteal'),
                    'rs_thigh_mid' => $this->input->post('rs_thigh_mid'),
                    'rs_calf' => $this->input->post('rs_calf'),
                    'rs_ankle' => $this->input->post('rs_ankle')
                   
                );
                
                $newValue = $this->gympro_library->update_assessment($assessment_id, $additional_data);
                if ($newValue) {
                    $this->data['message'] = $this->gympro_library->messages();
                    redirect('applications/gympro/assessments/', 'refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            }
        }
        $reassess_array = $this->gympro_library->get_all_reassess()->result_array();
        $this->data['reassess_list'] = array();
        foreach ($reassess_array as $reassess_info) {
            $this->data['reassess_list'][$reassess_info['id']] = $reassess_info['title'];
        }
        $assessment_info = array();
        $assessment_array = $this->gympro_library->get_assessment_info($assessment_id)->result_array();
        if(!empty($assessment_array))
        {
            $assessment_info = $assessment_array[0];            
        }          
        
        $this->data['date'] = array(
            'name' => 'date',
            'id' => 'date',
            'type' => 'text',
            'value' => $assessment_info['date']
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text',
            'value' => $assessment_info['weight']
        );
        $this->data['head'] = array(
            'name' => 'head',
            'id' => 'head',
            'type' => 'text',
            'value' => $assessment_info['head']
        );
        $this->data['neck'] = array(
            'name' => 'neck',
            'id' => 'neck',
            'type' => 'text',
            'value' => $assessment_info['neck']
        );
        $this->data['chest'] = array(
            'name' => 'chest',
            'id' => 'chest',
            'type' => 'text',
            'value' => $assessment_info['chest']
        );

        $this->data['body_fat'] = array(
            'name' => 'body_fat',
            'id' => 'body_fat',
            'type' => 'text',
            'value' => $assessment_info['body_fat']
        );
        $this->data['abdominal'] = array(
            'name' => 'abdominal',
            'id' => 'abdominal',
            'type' => 'text',
            'value' => $assessment_info['abdominal']
        );
        $this->data['waist'] = array(
            'name' => 'waist',
            'id' => 'waist',
            'type' => 'text',
            'value' => $assessment_info['waist']
        );
        $this->data['hip'] = array(
            'name' => 'hip',
            'id' => 'hip',
            'type' => 'text',
            'value' => $assessment_info['hip']
        );
        $this->data['ls_arm_relaxed'] = array(
            'name' => 'ls_arm_relaxed',
            'id' => 'ls_arm_relaxed',
            'type' => 'text',
            'value' => $assessment_info['ls_arm_relaxed']
        );
        $this->data['ls_arm_flexed'] = array(
            'name' => 'ls_arm_flexed',
            'id' => 'ls_arm_flexed',
            'type' => 'text',
            'value' => $assessment_info['ls_arm_flexed']
        );
        $this->data['ls_forearm'] = array(
            'name' => 'ls_forearm',
            'id' => 'ls_forearm',
            'type' => 'text',
            'value' => $assessment_info['ls_forearm']
        );
        $this->data['ls_wrist'] = array(
            'name' => 'ls_wrist',
            'id' => 'ls_wrist',
            'type' => 'text',
            'value' => $assessment_info['ls_wrist']
        );
        $this->data['ls_thigh_gluteal'] = array(
            'name' => 'ls_thigh_gluteal',
            'id' => 'ls_thigh_gluteal',
            'type' => 'text',
            'value' => $assessment_info['ls_thigh_gluteal']
        );
        $this->data['ls_thigh_mid'] = array(
            'name' => 'ls_thigh_mid',
            'id' => 'ls_thigh_mid',
            'type' => 'text',
            'value' => $assessment_info['ls_thigh_mid']
        );
        $this->data['ls_calf'] = array(
            'name' => 'ls_calf',
            'id' => 'ls_calf',
            'type' => 'text',
            'value' => $assessment_info['ls_calf']
        );
        $this->data['ls_ankle'] = array(
            'name' => 'ls_ankle',
            'id' => 'ls_ankle',
            'type' => 'text',
            'value' => $assessment_info['ls_ankle']
        );
        $this->data['rs_arm_relaxed'] = array(
            'name' => 'rs_arm_relaxed',
            'id' => 'rs_arm_relaxed',
            'type' => 'text',
            'value' => $assessment_info['rs_arm_relaxed']
        );
        $this->data['rs_arm_flexed'] = array(
            'name' => 'rs_arm_flexed',
            'id' => 'rs_arm_flexed',
            'type' => 'text',
            'value' => $assessment_info['rs_arm_flexed']
        );
        $this->data['rs_forearm'] = array(
            'name' => 'rs_forearm',
            'id' => 'rs_forearm',
            'type' => 'text',
            'value' => $assessment_info['rs_forearm']
        );
        $this->data['rs_wrist'] = array(
            'name' => 'rs_wrist',
            'id' => 'rs_wrist',
            'type' => 'text',
            'value' => $assessment_info['rs_wrist']
        );
        $this->data['rs_thigh_gluteal'] = array(
            'name' => 'rs_thigh_gluteal',
            'id' => 'rs_thigh_gluteal',
            'type' => 'text',
            'value' => $assessment_info['rs_thigh_gluteal']
        );
        $this->data['rs_thigh_mid'] = array(
            'name' => 'rs_thigh_mid',
            'id' => 'rs_thigh_mid',
            'type' => 'text',
            'value' => $assessment_info['rs_thigh_mid']
        );
        $this->data['rs_calf'] = array(
            'name' => 'rs_calf',
            'id' => 'rs_calf',
            'type' => 'text',
            'value' => $assessment_info['rs_calf']
        );
        $this->data['rs_ankle'] = array(
            'name' => 'rs_ankle',
            'id' => 'rs_ankle',
            'type' => 'text',
            'value' => $assessment_info['rs_ankle']
        );
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );
        
        $this->data['assessment_id'] = $assessment_id;       
        $this->template->load(null,'applications/gympro/assessment_edit', $this->data);
    }
    /*
     * Ajax call to delete an assessment
     * @Author Nazmul on 7th December 2014
     */
    public function delete_assessment()
       {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->gympro_library->delete_assessment($delete_id))
        {
            $result['message'] = $this->gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }
    
    //-----------------------------------------Mission Module------------------------------------//
    /*
     * This method will show all missions of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function manage_missions()
    {
        $mission_list = $this->gympro_library->get_all_missions($this->session->userdata('user_id'));
        $this->data['mission_list'] = $mission_list;
        $this->data['message'] = '';        
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;        
        $this->template->load(null,'applications/gympro/missions', $this->data);
    }
    /*
     * This method will create a mission
     * @Author Nazmul on 7th December 2014
     */
    public function create_mission()
    {    
        $this->data['message'] = '';
        $this->form_validation->set_rules('label', 'label', 'xss_clean|required');
        if ($this->input->post()) 
        {
            if ($this->form_validation->run() == true) 
            {
                $additional_data = array(
                    'label' => $this->input->post('label'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'sunday' => $this->input->post('sunday'),
                    'monday' => $this->input->post('monday'),
                    'tuesday' => $this->input->post('tuesday'),
                    'wednesday' => $this->input->post('wednesday'),
                    'thursday' => $this->input->post('thursday'),
                    'friday' => $this->input->post('friday'),
                    'saturday' => $this->input->post('saturday'),
                    'user_id' => $this->session->userdata('user_id')
                );
                $value = $this->gympro_library->create_mission($additional_data);
                if ($value !== FALSE) 
                {
                    $this->session->set_flashdata('message', $this->gympro_library->messages());
                    redirect('applications/gympro/create_mission', 'refresh');
                } else 
                {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }

        $this->data['label'] = array(
            'name' => 'label',
            'id' => 'label',
            'type' => 'text'
        );

        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text'
        );

        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text'
        );

        $this->data['start_data'] = array(
            'name' => 'start_data',
            'id' => 'start_data',
            'type' => 'text'
        );

        $this->data['sunday'] = array(
            'name' => 'sunday',
            'id' => 'sunday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['monday'] = array(
            'name' => 'monday',
            'id' => 'monday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['tuesday'] = array(
            'name' => 'tuesday',
            'id' => 'tuesday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['wednesday'] = array(
            'name' => 'wednesday',
            'id' => 'wednesday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['thursday'] = array(
            'name' => 'thursday',
            'id' => 'thursday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['friday'] = array(
            'name' => 'friday',
            'id' => 'friday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['saturday'] = array(
            'name' => 'saturday',
            'id' => 'saturday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );
        $this->template->load(null, 'applications/gympro/mission_create', $this->data);
    }    
    /*
     * This method will edit a mission
     * @param $mission_id, mission id
     * @Author Nazmul on 7th December 2014
     */
    public function edit_mission($mission_id = 0)
    {    
        if($mission_id == 0)
        {
            redirect('applications/gympro/manage_missions', 'refresh');
        }
        $mission_info = array();
        $mission_array = $this->gympro_library->get_mission_info($mission_id)->result_array();
        if(!empty($mission_array))
        {
            $mission_info = $mission_array[0];            
        }
        $this->data['message'] = ''; 
        $this->form_validation->set_rules('label', 'label', 'xss_clean|required');
        if ($this->input->post()) 
        {
            if ($this->form_validation->run() == true) 
            {
                $additional_data = array(
                    'label' => $this->input->post('label'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'sunday' => $this->input->post('sunday'),
                    'monday' => $this->input->post('monday'),
                    'tuesday' => $this->input->post('tuesday'),
                    'wednesday' => $this->input->post('wednesday'),
                    'thursday' => $this->input->post('thursday'),
                    'friday' => $this->input->post('friday'),
                    'saturday' => $this->input->post('saturday')
                );
                $value = $this->gympro_library->update_mission($mission_id, $additional_data);
                if($value === TRUE) 
                {
                    $this->data['message'] = $this->gympro_library->messages();
                    redirect('applications/gympro/manage_missions/', 'refresh');
                } else 
                {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            }
        }
        
        $this->data['label'] = array(
            'name' => 'label',
            'id' => 'label',
            'type' => 'text',
            'value' => $mission_info['label']
        );

        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text',
            'value' => $mission_info['end_date']
        );

        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text',
            'value' => $mission_info['start_date']
        );
        $this->data['sunday'] = array(
            'name' => 'sunday',
            'id' => 'sunday',
            'type' => 'text',
            'rows' => '4',
            'value' => $mission_info['sunday']
        );
        $this->data['monday'] = array(
            'name' => 'monday',
            'id' => 'monday',
            'type' => 'text',
            'rows' => '4',
            'value' => $mission_info['monday']
        );
        $this->data['tuesday'] = array(
            'name' => 'tuesday',
            'id' => 'tuesday',
            'type' => 'text',
            'rows' => '4',
            'value' => $mission_info['tuesday']
        );
        $this->data['wednesday'] = array(
            'name' => 'wednesday',
            'id' => 'wednesday',
            'type' => 'text',
            'rows' => '4',
            'value' => $mission_info['wednesday']
        );
        $this->data['thursday'] = array(
            'name' => 'thursday',
            'id' => 'thursday',
            'type' => 'text',
            'rows' => '4',
            'value' => $mission_info['thursday']
        );
        $this->data['friday'] = array(
            'name' => 'friday',
            'id' => 'friday',
            'type' => 'text',
            'rows' => '4',
            'value' => $mission_info['friday']
        );
        $this->data['saturday'] = array(
            'name' => 'saturday',
            'id' => 'saturday',
            'type' => 'text',
            'rows' => '4',
            'value' => $mission_info['saturday']
        );
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );
        $this->data['mission_id'] = $mission_id;
        $this->template->load(null, 'applications/gympro/mission_edit', $this->data);
    }
    /*
     * Ajax call to delete mission
     * @Author Nazmul on 7th December 2014
     */
    public function delete_mission()
   {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if($this->gympro_library->delete_mission($delete_id))
        {
            $result['message'] = $this->gympro_library->messages_alert();
        }
        else
        {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
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
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->template->load(null,'applications/gympro/session_create', $this->data);
    }
    public function earnings_summary()
    {
        $this->data['message'] = ''; 
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
        $this->template->load(null,'applications/gympro/earnings_summary', $this->data);
    }
}

                    

