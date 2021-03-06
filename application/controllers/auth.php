<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Role_Controller{
    private $captcha_params;

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('recaptcha');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("statuses");
        $this->load->library("org/profile/business/business_profile_library");
        $this->load->library("basic_profile");
        $this->load->library("newsfeed");
        $this->load->library("follower");
        $this->load->library("visitors");
        $this->load->library("recent_activities");
        $this->load->library("trending_features");
        $this->load->library("user_logs");
        $this->load->library('org/application/application_directory_library');
        $this->load->library('org/utility/Utils');
        $this->load->library('org/configure/login_page_library');
        $this->load->library('org/configure/logout_page_library');
        $this->load->library('org/question/security_question_library');
        $this->load->model("dataprovider_model");

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

        $this->captcha_params = array(
            'img_path' => './resources/captcha/',
            'img_url' => base_url() . 'resources/captcha/',
            'img_width' => '200',
            'img_height' => 40,
            'font_path' => './resources/font/texb.ttf',
            'expiration' => 7200
        );
    }

    function index() 
    {
        if (!$this->ion_auth->logged_in()) 
        {
            redirect('auth/login', 'refresh');
        } 
        else 
        {
            if ($this->ion_auth->is_user_type(ADMIN)) 
            {
                //configuring the member profile for the admin
                if($this->basic_profile->get_profile_id() <= 0){
                    redirect("register");
                }
                //admin is loggin as a member
                $this->ion_auth->set_current_user_type(MEMBER);
            } 
            elseif ($this->ion_auth->is_user_type(BUSINESSMAN) || $this->ion_auth->is_user_type(MEMBER)) 
            {
                if($this->basic_profile->get_profile_id() <= 0)
                {
                    redirect("register");
                }
                else if($this->business_profile_library->get_profile_id() <= 0 && $this->ion_auth->is_user_type(BUSINESSMAN))
                {
                    redirect("register/business_profile");
                }
                //setting current user type as member
                $this->ion_auth->set_current_user_type(MEMBER);
            }
            $user_id = $this->ion_auth->get_user_id();
            $this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');
            $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
            $this->data['newsfeeds'] = $this->statuses->get_statuses();
            $this->data['followers'] = $this->follower->get_user_followers();
            $this->data['user_info'] = $this->ion_auth->get_user_info();
            $this->data['user_id'] = $user_id;
            $this->data['current_user_id'] = $user_id;
            //status posted at newsfeed will be displayed at member profile
            $this->data['status_list_id'] = STATUS_LIST_USER_PROFILE;
            $this->data['mapping_id'] = $user_id;
            $this->data['recent_activities'] = $this->recent_activities->get_recent_activites();
            $this->data['popular_trends'] = $this->trending_features->get_popular_trends()->result_array();
            $this->data['app_id_list'] = $this->application_directory_library->get_user_application_id_list($user_id);
            $this->data['applications_info'] = $this->application_directory_library->get_all_applications();
            $visit_success = $this->visitors->store_page_visitor(VISITOR_PAGE_NEWSFEED_ID);
            $this->template->load(null, MEMBER_LOGIN_SUCCESS_VIEW, $this->data);
        }
    }
    
    /*
     * This method will load the login page
     * @author nazmul hasan
     */
    function login() {

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
        }

        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            if (!$this->ion_auth->logged_in()) {
                if ($this->input->post('login_btn') != null) {
                    $this->session->set_userdata('identity', $this->input->post('identity'));
                    $this->session->set_flashdata('message', $this->data['message']);
                    redirect('auth/login_wrong_attempt', 'refresh');
                }
            } else {
                redirect('auth', 'refresh');
            }
          
            //We have used twitter background image list for login page instead of this logic
            /*$this->data['current_configuration'] = array();
            $current_date = $this->utils->get_current_date_yyyymmdd();
            $current_configuration = $this->login_page_library->get_current_configuration($current_date)->result_array();
            if(!empty($current_configuration))
            {
                $this->data['current_configuration'] = $current_configuration[0];
            }*/
            $image_list = array();
            $background_image_list_array = $this->login_page_library->get_login_page_background_image_list()->result_array();
            foreach($background_image_list_array as $image_info)
            {
                $image_list[] = $image_info['img'];
            }
            $this->data['image_list'] = $image_list;
            //login form values
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'tabindex' => '1',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'maxlength' => '20',
                'tabindex' => '2',
            );
            $this->data['forget_password'] = array('name' => 'forget_password',
                'id' => 'forget_password',
                'type' => 'forget_password',
                'tabindex' => '3',
            );
            $this->data['login_btn'] = array('name' => 'login_btn',
                'id' => 'login_btn',
                'type' => 'submit',
                'tabindex' => '4',
                'value' => 'Sign in',
            );

            /******************registration form values******************** */
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
            $this->template->load(NULL, LOGIN_VIEW, $this->data);
        } elseif ($this->input->post('login_btn') != null) {
            $remember = FALSE;
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //login is successful
                $date = date('Y-m-d');
                $this->user_logs->store_user_log(0,$date);
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('auth', 'refresh');
            } else {
                //login is unsuccessful so redirecting to wrong login attempt page
                $this->session->set_userdata('identity', $this->input->post('identity'));
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login_wrong_attempt', 'refresh');
            }
        } elseif ($this->input->post('recaptcha_response_field') != null) {
            $username = strtolower($this->input->post('r_first_name')) . ' ' . strtolower($this->input->post('r_last_name'));
            $email = $this->input->post('r_email');
            $password = $this->input->post('r_password');

            $additional_data = array(
                'first_name' => $this->input->post('r_first_name'),
                'last_name' => $this->input->post('r_last_name'),
            );
            if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
            } else {
                //registration is unsuccessful
                $this->session->set_flashdata('message', "Unsuccessful to register a user.");
                redirect("auth/login", 'refresh');
            }            
            $this->data['message'] = $this->session->flashdata('message');
            $this->template->load("templates/profile_setting_tmpl", "display_message", $this->data);
        }
    }
    
    //log the user out
    function logout() {
        $this->data['title'] = "Logout";
        $this->user_logs->update_user_log_by_logout();
        //log the user out
        $logout = $this->ion_auth->logout();
        
        //validate login form
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            //setting all values for all forms of this page
            //setting the filled values also
            $this->data['current_configuration'] = array();
            $current_date = $this->utils->get_current_date_yyyymmdd();
            $current_configuration = $this->logout_page_library->get_current_configuration($current_date)->result_array();
            if(!empty($current_configuration))
            {
                $this->data['current_configuration'] = $current_configuration[0];
            }
            //login form values
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'tabindex' => '1',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'maxlength' => '20',
                'tabindex' => '2',
            );
            $this->data['forget_password'] = array('name' => 'forget_password',
                'id' => 'forget_password',
                'type' => 'forget_password',
                'tabindex' => '3',
            );
            $this->data['login_btn'] = array('name' => 'login_btn',
                'id' => 'login_btn',
                'type' => 'submit',
                'tabindex' => '4',
                'value' => 'Sign in',
            );
        }
        
        
        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        $this->template->load("templates/logout_tmpl","logout", $this->data);
        //redirect('auth/login', 'refresh');
    }

    public function get_captcha_code() {
        echo recaptcha();
        /*$captcha = create_captcha($this->captcha_params);
        $this->session->set_userdata('captchaword', $captcha['word']);
        echo $captcha['image'];*/
    }

    public function captcha_check() {
        $recaptch_config = $this->config->item('recaptcha');            
        $privatekey = $recaptch_config['private_key'];
        $word_verification = recaptcha_check_answer($privatekey, $this->input->server("REMOTE_ADDR"), $this->input->post("recaptcha_challenge_field"), $this->input->post("recaptcha_response_field"));
        return $word_verification->is_valid;
        
        
        /*if (strtolower($this->session->userdata('captchaword')) != strtolower($captcha_val)) {
            $this->form_validation->set_message('captcha_check', lang('captcha_error_msg'));
            return FALSE;
        } else {
            return TRUE;
        }*/
    }

    public function captcha_check_client() {
        $recaptch_config = $this->config->item('recaptcha');            
        $privatekey = $recaptch_config['private_key'];
        $word_verification = recaptcha_check_answer($privatekey, $this->input->server("REMOTE_ADDR"), $this->input->post("recaptcha_challenge_field"), $this->input->post("recaptcha_response_field"));
        echo json_encode($word_verification);
        //echo $this->captcha_check();        
        /*$captcha_val = $this->input->post('captcha_val');
        if ($this->captcha_check($captcha_val) == TRUE) {
            echo TRUE;
        } else {
            $captcha = create_captcha($this->captcha_params);
            $this->session->set_userdata('captchaword', $captcha['word']);
            echo $captcha['image'];
        }*/
    }

    public function register_client() {
        $username = strtolower($this->input->post('r_first_name')) . ' ' . strtolower($this->input->post('r_last_name'));
        $email = $this->input->post('r_email');
        $password = $this->input->post('r_password');

        $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name')
        );
        if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
            //check to see if we are creating the user
            //redirect them back to the admin page
            echo true;
        } else {
            echo false;
        }
    }
    function check_email_client(){
        $return = "false";
        if( $this->input->post("r_email") == null && $this->input->post("email") == NULL){
            echo $return;
        }
        else if( $this->input->post("email") != null){
            $this->ion_auth->email_check($this->input->post("email")) >= 1 ? $return = "false": $return = "true";
        }
        else if( $this->input->post("r_email") != null ){
            $this->ion_auth->email_check($this->input->post("r_email")) >= 1 ? $return = "false": $return = "true";
        }
        echo $return;
    }

    function login_wrong_attempt() {
        $identity = "";
        if($this->session->userdata('identity') !== FALSE && $this->session->userdata('identity') != "")
        {
            $identity = $this->session->userdata('identity');
            $this->session->unset_userdata('identity');
        }
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['identity'] = array('name' => 'identity',
            'id' => 'identity',
            'type' => 'text',
            'tabindex' => '1',
            'value' => $identity
        );
        $this->data['password'] = array('name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'tabindex' => '2',
            'value' => ""
        );

        $this->data['forget_password'] = array('name' => 'forget_password',
            'id' => 'forget_password',
            'type' => 'forget_password',
            'tabindex' => '3'
        );
        $this->data['login_btn'] = array('name' => 'login_btn',
            'id' => 'login_btn',
            'type' => 'submit',
            'tabindex' => '4',
            'value' => 'Sign In',
        );
        $this->template->load(WRONG_ATTEMPT_TEMPLATE, WRONG_ATTEMPT_VIEW, $this->data);
    }

    //change password
    function change_password() {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            //render
            $this->_render_page('auth/change_password', $this->data);
        } else {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    //forgot password
    function forgot_password() {
        $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required');
        if ($this->form_validation->run() == false) {
            //setup the input
            $this->data['email'] = array('name' => 'email',
                'id' => 'email',
            );

            $question_sets = $this->security_question_library->get_all_security_questions();
            
            $this->data['questions'] = $this->dataprovider_model->dropDownListWithSource($question_sets [ 0 ], "id", "description");
            
            if ($this->config->item('identity', 'ion_auth') == 'username') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            //$this->_render_page('auth/forgot_password', $this->data);
            $this->template->load("templates/profile_setting_tmpl", 'auth/forgot_password', $this->data);
        } else {
            // get identity for that email
            $config_tables = $this->config->item('tables', 'ion_auth');
            $identity = $this->db->where('email', $this->input->post('email'))->limit('1')->get($config_tables['users'])->row();

            if(count($identity)){
                $answers[] = array('question_id' => $this->input->post('question'), 'answer' => $this->input->post('answer'));
                $correct = $this->security_question_library->is_answer_correct($identity->id, $answers);
                

                if($correct){
                    $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
                    if($forgotten){
                        //if there were no errors
                        //$this->session->set_flashdata('message', $this->ion_auth->messages());
                        $this->data['message'] = $this->ion_auth->messages();
                        $this->template->load("templates/profile_setting_tmpl", "message" , $this->data);
                    }
                    else{
                        $this->session->set_flashdata('message', $this->ion_auth->errors(). "Try again!.");
                        redirect("auth/forgot_password", 'refresh');
                    }
                    
                }
                else{
                    $this->session->set_flashdata('message', $this->security_question_library->errors());
                    redirect("auth/forgot_password", 'refresh');
                }
            }
            else {
                $this->session->set_flashdata('message', $this->lang->line('invalid_email_address'));
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    //reset password - final step for forgotten password
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            //if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                //display the form
                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                //render
                //$this->_render_page('auth/reset_password', $this->data);
                $this->template->load("templates/profile_setting_tmpl", "auth/reset_password", $this->data);
                        
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/logout");
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //activate the user
    function activate($id, $code = false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("register/security_questions", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL) {
        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->_render_page('auth/deactivate_user', $this->data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            //redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    //create a new user
    function create_user() {
        $this->data['title'] = "Create User";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|xss_clean');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required|xss_clean');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data)) {
            //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

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
            $this->data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->_render_page('auth/create_user', $this->data);
        }
    }

    //edit a user
    function edit_user($id) {
        $this->data['title'] = "Edit User";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required|xss_clean');
        $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );

            //Update the groups user belongs to
            $groupData = $this->input->post('groups');

            if (isset($groupData) && !empty($groupData)) {

                $this->ion_auth->remove_from_group('', $id);

                foreach ($groupData as $grp) {
                    $this->ion_auth->add_to_group($grp, $id);
                }
            }

            //update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE) {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', "User Saved");
                redirect("auth", 'refresh');
            }
        }

        //display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );

        $this->_render_page('auth/edit_user', $this->data);
    }

    // create a new group
    function create_group() {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('description', $this->lang->line('create_group_validation_desc_label'), 'xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else {
            //display the create group form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );

            $this->_render_page('auth/create_group', $this->data);
        }
    }

    //edit a group
    function edit_group($id) {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['group'] = $group;

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->_render_page('auth/edit_group', $this->data);
    }

    function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
                $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function _render_page($view, $data = null, $render = false) {

        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $render);

        if (!$render)
            return $view_html;
    }

}