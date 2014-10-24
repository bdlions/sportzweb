<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Score_prediction extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->helper('url');
        
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';
        $this->template->load(null,"applications/score_prediction/index", $this->data);
    }
    
    
}

