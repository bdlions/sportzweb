<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class Auth extends JsonRPCServer {
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
    function register($user_data) {        
        $result = array();
        //decoding json data from string to object
        $data = json_decode($user_data);
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
            $result['message'] = $this->ion_auth->messages();
            //activating newly created user
            if(!$this->ion_auth->activate($user_id))
            {
                $result['message'] = $this->ion_auth->errors();
            }
        } 
        else 
        {
            $result['message'] = $this->ion_auth->errors();
        }
        json_decode($result);
    }
    
    /*
     * This method will check login based on identity and password
     * @param $identity, user identity
     * @param $password, user password
     * @Author Nazmul on 25th September 2014
     */
    public function login($identity = '', $password = '')
    {
        $response = array();
        if ($this->ion_auth->login($identity, $$password)) {
            $response['message'] = $this->ion_auth->messages();
            $user_id = $this->session->userdata('user_id');
            $user_info_array = $$this->ion_auth->get_users($array($user_id))->result();
            if(!empty($user_info_array))
            {
                $response['user_info'] = $user_info_array[0];
                //status 1 means everything is perfect
                $response['status'] = 1;
            }
        }
        else
        {
            $response['message'] = $this->ion_auth->errors();
            $response['status'] = 0;
        }
        echo json_encode($response);
    }
}

?>
