<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trending_feature extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/application_directory_library');
        $this->load->library("basic_profile");
        $this->load->library("recent_activities");
        $this->load->library("statuses");
        $this->load->library("Trending_features");
                
        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function hashtag($hashtag)
    {
        $status_id_list = $this->trending_features->get_status_ids_hashtag($hashtag);
        $this->data['newsfeeds'] = $this->statuses->get_statuses(0, 0, 0, 0, $status_id_list);
        
        $user_id = $this->session->userdata('user_id');
        $this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
         
        //$this->data['followers'] = $this->follower->get_followers();
        $user_id = $this->ion_auth->get_user_id();
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['user_id'] = $user_id;
        $this->data['current_user_id'] = $this->session->userdata['user_id'];
        $this->data['status_list_id'] = STATUS_LIST_HASHTAG;
        $this->data['hashtag'] = $hashtag;
        $this->data['mapping_id'] = $user_id;
        $this->data['recent_activities'] = $this->recent_activities->get_recent_activites();
        $this->data['popular_trends'] = $this->trending_features->get_popular_trends()->result_array();
        $this->data['app_id_list'] = $this->application_directory_library->get_user_application_id_list($user_id);
        $this->template->load(null, "trending_feature/hashtag/index", $this->data);
    }
    
    public function get_hash_tags()
    {
        $hash_tag = $this->input->post('hash_tag');
        $hash_tag_list = array();
        
        $hashtags_array = $this->trending_features->get_hashtags($hash_tag);
        foreach($hashtags_array as $hashtag_info)
        {
            $ht = new stdClass();
            $ht->name = $hashtag_info['hashtag'];
            $ht->value = $hashtag_info['hashtag'];
            $hash_tag_list[] = $ht;
        }        
        echo json_encode($hash_tag_list);        
    }
    
    public function get_at()
    {
        $at = $this->input->post('at');
        $at_list = array();
        $users_array = $this->trending_features->get_users_at($at);
        foreach($users_array as $user_info)
        {
            $at1 = new stdClass();
            $at1->name = $user_info['first_name'].' '.$user_info['last_name'];
            $at1->type_id = AT_USER_TYPE_ID;
            $at1->id = $user_info['user_id'];        
            $at1->value = $user_info['first_name'].' '.$user_info['last_name'];
            $at_list[] = $at1;
        }        
        echo json_encode($at_list);
        
    }
    
    public function get_selected_at()
    {
        $type_id = $this->input->post('type_id');
        $id = $this->input->post('id');
        $at1 = new stdClass();
        if($type_id == AT_USER_TYPE_ID)
        {
            $user_info_array = $this->trending_features->get_user_info($id);
            if(!empty($user_info_array))
            {
                $user_info = $user_info_array[0];                
                $at1->name = $user_info['first_name'].' '.$user_info['last_name'];
                $at1->url = base_url().'member_profile/show/'.$user_info['user_id'];
            }
        }        
        echo json_encode($at1);        
    }
}