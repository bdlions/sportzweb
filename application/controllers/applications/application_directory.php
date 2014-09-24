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
        
        
//        $this->load->view('test', $this->data);
        $app1 = array(
            'app_name' => 'FaceGGame',
            'desc' => 'Description description description description description description description description description description.',
            'summ' => '',
            'img1' => base_url()."resources/images/face.jpg",
            'img2' => base_url()."resources/images/face.jpg",
            'gal_img1' => base_url()."resources/images/face.jpg",
            'gal_img2' => base_url()."resources/images/face.jpg",
            'gal_img3' => base_url()."resources/images/face.jpg",
            'gal_img4' => base_url()."resources/images/face.jpg",
            'btn_state' => "Try it",
        );
        $app2 = array(
            'app_name' => 'abc',
            'desc' => 'desc',
            'summ' => '',
            'img1' => base_url()."resources/images/face.jpg",
            'img2' => base_url()."resources/images/face.jpg",
            'gal_img1' => base_url()."resources/images/face.jpg",
            'gal_img2' => base_url()."resources/images/face.jpg",
            'gal_img3' => base_url()."resources/images/face.jpg",
            'gal_img4' => base_url()."resources/images/face.jpg",
            'btn_state' => "Try it",
        );
        $app3 = array(
            'app_name' => 'abc',
            'desc' => 'desc',
            'summ' => '',
            'img1' => base_url()."resources/images/face.jpg",
            'img2' => base_url()."resources/images/face.jpg",
            'gal_img1' => base_url()."resources/images/face.jpg",
            'gal_img2' => base_url()."resources/images/face.jpg",
            'gal_img3' => base_url()."resources/images/face.jpg",
            'gal_img4' => base_url()."resources/images/face.jpg",
            'btn_state' => "Try it",
        );
        
        $app_data = array();
        $app_data[0] = $app1;
        $app_data[1] = $app2;
        $app_data[2] = $app3;
        
        $this->data['app_data'] = $app_data;
        $this->template->load(null, "applications/application_directory_view", $this->data);
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
