<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class Status_feed extends JsonRPCServer {
//class Status_feed extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library("statuses");
        $this->load->library("Trending_features");	
		if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    function get_statuses($status_data = ''){
        $result = array();
        //$status_data = '{"hashtag":"","limit":5,"status_list_id":1,"mapping_id":0,"offset":0,"user_id":4}';
        $data = json_decode($status_data);
        $this->session->set_userdata('user_id', $data->user_id);
        /*$data = new stdClass();
        $data->status_list_id = 1;
        $data->mapping_id = 4;
        $data->limit = 1;
        $data->offset = 0;
        $data->hashtag = ''; */
        
        if($data->status_list_id == STATUS_LIST_HASHTAG)
        {
            $status_ids = $this->trending_features->get_status_ids_hashtag($data->hashtag);
            $newsfeeds = $this->statuses->get_statuses($data->status_list_id, $data->mapping_id, $data->limit, $data->offset, $status_ids);
        }
        else
        {
            $newsfeeds = $this->statuses->get_statuses($data->status_list_id, $data->mapping_id, $data->limit, $data->offset);
        } 
        $result['newsfeeds'] = $newsfeeds;
        //echo json_encode($result);
        return json_encode($result);
    }
    
    /*
     * This method will store a status
     * @param $status_data, status data
     * @Author Nazmul on 23rd November 2014
     */
    function post_status($status_data = '')
    {
        $result = array();
        $data = json_decode($status_data);
        /*$data = new stdClass();
        $data->user_id = 4;
        $data->mapping_id = 4;
        $data->status_type_id = 1;
        $data->status_category_id = 2;
        $data->description = 'test';
        $data->reference_id = '';
        $data->shared_type_id = '';
        $data->via_user_id = '';*/
        
        $this->session->set_userdata('user_id', $data->user_id);
        $additional_data = array();
        $additional_data["user_id"] = $data->user_id;
        $additional_data["mapping_id"] = $data->mapping_id;
        $additional_data["status_type_id"] = $data->status_type_id;
        $additional_data["status_category_id"] = $data->status_category_id;
        $additional_data["description"] = $data->description;
        //$additional_data["reference_id"] = $data->reference_id;
        //$additional_data["shared_type_id"] = $data->shared_type_id;
        //$additional_data["via_user_id"] = $data->via_user_id;
        $status_id = $this->statuses->post_status($additional_data);
        if( $status_id !== FALSE)
        {
            $result['status'] = 1;
			$newsfeeds = $this->statuses->get_statuses(0, 0, 0, 0, $status_id);
			if(!empty($newsfeeds))
			{
				$result['status_info'] = $newsfeeds[0];
			}
        }
        else
        {
            $result['status'] = 0;
        }
        //echo json_encode($result);
        return json_encode($result);
    }
    
    /*
     * This method will post feedback of a status
     * @param $feedback_data, feedback data
     * @Author Nazmul on 23rd November 2014
     */
    function post_feedback($feedback_data = ''){
        $result = array();        
        $data = json_decode($feedback_data);
        /*$data = new stdClass();
        $data->user_id = 4;
        $data->status_id = 10;
        $data->feedback = 'test comment';*/
        $this->session->set_userdata('user_id', $data->user_id);
        $status_id = $data->status_id;
        $feedback = $data->feedback;
        
        $this->statuses->add_feedback($status_id, $feedback);
        $result['status'] = 1;
        //echo json_encode($result);
        return json_encode($result);
    }
	
	function delete_status($status_id = 0)
    {
        $result = array(); 
		if($status_id > 0 )
	    {
			$result['status'] = $this->statuses->delete_status($status_id);
		}
		else
		{
			$result['status'] = FALSE;
		}		
		//echo json_encode($result);
        return json_encode($result);
    }
}