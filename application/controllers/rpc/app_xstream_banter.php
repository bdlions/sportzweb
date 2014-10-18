<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_xstream_banter extends JsonRPCServer {
//class App_xstream_banter extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/xstream_banter_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    public function get_all_sports()
    {
        $response = array();
        $sports_list = $this->xstream_banter_library->app_get_all_sports()->result_array();
        $response['sports_list'] = $sports_list;
        return json_encode($response);
    }
}