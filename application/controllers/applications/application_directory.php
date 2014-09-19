<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Application_directory extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');

        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('ion_auth');
        
        $this->load->library('visitors');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';
        $this->template->load(null, "applications/directory/index", $this->data);
    }
    
    /*
     * This method will add an application under a user
     * @Author Nazmul on 20th September 2014
     */
    public function add_application_to_user()
    {
        
    }
    
    /*
     * This method will remove an application from a user
     * @Author Nazmul on 20th September 2014
     */
    public function remove_application_from_user()
    {
        
    }
    
    
}

