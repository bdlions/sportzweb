<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('follower');
        $this->load->library('searches');
        $this->load->library('org/profile/business/business_profile_library');
        

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->library("profile");

    }

    public function get_users() {
        //print_r($this->profile->get_users());
        $users = $this->profile->get_users();
        $temp_users = array();
        
        foreach ($users as  $user) {
            $user -> value = $user -> first_name . " ". $user -> last_name;
            $user -> signature = $user -> first_name[0].$user -> last_name[0];
            array_push($temp_users, $user);
        }
        echo json_encode($temp_users);
    }
    
    public function get_followers(){
        $users = $this->follower->get_followers();
        $temp_users = array();
        
        foreach ($users as  $user) {
            $user -> value = $user -> first_name . " ". $user -> last_name;
            $user -> signature = $user -> first_name[0].$user -> last_name[0];
            array_push($temp_users, $user);
        }
        echo json_encode($temp_users);
    }
    
    public function get_business_names(){
        $business_names = $this->business_profile_library->get_all_business_profile();
        
        foreach ($business_names as  $business_name) {
            $business_name -> value = $business_name -> business_name ;
            $business_name -> signature = $business_name -> business_name[0];
        }
        echo json_encode($business_names);
    }
    
    public function get_pages(){
        $pages = array();
        $healthy_recipes = $this->searches_model->get_healthy_recipes()->result();
        foreach ($healthy_recipes as  $healthy_recipe) {
            $healthy_recipe -> value = $healthy_recipe -> title ;
            $healthy_recipe -> picture = base_url() . HEALTHY_RECIPES_IMAGE_PATH .$healthy_recipe -> main_picture ;
            $healthy_recipe -> type = 'page';
            $healthy_recipe -> url = base_url() . 'applications/healthy_recipes/recipe/'.$healthy_recipe -> id;
            array_push($pages, $healthy_recipe);
        }
        
        $services = $this->searches_model->get_services()->result();
        foreach ($services as  $service) {
            $service -> value = $service -> title ;
            $service -> picture = base_url() . SERVICE_IMAGE_PATH .$service -> picture ;
            $service -> type = 'page';
            $service -> url = base_url() . 'applications/service_directory/show_service_detail/'.$service -> id;
            array_push($pages, $service);
        }
        
        $news_list = $this->searches_model->get_news()->result();
        foreach ($news_list as  $news) {
            $news -> value = $news -> headline ;
            $news -> title = $news -> headline ;
            $news -> picture = base_url() . NEWS_IMAGE_PATH .$news -> picture ;
            $news -> type = 'page';
            $news -> url = base_url() . 'applications/news_app/news_item/'.$news -> id;
            array_push($pages, $news);
        }
        
        $blog_list = $this->searches_model->get_blogs()->result();
        foreach ($blog_list as  $blog) {
            $blog -> value = $blog -> title ;
            $blog -> picture = base_url() . BLOG_POST_IMAGE_PATH .$blog -> picture ;
            $blog -> type = 'page';
            $blog -> url = base_url() . 'applications/blog_app/view_blog_post/'.$blog -> id;
            array_push($pages, $blog);
        }
        echo json_encode($pages);
    }
}
?>