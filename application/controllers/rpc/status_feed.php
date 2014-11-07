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
        //$data = json_decode($status_data);
		$this->session->set_userdata('user_id', 2);
        $data = new stdClass();
        $data->status_list_id = 1;
        $data->mapping_id = 4;
        $data->limit = 3;
        $data->offset = 0;
        $data->hashtag = ''; 
        
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
}