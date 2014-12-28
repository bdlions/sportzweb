<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class Member_profile extends JsonRPCServer {
//class Member_profile extends CI_Controller{
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
    function show($user_id = 0, $is_myself = 1)
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
        //echo json_encode($response);
        return json_encode($response);
    }
    
    /*
     * This method will return user info
     * @param $user_id, user id
     * @Author Nazmul on 11th November 2014
     */
    function info($user_id = 0)
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
        //echo json_encode($response);
        return json_encode($response);
    }
    
    public function get_member_profile_info($user_id)
    {
        $response = array();
        $member_profile_info = array();
        $member_profile_info_array = $this->basic_profile->get_member_profile_info($user_id)->result_array();
        if(!empty($member_profile_info_array))
        {
            $member_profile_info = $member_profile_info_array[0];
        }
        $response['member_profile_info'] = $member_profile_info;
        //echo json_encode($response);
        return json_encode($response);
    }
    
    /*
     * This method will store special interest of a member
     * @param user id ad int and special interest id as array
     */
    function store_special_interests()
    {
        $user_id = 4;
        $special_interest_id_list = array(2);
        
        $response = array(
            'message' => ''
        );
        
        $selected_special_interest_list = array();
        $special_interest_list = $this->special_interest->get_special_interest_list();
        foreach($special_interest_list as $special_interest_info)
        {
            if(in_array($special_interest_info['special_interest_id'], $special_interest_id_list))
            {
                foreach($special_interest_info['sub_category_list'] as $subcategory)
                {
                    $selected_special_interest_list[] = array('interest_id'=>$special_interest_info['special_interest_id'], 'sub_interest_id' => $subcategory['id']);
                }
            }
        }
        $profile_data = array(
            'user_id' => $user_id,
            'special_interests' => json_encode($selected_special_interest_list)
        );
        $profile_id = $this->basic_profile->get_profile_id();
        if($profile_id > 0){
            //update profile
           $this->basic_profile->update_profile($profile_data);
           $response['message'] = 'Interest is updated successfully.';
        }
        else{
            //insert profile for the first time
            $this->basic_profile->create_profile($profile_data);
            $response['message'] = 'Interest is stored successfully.';
        }
        //echo json_encode($response);
        return json_encode($response);
    }
}