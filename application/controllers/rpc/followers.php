<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class Followers extends JsonRPCServer {
//class Followers extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('follower');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    /*
     * This method will return follower page of a user
     * @param $user_id, user id
     * @Author Nazmul on 11th November 2014
     */
    function show($user_id)
    {
        $response = array();
        $response['followers'] = $this->follower->get_user_followers($user_id);
        //echo json_encode($response);
        return json_encode($response);
    }
}