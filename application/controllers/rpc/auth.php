<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class Auth extends JsonRPCServer {
//class Auth extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    /*
     * This method will register a new user
     * @param $user_data, user data to be registered
     * @Author Nazmul on 25th September 2014
     */
    function register($user_data = '') {  
        $response = array();
        //decoding json data from string to object
        $data = json_decode($user_data);
        /*$data = new stdClass();
        $data->first_name = 'bdlions';
        $data->last_name = 'bdlions';
        $data->email = 'bdlions@test.com';
        $data->password = 'password';*/
        $username = strtolower($data->first_name) . ' ' . strtolower($data->last_name);
        $email = $data->email;
        $password = $data->password;

        $additional_data = array(
            'first_name' => $data->first_name,
            'last_name' => $data->last_name
        );
        //registering a new user
        $user_id = $this->ion_auth_model->register($username, $password, $email, $additional_data);
        if ($user_id !== FALSE) 
        {
            $response['success_message'] = $this->ion_auth->messages_mobile_app();
            $response['msg'] = "SIGNUP_COMPLETED";
            $response['status'] = RPC_SUCCESS;
            //activating newly created user
            $this->ion_auth_model->activate($user_id);
        } 
        else 
        {
            $response['msg'] = "SIGNUP_FAILD_PLEASE_TRY_AGAIN";
            $response['error_messages'] = $this->ion_auth->errors_mobile_app();
            $response['status'] = RPC_ERROR;
        }
        return json_encode($response);
    }
    
    /*
     * This method will check login based on identity and password
     * @param $identity, user identity
     * @param $password, user password
     * @Author Nazmul on 25th September 2014
     */
    public function login($identity = '', $password = '')
    {
        //$identity = 'bdlions@bdlions.com';
        //$password = 'password';
        $response = array();
        if ($this->ion_auth->login($identity, $password)) {
            $response['success_message'] = $this->ion_auth->messages_mobile_app();
            $user_id = $this->session->userdata('user_id');
            //print_r($user_id);
            $user_info_array = $this->ion_auth_model->get_user_info($user_id)->result();
            //print_r($user_info_array);
            if(!empty($user_info_array))
            {
                $response['user_info'] = $user_info_array[0];
                $response['id'] = $user_info_array[0]->user_id;
                $response['first_name'] = $user_info_array[0]->first_name;
                $response['last_name'] = $user_info_array[0]->last_name;
                $response['email'] = $user_info_array[0]->email;
                
                $response['status'] = RPC_SUCCESS;
                $response['msg'] = "SIGNIN_SUCCESSFULLY";                
            }
        }
        else
        {
            $response['error_messages'] = $this->ion_auth->errors_mobile_app();
            $response['status'] = RPC_ERROR;
            $response['msg'] = "EMAIL_AND_PASSWORD_DOES_NOT_MATCH";
        }
        return json_encode($response);
    }
}

?>
