<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Admin Score Prediciton Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Admin_score_prediction_model extends Ion_auth_model
{
    protected $sports_identity_column;
    protected $team_identity_column;
    protected $tournament_identity_column1;
    protected $tournament_identity_column2;
    public function __construct() {
        parent::__construct();
        $this->sports_identity_column = $this->config->item('app_sp_sports_identity_column', 'ion_auth');
        $this->team_identity_column = $this->config->item('app_sp_team_identity_column', 'ion_auth');
        $this->tournament_identity_column1 = $this->config->item('app_sp_tournament_identity_column1', 'ion_auth');
        $this->tournament_identity_column2 = $this->config->item('app_sp_tournament_identity_column2', 'ion_auth');
    }
    
    // -------------------------------- Sports Module --------------------------------------
    /*
     * This method will check identity of sports table
     * @param $identity, identity of sports table
     * @Author Nazmul on 24th October 2014
     */
    public function sports_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->sports_identity_column,$identity);
        return $this->db->count_all_results($this->tables['app_sp_sports']) > 0;
    }
    /*
     * This method will create a sports
     * @param $additional_data, sports data to be added
     * @Author Nazmul on 24th October 2014
     */
    public function create_sports($additional_data)
    {
        if (array_key_exists($this->sports_identity_column, $additional_data) && $this->sports_identity_check($additional_data[$this->sports_identity_column]) )
        {
            $this->set_error('update_sports_duplicate_' . $this->sports_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_sp_sports'], $additional_data);       
        
        $this->db->insert($this->tables['app_sp_sports'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_sports_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will update sports info
     * @param $sports_id, sports id
     * @param $additional_data, sports data to be updated
     * @Author Nazmul on 24th October 2014
     */
    public function update_sports($sports_id, $additional_data)
    {
        $sports_info = $this->get_sports_info($sports_id)->row();
        if (array_key_exists($this->sports_identity_column, $additional_data) && $this->sports_identity_check($additional_data[$this->sports_identity_column]) && $sports_info->{$this->sports_identity_column} !== $additional_data[$this->sports_identity_column])
        {
            $this->set_error('update_sports_duplicate_' . $this->sports_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_sp_sports'], $additional_data);
        $this->db->update($this->tables['app_sp_sports'], $data, array('id' => $sports_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_sports_unsuccessful');
            return FALSE;
        }
        $this->set_message('update_sports_successful');
        return TRUE;
    }
    
    /*
     * This method will return sports info
     * @param $sports_id, sports id
     * @Author Nazmul on 24th October 2014
     */
    public function get_sports_info($sports_id)
    {
        $this->db->where($this->tables['app_sp_sports'].'.id', $sports_id);
        return $this->db->select($this->tables['app_sp_sports'].'.id as sports_id,'.$this->tables['app_sp_sports'].'.*')
                    ->from($this->tables['app_sp_sports'])
                    ->get();
    }
    
    /*
     * This method will return sports id based on sports title
     * @param $sports_title, sports title
     * @Author Nazmul on 28th October 2014
     */
    public function get_sports_id($sports_title)
    {
        $this->db->where($this->tables['app_sp_sports'].'.title', $sports_title);
        return $this->db->select($this->tables['app_sp_sports'].'.id as sports_id')
                    ->from($this->tables['app_sp_sports'])
                    ->get();
    }
    
    /*
     * This method will return all sports
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_sports()
    {
        return $this->db->select($this->tables['app_sp_sports'].'.id as sports_id,'.$this->tables['app_sp_sports'].'.*')
                    ->from($this->tables['app_sp_sports'])
                    ->get();
    }
    
    /*
     * This method will delete sports info
     * @param $sports_id, sports id
     * @Author Nazmul on 24th October 2014
     */
    public function delete_sports($sports_id)
    {
        if(!isset($sports_id) || $sports_id <= 0)
        {
            $this->set_error('delete_sports_unsuccessful');
            return FALSE;
        }
        $this->db->where('id',$sports_id);
        $this->db->delete($this->tables['app_sp_sports']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_sports_unsuccessful');
            return FALSE;
        }
        $this->set_message('delete_sports_successful');
        return TRUE;
    }
    // ------------------------------------- Team Module ------------------------------
    /*
     * This method will check identity of team table
     * @param $identity, identity of team table
     * @Author Nazmul on 24th October 2014
     */
    public function team_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->team_identity_column,$identity);
        return $this->db->count_all_results($this->tables['app_sp_teams']) > 0;
    }
    /*
     * This method will create a team
     * @param $additional_data, team data to be added
     * @Author Nazmul on 24th October 2014
     */
    public function create_team($additional_data)
    {
        if (array_key_exists($this->team_identity_column, $additional_data) && $this->team_identity_check($additional_data[$this->team_identity_column]) )
        {
            $this->set_error('update_team_duplicate_' . $this->team_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_sp_teams'], $additional_data);       
        
        $this->db->insert($this->tables['app_sp_teams'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_team_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will update team info
     * @param $team_id, sports id
     * @param $additional_data, team data to be updated
     * @Author Nazmul on 24th October 2014
     */
    public function update_team($team_id, $additional_data)
    {
        $team_info = $this->get_team_info($team_id)->row();
        if (array_key_exists($this->team_identity_column, $additional_data) && $this->team_identity_check($additional_data[$this->team_identity_column]) && $team_info->{$this->team_identity_column} !== $additional_data[$this->team_identity_column])
        {
            $this->set_error('update_team_duplicate_' . $this->team_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_sp_teams'], $additional_data);
        $this->db->update($this->tables['app_sp_teams'], $data, array('id' => $team_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_team_unsuccessful');
            return FALSE;
        }
        $this->set_message('update_team_successful');
        return TRUE;
    }
    
    /*
     * This method will return team info
     * @param $team_id, team id
     * @Author Nazmul on 24th October 2014
     */
    public function get_team_info($team_id)
    {
        $this->db->where($this->tables['app_sp_teams'].'.id', $team_id);
        return $this->db->select($this->tables['app_sp_teams'].'.id as team_id,'.$this->tables['app_sp_teams'].'.*')
                    ->from($this->tables['app_sp_teams'])
                    ->get();
    }
    
    /*
     * This method will return team id based on team title
     * @param $team_title, team title
     * @Author Nazmul on 28th October 2014
     */
    public function get_team_id($team_title)
    {
        $this->db->where($this->tables['app_sp_teams'].'.title', $team_title);
        return $this->db->select($this->tables['app_sp_teams'].'.id as team_id')
                    ->from($this->tables['app_sp_teams'])
                    ->get();
    }
    
    /*
     * This method will return all teams
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_teams($sports_id)
    {
        $this->db->where($this->tables['app_sp_teams'].'.sports_id', $sports_id);        
        return $this->db->select($this->tables['app_sp_teams'].'.id as team_id,'.$this->tables['app_sp_teams'].'.*')
                    ->from($this->tables['app_sp_teams'])
                    ->get();
    }
    
    /*
     * This method will delete team info
     * @param $team_id, team id
     * @Author Nazmul on 24th October 2014
     */
    public function delete_team($team_id)
    {
        if(!isset($team_id) || $team_id <= 0)
        {
            $this->set_error('delete_team_unsuccessful');
            return FALSE;
        }
        $this->db->where('id',$team_id);
        $this->db->delete($this->tables['app_sp_teams']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_team_unsuccessful');
            return FALSE;
        }
        $this->set_message('delete_team_successful');
        return TRUE;
    }
    
    // -------------------------- Tournament Module ------------------------------------
    /*
     * This method will check identity of tournament table
     * @param $identity1, identity1 of tournament table
     * @param $identity2, identity2 of tournament table
     * @Author Nazmul on 24th October 2014
     */
    public function tournament_identity_check($identity1 = '', $identity2 = '') {
        if(empty($identity1) || empty($identity2))
        {
            return FALSE;
        }
        $this->db->where($this->tournament_identity_column1,$identity1);
        $this->db->where($this->tournament_identity_column2,$identity2);
        return $this->db->count_all_results($this->tables['app_sp_tournaments']) > 0;
    }
    /*
     * This method will create a tournament
     * @param $additional_data, tournament data to be added
     * @Author Nazmul on 24th October 2014
     */
    public function create_tournament($additional_data)
    {
        if ( array_key_exists($this->tournament_identity_column1, $additional_data) && array_key_exists($this->tournament_identity_column2, $additional_data) && $this->tournament_identity_check($additional_data[$this->tournament_identity_column1], $additional_data[$this->tournament_identity_column2]) )
        {
            $this->set_error('update_tournament_duplicate_' . $this->tournament_identity_column1);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_sp_tournaments'], $additional_data);       
        
        $this->db->insert($this->tables['app_sp_tournaments'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_tournament_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will update tournament info
     * @param $tournament_id, tournament id
     * @param $additional_data, tournament data to be updated
     * @Author Nazmul on 24th October 2014
     */
    public function update_tournament($tournament_id, $additional_data)
    {
        $tournament_info = $this->get_tournament_info($tournament_id)->row();
        if ( array_key_exists($this->tournament_identity_column1, $additional_data) && array_key_exists($this->tournament_identity_column2, $additional_data) && $this->tournament_identity_check($additional_data[$this->tournament_identity_column1], $additional_data[$this->tournament_identity_column2])  && $tournament_info ->{$this->tournament_identity_column1} !== $additional_data[$this->tournament_identity_column1] && $tournament_info ->{$this->tournament_identity_column2} !== $additional_data[$this->tournament_identity_column2])
        {
            $this->set_error('update_tournament_duplicate_' . $this->tournament_identity_column1);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_sp_tournaments'], $additional_data);
        $this->db->update($this->tables['app_sp_tournaments'], $data, array('id' => $tournament_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_tournament_unsuccessful');
            return FALSE;
        }
        $this->set_message('update_tournament_successful');
        return TRUE;
    }
    
    /*
     * This method will return tournament info
     * @param $tournament_id, tournament id
     * @Author Nazmul on 24th October 2014
     */
    public function get_tournament_info($tournament_id)
    {
        $this->db->where($this->tables['app_sp_tournaments'].'.id', $tournament_id);
        return $this->db->select($this->tables['app_sp_tournaments'].'.id as tournament_id,'.$this->tables['app_sp_tournaments'].'.*')
                    ->from($this->tables['app_sp_tournaments'])
                    ->get();
    }
    
    /*
     * This method will return tournament id based on tournament title and season
     * @param $tournament_title, tournament title
     * @param $season, season
     * @Author Nazmul on 28th October 2014
     */
    public function get_tournament_id($tournament_title, $season)
    {
        $this->db->where($this->tables['app_sp_tournaments'].'.title', $tournament_title);
        $this->db->where($this->tables['app_sp_tournaments'].'.season', $season);
        return $this->db->select($this->tables['app_sp_tournaments'].'.id as tournament_id')
                    ->from($this->tables['app_sp_tournaments'])
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
     * This method will delete tournament info
     * @param $tournament_id, tournament id
     * @Author Nazmul on 24th October 2014
     */
    public function delete_tournament($tournament_id)
    {
        if(!isset($tournament_id) || $tournament_id <= 0)
        {
            $this->set_error('delete_tournament_unsuccessful');
            return FALSE;
        }
        $this->db->where('id',$tournament_id);
        $this->db->delete($this->tables['app_sp_tournaments']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_tournament_unsuccessful');
            return FALSE;
        }
        $this->set_message('delete_tournament_successful');
        return TRUE;
    }
    
    // ----------------------------------- Match status module -------------------------
    /*
     * This method will return all match statuses
     * @Author Nazmul on 27th October 2014
     */
    public function get_match_statuses()
    {
        return $this->db->select($this->tables['app_sp_match_statuses'].'.id as match_status_id,'.$this->tables['app_sp_match_statuses'].'.*')
                    ->from($this->tables['app_sp_match_statuses'])
                    ->get();
    }
    
    // ------------------------------------ Match Module ----------------------------------
    /*
     * This method will create a match
     * @param $additional_data, match data to be added
     * @Author Nazmul on 24th October 2014
     */
    public function create_match($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_sp_matches'], $additional_data);       
        
        $this->db->insert($this->tables['app_sp_matches'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_match_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will update match info
     * @param $match_id, match id
     * @param $additional_data, match data to be updated
     * @Author Nazmul on 24th October 2014
     */
    public function update_match($match_id, $additional_data)
    {
        $data = $this->_filter_data($this->tables['app_sp_matches'], $additional_data);
        $this->db->update($this->tables['app_sp_matches'], $data, array('id' => $match_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_match_unsuccessful');
            return FALSE;
        }
        $this->set_message('update_match_successful');
        return TRUE;
    }
    
    /*
     * This method will return match info
     * @param $match_id, match id
     * @Author Nazmul on 24th October 2014
     */
    public function get_match_info($match_id)
    {
        $this->db->where($this->tables['app_sp_matches'].'.id', $match_id);
        return $this->db->select($this->tables['app_sp_matches'].'.id as match_id,'.$this->tables['app_sp_matches'].'.*')
                    ->from($this->tables['app_sp_matches'])
                    ->get();
    }
    
    /*
     * This method will return all matches
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_matches($tournament_id)
    {
        $this->db->where($this->tables['app_sp_matches'].'.tournament_id',$tournament_id);
        return $this->db->select($this->tables['app_sp_matches'].'.id as match_id,'.$this->tables['app_sp_matches'].'.*,'.$this->tables['app_sp_tournaments'].'.title as tournament_name,'.$this->tables['app_sp_tournaments'].'.season, home_team.title as home_team_name, away_team.title as away_team_name,'.$this->tables['app_sp_match_statuses'].'.title as match_status')
                    ->from($this->tables['app_sp_matches'])
                    ->join($this->tables['app_sp_tournaments'], $this->tables['app_sp_tournaments'].'.id='.$this->tables['app_sp_matches'].'.tournament_id')
                    ->join($this->tables['app_sp_match_statuses'], $this->tables['app_sp_match_statuses'].'.id='.$this->tables['app_sp_matches'].'.status_id')
                    ->join($this->tables['app_sp_teams'].' as home_team', 'home_team.id='.$this->tables['app_sp_matches'].'.team_id_home')
                    ->join($this->tables['app_sp_teams'].' as away_team', 'away_team.id='.$this->tables['app_sp_matches'].'.team_id_away')
                    ->get();
    }
    
    /*
     * This method will delete match info
     * @param $match_id, match id
     * @Author Nazmul on 24th October 2014
     */
    public function delete_match($match_id)
    {
        if(!isset($match_id) || $match_id <= 0)
        {
            $this->set_error('delete_match_unsuccessful');
            return FALSE;
        }
        $this->db->where('id',$match_id);
        $this->db->delete($this->tables['app_sp_matches']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_match_unsuccessful');
            return FALSE;
        }
        $this->set_message('delete_match_successful');
        return TRUE;
    }
    
    // -------------------------------- Match Prediction Module ------------------------
    /*
     * This method will create a match prediction
     * @param $additional_data, match prediction data to be added
     * @Author Nazmul on 24th October 2014
     */
    public function create_match_prediction($additional_data)
    {
        
    }
    
    public function get_match_prediction($match_id){
        $this->db->where($this->tables['app_sp_match_predictions'].'.match_id', $match_id);
        return  $this->db->select($this->tables['app_sp_match_predictions'].'.id as prdiction_id,'.$this->tables['app_sp_match_predictions'].'.*')
                    ->from($this->tables['app_sp_match_predictions'])
                    ->get();
    
        
    }
     /*
     * This add notification
     * Parameter  notification list array and user id
     * @Author Rashida on 13th April 2015
     */
    public function add_notification($user_id,$new_notification_list) {
        if ($user_id != 0) {
            $new_notification_list = $this->_filter_data($this->tables['notification_list'], $new_notification_list);
            $this->db->insert($this->tables['notification_list'], $new_notification_list);
            return $insert_id = $this->db->insert_id();
        }
    }
    /*
     * This update notification
     * Parameter  notification list array and user id
     * @Author Rashida on 13th April 2015
     */
    public function update_notification($user_id, $new_notification_list)
    {
        $this->db->where('user_id', $user_id);
        $new_notification_list = $this->_filter_data($this->tables['notification_list'], $new_notification_list);
        return $this->db->update($this->tables['notification_list'], $new_notification_list);
        
    }
    public function get_notification_list($user_id = 0) {
        $this->db->where($this->tables['notification_list'].'.user_id', $user_id);
        return $this->db->select($this->tables['usres_following_acceptance'].'.following_acceptance_type, '.$this->tables['notification_list'] . ".*")
                    ->from($this->tables['notification_list'])  
                    ->join($this->tables['usres_following_acceptance'], $this->tables['usres_following_acceptance'].'.user_id='.$this->tables['notification_list'].'.user_id ','left')
                    ->get();
    }
    
    // ------------------------------- Home Page Configuration ---------------------------
    /*
     * This method will add home page configuration
     * @param $additional_data, home page configuration data to be added
     * @Author Nazmul on 24th October 2014
     */
    public function add_home_page_configuration($additional_data)
    {
        $additional_data = $this->_filter_data($this->tables['app_sp_configure_homepage'], $additional_data);       
        
        $this->db->insert($this->tables['app_sp_configure_homepage'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('configure_homepage_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will return all home page configurations
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_home_page_configurations()
    {
        
    }
}