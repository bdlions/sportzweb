<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class User_registration_login extends JsonRPCServer {

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

    function userRegistration($data) {
        //$data = json_decode('{"last_name":"sdfsd","password":"dsfds","email":"sdf","first_name":"sdf"}');
        /* $data = array(
          'first_name' => $data->first_name,
          'last_name' => $data->last_name,
          'email' => $data->email,
          'password' => $data->password,
          'account_status_id' =>1,
          'created_on' => now()
          );

          if (!$this->user_rpc_library->checkEmail($data->email)) {
          if ($this->user_rpc_library->user_registration($data))
          $msg = "SIGNUP_COMPLETED";
          else
          $msg = "SIGNUP_FAILD_PLEASE_TRY_AGAIN";
          } else {
          $msg = "EMAIL_ALREADY_EXIST";
          }
          $output = array(
          'msg' => $msg
          );

          json_encode($output); */
        json_decode($data);
    }

    function getAllUsers() {
        $result = $this->user_rpc_library->getALlUsers()->result_array();
        //echo '<pre/>';echo json_encode($result);exit('here');
        return json_encode($result);
    
    }

    // signin 
    public function signin($email = "", $password = "") {
        $accessToken = "";
        $id = "";
        if ($this->user_rpc_library->checkEmail(trim($email))) {

            $result = $this->user_rpc_library->signin($email, $password);
            if ($result != "ZERO") {
                $msg = "SIGNIN_SUCCESSFULLY";
                $id = $result->id;
                $email = $result->email;

                $accessToken = $this->api_model->generateAccessToken($id);
                if ($accessToken == FALSE) {
                    $msg = "SERVER_BUSY_PLEASE_TRY_AGAIN";
                    $id = "";
                    $email = "";
                    $accessToken = "";
                }
            } else {
                $msg = "EMAIL_AND_PASSWORD_DOES_NOT_MATCH";
            }
        } else {
            $msg = "EMAIL_NOT_EXIST";
        }

        $output = array(
            'msg' => $msg,
            'id' => $id,
            'accessToken' => "" . $accessToken,
            'email' => $email
        );

        json_encode($output);
    }

}

?>
