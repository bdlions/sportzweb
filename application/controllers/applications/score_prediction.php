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
    
    /*public function index(){
        $this->data['message'] = '';
        $current_date = $this->utils->get_current_date_yyyymmdd();
        $sports_id = $this->score_prediction_library->get_home_page_configuration($current_date);
//        redirect('applications/score_prediction/sports/'.$configured_sports_id,'refresh');
         
        $tournament_list = array();
        $tournament_list_array = $this->score_prediction_library->get_all_tournaments($sports_id)->result_array();
        foreach($tournament_list_array as $tournament_info){
            $tournament_list[$tournament_info['tournament_id']] = $tournament_info['title'].' '.$tournament_info['season'];
        }
        $this->data['tournament_list'] = $tournament_list;
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
        $this->template->load(null,"applications/score_prediction/index", $this->data);
    }*/
        
    /*
     * Loads home page for score predictions
     */
//    public function sports($sports_id){
//        $tournament_list = array();
//        $tournament_list_array = $this->score_prediction_library->get_all_tournaments($sports_id)->result_array();
//        foreach($tournament_list_array as $tournament_info){
//            $tournament_list[$tournament_info['tournament_id']] = $tournament_info['title'].' '.$tournament_info['season'];
//        }
//        $this->data['tournament_list'] = $tournament_list;
//        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
//        $this->template->load(null,"applications/score_prediction/sports", $this->data);
//    }
    public function predicted_result_view(){
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
       $this->template->load(null,"applications/score_prediction/preticted_result_view", $this->data);
    }

    /*
     * Responses to ajax call from post_vote()
     * @Author Tanveer Ahmed
     */
    /*public function post_vote() {
        $predictions = array();
        $match_id = (string)$this->input->post('match_id');
        $user_id = (string)$this->session->userdata('user_id');
        $user_prediction = (string)$this->input->post('match_status_id');
        $prediction_info = $this->score_prediction_library->get_prediction_info_for_match($match_id)->result_array();
        if( !empty($prediction_info)  ){
            $prediction_info = $prediction_info[0];
            $predictions = json_decode($prediction_info['prediction_list'], TRUE);
            if( !isset($predictions[$user_id]) ){
                $predictions[$user_id] = $user_prediction;
            }
            $predictions = json_encode($predictions);
            $update_info = $this->score_prediction_library->update_prediction($match_id, $predictions);
        }
        else {
            $predictions[$user_id] = $user_prediction;
            $predictions = json_encode($predictions);
            $additional_data = array(
                'match_id' => $match_id,
                'prediction_list' => $predictions
            );
            $update_info = $this->score_prediction_library->add_prediction($additional_data);
        }
        if($update_info !== FALSE){
            $response['message'] = $this->score_prediction_library->messages_alert();
        }else{
            $response['message'] = $this->score_prediction_library->errors_alert();
        }
        echo json_encode($response); return;
    }*/
    
    /*
     * @Author Tanveer ahmed
     * @param tournament_id, month
     * responds to ajax call
     */
    public function get_predictions_for_month(){
        $user_id = $this->session->userdata('user_id');
        $tournament_id  = $this->input->post('tournament_id');
        $current_month  = $this->input->post('current_month');
        $next_month     = $this->input->post('next_month');
        $where = array(
            'date >=' => $current_month,
            'date <' => $next_month
        );
        $match_prediction_data = $this->score_prediction_library->where($where)->get_predictions_matches_for_tournament($tournament_id)->result_array();
        foreach ($match_prediction_data as $match_data_key=>$match_data) {
            if($match_data['status_id'] != MATCH_STATUS_UPCOMING) {unset($match_prediction_data[$match_data_key]); continue;} //to be updated according to client
            $match_prediction_data[$match_data_key]['win_home_chance']  = 0;
            $match_prediction_data[$match_data_key]['win_away_chance']  = 0;
            $match_prediction_data[$match_data_key]['draw_game_chance'] = 0;
            $match_prediction_data[$match_data_key]['can_predict'] = 1;
            if(isset($match_data['prediction_list'])){
                $match_predictions = json_decode($match_data['prediction_list'], TRUE);
                $prediction_length = sizeof($match_predictions);
                foreach($match_predictions as $prediction){
                    if      ($prediction == MATCH_STATUS_WIN_HOME)  {$match_prediction_data[$match_data_key]['win_home_chance']     += (1/($prediction_length));}
                    elseif  ($prediction == MATCH_STATUS_WIN_AWAY)  {$match_prediction_data[$match_data_key]['win_away_chance']     += (1/($prediction_length));}
                    elseif  ($prediction == MATCH_STATUS_DRAW)      {$match_prediction_data[$match_data_key]['draw_game_chance']    += (1/($prediction_length));}
                }
                if(isset($match_data['prediction_list'][$user_id])){
                    $match_prediction_data[$match_data_key]['can_predict'] = 0;
                }
            }
        }
        $predictions_by_date = array();
        foreach ($match_prediction_data as $value) {
            $predictions_by_date[$value['date']][] = $value;
        }
        ksort($predictions_by_date);
        echo json_encode($predictions_by_date); return;
    } 
    
    /*
     * Author Tanveer ahmed
     * @param tournament_id, month
     * responds to ajax call 
     */
    public function get_team_standings(){
        $tournament_id = $this->input->post('tournament_id');
        
        $where = array(
            'tournament_id' => $tournament_id
        );
        $matches_under_tournament = $this->score_prediction_library->where($where)->get_matches()->result_array();
        $sorted_by_team = array();
        $team_name_list = $this->score_prediction_library->get_all_teams()->result_array();
        foreach ($matches_under_tournament as $match) {
            if( $match['status_id'] ==  MATCH_STATUS_UPCOMING || $match['status_id'] ==  MATCH_STATUS_CANCEL  ) {continue;}
            $point_home; $point_away;
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_home=SCORE_WIN;}  elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_home=SCORE_LOSE;} elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_home=SCORE_DRAW;}
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_away=SCORE_LOSE;} elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_away=SCORE_WIN;}  elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_away=SCORE_DRAW;}
            
            //home
            $sorted_by_team[ $match['team_id_home'] ]['team_name'] = $team_name_list[$match['team_id_home']-1]['title'];
            
            if( !isset($sorted_by_team[ $match['team_id_home'] ]['point']) ){$sorted_by_team[ $match['team_id_home'] ]['point']=0;}
            $sorted_by_team[ $match['team_id_home'] ]['point'] += $match['point_home'];
            
            if( !isset($sorted_by_team[ $match['team_id_home'] ]['gd']) ){$sorted_by_team[ $match['team_id_home'] ]['gd']=0;}
            $sorted_by_team[ $match['team_id_home'] ]['gd'] += (int)$match['score_home'] - (int)$match['score_away'];
            
            if( !isset($sorted_by_team[ $match['team_id_home'] ]['played']) ){$sorted_by_team[ $match['team_id_home'] ]['played']=0;}
            $sorted_by_team[ $match['team_id_home'] ]['played'] += 1; //$to_be_ fixes
            
            //away
            $sorted_by_team[ $match['team_id_away'] ]['team_name'] = $team_name_list[$match['team_id_away']-1]['title'];
            
            if( !isset($sorted_by_team[ $match['team_id_away'] ]['point']) ){$sorted_by_team[ $match['team_id_away'] ]['point']=0;}
            $sorted_by_team[ $match['team_id_away'] ]['point'] += $match['point_away'];
            
            if( !isset($sorted_by_team[ $match['team_id_away'] ]['gd']) ){$sorted_by_team[ $match['team_id_away'] ]['gd']=0;}
            $sorted_by_team[ $match['team_id_away'] ]['gd'] += (int)$match['score_away'] - (int)$match['score_home'];
            
            if( !isset($sorted_by_team[ $match['team_id_away'] ]['played']) ){$sorted_by_team[ $match['team_id_away'] ]['played']=0;}
            $sorted_by_team[ $match['team_id_away'] ]['played'] += 1; //$to_be_ fixes
        }
        $team_standings=array();
        foreach ($sorted_by_team as $team) {
            $team_standings[] = $team;
        }
        if(!empty($team_standings)){
        usort($team_standings, function($a, $b){
            return $b['point'] - $a['point'];
        });}
        $result_data['team_standings'] = $team_standings;
        echo json_encode($result_data); return;
    }
    
    //------------------------------------------------------------------------//
    /*
     * This method will load home page of score prediction application
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function index($match_id = 0){
        $this->data['message'] = '';
        // sports list for the score prediction application
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
        $leader_board_options = array(
            LEADER_BOARD_OPTION_ALL_TIME => 'All Time',
            LEADER_BOARD_OPTION_THIS_WEEK => 'This Week',
            LEADER_BOARD_OPTION_THIS_MONTH => 'This Month',
            LEADER_BOARD_OPTION_LAST_WEEK => 'Last Week',
            LEADER_BOARD_OPTION_LAST_MONTH => 'Last Month'
        );
        $this->data['leader_board_options'] = $leader_board_options;
        $this->data['sports_id'] = 0;
        $this->data['match_id'] = $match_id;
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
        $date = (string)$this->input->post('date');
        $sports_id = (string)$this->session->userdata('sports_id');
        //generate match list based on date and sports id
        $match1 = array(
            'match_id' => 1,
            'time' => '13:00',
            'team_title_home' => 'Chelsea',
            'team_title_away' => 'Arsenal',
            'status_id' => 2,
            'score_home' => 2,
            'score_away' => 0,
            'is_predicted' => 1,
            'prediction_info' => array(
                'home' => '40%',
                'draw' => '50%',
                'away' => '10%'
            )
        );
        $match2 = array(
            'match_id' => 2,
            'time' => '14:00',
            'team_title_home' => 'Tottenham',
            'team_title_away' => 'Chelsea',
            'status_id' => 1,
            'score_home' => 0,
            'score_away' => 0,
            'is_predicted' => 1,
            'prediction_info' => array(
                'home' => '20%',
                'draw' => '0%',
                'away' => '80%'
            )
        );
        $match3 = array(
            'match_id' => 3,
            'time' => '15:00',
            'team_title_home' => 'Arsenal',
            'team_title_away' => 'Swansea',
            'status_id' => 1,
            'score_home' => 0,
            'score_away' => 0,
            'is_predicted' => 0,
            'prediction_info' => array(
                'home' => '50%',
                'draw' => '30%',
                'away' => '20%'
            )
        );
        $t1_match_list = array();
        $t1_match_list[] = $match1;
        $t1_match_list[] = $match2;
        $t1_match_list[] = $match3;
        $tournament1 = array(
            'title' => 'Barclays premier league 2014/15',
            'match_list' => $t1_match_list
        );
        $match4 = array(
            'match_id' => 4,
            'time' => '16:00',
            'team_title_home' => 'Hull',
            'team_title_away' => 'Aston Villa',
            'status_id' => 3,
            'score_home' => 2,
            'score_away' => 3,
            'is_predicted' => 1,
            'prediction_info' => array(
                'home' => '50%',
                'draw' => '40%',
                'away' => '10%'
            )
        );
        $match5 = array(
            'match_id' => 5,
            'time' => '17:00',
            'team_title_home' => 'Aston Villa',
            'team_title_away' => 'Man City',
            'status_id' => 1,
            'score_home' => 0,
            'score_away' => 0,
            'is_predicted' => 1,
            'prediction_info' => array(
                'home' => '20%',
                'draw' => '10%',
                'away' => '70%'
            )
        );
        $match6 = array(
            'match_id' => 6,
            'time' => '18:00',
            'team_title_home' => 'Man City',
            'team_title_away' => 'Hull',
            'status_id' => 1,
            'score_home' => 0,
            'score_away' => 0,
            'is_predicted' => 0,
            'prediction_info' => array(
                'home' => '20%',
                'draw' => '30%',
                'away' => '50%'
            )
        );
        $t2_match_list = array();
        $t2_match_list[] = $match4;
        $t2_match_list[] = $match5;
        $t2_match_list[] = $match6;
        $tournament2 = array(
            'title' => 'Championship 2014/15',
            'match_list' => $t2_match_list
        );
        $s1_tournament_list = array();
        $s1_tournament_list[] = $tournament1;
        $s1_tournament_list[] = $tournament2;
        $sports1 = array(
            'title' => 'Football',
            'tournament_list' => $s1_tournament_list
        );
        $sports_list = array();
        $sports_list[] = $sports1;
        $match7 = array(
            'match_id' => 7,
            'time' => '09:30',
            'team_title_home' => 'Bangladesh',
            'team_title_away' => 'India',
            'status_id' => 4,
            'score_home' => 0,
            'score_away' => 0,
            'is_predicted' => 1,
            'prediction_info' => array(
                'home' => '40%',
                'draw' => '50%',
                'away' => '10%'
            )
        );
        $match8 = array(
            'match_id' => 8,
            'time' => '15:00',
            'team_title_home' => 'Bangladesh',
            'team_title_away' => 'India',
            'status_id' => 1,
            'score_home' => 0,
            'score_away' => 0,
            'is_predicted' => 1,
            'prediction_info' => array(
                'home' => '20%',
                'draw' => '0%',
                'away' => '80%'
            )
        );
        $match9 = array(
            'match_id' => 9,
            'time' => '18:00',
            'team_title_home' => 'Bangladesh',
            'team_title_away' => 'India',
            'status_id' => 1,
            'score_home' => 0,
            'score_away' => 0,
            'is_predicted' => 0,
            'prediction_info' => array(
                'home' => '50%',
                'draw' => '30%',
                'away' => '20%'
            )
        );
        $t3_match_list = array();
        $t3_match_list[] = $match7;
        $t3_match_list[] = $match8;
        $t3_match_list[] = $match9;
        $tournament3 = array(
            'title' => 'Bangladesh vs India Series 2015',
            'match_list' => $t3_match_list
        );
        $s2_tournament_list = array();
        $s2_tournament_list[] = $tournament3;
        $sports2 = array(
            'title' => 'Cricket',
            'tournament_list' => $s2_tournament_list
        );
        $sports_list[] = $sports2;
        $response['sports_list'] = $sports_list;
        echo json_encode($response);
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
        //generate leader board data based on leader board option
        $user1 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user2 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user3 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user4 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user5 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user6 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user7 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user8 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user9 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user10 = array(
            'rank' => 1,
            'user_info' => array(
                'user_id' => 1,
                'first_name' => 'Shem',
                'last_name' => 'Haye',
                'picture' => 'user_male.png'
            ),
            'prediction' => '95%',
            'score' => '95'
        );
        $user_list = array();
        $user_list[] = $user1;
        $user_list[] = $user2;
        $user_list[] = $user3;
        $user_list[] = $user4;
        $user_list[] = $user5;
        $user_list[] = $user6;
        $user_list[] = $user7;
        $user_list[] = $user8;
        $user_list[] = $user9;
        $user_list[] = $user10;
        $response['user_list'] = $user_list;
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
        $this->data['sports_id'] = $sports_id;
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
        $team1 = array(
            'position' => 1,
            'title' => 'Aston Villa',
            'point' => '2',
            'difference' => '0',
            'points' => '4'
        );
        $team2 = array(
            'position' => 2,
            'title' => 'Chelsea',
            'point' => '1',
            'difference' => '0',
            'points' => '3'
        );
        $team3 = array(
            'position' => 3,
            'title' => 'Arsenal',
            'point' => '1',
            'difference' => '0',
            'points' => '1'
        );
        $team4 = array(
            'position' => 4,
            'title' => 'Southampton',
            'point' => '2',
            'difference' => '0',
            'points' => '0'
        );
        $team_list = array();
        $team_list[] = $team1;
        $team_list[] = $team2;
        $team_list[] = $team3;
        $team_list[] = $team4;
        $response['team_list'] = $team_list;
        echo json_encode($response);
    }
}

