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
        $this->load->library('basic_profile');
        $this->load->library('org/profile/business/business_profile_library');
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
            $user_info_array = $this->ion_auth_model->get_user_info($user_id)->result();
            if(!empty($user_info_array))
            {
                $response['user_info'] = $user_info_array[0];     
            }
        } 
        else 
        {
            $response['msg'] = "SIGNUP_FAILD_PLEASE_TRY_AGAIN";
            $response['error_messages'] = $this->ion_auth->errors_mobile_app();
            $response['status'] = RPC_ERROR;
        }
        return json_encode($response);
    }
    
    public function updateGender($user_data = '') {
        $response = array();
        //decoding json data from string to object
        //{"genden":"MALE"}
        $data = json_decode($user_data);
        $response['status'] = RPC_SUCCESS;
        $response['msg'] = "UPDATE_OK";
        
        return json_encode($response);
    }
    
    /*
     * This method will update gender of a user
     * @param $user_data, user id and gender id
     * @Author Nazmul on 1st October 2014
     */
    public function update_gender($user_data = '') {
        $response = array();
        $data = json_decode($user_data);
        /*$data = new stdClass();
        $data->user_id = 2;
        $data->gender_id = 2;*/
        
        $gender_id = $data->gender_id;
        $user_id = $data->user_id;
        $profile_data = array(
            'gender_id' => $gender_id
        );
        if($this->basic_profile_model->get_profile_id($user_id) > 0)
        {
            if($this->basic_profile_model->update_profile_info($profile_data, $user_id))
            {
                $response['status'] = RPC_SUCCESS;
                $response['success_message'] = 'Gender is updated successfully';
            }
            else
            {
                $response['status'] = RPC_ERROR;
                $response['error_messages'] = 'Error while storing gender';
            }
        }
        else
        {
            $profile_data['user_id'] = $user_id;
            if($this->basic_profile_model->create_profile($profile_data))
            {
                $response['status'] = RPC_SUCCESS;
                $response['success_message'] = 'Gender is updated successfully';
            }
            else
            {
                $response['status'] = RPC_ERROR;
                $response['error_messages'] = 'Error while storing gender';
            }            
        }        
        return json_encode($response);
    }
    
    /*
     * This method will update date of birth of a user
     * @param $user_data, user id and date of birth in yyyy-mm-dd format
     * @Author Nazmul on 1st October 2014
     */
    public function update_dob($user_data = '') {
        $response = array();
        $data = json_decode($user_data);
        /*$data = new stdClass();
        $data->user_id = 2;
        $data->dob = '2014-07-30';*/
        
        $dob = $data->dob;
        $user_id = $data->user_id;
        $profile_data = array(
            'dob' => $dob
        );
        if($this->basic_profile_model->get_profile_id($user_id) > 0)
        {
            if($this->basic_profile_model->update_profile_info($profile_data, $user_id))
            {
                $response['status'] = RPC_SUCCESS;
                $response['success_message'] = 'Date of birth is updated successfully';
            }
            else
            {
                $response['status'] = RPC_ERROR;
                $response['error_messages'] = 'Error while storing date of birth';
            }
        }
        else
        {
            $profile_data['user_id'] = $user_id;
            if($this->basic_profile_model->create_profile($profile_data))
            {
                $response['status'] = RPC_SUCCESS;
                $response['success_message'] = 'Date of birth is updated successfully';
            }
            else
            {
                $response['status'] = RPC_ERROR;
                $response['error_messages'] = 'Error while storing date of birth';
            }            
        }
        return json_encode($response);
    }
    
    /*
     * This method will update profile information of a user
     * @param $user_data, user id, country id, school/university, employer, occupation
     * @Author Nazmul on 1st October 2014
     */
    public function update_profile_information($user_data = '') {
        $response = array();
        $data = json_decode($user_data);
        /*$data = new stdClass();
        $data->user_id = 2;
        $data->country_id = 223;
        $data->clg_or_uni = 'university2';
        $data->employer = 'bdlions2';
        $data->occupation = 'Software Developer2';*/
        
        $user_id = $data->user_id;
        $country_id = $data->country_id;
        $clg_or_uni = $data->clg_or_uni;
        $employer = $data->employer;
        $occupation = $data->occupation;
        
        $profile_data = array(
            'country_id' => $country_id,
            'clg_or_uni' => $clg_or_uni,
            'employer' => $employer,
            'occupation' => $occupation
        );
        if($this->basic_profile_model->get_profile_id($user_id) > 0)
        {
            if($this->basic_profile_model->update_profile_info($profile_data, $user_id))
            {
                $response['status'] = RPC_SUCCESS;
                $response['success_message'] = 'Profile is updated successfully';
            }
            else
            {
                $response['status'] = RPC_ERROR;
                $response['error_messages'] = 'Error while storing profile';
            }
        }
        else
        {
            $profile_data['user_id'] = $user_id;
            if($this->basic_profile_model->create_profile($profile_data))
            {
                $response['status'] = RPC_SUCCESS;
                $response['success_message'] = 'Profile is updated successfully';
            }
            else
            {
                $response['status'] = RPC_ERROR;
                $response['error_messages'] = 'Error while storing profile';
            }            
        }
        return json_encode($response);
    }
    
    public function updateUsersInfo($user_data = '') {
        $response = array();
        //decoding json data from string to object
        //{"genden":"MALE"}
        $data = json_decode($user_data);
        $response['status'] = RPC_SUCCESS;
        $response['msg'] = "UPDATE_OK";
        
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
    
    function country_list() {
        $output = array();
        $output['country_list'] = $this->business_profile_library->get_country_list()->result_array();
        //echo json_encode($output);
        return json_encode($output);
    }
}

?>
