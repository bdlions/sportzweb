<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

//class App_bmi_calculator extends JsonRPCServer {
class App_bmi_calculator extends CI_Controller{
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
    
    public function get_bmi_calculator_data()
    {
        $response = array();
        $metric_height = array();
        $metric_weight = array();
        $imperial_height = array();
        $imperial_weight = array();
        $counter = 1.40;
        while($counter <= 2)
        {
            $m_h_unit = array(
                'id' => $counter,
                'label' => $counter.' m'
            );
            $metric_height[] = $m_h_unit;
            $counter = $counter + 0.01;
        }
        for($counter = 25 ; $counter <= 200; $counter++)
        {
            $m_w_unit = array(
                'id' => $counter,
                'label' => $counter.' kg'
            );
            $metric_weight[] = $m_w_unit;
        }
        for($counter = 55 ; $counter <= 78; $counter++)
        {
            $i_h_unit = array(
                'id' => $counter,
                'label' => $counter.' "'
            );
            $imperial_height[] = $i_h_unit;
        }
        for($counter = 70 ; $counter <= 420; $counter++)
        {
            $i_w_unit = array(
                'id' => $counter,
                'label' => $counter.' st'
            );
            $imperial_weight[] = $i_w_unit;
        }
        $response['metric_height'] = $metric_height;
        $response['metric_weight'] = $metric_weight;
        $response['imperial_height'] = $imperial_height;
        $response['imperial_weight'] = $imperial_weight;
        echo json_encode($response);
    }
}