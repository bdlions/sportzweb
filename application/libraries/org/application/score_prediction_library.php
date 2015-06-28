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
    public function get_match_list($date = '', $sports_id = 0, $match_id = 0)
    {
        
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