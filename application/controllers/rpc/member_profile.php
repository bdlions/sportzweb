<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

//class Member_profile extends JsonRPCServer {
class Member_profile extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('basic_profile');
        $this->load->library("follower");
        $this->load->library("org/interest/special_interest");
        $this->load->library("statuses");
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    /*
     * This method will return user profile info
     * @param $user_id, user id of a profile
     * @param $is_myself, 1 or 0 based on user id is mine or not
     * @Author Nazmul on 11th November 2014
     */
    function show($user_id, $is_myself)
    {
        $response = array();
        $response['profile_type'] = PROFILE_NON_FOLLOWER;
        if($is_myself == 1)
        {
            $response['profile_type'] = PROFILE_MYSELF;
        }
        else
        {
            $response = array_merge($response, $this->follower->get_relation_with_user($user_id));     
        }
        $response['newsfeeds'] = $this->statuses->get_statuses(STATUS_LIST_USER_PROFILE, $user_id);
        $response['status_list_id'] = STATUS_LIST_USER_PROFILE;
        $response['mapping_id'] = $user_id;
        $response['user_info'] = $this->ion_auth->get_user_info($user_id);
        
        $response['status_or_comment_in'] = STATUS_POSTED_IN_BASIC_PROFILE;
        $response['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        echo json_encode($response);
        //return json_encode($response);
    }
    
    /*
     * This method will return user info
     * @param $user_id, user id
     * @Author Nazmul on 11th November 2014
     */
    function info($user_id)
    {
        $response = array();
        $profile_info = $this->basic_profile->get_profile_info($user_id);
        $response['profile_info'] = $profile_info;
        $response['special_interests'] = $this->special_interest->get_all_special_interests();
        
        $selected_special_interest = array();
        $selected_interests = json_decode($profile_info->special_interests);
        if (is_array($selected_interests)) {            
            foreach ($selected_interests as $value) {
                $selected_special_interest[] = ($value->interest_id . "_" . $value->sub_interest_id);
            }
        }
        $response['selected_special_interest'] = $selected_special_interest;
        echo json_encode($response);
        //return json_encode($response);
    }
}