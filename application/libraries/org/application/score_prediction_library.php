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
    
    /*public function get_home_page_configuration($date)
    {
        $sports_id = 0;
        $configuration_array = $this->score_prediction_model->get_home_page_configuration_info($date)->result_array();
        if(!empty($configuration_array))
        {
            $configuration_info = $configuration_array[0];
            $sports_id = $configuration_info['sports_id'];
        }
        else
        {
            $sports_list = $this->score_prediction_model->get_all_sports()->result_array();
            if(!empty($sports_list))
            {
                $sports_info = $sports_list[0];
                $sports_id = $sports_info['sports_id'];
            }
        }
        return $sports_id;
    }*/
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
        $match_list_array = $this->score_prediction_model->get_all_matches($date, $sports_id, $match_id)->result_array();
        $sports_list = array();
        $tournaments = array();
        $sports = array();
        foreach($match_list_array as $match_info)
        {
            $match_info['is_predicted'] = 0;
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
            
            
            
//            $sports_list[$match_info['sports_id']]['title'] = $match_info['sports_title'];
//            $sports_list[$match_info['sports_id']]['sports_id'] = $match_info['sports_id'];
//            $sports_list[$match_info['sports_id']]['tournament_list'][$match_info['tournament_id']]['tournament_id'] = $match_info['tournament_id'];
//            $sports_list[$match_info['sports_id']]['tournament_list'][$match_info['tournament_id']]['title'] = $match_info['tournament_title'];
//            $sports_list[$match_info['sports_id']]['tournament_list'][$match_info['tournament_id']]['match_list'][$match_info['match_id']] = $match_info;
//            //print_r($sports_list);
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
    public function post_vote($match_id, $predicted_match_status_id, $user_id)
    {
        $prediction_list = array();
        $prediction_info = new stdClass();
        $prediction_info->user_id = $user_id;
        $prediction_info->prediction_id = $predicted_match_status_id;
        $prediction_info->created_on = now();
        $match_predictions_array = $this->score_prediction_model->get_match_predictions($match_id)->result_array();
        if(empty($match_predictions_array))
        {
            
            $prediction_list[] = $prediction_info;
            $additional_data = array(
                'match_id' => $match_id,
                'prediction_list' => json_encode($prediction_list)
            );
            $this->score_prediction_model->add_prediction($additional_data);
        }
        else
        {
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
        
    }
    /*
     * This method will prepare league table data
     * @param $tournament_id, tournament id
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function get_league_table_data($tournament_id)
    {
        
    }
}