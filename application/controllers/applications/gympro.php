<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gympro extends Role_Controller{
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
        //$this->data['message'] = '';        
        //$this->template->load(null,'applications/gympro/index', $this->data);
        $this->manage_clients();
        
    }
    
    public function manage_clients()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/clients', $this->data);
        
    }
    
    public function manage_groups()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/groups', $this->data);
        
    }
    
    public function nutrition()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/nutrition', $this->data);
    }
    
    public function program()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/program', $this->data);
    }
    /*
     * This method will load account info of a client
     * @Author Nazmul on 17th November 2014
     */
    public function account()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/account', $this->data);
    }
    /*
     * This method will load preference info of a client
     * @Author Nazmul on 17th November 2014
     */
    public function preference()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/preference', $this->data);
    }
}

