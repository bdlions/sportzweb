<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Photography extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');

        $this->load->helper('language');
        $this->load->helper('url');
        
        $this->load->library('org/application/photography_library');
        
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $image_array = $this->photography_library->get_all_images()->result_array();
        $this->data['image_list'] = $image_array;
        //echo '<pre/>';print_r($image_array);exit('here');
        $this->template->load(null,"applications/photography/home", $this->data);
    }
    
    
}

