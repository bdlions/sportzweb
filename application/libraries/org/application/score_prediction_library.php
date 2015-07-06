<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Score Prediction Library
 *
 * Author: @Nazmul
 * 
 * Requirements: PHP5 or above
 *
 */
class Score_prediction_library {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('org/application/score_prediction_model');
        $this->score_prediction_model->trigger_events('library_constructor');
    }
    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->score_prediction_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in score_prediction_model');
        }

        return call_user_func_array(array($this->score_prediction_model, $method), $arguments);
    }
    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }
    /*
     * This method will return match list
     * $param $date, date of the matches
     * @param $sports_id, sports id of the matches
     * @param $match_id, if we need only a match
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function get_match_list($date = '', $sports_id = 0, $match_id = 0, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        //retrieving match list
        $match_list_array = $this->score_prediction_model->get_all_matches($date, $sports_id, $match_id)->result_array();
        $sports_list = array();
        $tournaments = array();
        $sports = array();
        foreach($match_list_array as $match_info)
        {
            //whether the match is predicted by current user or not
            $match_info['is_predicted'] = 0;
            $match_info['my_prediction_id'] = 0;
            //inatializing match prediction info
            $match_info['prediction_info'] = array(
                'home' => '0%',
                'draw' => '0%',
                'away' => '0%'
            );
            $p_list = $match_info['prediction_list'];
            if($p_list != NULL && $p_list != "")
            {
                $prediction_list = json_decode($p_list);
                $home_win_prediction_counter = 0;
                $draw_prediction_counter = 0;
                $away_win_prediction_counter = 0;
                $prediction_counter = 0;
                foreach($prediction_list as $prediction_info)
                {
                    if($prediction_info->user_id == $user_id)
                    {
                        $match_info['is_predicted'] = 1;
                        $match_info['my_prediction_id'] = $prediction_info->prediction_id;
                    }
                    if($prediction_info->prediction_id == MATCH_STATUS_WIN_HOME)
                    {
                        $home_win_prediction_counter++;
                    }
                    else if($prediction_info->prediction_id == MATCH_STATUS_DRAW)
                    {
                        $draw_prediction_counter++;
                    }
                    else if($prediction_info->prediction_id == MATCH_STATUS_WIN_AWAY)
                    {
                        $away_win_prediction_counter++;
                    }
                    $prediction_counter++;
                }
                if($prediction_counter > 0)
                {
                    //calculating match prediciton ratio
                    $match_info['prediction_info']['home'] = round($home_win_prediction_counter/$prediction_counter*100);
                    $match_info['prediction_info']['draw'] = round($draw_prediction_counter/$prediction_counter*100);
                    $match_info['prediction_info']['away'] = round($away_win_prediction_counter/$prediction_counter*100);
                    $match_info['prediction_info']['home'] = $match_info['prediction_info']['home']."%";
                    $match_info['prediction_info']['draw'] = $match_info['prediction_info']['draw']."%";
                    $match_info['prediction_info']['away'] = $match_info['prediction_info']['away']."%";
                }
            }  
            
            $tournaments[$match_info['tournament_id']]['title'] = $match_info['tournament_title'];
            $tournaments[$match_info['tournament_id']]['tournament_id'] = $match_info['tournament_id'];
            $tournaments[$match_info['tournament_id']]['match_list'][] = $match_info;
            
            $sports[$match_info['sports_id']]['title'] = $match_info['sports_title'];
            $sports[$match_info['sports_id']]['sports_id'] = $match_info['sports_id'];
            if(!array_key_exists("tournament_id_list", $sports[$match_info['sports_id']]) || !in_array($match_info['tournament_id'], $sports[$match_info['sports_id']]['tournament_id_list']))
            {
                $sports[$match_info['sports_id']]['tournament_id_list'][] = $match_info['tournament_id'];
            }
        }
        foreach($sports as $sports_id => $sports_info)
        {
            $tournament_list = array();
            foreach($sports_info['tournament_id_list'] as $tournament_id)
            {
                $tournament_info = $tournaments[$tournament_id];
                $tournament_list[] = $tournament_info;
            }
            $sports_info['tournament_list'] = $tournament_list;
            
            $sports_list[] = $sports_info;
        }
        return $sports_list;
    }
    /*
     * This method will store user vote for a match
     * @param $match_id, match id
     * @param $predicted_match_status_id, user prediction about the match
     * @param $user_id, user id
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function post_vote($match_id, $predicted_match_status_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $prediction_list = array();
        $prediction_info = new stdClass();
        $prediction_info->user_id = $user_id;
        $prediction_info->prediction_id = $predicted_match_status_id;
        $prediction_info->created_on = now();
        $match_predictions_array = $this->score_prediction_model->get_match_predictions($match_id)->result_array();
        if(empty($match_predictions_array))
        {
            //storing first vote of this match
            $prediction_list[] = $prediction_info;
            $additional_data = array(
                'match_id' => $match_id,
                'prediction_list' => json_encode($prediction_list)
            );
            $this->score_prediction_model->add_prediction($additional_data);
        }
        else
        {
            //updating vote of this match
            $match_predictions_info = $match_predictions_array[0];
            $p_list = $match_predictions_info['prediction_list'];
            if($p_list != NULL && $p_list != "")
            {
                $prediction_list = json_decode($p_list);
                $prediction_list[] = $prediction_info;
            }
            $additional_data = array(
                'prediction_list' => json_encode($prediction_list)
            );
            $this->score_prediction_model->update_prediction($match_id, $additional_data);
        }
    }
    /*
     * This method will prepare leader board data
     * @param $leader_board_option, leader board option selected by the user
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function get_leader_board_data($leader_board_option)
    {
        $leader_board_data = array();
        $leader_board_user_list = array();
        $user_id_list = array();
        $user_id_info_map = array();        
        //processing start date and end date based on selected option at leader board
        $start_date = '';
        $end_date = '';
        $date_range = '';
        if($leader_board_option == LEADER_BOARD_OPTION_THIS_WEEK)
        {
            $date_range = $this->utils->get_this_week_date_range();
        }
        else if($leader_board_option == LEADER_BOARD_OPTION_LAST_WEEK)
        {
            $date_range = $this->utils->get_last_week_date_range();
        }
        else if($leader_board_option == LEADER_BOARD_OPTION_THIS_MONTH)
        {
            $date_range = $this->utils->get_this_month_date_range();
        }
        else if($leader_board_option == LEADER_BOARD_OPTION_LAST_MONTH)
        {
            $date_range = $this->utils->get_last_month_date_range();
        }
        if($date_range != '')
        {
            $start_date =  $date_range['start_date'];
            $end_date =  $date_range['end_date'];
        }
        //retrieving match list based on the dates
        $match_list_array = $this->score_prediction_model->get_leader_board_matches($start_date, $end_date)->result_array();
        foreach($match_list_array as $match_info)
        {
            $p_list = $match_info['prediction_list'];
            if($p_list != NULL && $p_list != "")
            {
                $prediction_list = json_decode($p_list);
                foreach($prediction_list as $prediction_info)
                {
                    if(!array_key_exists($prediction_info->user_id, $leader_board_data))
                    {
                        $leader_board_data[$prediction_info->user_id]['correct_predictions'] = 0;
                        $leader_board_data[$prediction_info->user_id]['total_predictions'] = 0;
                        $leader_board_data[$prediction_info->user_id]['prediction_ratio'] = 0;
                        $leader_board_data[$prediction_info->user_id]['score'] = 0;
                        $leader_board_data[$prediction_info->user_id]['user_id'] = $prediction_info->user_id; 
                    }
                    if($match_info['status_id'] == $prediction_info->prediction_id)
                    {
                        $leader_board_data[$prediction_info->user_id]['correct_predictions'] = ($leader_board_data[$prediction_info->user_id]['correct_predictions'] + 1);
                        $leader_board_data[$prediction_info->user_id]['score'] = ($leader_board_data[$prediction_info->user_id]['score'] + LEADER_BOARD_CORRECT_PREDICTION_SCORE);
                    }
                    $leader_board_data[$prediction_info->user_id]['total_predictions'] = ($leader_board_data[$prediction_info->user_id]['total_predictions'] + 1);
                    $leader_board_data[$prediction_info->user_id]['prediction_ratio'] = round($leader_board_data[$prediction_info->user_id]['correct_predictions'] / $leader_board_data[$prediction_info->user_id]['total_predictions'] * 100);
                }
            }
        }        
        //sorting user list based on score
        $temp_user_list = array();
        $score = array();
        foreach($leader_board_data as $key => $user_score_info)
        {
            $score[$key] = $user_score_info['prediction_ratio'];
            $temp_user_list[] = $user_score_info;
        }
        array_multisort($score, SORT_DESC, $temp_user_list);
        //getting users ids which will be displayed at leader board
        $user_counter = 0;
        foreach($temp_user_list as $user_score_info)
        {
            if(!in_array($prediction_info->user_id, $user_id_list))
            {
                $user_id_list[] = $user_score_info['user_id'];
            }
            $user_counter++;
            if( $user_counter == LEADER_BOARD_MAXIMUM_USERS )
            {
                break;
            }
        }
        //getting user info based on user ids
        if (!empty($user_id_list)) {
            $user_info_array = $this->score_prediction_model->get_users($user_id_list)->result_array();
            foreach ($user_info_array as $user_info) {
                $user_id_user_info_map[$user_info['user_id']] = $user_info;
            }
        }
        //appending user info at leader board users
        foreach($temp_user_list as $user_score_info)
        {
            $user_score_info['user_info'] = $user_id_user_info_map[$user_score_info['user_id']];
            $leader_board_user_list[] = $user_score_info;
        }        
        return $leader_board_user_list;
    }
    /*
     * This method will prepare league table data
     * @param $tournament_id, tournament id
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function get_league_table_data($tournament_id)
    {
        $result = array();
        $team_list = array();
        $league_table_data = array();
        
        $league_table_configuration = array();
        $league_table_configuration[] = 1;
        $league_table_configuration[] = 4;
        $league_table_configuration[] = 5;
        $league_table_configuration[] = 6;
        $league_table_configuration[] = 7;  
        
        //retrieving match list for a tournament
        $match_list_array = $this->score_prediction_model->get_league_table_matches($tournament_id)->result_array();
        foreach($match_list_array as $match_info)
        {
            //initializing team data
            if(!array_key_exists($match_info['team_id_home'], $league_table_data))
            {
                $league_table_data[$match_info['team_id_home']]['rank'] = 0;
                $league_table_data[$match_info['team_id_home']]['title'] = $match_info['home_team_title'];
                $league_table_data[$match_info['team_id_home']]['played_matches'] = 0;
                $league_table_data[$match_info['team_id_home']]['score_difference'] = 0;
                $league_table_data[$match_info['team_id_home']]['points'] = 0;
            }
            if(!array_key_exists($match_info['team_id_away'], $league_table_data))
            {
                $league_table_data[$match_info['team_id_away']]['rank'] = 0;
                $league_table_data[$match_info['team_id_away']]['title'] = $match_info['away_team_title'];
                $league_table_data[$match_info['team_id_away']]['played_matches'] = 0;
                $league_table_data[$match_info['team_id_away']]['score_difference'] = 0;
                $league_table_data[$match_info['team_id_away']]['points'] = 0;
            }
            //updating team data
            $league_table_data[$match_info['team_id_home']]['played_matches'] = ($league_table_data[$match_info['team_id_home']]['played_matches'] + 1);
            $league_table_data[$match_info['team_id_home']]['points'] = ($league_table_data[$match_info['team_id_home']]['points'] + $match_info['point_home']);
            $league_table_data[$match_info['team_id_home']]['score_difference'] =  ($league_table_data[$match_info['team_id_home']]['score_difference'] + $match_info['score_home'] - $match_info['score_away']);
            
            $league_table_data[$match_info['team_id_away']]['played_matches'] = ($league_table_data[$match_info['team_id_away']]['played_matches'] + 1);
            $league_table_data[$match_info['team_id_away']]['points'] = ($league_table_data[$match_info['team_id_away']]['points'] + $match_info['point_away']);
            $league_table_data[$match_info['team_id_away']]['score_difference'] =  ($league_table_data[$match_info['team_id_away']]['score_difference'] + $match_info['score_away'] - $match_info['score_home']);
        }
        //sorting team list based on points
        $points = array();
        foreach($league_table_data as $key => $team_score_info)
        {
            $points[$key] = $team_score_info['points'];
            $team_list[] = $team_score_info;
        }
        array_multisort($points, SORT_DESC, $team_list);
        $counter = 1;
        $result_team_list = array();
        foreach($team_list as $team_info)
        {
            $result_team_info = array();
            if(in_array(LEAGUE_TABLE_POSITION_ID, $league_table_configuration))
            {
                $result_team_info['column1'] = $counter++;
            }
            if(in_array(LEAGUE_TABLE_DRIVERS_ID, $league_table_configuration))
            {
                $result_team_info['column2'] = $team_info['title'];
            }
            if(in_array(LEAGUE_TABLE_PLAYERS_ID, $league_table_configuration))
            {
                $result_team_info['column3'] = $team_info['title'];
            }
            if(in_array(LEAGUE_TABLE_TEAMS_ID, $league_table_configuration))
            {
                $result_team_info['column4'] = $team_info['title'];
            }
            if(in_array(LEAGUE_TABLE_PLAYED_ID, $league_table_configuration))
            {
                $result_team_info['column5'] = $team_info['played_matches'];
            }
            if(in_array(LEAGUE_TABLE_GOAL_DIFFERENCE_ID, $league_table_configuration))
            {
                $result_team_info['column6'] = $team_info['score_difference'];
            }
            if(in_array(LEAGUE_TABLE_POINTS_ID, $league_table_configuration))
            {
                $result_team_info['column7'] = $team_info['points'];
            }
            $result_team_list[] = $result_team_info;
        }
        $result['team_list'] = $result_team_list;
        if(in_array(LEAGUE_TABLE_POSITION_ID, $league_table_configuration))
        {
            $league_table_header_title_list[] = 'POS';            
        }
        if(in_array(LEAGUE_TABLE_DRIVERS_ID, $league_table_configuration))
        {
            $league_table_header_title_list[] = 'DRIVER';            
        }
        if(in_array(LEAGUE_TABLE_PLAYERS_ID, $league_table_configuration))
        {
            $league_table_header_title_list[] = 'PLAYER';            
        }
        if(in_array(LEAGUE_TABLE_TEAMS_ID, $league_table_configuration))
        {
            $league_table_header_title_list[] = 'TEAM';            
        }
        if(in_array(LEAGUE_TABLE_PLAYED_ID, $league_table_configuration))
        {
            $league_table_header_title_list[] = 'P';            
        }
        if(in_array(LEAGUE_TABLE_GOAL_DIFFERENCE_ID, $league_table_configuration))
        {
            $league_table_header_title_list[] = 'GD';            
        }
        if(in_array(LEAGUE_TABLE_POINTS_ID, $league_table_configuration))
        {
            $league_table_header_title_list[] = 'PTS';            
        }
        $result['league_table_header_title_list'] = $league_table_header_title_list;
        return $result;
    }
}