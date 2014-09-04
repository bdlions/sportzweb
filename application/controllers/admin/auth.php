<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Role_Controller{
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

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->helper('language');
    }

    function index() {
        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('admin/auth/login', 'refresh');
        } else {
            //if ($this->ion_auth->is_user_type(ADMIN)) {
            //    redirect('admin/overview_show','refresh');
            //}
            redirect('admin/overview_show','refresh');
        }
    }
    
    function login() {

        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->input->post('login_btn') != null) 
        {
            if ($this->form_validation->run() === TRUE) 
            {
                $remember = FALSE;
                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('admin/auth/home','refresh');
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('admin/auth/login', 'refresh');
                }
            }
        }
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['identity'] = array('name' => 'identity',
            'id' => 'identity',
            'name' => 'identity',
            'type' => 'text',
            'tabindex' => '1',
            'value' => $this->form_validation->set_value('identity'),
        );
        $this->data['password'] = array('name' => 'password',
            'id' => 'password',
            'name' => 'password',
            'type' => 'password',
            'maxlength' => '20',
            'tabindex' => '2',
        );
        $this->data['login_btn'] = array('name' => 'login_btn',
            'id' => 'login_btn',
            'name' => 'login_btn',
            'type' => 'submit',
            'tabindex' => '3',
            'value' => 'Sign in',
        );
        $this->template->load("admin/templates/login_tmpl", "admin/login", $this->data);   
    }
    
    //log the user out
    function logout() {
        $this->data['title'] = "Logout";
        
        //log the user out
        $logout = $this->ion_auth->logout();
        redirect('admin/auth/login','refresh');
        
    }
    
    public function home()
    {
        $tmpl = '';
        $this->data['message'] = "Welcome";
        $selected_user_group = $this->session->userdata('user_type');
        if(isset($selected_user_group ) && $selected_user_group != ""){
            $this->user_group_array = array($selected_user_group);
        }
        else
        {
            $this->user_group_array = $this->ion_auth->get_current_user_types();
        } 
        if (in_array(ADMIN, $this->user_group_array)) {
            $tmpl = ADMIN_DASHBOARD_TEMPLATE;
        }
        else
        {
            $tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
        }
        $this->template->load($tmpl, "admin/home", $this->data);
    }
}