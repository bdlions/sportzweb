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
    
    public function index(){
        $this->data['message'] = '';
        $current_date = $this->utils->get_current_date_yyyymmdd();
        $configured_sports_id = $this->score_prediction_library->get_home_page_configuration($current_date);
        redirect('applications/score_prediction/sports/'.$configured_sports_id,'refresh');
    }
        
    /*
     * Loads home page for score predictions
     */
    public function sports($sports_id){
        $tournament_list = array();
        $tournament_list_array = $this->score_prediction_library->get_all_tournaments($sports_id)->result_array();
        foreach($tournament_list_array as $tournament_info){
            $tournament_list[$tournament_info['tournament_id']] = $tournament_info['title'].' '.$tournament_info['season'];
        }
        $this->data['tournament_list'] = $tournament_list;
        $this->data['sports_list'] = $this->score_prediction_library->get_all_sports()->result_array();
        $this->template->load(null,"applications/score_prediction/index", $this->data);
    }

    /*
     * Responses to ajax call from post_vote()
     * @Author Tanveer Ahmed
     */
    public function post_vote() {
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
    }
    
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
    
}

