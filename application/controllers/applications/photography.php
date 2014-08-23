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
        //$bg = array("01-02-2014"=>'1.jpg', "02-02-2014"=>'2.jpg', "03-02-2014"=>'3.jpg', "04-02-2014"=>'4.jpg', "05-02-2014"=>'5.jpg'); // array of filenames
        $bg = array('a.jpg', 'b.jpg', 'c.jpg','d.jpg','e.jpg');
        //print_r($bg);
        //$i = rand(0, count($bg)-1); // generate random number size of the array
        //$selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
        $this->data['bg_image'] = $bg;
        $this->template->load(null,"applications/photography/home", $this->data);
    }
    
    
}

