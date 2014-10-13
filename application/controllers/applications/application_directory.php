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
        $this->load->library('org/application/application_directory_library');
        
        $this->load->library('visitors');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $user_application_id_list = $this->application_directory_library->get_user_application_id_list($user_id);
        $application_list = $this->application_directory_library->get_all_applications();
        $app_data = array();
        foreach($application_list as $application)
        {
            $application['summary'] = html_entity_decode(html_entity_decode($application['summary']));
            if(in_array($application['id'], $user_application_id_list))
            {
                $application['is_removed'] = 1;
            }
            else
            {
                $application['is_removed'] = 0;
            }
            $application['btn_state'] = "Try it";  
            $app_data[$application['id']] = $application;
        }
        $this->data['app_data'] = $app_data;
        $this->template->load(null, "applications/directory/index", $this->data);
    }
    
    public function test()
    {
        //dummy array... load data into app_data[] 2d array dynamically.
        $app1 = array(
            'app_name' => 'FaceGGame',
            'desc' => 'Description description description description description description description description description description.',
            'summ' => '',
            'img1' => base_url()."resources/images/photo.jpg",
            'img2' => base_url()."resources/images/face.jpg",
            'gal_img1' => base_url()."resources/images/face.jpg",
            'gal_img2' => base_url()."resources/images/event.jpg",
            'gal_img3' => base_url()."resources/images/map.jpg",
            'gal_img4' => base_url()."resources/images/shop.jpg",
            'btn_state' => "Try it",
        );
        $app2 = array(
            'app_name' => 'second app',
            'desc' => 'desc',
            'summ' => '',
            'img1' => base_url()."resources/images/golf.jpg",
            'img2' => base_url()."resources/images/face.jpg",
            'gal_img1' => base_url()."resources/images/map.jpg",
            'gal_img2' => base_url()."resources/images/face.jpg",
            'gal_img3' => base_url()."resources/images/face.jpg",
            'gal_img4' => base_url()."resources/images/face.jpg",
            'btn_state' => "Try it",
        );
        $app3 = array(
            'app_name' => 'map',
            'desc' => 'desc',
            'summ' => '',
            'img1' => base_url()."resources/images/map.jpg",
            'img2' => base_url()."resources/images/face.jpg",
            'gal_img1' => base_url()."resources/images/face.jpg",
            'gal_img2' => base_url()."resources/images/map.jpg",
            'gal_img3' => base_url()."resources/images/face.jpg",
            'gal_img4' => base_url()."resources/images/face.jpg",
            'btn_state' => "Try it",
        );
        
        $app_data = array();
        $app_data[0] = $app1;
        $app_data[1] = $app2;
        $app_data[2] = $app3;
        
        //dummy array end ^^.
        
        
        
        
        
        
//        $length = sizeof($app_data);
//        
//        $this->data['app_data1'] = array_slice($app_data, 0, $length/2);
//        $this->data['app_data2'] = array_slice($app_data, $length/2, $length);
        $this->data['app_data'] = $app_data;
        $this->template->load(null, "applications/application_directory_view", $this->data);
    }
    
    /*
     * This method will add an application under a user
     * @Author Nazmul on 20th September 2014
     */
    public function add_application_to_user()
    {
        $app_id = $this->input->post('app_id');
        $user_id = $this->session->userdata('user_id');
        $this->application_directory_library->add_user_application($app_id, $user_id);
        $result = array(
            'message' => 'Application is added successfully'
        );
        echo json_encode($result);
    }
    
    /*
     * This method will remove an application from a user
     * @Author Nazmul on 20th September 2014
     */
    public function remove_application_from_user()
    {
        $app_id = $this->input->post('app_id');
        $user_id = $this->session->userdata('user_id');
        $this->application_directory_library->remove_user_application($app_id, $user_id);
        $result = array(
            'message' => 'Application is removed successfully'
        );
        echo json_encode($result);
    }
    
    
}

