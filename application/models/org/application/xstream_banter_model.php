<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Xstream Banter Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Xstream_banter_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }  
    
    
    // -----------------------------------------Sports Module -----------------------------
    
    /*
     * This method will return all sports
     * @Author Nazmul
     */
    public function get_all_sports()
    {
        $this->db->order_by('order');
        return $this->db->select('*')
                    ->from($this->tables['app_xb_sports'])
                    ->get();
    }
    
    // ---------------------------------------Tournament Module --------------------------------
    /*
     * This method will return tournament info
     * @param $tournament_id, tournament id
     * @Author Nazmul
     */
    public function get_tournament($tournament_id)
    {
        $this->db->where('id',$tournament_id);
        return $this->db->select('*')
                    ->from($this->tables['app_xb_tournaments'])
                    ->get();
    }
    
    /*
     * This method will return all tournaments of a sports
     * @param $sports_id, sports id
     * @Author Nazmul
     */
    public function get_all_tournaments($sports_id)
    {
        $this->db->where('sports_id',$sports_id);
        return $this->db->select('*')
                    ->from($this->tables['app_xb_tournaments'])
                    ->get();
    }
    
    /*
     * This method will return tournaments where we have matches under the date
     * @param $sports_id, sports id of tournaments
     * @param $date, date of a match
     * @author nazmul hasan
     * @created on 15th September 2015
     */
    public function get_tournaments_match_date($sports_id, $date)
    {
        $this->db->distinct();
        $this->db->where($this->tables['app_xb_tournaments'].'.sports_id', $sports_id);
        $this->db->where($this->tables['app_xb_matches'].'.date',$date);
        return $this->db->select($this->tables['app_xb_tournaments'].'.id as tournament_id,'.$this->tables['app_xb_tournaments'].'.*')
                    ->from($this->tables['app_xb_tournaments'])
                    ->join($this->tables['app_xb_matches'], $this->tables['app_xb_tournaments'].'.id='.$this->tables['app_xb_matches'].'.tournament_id')
                    ->get();
    }
    
    // -----------------------------------Match Module --------------------------------------
    public function get_match($match_id)
    {
        $this->db->where($this->tables['app_xb_matches'].'.id',$match_id);
        return $this->db->select($this->tables['app_xb_matches'].'.id,'.$this->tables['app_xb_matches'].'.id as match_id, team1.id as team_id_home, team1.title as team1_title, team2.id as team_id_away, team2.title as team2_title,'.$this->tables['app_xb_matches'].'.date,'.$this->tables['app_xb_matches'].'.time,'.$this->tables['app_xb_tournaments'].'.title as tournament_title')
                    ->from($this->tables['app_xb_matches'])
                    ->join($this->tables['app_xb_teams'].' as team1', 'team1.id='.$this->tables['app_xb_matches'].'.team_id_home')
                    ->join($this->tables['app_xb_teams'].' as team2', 'team2.id='.$this->tables['app_xb_matches'].'.team_id_away')
                    ->join($this->tables['app_xb_tournaments'], $this->tables['app_xb_tournaments'].'.id='.$this->tables['app_xb_matches'].'.tournament_id')
                    ->get();
    }
    
    public function get_all_matches($tournament_id, $date = '')
    {
        if(!empty($date))
        {
            $this->db->where('date',$date);
        }
        $this->db->where('tournament_id',$tournament_id);
        return $this->db->select($this->tables['app_xb_matches'].'.id,'.$this->tables['app_xb_matches'].'.id as match_id, team1.title as team1_title, team2.title as team2_title,'.$this->tables['app_xb_matches'].'.date,'.$this->tables['app_xb_matches'].'.time')
                    ->from($this->tables['app_xb_matches'])
                    ->join($this->tables['app_xb_teams'].' as team1', 'team1.id='.$this->tables['app_xb_matches'].'.team_id_home')
                    ->join($this->tables['app_xb_teams'].' as team2', 'team2.id='.$this->tables['app_xb_matches'].'.team_id_away')
                    ->get();
    }
    
    // ----------------------------------- Chat Room Module ----------------------------
    /*
     * This method will create a new chat room
     * @Author Nazmul
     */
    public function create_chat_room($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_xb_chat_rooms'], $additional_data);
        $this->db->insert($this->tables['app_xb_chat_rooms'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('chat_room_create_successful');
        return isset($id)? $id: FALSE;
    }
    /*
     * This method will store chat room mapping information
     * @Author Nazmul
     */
    public function store_chat_room_mapping($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_xb_chat_rooms_map'], $additional_data);
        $this->db->insert($this->tables['app_xb_chat_rooms_map'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('chat_room_mapping_successful');
        
        return isset($id)? $id: FALSE;
    }
    
    /*
     * This method will return chat room info 
     * @param $room_id, chat room id
     * @param $group_access_code, group access code of that chat room
     * @Author Nazmul
     */
    public function get_chat_room_info($room_id = 0, $group_access_code = '')
    {
        if($room_id != 0)
        {
            $this->db->where('id',$room_id);
        }
        if(!empty($group_access_code))
        {
            $this->db->where('group_access_code',$group_access_code);
        }
        return $this->db->select('*')
                ->from($this->tables['app_xb_chat_rooms'])
                ->get();
    }
    
    /*
     * This method will retunr chat room messages
     * @param $xb_chat_room_id, chat room id
     * @Author Nazmul
     */
    public function get_chat_room_messages($xb_chat_room_id)
    {
        $this->db->where($this->tables['app_xb_chat_messages'].'.xb_chat_room_id',$xb_chat_room_id);
        return $this->db->select($this->tables['app_xb_chat_messages'].'.message_list, '.$this->tables['users'].'.first_name, '.$this->tables['users'].'.last_name, '.$this->tables['app_xb_teams'].'.title as team_name')
                    ->from($this->tables['app_xb_chat_messages'])
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['app_xb_chat_messages'].'.user_id')
                    ->join($this->tables['app_xb_chat_rooms_map'], $this->tables['app_xb_chat_rooms_map'].'.xb_chat_room_id='.$this->tables['app_xb_chat_messages'].'.xb_chat_room_id AND '.$this->tables['app_xb_chat_rooms_map'].'.user_id='.$this->tables['app_xb_chat_messages'].'.user_id')
                    ->join($this->tables['app_xb_teams'], $this->tables['app_xb_teams'].'.id='.$this->tables['app_xb_chat_rooms_map'].'.team_id')
                    ->get();
    }
    
    /*
     * This method will retuned previous chat rooms of a match of previously accessed user
     * @param $match_id, match id
     * @param $user_id, user id
     * @Author Nazmul
     */
    public function previous_joined_chat_rooms($match_id,$user_id)
    {
        
        $this->db->where($this->tables['app_xb_chat_rooms_map'].'.user_id',$user_id);
        $this->db->where($this->tables['app_xb_chat_rooms'].'.match_id',$match_id);
        return $this->db->select('*')
                    ->from($this->tables['app_xb_chat_rooms_map'])                
                    ->join($this->tables['app_xb_chat_rooms'],  $this->tables['app_xb_chat_rooms'].'.id='.$this->tables['app_xb_chat_rooms_map'].'.xb_chat_room_id')
                    ->get();
    }
    
    
    
    public function is_chat_room_mapping_stored($xb_chat_room_id, $user_id)
    {
        $this->db->where('xb_chat_room_id', $xb_chat_room_id);
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results($this->tables['app_xb_chat_rooms_map']) > 0;
    }
    
    
    
    /*
     * This method will return chat room messages of a user
     */
    public function get_chat_room_message_info($xb_chat_room_id, $user_id)
    {
        $this->db->where('xb_chat_room_id', $xb_chat_room_id);
        $this->db->where('user_id', $user_id);
        return $this->db->select('*')
                        ->from($this->tables['app_xb_chat_messages'])
                        ->get();
    }
    
    /*
     * This method will add a new message of a chat room
     */
    public function add_chat_room_message_info($additional_data)
    {
        $additional_data = $this->_filter_data($this->tables['app_xb_chat_messages'], $additional_data);
        $this->db->insert($this->tables['app_xb_chat_messages'], $additional_data);
        $id = $this->db->insert_id();
        return isset($id)? $id: FALSE;
    }
    
    
    
    /*
     * This method will append/update message of a user
     */
    public function update_chat_room_message_info($xb_chat_room_id, $user_id, $additional_data)
    {
        $this->db->where('xb_chat_room_id', $xb_chat_room_id);
        $this->db->where('user_id', $user_id);
        $this->db->update($this->tables['app_xb_chat_messages'], $additional_data);
    }
    
    /*
     * This method will return chat room map and user info
     * @param $user_id, user id
     * @Author Nazmul on 4th November 2014
     */
    public function get_user_chat_room_map_info($chat_room_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->where($this->tables['app_xb_chat_rooms_map'].'.xb_chat_room_id',$chat_room_id);
        $this->db->where($this->tables['app_xb_chat_rooms_map'].'.user_id',$user_id);
        return $this->db->select($this->tables['users'].'.first_name, '.$this->tables['users'].'.last_name, '.$this->tables['app_xb_teams'].'.title as team_name')
                    ->from($this->tables['users'])
                    ->join($this->tables['app_xb_chat_rooms_map'], $this->tables['app_xb_chat_rooms_map'].'.user_id='.$this->tables['users'].'.id')
                    ->join($this->tables['app_xb_teams'], $this->tables['app_xb_teams'].'.id='.$this->tables['app_xb_chat_rooms_map'].'.team_id')
                    ->get();
    }
    
    
    
}
