<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class Business_profile extends JsonRPCServer {
//class Business_profile extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/profile/business/business_profile_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    /*
     * This method will return country list and business profile type list
     * @Author Nazmul on 11th October 2014
     */
    function get_business_profile_registration_data()
    {
        $response = array();
        $response['country_list'] = $this->business_profile_library->get_country_list()->result_array();
        $response['business_profile_type_list'] = $this->business_profile_library->get_business_profile_type_list();
        //echo json_encode($response);exit;
        return json_encode($response);
    }
    
    /*
     * This method will create a new business profile
     * @author Nazmul on 11th October 2014
     */
    function create_business_profile($business_profile_data = '')
    {
        $response = array();
        $data = json_decode($business_profile_data);
        //$data = new stdClass();
        /*$data->user_id = 2;
        $data->business_profile_type = 1;
        $data->business_profile_sub_type = 1;
        $data->business_name = 'test profile';
        $data->street_name = 'street1';
        $data->business_country = 223;
        $data->business_city = 'dhaka';
        $data->post_code = 1207;
        $data->telephone = '01678112509';
        $data->business_email = 'bdlions@gmail.com';
        $data->website_address = 'www.abc.com';
        $data->business_hour = 'www.abc.com';
        $data->registered_company_number = 1;
        $data->business_description = 'description';*/
        $additional_data = array(
            'user_id' => $data->user_id,
            'business_profile_type' => $data->business_profile_type,
            'business_profile_sub_type' => $data->business_profile_sub_type,
            'business_name' => $data->business_name,
            'street_name' => $data->street_name,
            'business_country' => $data->business_country,
            'business_city' => $data->business_city,
            'post_code' => $data->post_code,
            'telephone' => $data->telephone,
            'business_email' => $data->business_email,
            'website_address' => $data->website_address,
            'business_hour' => $data->business_hour,
            'registered_company_number' => $data->registered_company_number,
            'business_description' => $data->business_description,
        );
        $business_profile_id = $this->business_profile_library->add_business_profile($additional_data);
        if ($business_profile_id !== FALSE) 
        {
            $response['success_message'] = 'Business Profile is created successfully';
            $response['status'] = RPC_SUCCESS;
            $business_profile_info = $this->business_profile_library->get_profile_info($data->user_id);
            if($business_profile_info != FALSE)
            {
                $response['is_bp_exists'] = "1";
                $response['business_profile_info'] = $business_profile_info;
            }
            else
            {
                $response['is_bp_exists'] = "0";
            }
        } 
        else 
        {
            $response['error_messages'] = 'Error while creating a business profile';
            $response['status'] = RPC_ERROR;
        }
        return json_encode($response);
    }
    
    /*
     * This method will update business profile
     * @author Nazmul on 11th October 2014
     */
    function update_business_profile_info()
    {
        
    }
    
    /*
     * This method will return business profile
     * @param $user_id, user id of the business profile
     * @author Nazmul on 11th October 2014
     */
    function get_business_profile_info($user_id = 0)
    {
        $response = array();
        $business_profile_info = $this->business_profile_library->get_profile_info($user_id);
        $response['business_profile_info'] = $business_profile_info;
        //echo json_encode($response);
        return json_encode($response);
    }
}

?>
