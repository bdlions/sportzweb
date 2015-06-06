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

    /*
     * This method return users info by search type
     * Ajax call typeahead result
     * @Rashida on 18th March
     */

    public function get_users() {
        $temp_users = array();
        $search_value = $_GET['query'];
        if ($search_value != null) {
            $users = $this->searches_model->get_users($search_value);
            foreach ($users as $user) {
                $is_gympro = $this->searches_model->is_gympro_user($user->user_id);
                $user->ptpro_display = ($is_gympro) ? 'block' : 'none';
                $user->value = $user->first_name . " " . $user->last_name;
                $user->signature = "";
                if ($user->first_name != NULL && $user->first_name != "") {
                    $user->signature = $user->first_name[0];
                }
                if ($user->last_name != NULL && $user->last_name != "") {
                    $user->signature = $user->signature . $user->last_name[0];
                }
                //$user -> signature = $user -> first_name[0].$user -> last_name[0];
                array_push($temp_users, $user);
            }
            echo json_encode($temp_users);
        } else
            echo json_encode(array());
    }

    public function get_followers() {
        $user_id = $this->session->userdata('user_id');
        $users = $this->follower->get_user_followers($user_id);
        $temp_users = array();

        foreach ($users as $user) {
            $user->value = $user->first_name . " " . $user->last_name;
            $user->signature = "";
            if ($user->first_name != NULL && $user->first_name != "") {
                $user->signature = $user->first_name[0];
            }
            if ($user->last_name != NULL && $user->last_name != "") {
                $user->signature = $user->signature . $user->last_name[0];
            }
            //$user -> signature = $user -> first_name[0].$user -> last_name[0];
            array_push($temp_users, $user);
        }
        echo json_encode($temp_users);
    }

    /*
     * This method return business info by search type
     * Ajax call typeahead result
     * @Rashida on 18th March
     */

    public function get_business_names() {
        $search_value = $_GET['query'];
        $business_names = $this->searches_model->get_all_business_profile($search_value);

        foreach ($business_names as $business_name) {
            $business_name->value = $business_name->business_name;
            $business_name->signature = "";
            if ($business_name->business_name != NULL && $business_name->business_name != "") {
                $business_name->signature = $business_name->business_name[0];
            }
            //$business_name -> signature = $business_name -> business_name[0];
        }
        echo json_encode($business_names);
    }

    /*
     * This method return pages info by search type
     * Ajax call typeahead result
     * @Rashida on 18th March
     */

    public function get_healthy_recipes() {
        $search_value = $_GET['query'];
        $temp_recipes = array();
        $healthy_recipes = $this->searches_model->get_healthy_recipes($search_value)->result();
        foreach ($healthy_recipes as $healthy_recipe) {
            $healthy_recipe->value = $healthy_recipe->title;
            $healthy_recipe->picture = base_url() . HEALTHY_RECIPES_IMAGE_PATH . $healthy_recipe->main_picture;
            $healthy_recipe->type = 'page';
            $healthy_recipe->url = base_url() . 'applications/healthy_recipes/recipe/' . $healthy_recipe->id;
            array_push($temp_recipes, $healthy_recipe);
        }
        echo json_encode($temp_recipes);
    }

    /*
     * This method return pages info by search type
     * Ajax call typeahead result
     * @Rashida on first june 2015
     */

    public function get_services() {
        $search_value = $_GET['query'];
        $temp_services = array();
        $services = $this->searches_model->get_services($search_value)->result();
        foreach ($services as $service) {
            $service->value = $service->title;
            $service->picture = base_url() . SERVICE_IMAGE_PATH . $service->picture;
            $service->type = 'page';
            $service->url = base_url() . 'applications/service_directory/show_service_detail/' . $service->id;
            array_push($temp_services, $service);
        }
        echo json_encode($temp_services);
    }

    public function get_news() {
        $search_value = $_GET['query'];
        $temp_news = array();
        $news_list = $this->searches_model->get_news($search_value)->result();
        foreach ($news_list as $news) {
            $news->value = strip_tags(html_entity_decode(html_entity_decode($news->headline)));
            $news->title = strip_tags(html_entity_decode(html_entity_decode($news->headline)));
            $news->picture = base_url() . NEWS_IMAGE_PATH . $news->picture;
            $news->type = 'page';
            $news->url = base_url() . 'applications/news_app/news_item/' . $news->id;
            array_push($temp_news, $news);
        }
        echo json_encode($temp_news);
    }

    public function get_blogs() {
        $search_value = $_GET['query'];
        $temp_blogs = array();
        $blog_list = $this->searches_model->get_blogs($search_value)->result();
        foreach ($blog_list as $blog) {
            $blog->value = strip_tags(html_entity_decode(html_entity_decode($blog->title)));
            $blog->title = strip_tags(html_entity_decode(html_entity_decode($blog->title)));
            $blog->picture = base_url() . BLOG_POST_IMAGE_PATH . $blog->picture;
            $blog->type = 'page';
            $blog->url = base_url() . 'applications/blog_app/view_blog_post/' . $blog->id;
            array_push($temp_blogs, $blog);
        }
        echo json_encode($temp_blogs);
    }

    /*
     * This method return all info by search type
     * Ajax call custom typeahead result
     * @Rashida on first june 2015
     */

    function get_search_result() {
        $temp_users = array();
        $temp_news = array();
        $temp_recipes = array();
        $temp_blogs = array();
        $temp_business = array();
        $response = array();
        $search_value = $_POST['input_value'];
        if ($search_value != null) {
            $users = $this->searches_model->get_users($search_value);
            foreach ($users as $user) {
                $is_gympro = $this->searches_model->is_gympro_user($user->user_id);
                $user->ptpro_display = ($is_gympro) ? 'block' : 'none';
                $user->value = $user->first_name . " " . $user->last_name;
                $user->signature = "";
                $user->url = base_url().'member_profile/show/'.$user->user_id;
                if ($user->first_name != NULL && $user->first_name != "") {
                    $user->signature = $user->first_name[0];
                }
                if ($user->last_name != NULL && $user->last_name != "") {
                    $user->signature = $user->signature . $user->last_name[0];
                }
                $user -> user_image = base_url() . PROFILE_PICTURE_PATH_W32_H32 .$user -> photo;
                array_push($temp_users, $user);
            }
            $response['users'] = $temp_users;


            $news_list = $this->searches_model->get_news($search_value)->result();
            foreach ($news_list as $news) {
                $news->value = strip_tags(html_entity_decode(html_entity_decode($news->headline)));
                $news->title = strip_tags(html_entity_decode(html_entity_decode($news->headline)));
                $news->picture = base_url() . NEWS_IMAGE_PATH . $news->picture;
                $news->url = base_url() . 'applications/news_app/news_item/' . $news->id;
                array_push($temp_news, $news);
            }
            $response['news'] = $temp_news;

            $healthy_recipes = $this->searches_model->get_healthy_recipes($search_value)->result();
            foreach ($healthy_recipes as $healthy_recipe) {
                $healthy_recipe->value = $healthy_recipe->title;
                $healthy_recipe->picture = base_url() . HEALTHY_RECIPES_IMAGE_PATH . $healthy_recipe->main_picture;
                $healthy_recipe->url = base_url() . 'applications/healthy_recipes/recipe/' . $healthy_recipe->id;
                array_push($temp_recipes, $healthy_recipe);
            }

            $response['recipes'] = $temp_recipes;

            $healthy_recipes = $this->searches_model->get_healthy_recipes($search_value)->result();
            foreach ($healthy_recipes as $healthy_recipe) {
                $healthy_recipe->value = $healthy_recipe->title;
                $healthy_recipe->picture = base_url() . HEALTHY_RECIPES_IMAGE_PATH . $healthy_recipe->main_picture;
                $healthy_recipe->url = base_url() . 'applications/healthy_recipes/recipe/' . $healthy_recipe->id;
                array_push($temp_recipes, $healthy_recipe);
            }


            $blog_list = $this->searches_model->get_blogs($search_value)->result();
            foreach ($blog_list as $blog) {
                $blog->value = strip_tags(html_entity_decode(html_entity_decode($blog->title)));
                $blog->title = strip_tags(html_entity_decode(html_entity_decode($blog->title)));
                $blog->picture = base_url() . BLOG_POST_IMAGE_PATH . $blog->picture;
                $blog->url = base_url() . 'applications/blog_app/view_blog_post/' . $blog->id;
                array_push($temp_blogs, $blog);
            }
            $response['blogs'] = $temp_blogs;

            $business_names = $this->searches_model->get_all_business_profile($search_value);
            foreach ($business_names as $business_name) {
                $business_name->url = base_url() . 'business_profile/show/' . $business_name->id;
                $business_name->logo = base_url() . BUSINESS_PROFILE_LOGO_PATH . $business_name->logo;
                $business_name->value = $business_name->business_name;
                $business_name->signature = "";
                if ($business_name->business_name != NULL && $business_name->business_name != "") {
                    $business_name->signature = $business_name->business_name[0];
                }
                array_push($temp_business, $business_name);
            }
            $response['business_user'] = $temp_business;
            echo json_encode($response);
        } else
            echo json_encode(array());
    }

}

?>