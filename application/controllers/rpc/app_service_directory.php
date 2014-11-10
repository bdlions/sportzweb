<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_service_directory extends JsonRPCServer {
//class App_service_directory extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/service_directory_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    /*
     * This method will return all service categories
     * @Author Nazmul on 10th November 2014
     */
    function get_all_service_categories()
    {
        $response = array();  
        $service_category_list = array();
        $service_category_list_array = $this->service_directory_library->get_all_service_categories()->result_array();
        foreach($service_category_list_array as $service_category_info)
        {
            $service_category = array(
                'id' => $service_category_info['id'],
                'title' => $service_category_info['description']
            );
            $service_category_list[] = $service_category;
        }
        $response['service_category_list'] = $service_category_list;
        //echo (json_encode($response));
        return json_encode($response);
    }
}