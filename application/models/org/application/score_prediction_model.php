<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Name: Score Prediciton Model
 * 
 * Author: Nazmul Hasan
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
     * This method will return matches based on where logic
     * @Author Nazmul Hasan on 28th June 2015
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
     * This method will return match list
     * @param $date, match date
     * @param $sports_id, sports id
     * @param $match_id, match id
     * @return match list
     * @Author nazmul hasan on 27th June 2015
     */
    public function get_all_matches($date = '', $sports_id = 0, $match_id = 0)
    {
        if($date != '')
        {
            $this->db->where('date' , $date);
        }
        if($sports_id != 0)
        {
            $this->db->where($this->tables['app_sp_tournaments'].'.sports_id' , $sports_id);
        }
        if($match_id != 0)
        {
            $this->db->where($this->tables['app_sp_matches'].'.id' , $match_id);
        }
        $this->db->order_by('time');
        return $this->db->select($this->tables['app_sp_sports'].".id as sports_id, ".$this->tables['app_sp_sports'].".title as sports_title, ".$this->tables['app_sp_tournaments'].".id as tournament_id, ".$this->tables['app_sp_tournaments'].".title as tournament_title, ".$this->tables['app_sp_matches'].".*,".$this->tables['app_sp_matches'].".id as match_id, ".$this->tables['app_sp_match_predictions'].".prediction_list, home_team_table.title as team_title_home, away_team_table.title as team_title_away")
                        ->from($this->tables['app_sp_matches'])
                        ->join($this->tables['app_sp_tournaments'], $this->tables['app_sp_tournaments'] . '.id =' . $this->tables['app_sp_matches'] . '.tournament_id', 'left')
                        ->join($this->tables['app_sp_sports'], $this->tables['app_sp_sports'] . '.id =' . $this->tables['app_sp_tournaments'] . '.sports_id', 'left')
                        ->join($this->tables['app_sp_match_predictions'], $this->tables['app_sp_match_predictions'] . '.match_id=' . $this->tables['app_sp_matches'] . '.id', 'left')
                        ->join($this->tables['app_sp_teams'].' as home_team_table', 'home_team_table.id=' . $this->tables['app_sp_matches'] . '.team_id_home', 'left')
                        ->join($this->tables['app_sp_teams'].' as away_team_table', 'away_team_table.id=' . $this->tables['app_sp_matches'] . '.team_id_away', 'left')
                        ->get();
    }
    /*
     * This method will return match predictions
     * @param $match_id, match id
     * @Author Nazmul Hasan on 1st July 2015
     */
    public function get_match_predictions( $match_id ) {
        $this->db->where('match_id', $match_id);
        return $this->db->select('*')
                        ->from($this->tables['app_sp_match_predictions'])
                        ->get();
    }
    /*
     * This method will return all matches prediction
     * @Author Nazmul Hasan on 3rd July 2015
     */
    public function get_all_matches_predictions() {
        return $this->db->select('*')
                        ->from($this->tables['app_sp_match_predictions'])
                        ->get();
    }
    /*
     * This method will add prediction list
     * @param $prediction_data, match predition data
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function add_prediction( $prediction_data )
    {
        $data = $this->_filter_data($this->tables['app_sp_match_predictions'], $prediction_data);
        $this->db->insert($this->tables['app_sp_match_predictions'], $data);
        $insert_id = $this->db->insert_id();
        if($insert_id > 0){
            $this->set_message('sp_vote_successful');
        } else {
            $this->set_error('sp_vote_fail');
        }
        return (isset($insert_id)) ? $insert_id : FALSE;
        
    }    
    /*
     * This method will update prediction list
     * @param $match_id, match id
     * @param $prediction_data, match prediction data
     * @Author Nazmul Hasan on 28th June 2015
     */
    public function update_prediction($match_id, $prediction_data) {
        $data = $this->_filter_data($this->tables['app_sp_match_predictions'], $prediction_data);
        $this->db->update($this->tables['app_sp_match_predictions'], $data, array('match_id' => $match_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('sp_vote_fail');
            return FALSE;
        }
        $this->set_message('sp_vote_successful');
        return TRUE;
    }
    /*
     * This method will return match list for the leader board
     * @param $start_date, date of match
     * @param $end_date, date of match
     */
    public function get_leader_board_matches($start_date = '', $end_date = '')
    {
        if($start_date != '')
        {
            $this->db->where($this->tables['app_sp_matches'].'.date >=', $start_date);
        }
        if($end_date != '')
        {
            $this->db->where($this->tables['app_sp_matches'].'.date <=', $end_date);
        }
        $this->db->where_in($this->tables['app_sp_matches'].'.status_id', array(MATCH_STATUS_WIN_HOME, MATCH_STATUS_DRAW, MATCH_STATUS_WIN_AWAY));
        return $this->db->select($this->tables['app_sp_matches'].'.id as match_id,'.$this->tables['app_sp_matches'].'.*,'.$this->tables['app_sp_match_predictions'].'.prediction_list')
                    ->from($this->tables['app_sp_matches'])
                    ->join($this->tables['app_sp_match_predictions'], $this->tables['app_sp_match_predictions'] . '.match_id=' . $this->tables['app_sp_matches'] . '.id', 'left')
                    ->get();
    }
    /*
     * This method will return user info
     * @param $user_id_list, user id list
     */
    public function get_users($user_id_list) {
        $this->db->where_in($this->tables['users'] . '.id', $user_id_list);
        $result = $this->db->select($this->tables['users'] . '.id as user_id,' . $this->tables['users'] . '.first_name,' . $this->tables['users'] . '.last_name,' . $this->tables['basic_profile'] . '.photo')
                ->from($this->tables['users'])
                ->join($this->tables['basic_profile'], $this->tables['users'] . '.id=' . $this->tables['basic_profile'] . '.user_id')
                ->get();
        return $result;
    }
    /*
     * This method will return matches for the league table
     * @param $tournament_id, tournament id
     */
    public function get_league_table_matches($tournament_id)
    {
        $this->db->where($this->tables['app_sp_matches'].'.tournament_id', $tournament_id);
        return $this->db->select($this->tables['app_sp_matches'].'.id as match_id,'.$this->tables['app_sp_matches'].'.*, home_team_table.title as home_team_title, away_team_table.title as away_team_title')
                    ->from($this->tables['app_sp_matches'])
                    ->join($this->tables['app_sp_teams'].' as home_team_table', 'home_team_table.id=' . $this->tables['app_sp_matches'] . '.team_id_home', 'left')
                    ->join($this->tables['app_sp_teams'].' as away_team_table', 'away_team_table.id=' . $this->tables['app_sp_matches'] . '.team_id_away', 'left')
                    ->get();
    }
}