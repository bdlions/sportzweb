<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class User_registration_login extends JsonRPCServer{
//class User_registration_login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model("dataprovider_model");
        $this->load->library("basic_profile");
        $this->load->library("org/interest/special_interest");
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('org/question/security_question_library');
        $this->load->library("org/rpc/user_rpc_library");
        $this->load->library("profile");
        $this->load->library('org/utility/Utils');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }

    function index() {
        
    }

    function getUserInfo() {
        
    }
    
    function userRegistration($data){
        //$data = json_decode('{"last_name":"sdfsd","password":"dsfds","email":"sdf","first_name":"sdf"}');
        return json_decode($data);
    }
    
    function getAllUsers() {
        $result = $this->user_rpc_library->getALlUsers()->result_array();
        //echo '<pre/>';echo json_encode($result);exit('here');
        //return json_encode($result);
        return '{
                "id": "1",
                "user": [
                  {
                    "id": "1",
                    "name": "Q1",
                    "email": "a@yahoo.com"
                  },
                  {
                    "id": "2",
                    "name": "emob",
                    "email": "ass@yahoo.com"
                  },
                  {
                    "id": "3",
                    "name": "ruton",
                    "noOfMsgs": "add@yahoo.com"
                  }
                ]
            }';
    }

}

?>
