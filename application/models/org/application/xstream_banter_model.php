<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  dataprovider Model
 *
 * Author:  alamgir kabir
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Xstream_banter_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }  
    
    public function get_all_sports()
    {
        return $this->db->select('*')
                    ->from($this->tables['sports'])
                    ->get();
    }
    
    public function get_tournament($tournament_id)
    {
        $this->db->where('id',$tournament_id);
        return $this->db->select('*')
                    ->from($this->tables['tournaments'])
                    ->get();
    }
    
    public function get_all_tournaments($sports_id)
    {
        $this->db->where('sports_id',$sports_id);
        return $this->db->select('*')
                    ->from($this->tables['tournaments'])
                    ->get();
    }
    
    public function get_match($match_id)
    {
        $this->db->where($this->tables['matches'].'.id',$match_id);
        return $this->db->select($this->tables['matches'].'.id,'.$this->tables['matches'].'.id as match_id, team1.id as team1_id, team1.title as team1_title, team2.id as team2_id, team2.title as team2_title,'.$this->tables['matches'].'.date,'.$this->tables['matches'].'.time,'.$this->tables['tournaments'].'.title as tournament_title')
                    ->from($this->tables['matches'])
                    ->join($this->tables['teams'].' as team1', 'team1.id='.$this->tables['matches'].'.team1_id')
                    ->join($this->tables['teams'].' as team2', 'team2.id='.$this->tables['matches'].'.team2_id')
                    ->join($this->tables['tournaments'], $this->tables['tournaments'].'.id='.$this->tables['matches'].'.tournament_id')
                    ->get();
    }
    
    public function get_all_matches($tournament_id, $date = '')
    {
        if(!empty($date))
        {
            $this->db->where('date',$date);
        }
        $this->db->where('tournament_id',$tournament_id);
        return $this->db->select($this->tables['matches'].'.id,'.$this->tables['matches'].'.id as match_id, team1.title as team1_title, team2.title as team2_title,'.$this->tables['matches'].'.date,'.$this->tables['matches'].'.time')
                    ->from($this->tables['matches'])
                    ->join($this->tables['teams'].' as team1', 'team1.id='.$this->tables['matches'].'.team1_id')
                    ->join($this->tables['teams'].' as team2', 'team2.id='.$this->tables['matches'].'.team2_id')
                    ->get();
    }
    
    /*
     * This method will return chat room info 
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
                ->from($this->tables['xb_chat_rooms'])
                ->get();
    }
    
    /*
     * This method will create a new chat room
     */
    public function create_chat_room($additional_data)
    {
        $additional_data = $this->_filter_data($this->tables['xb_chat_rooms'], $additional_data);
        $this->db->insert($this->tables['xb_chat_rooms'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('chat_room_create_successful');
        return isset($id)? $id: FALSE;
    }
    
    public function is_chat_room_mapping_stored($xb_chat_room_id, $user_id)
    {
        $this->db->where('xb_chat_room_id', $xb_chat_room_id);
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results($this->tables['xb_chat_rooms_map']) > 0;
    }
    
    /*
     * This method will store chat room mapping information
     */
    public function store_chat_room_mapping($additional_data)
    {
        $additional_data = $this->_filter_data($this->tables['xb_chat_rooms_map'], $additional_data);
        $this->db->insert($this->tables['xb_chat_rooms_map'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('chat_room_mapping_successful');
        
        return isset($id)? $id: FALSE;
    }
    
    /*
     * This method will return chat room messages of a user
     */
    public function get_chat_room_message_info($xb_chat_room_id, $user_id)
    {
        $this->db->where('xb_chat_room_id', $xb_chat_room_id);
        $this->db->where('user_id', $user_id);
        return $this->db->select('*')
                        ->from($this->tables['xb_chat_messages'])
                        ->get();
    }
    
    /*
     * This method will add a new message of a chat room
     */
    public function add_chat_room_message_info($additional_data)
    {
        $additional_data = $this->_filter_data($this->tables['xb_chat_messages'], $additional_data);
        $this->db->insert($this->tables['xb_chat_messages'], $additional_data);
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
        $this->db->update($this->tables['xb_chat_messages'], $additional_data);
    }
    
    public function get_chat_room_messages($xb_chat_room_id)
    {
        $this->db->where($this->tables['xb_chat_messages'].'.xb_chat_room_id',$xb_chat_room_id);
        return $this->db->select($this->tables['xb_chat_messages'].'.message_list, '.$this->tables['users'].'.first_name, '.$this->tables['users'].'.last_name, '.$this->tables['teams'].'.title as team_name')
                    ->from($this->tables['xb_chat_messages'])
                    ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['xb_chat_messages'].'.user_id')
                    ->join($this->tables['xb_chat_rooms_map'], $this->tables['xb_chat_rooms_map'].'.xb_chat_room_id='.$this->tables['xb_chat_messages'].'.xb_chat_room_id AND '.$this->tables['xb_chat_rooms_map'].'.user_id='.$this->tables['xb_chat_messages'].'.user_id')
                    ->join($this->tables['teams'], $this->tables['teams'].'.id='.$this->tables['xb_chat_rooms_map'].'.team_id')
                    ->get();
    }
    
    public function previous_joined_chat_rooms($match_id,$user_id)
    {
        
        $this->db->where($this->tables['xb_chat_rooms_map'].'.user_id',$user_id);
        $this->db->where($this->tables['xb_chat_rooms'].'.match_id',$match_id);
        return $this->db->select('*')
                    ->from($this->tables['xb_chat_rooms_map'])                
                    ->join($this->tables['xb_chat_rooms'],  $this->tables['xb_chat_rooms'].'.id='.$this->tables['xb_chat_rooms_map'].'.xb_chat_room_id')
                    ->get();
    }
    
    
    
    //mobile app
    public function app_get_all_sports()
    {
        return $this->db->select('id, title')
                    ->from($this->tables['sports'])
                    ->get();
    }
}
