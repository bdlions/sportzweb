<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

//class App_xstream_banter extends JsonRPCServer {
class App_xstream_banter extends CI_Controller{
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
    
    public function get_all_tournaments($sports_data = '')
    {
        $response = array();
        $data = json_decode($sports_data);
        /*$data = new stdClass();
        $data->sports_id = 2;*/
        $sports_id = $data->sports_id;
        $tournament_list = $this->xstream_banter_library->app_get_all_tournaments($sports_id)->result_array();
        $response['tournament_list'] = $tournament_list;
        return json_encode($response);
    }
    
    public function get_all_matches($tournament_data = '')
    {
        $response = array();
        $data = json_decode($tournament_data);
        /*$data = new stdClass();
        $data->tournament_id = 1;*/
        $tournament_id = $data->tournament_id;
        $match_list = $this->xstream_banter_library->app_get_all_matches($tournament_id)->result_array();
        $response['match_list'] = $match_list;
        return json_encode($response);
    }
}