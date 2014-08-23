<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
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
        
    }
    
    public function restriction_view()
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/restriction_view", $this->data);
    }
    
    public function restriction_access()
    {
        $this->data['message'] = '';
        $this->template->load(null, "admin/restriction_access", $this->data);
    }
}

