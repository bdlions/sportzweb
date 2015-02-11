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

    ////////////////////////////////////////////////
    //library

    public function test_get_match_prediction_list( $tournament_id=1 ){
        $where = array(
            'tournament_id' => $tournament_id
        );
        $matches_under_tournament = $this->score_prediction_library->where($where)->test_get_matches()->result_array();
        $sorted_by_team = array();
        $sorted_by_date;
        $win_home_chance=0;
        $draw_game_chance=0;
        $team_name_list = $this->score_prediction_library->test_get_all_teams()->result_array();
        foreach ($matches_under_tournament as $match) {
            $sorted_by_date[ $match['date'] ][] = array(
                'date'  =>  $match['date'],
                'time'  =>  $match['time'],
                'team_home'  =>  $match['team_id_home'],
                'team_away'  =>  $match['team_id_away'],
                'win_home_chance'  =>  $win_home_chance,
                'draw_game_chance'  =>  $draw_game_chance,
            );
            if( $match['status_id'] ==  MATCH_STATUS_UPCOMING || $match['status_id'] ==  MATCH_STATUS_CANCEL  ) {continue;}
            $point_home; $point_away;
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_home=3;} elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_home=0;} elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_home=1;}
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_away=0;} elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_away=3;} elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_away=1;}
            
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
        $team_standings;
        foreach ($sorted_by_team as $team) {
            $team_standings[] = $team;
        }
        usort($team_standings, function($a, $b){
            return $b['point'] - $a['point'];
        });
        
        $match_prediction_data = $this->score_prediction_library->get_predictions_matches_for_tournament()->result_array();
//        var_dump("team_standings");
//        var_dump($team_standings);
//        var_dump("match_prediction_data");
//        var_dump($match_prediction_data);exit;
        
        
        $sports_id = 1;
        
        $tournament_list = array();
        $tournament_list_array = $this->score_prediction_library->get_all_tournaments($sports_id)->result_array();
        foreach($tournament_list_array as $tournament_info)
        {
            $tournament_list[$tournament_info['tournament_id']] = $tournament_info['title'].' '.$tournament_info['season'];
        }
        
        $this->data['team_standings'] = $team_standings;
        $this->data['match_prediction_data'] = $match_prediction_data;
        
        $this->data['tournament_list'] = $tournament_list;
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
        $this->template->load(null,"applications/score_prediction/index", $this->data);

    }
    
    public function post_vote() {
        $match_id = $this->input->post('match_id');
        $user_prediction = $this->input->post('team_id');
        
        //get vote
        $prediction_info = $this->score_prediction_library->get_prediction_info_for_match($match_id)->result_array();
        $predictions = json_decode($prediction_info['prediction_list']);
        
        //checking pending
        
        //append
        $predictions[] = array(
            'user_id' => $this->session->userdata('user_id'),
            'prediction' => $user_prediction
        );
        
        //update vote
        $update_info = $this->score_prediction_library->update_prediction_info_for_match($match_id, $predictions);
        if($update_info !== FALSE){
            $response['message'] = $this->score_prediction_library->messages_alert();
        }else{
            $response['message'] = $this->score_prediction_library->errors_alert();
        }
    } 

    public function get_match_prediction_list(){
        $tournament_id = $this->input->post('tournament_id');
        
        $where = array(
            'tournament_id' => $tournament_id
        );
        $matches_under_tournament = $this->score_prediction_library->where($where)->test_get_matches()->result_array();
        $sorted_by_team = array();
        $sorted_by_date;
        $win_home_chance=0;
        $draw_game_chance=0;
        $team_name_list = $this->score_prediction_library->test_get_all_teams()->result_array();
        foreach ($matches_under_tournament as $match) {
            $sorted_by_date[ $match['date'] ][] = array(
                'date'  =>  $match['date'],
                'time'  =>  $match['time'],
                'team_home'  =>  $match['team_id_home'],
                'team_away'  =>  $match['team_id_away'],
                'win_home_chance'  =>  $win_home_chance,
                'draw_game_chance'  =>  $draw_game_chance,
            );
            if( $match['status_id'] ==  MATCH_STATUS_UPCOMING || $match['status_id'] ==  MATCH_STATUS_CANCEL  ) {continue;}
            $point_home; $point_away;
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_home=3;} elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_home=0;} elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_home=1;}
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_away=0;} elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_away=3;} elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_away=1;}
            
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
        $match_prediction_data = $this->score_prediction_library->get_predictions_matches_for_tournament($tournament_id)->result_array();
//        var_dump("team_standings");
//        var_dump($team_standings);
//        var_dump("match_prediction_data");
//        var_dump($match_prediction_data);exit;
        $result_data['team_standings'] = $team_standings;
        $result_data['match_prediction_data'] = $match_prediction_data;
        echo json_encode($result_data); return;
    }
    
    /*
     * Author Tanveer ahmed
     * @param tournament_id, month
     * responds to ajax call
     */
    public function get_predictions_for_month()
    {
        $tournament_id = $this->input->post('tournament_id');
        $month = $this->input->post('date');
        $where = array(
            'date >=' => "2013-01-01",
            'date <=' => "2016-03-01"
        );
        $match_prediction_data = $this->score_prediction_library->where($where)->get_predictions_matches_for_tournament($tournament_id)->result_array();
        echo json_encode($match_prediction_data); return;

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
        $matches_under_tournament = $this->score_prediction_library->where($where)->test_get_matches()->result_array();
        $sorted_by_team = array();
        $sorted_by_date;
        $win_home_chance=0;
        $draw_game_chance=0;
        $team_name_list = $this->score_prediction_library->test_get_all_teams()->result_array();
        foreach ($matches_under_tournament as $match) {
            $sorted_by_date[ $match['date'] ][] = array(
                'date'  =>  $match['date'],
                'time'  =>  $match['time'],
                'team_home'  =>  $match['team_id_home'],
                'team_away'  =>  $match['team_id_away'],
                'win_home_chance'  =>  $win_home_chance,
                'draw_game_chance'  =>  $draw_game_chance,
            );
            if( $match['status_id'] ==  MATCH_STATUS_UPCOMING || $match['status_id'] ==  MATCH_STATUS_CANCEL  ) {continue;}
            $point_home; $point_away;
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_home=3;} elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_home=0;} elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_home=1;}
            if($match['status_id']==MATCH_STATUS_WIN_HOME){$point_away=0;} elseif ($match['status_id']==MATCH_STATUS_WIN_AWAY){$point_away=3;} elseif ($match['status_id']==MATCH_STATUS_DRAW){$point_away=1;}
            
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
        $match_prediction_data = $this->score_prediction_library->get_predictions_matches_for_tournament($tournament_id)->result_array();
//        var_dump("team_standings");
//        var_dump($team_standings);
//        var_dump("match_prediction_data");
//        var_dump($match_prediction_data);exit;
        $result_data['team_standings'] = $team_standings;
        $result_data['match_prediction_data'] = $match_prediction_data;
        echo json_encode($result_data); return;
    }
}

