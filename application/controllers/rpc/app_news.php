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
        $category = array(
            'id' => 0,
            'title' => 'Home'
        );
        $news_category_list[] = $category;
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
    /*
     * This method will return news list at home page 
     * @Author Nazmul on 29th October 2014
     */
    function get_home_page_news_list()
    {
        $response = array();
        $news_list = array();
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
        $response['news_list'] = $news_list;
        return json_encode($response);
    }
    
    /*
     * This method will retunr news list of a category and also news list of each subcateogyr of that category
     * @param $news_category_id, news category id
     * @Author Nazmul on 29October 2014
     */
    function get_news_list($news_category_id)
    {
        $result = array();
        $category_news_list = array();
        $subcategory_id_news_list = array();
        $subcategory_news_list = array();
        $news_configuration = $this->news_app_library->get_news_category_configuration($news_category_id);            
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
                    $category_news_list[] = $news;
                }
            }
        }
        $news_subcategory_list_array = $this->news_app_library->get_all_news_sub_category($news_category_id)->result_array();
        foreach($news_subcategory_list_array as $subcategory_info)
        {
            $subcategory_news_list = array();
            $news_configuration = $this->news_app_library->get_news_sub_category_configuration($subcategory_info['id']);
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
                        $subcategory_news_list[] = $news;
                    }
                    $subcategory_id_news_list[$subcategory_info['id']] = $subcategory_news_list;
                }
            }
        }
        $result['category_news_list'] = $category_news_list;
        $result['subcategory_id_news_list'] = $subcategory_id_news_list;
        return json_encode($result);
    }
    
    /*
     * This method will return news info
     * @param $news_id, news id
     * @Author Nazmul on 29th October 2014
     */
    function get_news_info($news_id)
    {
        $result = array();
        $news_info = $this->news_app_library->get_news_info($news_id);
        $result['news_info'] = $news_info;
        return json_encode($result);
    }
}