<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Score_prediction extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('org/application/score_prediction_library');
        $this->load->library('org/utility/utils');
        if (!$this->ion_auth->logged_in()) {
            //redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';
        
        $current_date = $this->utils->get_current_date_yyyymmdd();
        $configured_sports_id = $this->score_prediction_library->get_home_page_configuration($current_date);
        redirect('applications/score_prediction/sports/'.$configured_sports_id,'refresh');
        
    }
    
    public function sports($sports_id)
    {
        $tournament_list = array();
        $tournament_list_array = $this->score_prediction_library->get_all_tournaments($sports_id)->result_array();
        foreach($tournament_list_array as $tournament_info)
        {
            $tournament_list[$tournament_info['tournament_id']] = $tournament_info['title'].' '.$tournament_info['season'];
        }
        $this->data['tournament_list'] = $tournament_list;
        
        
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
        $this->template->load(null,"applications/score_prediction/index", $this->data);
    }
    
    /*
     * Ajax call to get tournament deatils 
     * @Author Nazmul on 2nd November 2014
     */
    public function get_tournament_details()
    {
        $tournament_id = $this->input->post('tournament_id');
        //return point table and match list of this tournament
    }
    
    public function test()
    {
        //$name = $this->input->post('name');
        $messageInfo = $this->input->post('messageInfo');
        echo 'test method for '.$messageInfo;
    }
    
    
}

