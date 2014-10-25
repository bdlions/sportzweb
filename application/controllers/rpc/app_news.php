<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_news extends JsonRPCServer {
//class App_news extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/news_app_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    function load_news_app()
    {
        $response = array();
        $news_category_list = array();
        $news_list = array();
        $news_category_list_array = $this->news_app_library->get_all_news_category()->result_array();
        foreach($news_category_list_array as $news_category)
        {
            $category = array(
                'id' => $news_category['id'],
                'title' => $news_category['title']
            );
            $news_category_list[] = $category;
        }
        $news_home_page_configuration = $this->news_app_library->get_news_home_page_configuration();
        if(array_key_exists('news_id_news_info_map', $news_home_page_configuration))
        {
            $news_list_array = $news_home_page_configuration['news_id_news_info_map'];
            foreach($news_list_array as $news_info)
            {
                $news = array(
                    'id' => $news_info['news_id'],
                    'news_id' => $news_info['news_id'],
                    'headline' => $news_info['headline'],
                    'picture' => $news_info['picture']
                );
                $news_list[] = $news;
            }
        }
        $response['news_category_list'] = $news_category_list;
        $response['news_list'] = $news_list;
        return json_encode($response);
    }
    
    function get_news_list($news_category_id, $news_subcategory_id)
    {
        $response = array();
        $news_subcategory_list = array();
        $news_list = array();
        $news_configuration = array();
        $news_subcategory_list_array = array();
        if($news_category_id > 0)
        {
            $news_configuration = $this->news_app_library->get_news_category_configuration($news_category_id);            
            $news_subcategory_list_array = $this->news_app_library->get_all_news_sub_category($news_category_id)->result_array();
        
        }
        else if($news_subcategory_id > 0)
        {
            $news_configuration = $this->news_app_library->get_news_sub_category_configuration($news_subcategory_id);
        }
        if(!empty($news_configuration))
        {
            if(array_key_exists('news_id_news_info_map', $news_configuration))
            {
                $news_list_array = $news_configuration['news_id_news_info_map'];
                foreach($news_list_array as $news_info)
                {
                    $news = array(
                        'id' => $news_info['news_id'],
                        'news_id' => $news_info['news_id'],
                        'headline' => $news_info['headline'],
                        'picture' => $news_info['picture']
                    );
                    $news_list[] = $news;
                }
            }
        }
        foreach($news_subcategory_list_array as $subcategory_info)
        {
            $subcategory = array(
                'id' => $subcategory_info['id'],
                'title' => $subcategory_info['title']
            );
            $news_subcategory_list[] = $subcategory;
        }
        $response['news_subcategory_list'] = $news_subcategory_list;
        $response['news_list'] = $news_list;        
        return json_encode($response);
        
    }
}