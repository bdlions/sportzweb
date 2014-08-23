<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_us extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/admin/footer/admin_about_us');
        $this->load->library('org/utility/Utils');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
        
        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';
        //$this->template->load("admin/templates/dashboard_tmpl", "admin/contact_us/topic_list", $this->data);
        $this->template->load(null, "admin/footer/contact_us/customers_feedback", $this->data);
    }
    
    public function create_topic()
    {
        $this->data['message'] = '';
        //$this->template->load("admin/templates/dashboard_tmpl", "admin/contact_us/topic_list", $this->data);
        $this->template->load(null, "admin/footer/contact_us/topic_list", $this->data);
    }
    
    public function create_os()
    {
        $this->data['message'] = '';
        //$this->template->load("admin/templates/dashboard_tmpl", "admin/contact_us/topic_list", $this->data);
        $this->template->load(null, "admin/footer/contact_us/operating_system_list", $this->data);
    }
    
    public function create_browser()
    {
        $this->data['message'] = '';
        //$this->template->load("admin/templates/dashboard_tmpl", "admin/contact_us/topic_list", $this->data);
        $this->template->load(null, "admin/footer/contact_us/browser_list", $this->data);
    }
}

