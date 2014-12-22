<?php

/*
 * Settings RPC Controller
 * @Author Nazmul on 25th November 2014
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

//class Settings extends JsonRPCServer {
class Settings extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
}