<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model("dataprovider_model");
        $this->load->library("basic_profile");
        $this->load->library("org/interest/special_interest");
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('org/question/security_question_library');
        $this->load->library("org/profile/business/business_profile_library");
        $this->load->library("profile");
        $this->load->library('org/utility/Utils');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

    }
    function index(){
        $this->data["message"] = "";
        $this->data["gender_list"] = $this->dataprovider_model->getGenderList()->dropDownList('id', 'gender_name');
        $this->data["country_list"] = $this->dataprovider_model->getCountryList()->dropDownList('id', 'country_name');
        $profile_info = $this->basic_profile->get_profile_info();

        $home_town = '';
        $clg_or_uni = '';
        $employer = '';
        $gender_id = '';
        $dob = '';
        $country_id = '';
        $fav_team = '';
        $fav_player = '';
        $photo = '';
        $occupation ='';
        $selected_special_interest = '';

        if ($profile_info) {
            $home_town = $profile_info->home_town;
            $clg_or_uni = $profile_info->clg_or_uni;
            $employer = $profile_info->employer;
            $gender_id = $profile_info->gender_id;
            $dob = $profile_info->dob;
            $country_id = $profile_info->country_id;
            $fav_team = $profile_info->fav_team;
            $fav_player = $profile_info->fav_player;
            $photo = $profile_info->photo;
            $occupation = $profile_info->occupation;
            $selected_interests = json_decode($profile_info->special_interests);
            //print_r($selected_interests);
            if (is_array($selected_interests)) {
                $selected_special_interest = array();
                foreach ($selected_interests as $value) {
                    $selected_special_interest[] = ($value->interest_id . "_" . $value->sub_interest_id);
                }
            }
        }

        $this->data['home_town'] = $home_town;
        $this->data['college'] = $clg_or_uni;
        $this->data['employer'] = $employer;
        $this->data['gender_id'] = $gender_id;
        $this->data['dob'] = $dob;
        $this->data['country_id'] = $country_id;
        $this->data['sports_team'] = $fav_team;
        $this->data['fav_player'] = $fav_player;
        $this->data['photo'] = $photo;
        $this->data['occupation'] = $occupation;
        $this->data['selected_special_interest'] = json_encode($selected_special_interest);
        $this->data['special_interests'] = json_encode($this->special_interest->get_all_special_interests());

        $this->template->load("templates/profile_setting_tmpl", "member/registration_steps/steps", $this->data);
    }
    
    public function business_profile(){
        
        $this->data["country_list"] = $this->dataprovider_model->getCountryList()->dropDownList('id', 'country_name');
        $business_profile_types = $this->business_profile_library->get_business_types_profile();
        $this->data["business_profile_types"] = $this->dataprovider_model->dropDownListWithSource($business_profile_types, 'id', 'description');
        $profile_info = $this->business_profile_library->get_profile_info();
        $this->data['profile_info'] = $profile_info;
        
        $sub_type_list = array();
        foreach ($business_profile_types as $value) {
            $sub_type_list[$value['id']] = $this->dataprovider_model->dropDownListWithSource($value["sub_type_list"], 'id', 'description');
        }
        $this->data['sub_type_list'] = $sub_type_list;

        $this->data['business_name'] = array('name' => 'business_name',
            'id' => 'business_name',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('business_name') : $profile_info->business_name,
        );

        $this->data['street_name'] = array('name' => 'street_name',
            'id' => 'street_name',
            'type' => 'text',
            'value' => $profile_info == FALSE ?  $this->form_validation->set_value('street_name') : $profile_info->street_name,
        );
        $this->data['address'] = array('name' => 'address',
            'id' => 'address',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('address') : $profile_info->address,
        );
        $this->data['business_city'] = array('name' => 'business_city',
            'id' => 'business_city',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('business_city') : $profile_info->business_city,
        );
        $this->data['post_code'] = array('name' => 'post_code',
            'id' => 'post_code',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('post_code'): $profile_info->post_code,
        );
        $this->data['telephone'] = array('name' => 'telephone',
            'id' => 'telephone',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('telephone') : $profile_info->telephone,
        );
        $this->data['business_email'] = array('name' => 'business_email',
            'id' => 'business_email',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('business_email'): $profile_info->business_email,
        );
        $this->data['registered_company_number'] = array('name' => 'registered_company_number',
            'id' => 'registered_company_number',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('registered_company_number'): $profile_info->registered_company_number,
        );
        $this->data['website_address'] = array('name' => 'website_address',
            'id' => 'website_address',
            'type' => 'text',
            'value' => $profile_info == FALSE ? $this->form_validation->set_value('website_address'): $profile_info->website_address,
        );
        $this->data['business_hour'] = array('name' => 'business_hour',
            'id' => 'business_hour',
            'type' => 'text',
            'value' => $profile_info == FALSE ?  $this->form_validation->set_value('business_hour'): $profile_info->business_hour,
        );
        $this->data['business_description'] = array('name' => 'business_description',
            'id' => 'business_description',
            'type' => 'text',
            'value' => $profile_info == FALSE ?  $this->form_validation->set_value('business_description'): $profile_info->business_description,
        );
        $this->data["photo"] = "";
        $this->template->load("templates/profile_setting_tmpl", "business_man/registration_steps/steps", $this->data);
        
    }
    /**
     * Remote call
     * return value of the id
     */
    function step1(){
        //print_r($this->input->post());
        $interests = $this->input->post();
        if(is_array($interests))
        {
            $special_interest_list = array();
            foreach ($interests as $key => $value) {
                $ids = explode("_", $key);
                $category_id = $ids [ 1 ];
                $sub_category_id = $ids [ 2 ];
                $special_interest_list[] = array('interest_id'=>$category_id, 'sub_interest_id' => $sub_category_id);
            }
            $profile_data = array(
                'user_id' => $this->ion_auth->get_user_id(),
                'special_interests' => json_encode($special_interest_list)
            );
           $profile_id = $this->basic_profile->get_profile_id();
            if($profile_id > 0){
                //update profile
                echo $this->basic_profile->update_profile($profile_data);
            }
            else{
                //insert profile for the first time
                echo $this->basic_profile->create_profile($profile_data);
            }
            
        }
        else
        {
            echo true;
        }
    }
    /**
     * Remote call
     * return value of the id
     */
    function step2(){
        $profile_id = $this->basic_profile->get_profile_id();
        $profile_data = array(
                'user_id' => $this->ion_auth->get_user_id(),
                'home_town' => $this->input->post('home_town'),
                'clg_or_uni'=>  $this->input->post('college'),
                'employer'=>$this->input->post('employer'),
                'gender_id'=>$this->input->post('gender_list'),
                'dob'=>date('Y-m-d',strtotime($this->input->post('birthday_day')."-".$this->input->post('birthday_month')."-".$this->input->post('birthday_year'))),
                'country_id'=>$this->input->post('country_list'),
                'occupation'=>$this->input->post('occupation')
            );
        
        if($profile_id > 0){
            //update profile
            echo $this->basic_profile->update_profile($profile_data);
        }
        else{
            //insert profile for the first time
            echo $this->basic_profile->create_profile($profile_data);
        }
    }
    /**
     * Remote call
     * return value of the id
     */
    function step3(){
        //uploading picture
        $config['image_library'] = 'gd2';
        $config['upload_path'] = PROFILE_PICTURE_UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '10240';
        $config['file_name'] = $this->utils->generateRandomString();
        //$config['maintain_ratio'] = FALSE;
        //$config['width'] = 120;
        //$config['height'] = 120;
        //$config['create_thumb'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            
            $data = array('upload_data' => $upload_data);
            
            $profile_data = array(
                'user_id' => $this->ion_auth->get_user_id(),
                'photo' => $upload_data['file_name']
            );
            $profile_id = $this->basic_profile->get_profile_id();
            if ($profile_id > 0) {
                //update profile
                $this->basic_profile->update_profile($profile_data);
            }
            else {
                //insert profile for the first time
                $this->basic_profile->create_profile($profile_data);
            }
            $file_name = $upload_data['file_name'];
            //creating profile picture with 50x50 resolution
            $image_absolute_path = FCPATH.PROFILE_PICTURE_DISPLAY_PATH;
            if( !is_dir($image_absolute_path) )
            {
                mkdir($image_absolute_path, 0777, TRUE);
            }
            $config['image_library'] = 'gd2';
            $config['source_image'] =PROFILE_PICTURE_UPLOAD_PATH.$file_name;
            $config['new_image'] = PROFILE_PICTURE_DISPLAY_PATH.$file_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 50;
            $config['height'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            
            echo json_encode($data);
        }
    }
    
    function security_questions() {
        $question_sets = $this->security_question_library->get_all_security_questions();
        $user_id = $this->ion_auth->get_user_id();
        $question_answers = array();
        for($i = 1; $i <= sizeof($question_sets); $i++){
            $this->form_validation->set_rules('answer_'.$i , $this->lang->line('forgot_password_validation_email_label'), 'required');
            $question_answer = array('user_id' => $user_id ,'security_question_id' => $this->input->post('question_set_'.$i), 'answer' => $this->input->post('answer_'.$i));
            $question_answers[] = $question_answer;
        }
        //print_r($question_answers);
        if ($this->form_validation->run() == false) {
            $result_question_sets = array();
            foreach ($question_sets as $question_set) {
                $result_question_sets[] = $this->dataprovider_model->dropDownListWithSource($question_sets[0], "id", "description");
            }
            $this->data['question_sets'] = $result_question_sets;
            $this->template->load("templates/profile_setting_tmpl", "member/security_questions", $this->data);
        }
        else{
            
            $this->security_question_library->insert_security_answer($question_answers);
            redirect("register");
        }
        
        
    }
}