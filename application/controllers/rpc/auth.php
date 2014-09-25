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
        $result = array();
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
        $user_id = $this->ion_auth->register($username, $password, $email, $additional_data);
        if ($user_id !== FALSE) 
        {
            $result['message'] = 'Account is created successfully.';
            $result['msg'] = "SIGNUP_COMPLETED";
            //activating newly created user
            $this->ion_auth_model->activate($user_id);
        } 
        else 
        {
            $result['msg'] = "SIGNUP_FAILD_PLEASE_TRY_AGAIN";
            $result['message'] = $this->ion_auth->errors();
        }
        return json_encode($result);
    }
    
    /*
     * This method will check login based on identity and password
     * @param $identity, user identity
     * @param $password, user password
     * @Author Nazmul on 25th September 2014
     */
    public function login($identity = '', $password = '')
    {
        //$identity = 'bdlions@gmail.com';
        //$password = 'password';
        $response = array();
        if ($this->ion_auth->login($identity, $$password)) {
            $response['message'] = $this->ion_auth->messages();
            $user_id = $this->session->userdata('user_id');
            $user_info_array = $this->ion_auth_model->get_users(array($user_id))->result();
            if(!empty($user_info_array))
            {
                $response['user_info'] = $user_info_array[0];
                $response['id'] = $user_info_array[0]->user_id;
                $response['first_name'] = $user_info_array[0]->first_name;
                $response['last_name'] = $user_info_array[0]->last_name;
                $response['email'] = $user_info_array[0]->email;
                
                //status 1 means everything is perfect
                $response['msg'] = "SIGNIN_SUCCESSFULLY";
            }
        }
        else
        {
            $response['message'] = $this->ion_auth->errors();
            //status 0 means there is an error
            $response['msg'] = "EMAIL_AND_PASSWORD_DOES_NOT_MATCH";
        }
        return json_encode($response);
    }
}

?>
