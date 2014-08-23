<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bmi_calculator extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');

        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('org/application/bmi_calculator_library');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        
        $this->load->library('visitors');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $homepage_data = $this->bmi_calculator_library->get_homepage_question_list_configuration();
        $this->data['questions_list'] = $homepage_data['question_list'];
        $this->data['show_advertise'] = $homepage_data['show_advertise'];
        $this->template->load(null, "applications/bmi_calculator/bmi_home_view", $this->data);
    }
    
    
}

