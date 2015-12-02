<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Business_profile extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("org/profile/business/business_profile_library");
        $this->load->library('org/utility/Utils');
        $this->load->library("profile");
        $this->load->library("statuses");
        $this->load->library("basic_profile");
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->load->model("dataprovider_model");
        $this->load->library("users_album");
        $this->load->library("visitors");
        

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            //redirect('auth/login', 'refresh');
        }

    }

    function index() {

        if ($this->input->post('login_btn') != null) {
            //validate login form
            $this->form_validation->set_rules('identity', 'Identity', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
        } elseif ($this->input->post('recaptcha_response_field') != null) {
            //validate register form
            $this->form_validation->set_rules('r_first_name', 'First Name', 'required');
            $this->form_validation->set_rules('r_last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('r_email', 'Email', 'required');
            $this->form_validation->set_rules('r_email_conf', 'Email confirm', 'required|matches[r_email]');
            $this->form_validation->set_rules('r_password', 'Password', 'required');
            //$this->form_validation->set_rules('r_captcha_input', 'Security code', 'required|callback_captcha_check');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            //setting all values for all forms of this page
            //setting the filled values also
            //login form values
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'tabindex' => '1',
                'placeholder' => 'Enter Email',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'maxlength' => '20',
                'tabindex' => '2',
                'placeholder' => 'Enter Password',
            );
            $this->data['forget_password'] = array('name' => 'forget_password',
                'id' => 'forget_password',
                'type' => 'forget_password',
                'tabindex' => '3',
                'style' => 'font-size:9px;-webkit-text-size-adjust: none; color:#073A47;'
            );
            $this->data['login_btn'] = array('name' => 'login_btn',
                'id' => 'login_btn',
                'type' => 'submit',
                'tabindex' => '4',
                'value' => 'Sign in',
            );

            /*             * ****************registration form values******************** */
            $this->data['r_first_name'] = array(
                'name' => 'r_first_name',
                'id' => 'r_first_name',
                'type' => 'text',
                'placeholder' => lang('create_user_fname_label'),
                'value' => $this->form_validation->set_value('r_first_name'),
            );
            $this->data['r_last_name'] = array(
                'name' => 'r_last_name',
                'id' => 'r_last_name',
                'type' => 'text',
                'placeholder' => lang('create_user_lname_label'),
                'value' => $this->form_validation->set_value('r_last_name'),
            );
            $this->data['r_email'] = array(
                'name' => 'r_email',
                'id' => 'r_email',
                'type' => 'text',
                'placeholder' => lang('create_user_email_label'),
                'value' => $this->form_validation->set_value('r_email'),
            );
            $this->data['r_email_conf'] = array(
                'name' => 'r_email_conf',
                'id' => 'r_email_conf',
                'type' => 'text',
                'placeholder' => lang('create_user_confirm_email_label'),
                'value' => $this->form_validation->set_value('r_email_conf'),
            );

            $this->data['r_password'] = array(
                'name' => 'r_password',
                'id' => 'r_password',
                'type' => 'password',
                'placeholder' => lang('create_user_password_label'),
                'value' => $this->form_validation->set_value('r_password'),
            );

            /*$this->data['r_captcha_input'] = array(
                'name' => 'r_captcha_input',
                'id' => 'r_captcha_input',
                'type' => 'text',
                'value' => $this->form_validation->set_value('r_captcha_input'),
            );*/

            $this->data['next_btn'] = array('name' => 'next_btn',
                'id' => 'next_btn',
                'type' => 'submit',
                'tabindex' => '4',
                'value' => 'Join Now',
            );

            $this->data['register_btn'] = array('name' => 'register_btn',
                'id' => 'register_btn',
                'type' => 'submit',
                'value' => 'Confirm',
            );
            $recaptch_config = $this->config->item('recaptcha');
            $this->data['public_key'] = $recaptch_config['public_key'];
            /*****************registration form values completed******************** */

            if (!$this->ion_auth->logged_in()) {
                if ($this->input->post('login_btn') != null) {
                    $this->session->set_flashdata('message', $this->data['message']);
                    redirect('auth/login_wrong_attempt', 'refresh');
                    //$this->template->load(WRONG_ATTEMPT_TEMPLATE, WRONG_ATTEMPT_VIEW, $this->data);
                } else {
                    $this->template->load("templates/profile_setting_tmpl", "business_man/registration/register", $this->data);
                }
            } else {
                redirect("auth");
            }
        } elseif ($this->input->post('login_btn') != null) {
            //check to see if the user is logging in
            //check for "remember me"
            $remember = FALSE;

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                if (!$this->ion_auth->is_user_type(BUSINESSMAN)) {
                    $this->ion_auth->add_to_group('2');
                    redirect('auth/', 'refresh');
                }else{
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('auth/', 'refresh');
                }
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                //redirect('auth/login', 'refresh');
                redirect('auth/login_wrong_attempt', 'refresh');
            }
        } elseif ($this->input->post('recaptcha_response_field') != null) {
            $username = strtolower($this->input->post('r_first_name')) . ' ' . strtolower($this->input->post('r_last_name'));
            $email = $this->input->post('r_email');
            $password = $this->input->post('r_password');

            $additional_data = array(
                'first_name' => $this->input->post('r_first_name'),
                'last_name' => $this->input->post('r_last_name')
            );
            if ($this->ion_auth->register($username, $password, $email, $additional_data, array('2', '3'))) {
                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
            } else {
                $this->session->set_flashdata('message', "Unsuccessful to register a user.");
            }
            $this->data['message'] = $this->session->flashdata('message');
            //redirect("auth/login", 'refresh');
            $this->template->load("templates/profile_setting_tmpl", "display_message", $this->data);
        }
    }
    function create_profile(){
        $data = $this->input->post();
        $data = $data + array('user_id'=> $this->ion_auth->get_user_id(), 'business_profile_type' => $this->input->post("business_profile_types"), 'business_profile_sub_type' => $this->input->post('sub_type_list'));
        if ($this->business_profile_library->get_profile_id() > 0) {
            echo $this->business_profile_library->update_profile($data);
        } else {
            echo $this->business_profile_library->create_business_profile($data);
        }
        
    }
    
    function update_business_descripton(){
        echo $this->business_profile_library->update_profile($this->input->post());
    }
    function upload_logo(){
        $result = array();
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, BUSINESS_PROFILE_LOGO_PATH);   
            if($result['status'] == 1)
            {
                $profile_data = array(
                    'user_id' => $this->ion_auth->get_user_id(),
                    'logo' => $result['upload_data']['file_name']
                );
                $profile_id = $this->business_profile_library->get_profile_id();
                if ($profile_id > 0) {
                    //update profile
                    $this->business_profile_library->update_profile($profile_data);
                }
                else {
                    //insert profile for the first time
                    $this->business_profile_library->create_profile($profile_data);
                }
            }
            echo json_encode($result);
        } 
        
        
        /*$config['image_library'] = 'gd2';
        $config['upload_path'] = './resources/uploads/business/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10240';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 120;
        $config['height'] = 120;
        $config['create_thumb'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            
            $data = array('upload_data' => $upload_data);
            
            $profile_data = array(
                'user_id' => $this->ion_auth->get_user_id(),
                'logo' => $upload_data['file_name']
            );
            $profile_id = $this->business_profile_library->get_profile_id();
            if ($profile_id > 0) {
                //update profile
                $this->business_profile_library->update_profile($profile_data);
            }
            else {
                //insert profile for the first time
                $this->business_profile_library->create_profile($profile_data);
            }
            echo json_encode($data);
        }*/
    }
    
     function upload_cover_photo(){
        $result = array();
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, BUSINESS_PROFILE_COVER_PHOTO_PATH);   
            if($result['status'] == 1)
            {
                //$path = BUSINESS_PROFILE_COVER_PHOTO_PATH.$result['upload_data']['file_name'];
                //$resize_result = $this->utils->resize_image($path, $path, BUSINESS_PROFILE_COVER_PHOTO_MAX_HEIGHT, BUSINESS_PROFILE_COVER_PHOTO_MAX_WIDTH);
                $profile_data = array(
                    'user_id' => $this->ion_auth->get_user_id(),
                    'cover_photo' => $result['upload_data']['file_name']
                );
                $profile_id = $this->business_profile_library->get_profile_id();
                if ($profile_id > 0) {
                    //update profile
                    $this->business_profile_library->update_profile($profile_data);
                }
                else {
                    //insert profile for the first time
                    $this->business_profile_library->create_profile($profile_data);
                }
            }
            echo json_encode($result);
        }         
         
        /*$config['image_library'] = 'gd2';
        $config['upload_path'] = './resources/uploads/business/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10240';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 120;
        $config['height'] = 120;
        $config['create_thumb'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            
            $data = array('upload_data' => $upload_data);
            
            $profile_data = array(
                'user_id' => $this->ion_auth->get_user_id(),
                'cover_photo' => $upload_data['file_name']
            );
            $profile_id = $this->business_profile_library->get_profile_id();
            if ($profile_id > 0) {
                //update profile
                $this->business_profile_library->update_profile($profile_data);
            }
            else {
                //insert profile for the first time
                $this->business_profile_library->create_profile($profile_data);
            }
            echo json_encode($data);
        }*/
    }
    
    public function show($business_profile_id = 0){
        $user_id = $this->session->userdata('user_id');
        if($business_profile_id == 0)
        {            
            $this->data['profile'] = $this->business_profile_library->get_profile_info($user_id);
            $business_profile_id = $this->data['profile']->business_profile_id;
        }
        else
        {
            
            $this->data['profile'] = $this->business_profile_library->get_business_profile_info($business_profile_id);
        }
        
        $this->data['newsfeeds'] = $this->statuses->get_statuses(STATUS_LIST_BUSINESS_PROFILE, $business_profile_id);
        $this->data['status_list_id'] = STATUS_LIST_BUSINESS_PROFILE;
        $this->data['mapping_id'] = $business_profile_id;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        
        //print_r($this->profile->get_profile_info());
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        $this->data['myself'] = $this->basic_profile->get_profile_info();
        
        $this->data['user_id'] = $this->ion_auth->get_user_id();
        if($user_id){
            $this->data['user_id'] = $user_id;
        }
        
        $this->data['status_or_comment_in'] = STATUS_POSTED_IN_BUSINESS_PROFILE;
        $this->data['last_uploaded_photo'] = $this->users_album->get_last_uploaded_photo(1, $user_id);
        $this->data['user_connection'] = $this->business_profile_library->get_total_business_connections($business_profile_id);
        
        //$visit_success = $this->visitors->store_business_profile_visitor($business_profile_id);
        $this->template->load(null, "business_man/profile/show", $this->data);
    }
    public function update(){
        $this->data['profile'] = $this->profile->get_profile_info();
        //print_r($this->profile->get_profile_info());
        
        $this->template->load(null, "business_man/profile/edit", $this->data);
    }
    
    /*
     * Ajax call to store business profile connection
     * This method will store business profile connection if there is no connection before
     * This mehtod will return total connections of this business profile
     */
    public function store_business_profile_connection()
    {
        $business_profile_id = $_POST['business_profile_id'];
        //$business_profile_id = 2;
        $user_id = $this->session->userdata('user_id');
        
        $length = $this->business_profile_library->store_business_profile_connection($business_profile_id,$user_id);
        
        echo $length;
    }
}
?>