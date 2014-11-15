<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_healthy_recipe extends JsonRPCServer {
//class App_healthy_recipe extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/healthy_recipes_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    function load_recipe_app()
    {
        $response = array();        
        $recipe_category_recipe_list = array();
        
        $recipe_category_list_array = $this->healthy_recipes_library->get_all_recipe_categories()->result_array();
        foreach($recipe_category_list_array as $recipe_category)
        {
            $recipe_list = array();
            $recipe_list_array = $this->healthy_recipes_library->get_recipe_list_by_category($recipe_category['id'])->result_array();
            foreach($recipe_list_array as $recipe_info)
            {
                $recipe = array(
                    'id' => $recipe_info['id'],
                    'title' => $recipe_info['title'],
                    'picture' => $recipe_info['main_picture']
                );
                $recipe_list[] = $recipe;
            }
            $category_recipe = array(
                'id' => $recipe_category['id'],
                'title' => $recipe_category['description'],
                'recipe_list' => $recipe_list
            );
            $recipe_category_recipe_list[] = $category_recipe;
        }        
        $response['recipe_category_recipe_list'] = $recipe_category_recipe_list;
        return json_encode($response);
    }
    
    /*
     * This method will return recipe info
     * @param $recipe_id, recipe id
     * @Author Nazmul
     */
    function get_recipe_info($recipe_id = 0)
    {
        $result = array();
        $recipe_info = array();
        $recipe_info_array = $this->healthy_recipes_library->get_recipe_info($recipe_id)->result_array();
        if(!empty($recipe_info_array))
        {
            $recipe_info = $recipe_info_array[0];
        }
        $result['recipe_info'] = $recipe_info;
        $recipe_comments_array = $this->healthy_recipes_library->get_all_comments($recipe_id);
        $result['comment_list'] = $recipe_comments_array;
        //echo json_encode($result);
        return json_encode($result);
    }    
}