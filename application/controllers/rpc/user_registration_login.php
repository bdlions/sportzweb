<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';
class User_registration_login extends JsonRPCServer{
//class User_registration_login extends CI_Controller{
     function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model("dataprovider_model");
        $this->load->library("basic_profile");
        $this->load->library("org/interest/special_interest");
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('org/question/security_question_library');
        $this->load->library("org/profile/business/business_profile_library");
        $this->load->library("profile");
        $this->load->library('org/utility/Utils');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
     }

     function index(){
       
     }
     function getUserInfo(){
         
     }
}
?>
