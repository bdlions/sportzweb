<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Admin Xstream Banter Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Admin_xstream_banter_model extends Ion_auth_model
{
    protected $sports_identity_column;
    protected $team_identity_column;
    protected $tournament_identity_column1;
    protected $tournament_identity_column2;
    public function __construct() {
        parent::__construct();
        $this->sports_identity_column = $this->config->item('app_xb_sports_identity_column', 'ion_auth');
        $this->team_identity_column = $this->config->item('app_xb_team_identity_column', 'ion_auth');
        $this->tournament_identity_column1 = $this->config->item('app_xb_tournament_identity_column1', 'ion_auth');
        $this->tournament_identity_column2 = $this->config->item('app_xb_tournament_identity_column2', 'ion_auth');
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
        return $this->db->count_all_results($this->tables['app_xb_sports']) > 0;
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
        $additional_data = $this->_filter_data($this->tables['app_xb_sports'], $additional_data);       
        
        $this->db->insert($this->tables['app_xb_sports'], $additional_data);
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
        $data = $this->_filter_data($this->tables['app_xb_sports'], $additional_data);
        $this->db->update($this->tables['app_xb_sports'], $data, array('id' => $sports_id));
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
        $this->db->where($this->tables['app_xb_sports'].'.id', $sports_id);
        return $this->db->select($this->tables['app_xb_sports'].'.id as sports_id,'.$this->tables['app_xb_sports'].'.*')
                    ->from($this->tables['app_xb_sports'])
                    ->get();
    }
    
    /*
     * This method will return sports id based on sports title
     * @param $sports_title, sports title
     * @Author Nazmul on 28th October 2014
     */
    public function get_sports_id($sports_title)
    {
        $this->db->where($this->tables['app_xb_sports'].'.title', $sports_title);
        return $this->db->select($this->tables['app_xb_sports'].'.id as sports_id')
                    ->from($this->tables['app_xb_sports'])
                    ->get();
    }
    
    /*
     * This method will return all sports
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_sports()
    {
        $this->db->order_by('order');
        return $this->db->select($this->tables['app_xb_sports'].'.id as sports_id,'.$this->tables['app_xb_sports'].'.*')
                    ->from($this->tables['app_xb_sports'])
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
        $this->db->delete($this->tables['app_xb_sports']);
        
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
     * @param $sports_id, sports id
     * @author nazmul hasan 
     * @created on 24th October 2014
     * @modified on 4th October 2015
     */
    public function team_identity_check($identity = '', $sports_id = 0) {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->tables['app_xb_teams'].'.'.$this->team_identity_column, $identity);
        $this->db->where($this->tables['app_xb_sports'].'.id', $sports_id);
        $this->db->select("*")
            ->from($this->tables['app_xb_teams'])
            ->join($this->tables['app_xb_sports'], $this->tables['app_xb_sports'].'.id='.$this->tables['app_xb_teams'].'.sports_id');
        return $this->db->count_all_results() > 0;
    }
    /*
     * This method will create a team
     * @param $additional_data, team data to be added
     * @Author Nazmul on 24th October 2014
     */
    public function create_team($additional_data)
    {
        if (array_key_exists($this->team_identity_column, $additional_data) && array_key_exists('sports_id', $additional_data) && $this->team_identity_check($additional_data[$this->team_identity_column], $additional_data['sports_id']) )
        {
            $this->set_error('update_team_duplicate_' . $this->team_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_xb_teams'], $additional_data);       
        
        $this->db->insert($this->tables['app_xb_teams'], $additional_data);
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
        if (array_key_exists($this->team_identity_column, $additional_data) && array_key_exists('sports_id', $additional_data) && $this->team_identity_check($additional_data[$this->team_identity_column], $additional_data['sports_id']) && ($team_info->{$this->team_identity_column} !== $additional_data[$this->team_identity_column] && $team_info->{sports_id} !== $additional_data['sports_id']))
        {
            $this->set_error('update_team_duplicate_' . $this->team_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_xb_teams'], $additional_data);
        $this->db->update($this->tables['app_xb_teams'], $data, array('id' => $team_id));
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
        $this->db->where($this->tables['app_xb_teams'].'.id', $team_id);
        return $this->db->select($this->tables['app_xb_teams'].'.id as team_id,'.$this->tables['app_xb_teams'].'.*')
                    ->from($this->tables['app_xb_teams'])
                    ->get();
    }
    
    /*
     * This method will return team id based on team title
     * @param $team_title, team title
     * @Author Nazmul on 28th October 2014
     */
    public function get_team_id($team_title)
    {
        $this->db->where($this->tables['app_xb_teams'].'.title', $team_title);
        return $this->db->select($this->tables['app_xb_teams'].'.id as team_id')
                    ->from($this->tables['app_xb_teams'])
                    ->get();
    }
    
    /*
     * This method will return all teams
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_teams($sports_id)
    {
        $this->db->order_by('title', 'asc');
        $this->db->where($this->tables['app_xb_teams'].'.sports_id', $sports_id);        
        return $this->db->select($this->tables['app_xb_teams'].'.id as team_id,'.$this->tables['app_xb_teams'].'.*')
                    ->from($this->tables['app_xb_teams'])
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
        $this->db->delete($this->tables['app_xb_teams']);
        
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
        return $this->db->count_all_results($this->tables['app_xb_tournaments']) > 0;
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
        $additional_data = $this->_filter_data($this->tables['app_xb_tournaments'], $additional_data);       
        
        $this->db->insert($this->tables['app_xb_tournaments'], $additional_data);
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
        $data = $this->_filter_data($this->tables['app_xb_tournaments'], $additional_data);
        $this->db->update($this->tables['app_xb_tournaments'], $data, array('id' => $tournament_id));
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
        $this->db->where($this->tables['app_xb_tournaments'].'.id', $tournament_id);
        return $this->db->select($this->tables['app_xb_tournaments'].'.id as tournament_id,'.$this->tables['app_xb_tournaments'].'.*')
                    ->from($this->tables['app_xb_tournaments'])
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
        $this->db->where($this->tables['app_xb_tournaments'].'.title', $tournament_title);
        $this->db->where($this->tables['app_xb_tournaments'].'.season', $season);
        return $this->db->select($this->tables['app_xb_tournaments'].'.id as tournament_id')
                    ->from($this->tables['app_xb_tournaments'])
                    ->get();
    }
    
    /*
     * This method will return all tournaments
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_tournaments($sports_id)
    {
        $this->db->where('sports_id', $sports_id);
        return $this->db->select($this->tables['app_xb_tournaments'].'.id as tournament_id,'.$this->tables['app_xb_tournaments'].'.*')
                    ->from($this->tables['app_xb_tournaments'])
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
        $this->db->delete($this->tables['app_xb_tournaments']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_tournament_unsuccessful');
            return FALSE;
        }
        $this->set_message('delete_tournament_successful');
        return TRUE;
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
        $additional_data = $this->_filter_data($this->tables['app_xb_matches'], $additional_data);       
        
        $this->db->insert($this->tables['app_xb_matches'], $additional_data);
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
        $data = $this->_filter_data($this->tables['app_xb_matches'], $additional_data);
        $this->db->update($this->tables['app_xb_matches'], $data, array('id' => $match_id));
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
        $this->db->where($this->tables['app_xb_matches'].'.id', $match_id);
        return $this->db->select($this->tables['app_xb_matches'].'.id as match_id,'.$this->tables['app_xb_matches'].'.*')
                    ->from($this->tables['app_xb_matches'])
                    ->get();
    }
    
    /*
     * This method will return all matches
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_matches($tournament_id)
    {
        $this->db->order_by($this->tables['app_xb_matches'].'.date','asc');
        $this->db->order_by($this->tables['app_xb_matches'].'.time','asc');
        $this->db->where($this->tables['app_xb_matches'].'.tournament_id',$tournament_id);
        return $this->db->select($this->tables['app_xb_matches'].'.id as match_id,'.$this->tables['app_xb_matches'].'.*,'.$this->tables['app_xb_tournaments'].'.title as tournament_name,'.$this->tables['app_xb_tournaments'].'.season, home_team.title as home_team_name, away_team.title as away_team_name')
                    ->from($this->tables['app_xb_matches'])
                    ->join($this->tables['app_xb_tournaments'], $this->tables['app_xb_tournaments'].'.id='.$this->tables['app_xb_matches'].'.tournament_id')
                    ->join($this->tables['app_xb_teams'].' as home_team', 'home_team.id='.$this->tables['app_xb_matches'].'.team_id_home')
                    ->join($this->tables['app_xb_teams'].' as away_team', 'away_team.id='.$this->tables['app_xb_matches'].'.team_id_away')
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
        $this->db->delete($this->tables['app_xb_matches']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_match_unsuccessful');
            return FALSE;
        }
        $this->set_message('delete_match_successful');
        return TRUE;
    }
}