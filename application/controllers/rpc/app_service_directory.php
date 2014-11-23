<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_service_directory extends JsonRPCServer {
//class App_service_directory extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/service_directory_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    /*
     * This method will return service list 
     * This method will retrun service category list
     * @param $param, city or post code
     * @Author Nazmul on 11th November 2014
     */
    function get_services_by_city_or_postcode($param = '')
    {
        $response = array();
        $services_array = $this->service_directory_library->get_all_services()->result_array();
        $service_category_id_service_list = array();
        foreach($services_array as $service_info)
        {
            $service_category_id_service_list[$service_info['service_category_id']][] = $service_info;
        }        
        $response['service_list'] = $services_array;
        
        $service_category_list = array();
        $service_category_list_array = $this->service_directory_library->get_all_service_categories()->result_array();
        foreach($service_category_list_array as $service_category_info)
        {
            $service_category = array(
                'id' => $service_category_info['id'],
                'title' => $service_category_info['description']
            );
            if(array_key_exists($service_category_info['id'], $service_category_id_service_list))
            {
                $service_category['category_service_list'] = $service_category_id_service_list[$service_category_info['id']];
            }
            else
            {
                $service_category['category_service_list'] = array();
            }
            $service_category_list[] = $service_category;
        }
        $response['service_category_list'] = $service_category_list;
        //echo (json_encode($response));
        return json_encode($response);
    }
    
    /*
     * This method will return service info
     * @param $service_id, service id
     * @Author Nazmul on 19th November 2014
     */
    function get_service_info($service_id = 0)
    {
        $response = array();
        $service_info = $this->service_directory_library->get_service_info($service_id)->result_array();
        $service_comment = $this->service_directory_library->get_all_comments($service_id, NEWEST_FIRST,DEFAULT_VIEW_PER_PAGE);
        if(count($service_info)>0) {
            $service_info = $service_info[0];
        }
        $response['service_info'] = $service_info;
        $response['comment_list'] = $service_comment;
        //echo (json_encode($response));
        return json_encode($response);
    }
    
    /*
     * This method will return all service categories
     * @Author Nazmul on 10th November 2014
     */
    /*function get_all_service_categories()
    {
        $response = array();  
        $service_category_list = array();
        $service_category_list_array = $this->service_directory_library->get_all_service_categories()->result_array();
        foreach($service_category_list_array as $service_category_info)
        {
            $service_category = array(
                'id' => $service_category_info['id'],
                'title' => $service_category_info['description']
            );
            $service_category_list[] = $service_category;
        }
        $response['service_category_list'] = $service_category_list;
        //echo (json_encode($response));
        return json_encode($response);
    }*/
}