<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_bmi_calculator extends JsonRPCServer {
//class App_bmi_calculator extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/bmi_calculator_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    public function get_bmi_question_list()
    {
        $response = array();
        $homepage_data = $this->bmi_calculator_library->get_homepage_question_list_configuration();
        $response['question_list'] = $homepage_data['question_list'];
        //echo json_encode($response);
        return json_encode($response);
    }    

}