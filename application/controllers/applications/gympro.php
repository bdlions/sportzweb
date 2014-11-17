<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gympro extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('org/application/gympro_library');
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
    //----------------------------------- Client Module --------------------------------//
    public function manage_clients()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/client/clients', $this->data);
        
    }
    
    public function create_client()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/gympro/client/create_client', $this->data);
    }
    //----------------------------------- Group Module ---------------------------------//
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
    public function account($client_id = 0)
    {        
        $account_type_list = array();
        $account_types_array = $this->gympro_library->get_all_account_types()->result_array();
        foreach($account_types_array as $account_type)
        {
            $account_type_list[$account_type['account_type_id']] =  $account_type['title'];
        }
        $this->data['account_type_list'] = $account_type_list;  
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

