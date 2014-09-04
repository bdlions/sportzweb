<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trending_feature extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        
        $this->load->library("basic_profile");
        $this->load->library("recent_activities");
                
        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function hashtag($tag)
    {
        $user_id = $this->session->userdata('user_id');
        $this->data['message'] = validation_errors() ? validation_errors() : $this->session->flashdata('message');
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
        $this->data['newsfeeds'] = array();
        //$this->data['followers'] = $this->follower->get_followers();
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['user_id'] = $this->ion_auth->get_user_id();
        $this->data['current_user_id'] = $this->session->userdata['user_id'];
        //$this->data['status_list_id'] = STATUS_LIST_NEWSFEED;
        //$this->data['mapping_id'] = $user_id;
        $this->data['recent_activities'] = $this->recent_activities->get_recent_activites();
        $this->template->load(null, "trending_feature/hashtag/index", $this->data);
    }
    
    public function get_hash_tags()
    {
        $hash_tag_list = array();
        
        $hash_tag1 = new stdClass();
        $hash_tag1->name = '#cricket';
        $hash_tag1->value = '#cricket';
        
        $hash_tag2 = new stdClass();
        $hash_tag2->name = '#football';
        $hash_tag2->value = '#football';
        
        $hash_tag_list[] = $hash_tag1;
        $hash_tag_list[] = $hash_tag2;
        
        echo json_encode($hash_tag_list);
        
    }
}