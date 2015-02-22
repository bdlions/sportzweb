<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Score Prediciton Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Score_prediction_model extends Ion_auth_model
{
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return all sports
     * @Author Nazmul on 26th October 2014
     */
    public function get_all_sports()
    {
        return $this->db->select($this->tables['app_sp_sports'].'.id as sports_id,'.$this->tables['app_sp_sports'].'.*')
                    ->from($this->tables['app_sp_sports'])
                    ->get();
    }

    /*
     * This method will return all tournaments
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_tournaments($sports_id)
    {
        $this->db->where('sports_id', $sports_id);
        return $this->db->select($this->tables['app_sp_tournaments'].'.id as tournament_id,'.$this->tables['app_sp_tournaments'].'.*')
                    ->from($this->tables['app_sp_tournaments'])
                    ->get();
    }
    
    /*
     * This method will retrun home page configuration of a date
     * If there is no configuration for a date then it will return previously latest configured info
     * @param, $date, configuration date
     * @Author Namzul on 26th October 2014
     */
    public function get_home_page_configuration_info($date)
    {
        $this->db->where('selected_date <=',$date);
        $result = $this->db->select('*')
                        ->from($this->tables['app_sp_configure_homepage'])
                        ->order_by('id', 'desc')
                        ->limit(1)
                        ->get();
        return $result;
    }
    
    /*
     * Returns all team names from app_sp_teams
     * @Author Tanveer Ahmed
     */
    public function get_all_teams() {
        return $this->db->select('*')
                        ->from($this->tables['app_sp_teams'])
                        ->get();
    }
    
    /*
     * Selectively returns matches from app_sp_matches
     */
    public function get_matches() {
        if (isset($this->_ion_where)) {
            foreach ($this->_ion_where as $where) {
                $this->db->where($where);
            }
            $this->_ion_where = array();
        }
        return $this->db->select('*')
                        ->from($this->tables['app_sp_matches'])
                        ->get();
    }
    
    /*
     * Returns prediction info for a match
     * @Author Tanveer Ahmed
     */
    public function get_prediction_info_for_match( $match_id ) {
        $this->db->where('match_id', $match_id);
        return $this->db->select('*')
                        ->from($this->tables['app_sp_match_predictions'])
                        ->get();
    }
    
    /*
     * Called when no predictions is under a match
     * @Aythor Tanveer Ahmed on 22-02-15
     */
    public function add_prediction( $additional_data )
    {
        $data = $this->_filter_data($this->tables['app_sp_match_predictions'], $additional_data);
        $this->db->insert($this->tables['app_sp_match_predictions'], $additional_data);
        $insert_id = $this->db->insert_id();
        if($insert_id > 0){
            $this->set_message('sp_vote_successful');
        } else {
            $this->set_error('sp_vote_fail');
        }
        return (isset($insert_id)) ? $insert_id : FALSE;
        
    }
    
    /*
     * Appends user predicitons to already existing predictions
     * @Author Tanveer Ahmed
     */
    public function update_prediction($match_id, $prediction_list) {
        $additional_data = array(
            'match_id' => $match_id,
            'prediction_list' => $prediction_list
        );
        $data = $this->_filter_data($this->tables['app_sp_match_predictions'], $additional_data);
        $this->db->update($this->tables['app_sp_match_predictions'], $data, array('match_id' => $match_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('sp_vote_fail');
            return FALSE;
        }
        $this->set_message('sp_vote_successful');
        return TRUE;
    }
    
    /*
     * Gets match informations + prediction informations under match
     * @Author Tanveer Ahmed
     */
    public function get_predictions_matches_for_tournament( $tournament_id='1' )
    {
        if (isset($this->_ion_where)) {
            foreach ($this->_ion_where as $where) {
                    $this->db->where($where);
            }
            $this->_ion_where = array();
        }
        $this->db->where($this->tables['app_sp_matches'].'.tournament_id', $tournament_id);
        return $this->db->select("*, ".$this->tables['app_sp_matches'].".id as match_id, ".$this->tables['app_sp_match_predictions'].".id as prediction_id, home_team_table.title as team_title_home, away_team_table.title as team_title_away")
                        ->from($this->tables['app_sp_matches'])
                        ->join($this->tables['app_sp_match_predictions'], $this->tables['app_sp_match_predictions'] . '.match_id=' . $this->tables['app_sp_matches'] . '.id', 'left')
                        ->join($this->tables['app_sp_teams'].' as home_team_table', 'home_team_table.id=' . $this->tables['app_sp_matches'] . '.team_id_home', 'left')
                        ->join($this->tables['app_sp_teams'].' as away_team_table', 'away_team_table.id=' . $this->tables['app_sp_matches'] . '.team_id_away', 'left')
                        ->get();
    }
}