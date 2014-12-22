<?php

/*
 * Settings RPC Controller
 * @Author Nazmul on 6th December 2014
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class Share extends JsonRPCServer {
//class Share extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
		$this->load->library("statuses");
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
	
	public function share_status($status_data = '')
    {
		$result = array();
		//$status_data = '{"reference_id":"20","shared_type_id":"1","description":"shared text","status_category_id":1,"status_type_id":1,"user_id":4,"mapping_id":4}';
        $data = json_decode($status_data);
		
		$this->session->set_userdata('user_id', $data->user_id);
        $additional_data = array();
        $additional_data["user_id"] = $data->user_id;
        $additional_data["mapping_id"] = $data->mapping_id;
        $additional_data["status_type_id"] = $data->status_type_id;
        $additional_data["status_category_id"] = $data->status_category_id;
        $additional_data["description"] = $data->description;
		$additional_data["reference_id"] = $data->reference_id;
		$additional_data["shared_type_id"] = $data->shared_type_id;
		
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
}