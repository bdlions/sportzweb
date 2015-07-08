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
            redirect('auth/login', 'refresh');
        }
    }
    /*
     * This method will load home page of score prediction application
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function index($match_id = 0){
        $this->data['message'] = '';
        // sports list for the score prediction application
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
        //populating leader board options
        $leader_board_options = array(
            LEADER_BOARD_OPTION_ALL_TIME => 'All Time',
            LEADER_BOARD_OPTION_THIS_WEEK => 'This Week',
            LEADER_BOARD_OPTION_THIS_MONTH => 'This Month',
            LEADER_BOARD_OPTION_LAST_WEEK => 'Last Week',
            LEADER_BOARD_OPTION_LAST_MONTH => 'Last Month'
        );
        $this->data['leader_board_options'] = $leader_board_options;
        $this->data['date'] = $this->utils->get_current_date_yyyymmdd();
        //at home page we have all types of sports
        $this->data['sports_id'] = 0;
        //user will be able to load home page for a specific match
        $this->data['match_id'] = $match_id;
        if($match_id > 0)
        {
            $match_info_array = $this->score_prediction_library->get_match_info($match_id)->result_array();
            if(!empty($match_info_array))
            {
                $match_info = $match_info_array[0];
                $this->data['date'] = $match_info['date'];
            }
        }
        $this->template->load(null,"applications/score_prediction/index", $this->data);
    }
    /*
     * Ajax call
     * This method will return match list
     * @post date
     * @post sports_id, sports id (optional)
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function get_match_list()
    {
        $response = array();
        $date = $this->input->post('date');
        $sports_id = $this->input->post('sports_id');
        $match_id = $this->input->post('match_id');
        $user_id = $this->session->userdata('user_id');
        //generate match list based on date and sports id
        $sports_list = $this->score_prediction_library->get_match_list($date, $sports_id , $match_id, $user_id);
//        $sports_list['user_id'] = $user_id;
        $response['sports_list'] = $sports_list;
        echo json_encode($response);
        return;
    }
    /*
     * Ajax call
     * This method will return leader board content
     * @post $leader_board_option, leader board selection option
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function get_leader_board_data()
    {

        $response = array();
        $leader_board_option = $this->input->post('leader_board_option');
        $leader_board_data = $this->score_prediction_library->get_leader_board_data($leader_board_option);
        $response['user_list'] = $leader_board_data;
        echo json_encode($response);
    }
    
    /*
     * Ajax Call
     * This method will post vota by a user under a match
     * @post match_id, match id
     * @post user_id, user id
     * @post predicted_match_status_id, match status id
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function post_vote() {
        $response = array();
        $match_id = $this->input->post('match_id');
        $user_id = $this->session->userdata('user_id');
        $predicted_match_status_id = (string)$this->input->post('predicted_match_status_id');  
        $this->score_prediction_library->post_vote($match_id, $predicted_match_status_id, $user_id);        
        $match_info = array();
        $sports_list = $this->score_prediction_library->get_match_list('', 0, $match_id);
        if(!empty($sports_list))
        {
            $sports_info = $sports_list[0];
            $tournament_list = $sports_info['tournament_list'];
            if(!empty($tournament_list))
            {
                $tournament_info = $tournament_list[0];
                $match_list = $tournament_info['match_list'];
                if(!empty($match_list))
                {
                    $match_info = $match_list[0];
                }
            }
        }
        $response['match_info']= $match_info;
        echo json_encode($response);
    }
    /*
     * This method will load home page of a sports
     * @param $sports_id, sports id
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function sports($sports_id){
        $tournament_list = array();
        $tournament_list_array = $this->score_prediction_library->get_all_tournaments($sports_id)->result_array();
        foreach($tournament_list_array as $tournament_info){
            $tournament_list[$tournament_info['tournament_id']] = $tournament_info['title'].' '.$tournament_info['season'];
        }
        $this->data['tournament_list'] = $tournament_list;
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
        $this->data['date'] = $this->utils->get_current_date_yyyymmdd();
        $this->data['sports_id'] = $sports_id;
        $this->data['match_id'] = 0;
        $this->template->load(null,"applications/score_prediction/sports", $this->data);
    }
    /*
     * Ajax call
     * This method will generate league table data
     * @post $tournament_id, tournament id
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function get_league_table_data()
    {
        $response = array();
        $tournament_id = $this->input->post('tournament_id');
        $response = $this->score_prediction_library->get_league_table_data($tournament_id);
        //$response['team_list'] = $team_list;
        echo json_encode($response);
    }
}

