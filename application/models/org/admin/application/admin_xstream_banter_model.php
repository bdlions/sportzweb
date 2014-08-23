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
class Admin_xstream_banter_model extends Ion_auth_model {

    protected $sports_identity_column;
    protected $tournament_identity_column;
    protected $team_identity_column;
    public function __construct() {
        parent::__construct();
        $this->sports_identity_column = $this->config->item('sports_identity_column', 'ion_auth');
        $this->tournament_identity_column = $this->config->item('tournament_identity_column', 'ion_auth');
        $this->team_identity_column = $this->config->item('team_identity_column', 'ion_auth');
    }   
    
    public function get_all_sports()
    {
        $this->db->group_by($this->tables['sports'].'.id');
        return $this->db->select($this->tables['sports'].'.id,'.$this->tables['sports'].'.id as sports_id,'.$this->tables['sports'].'.name,'.$this->tables['sports'].'.title, count('.$this->tables['tournaments'].'.sports_id) as total_tournaments')
                    ->from($this->tables['sports'])
                    ->join($this->tables['tournaments'], $this->tables['tournaments'].'.sports_id='.$this->tables['sports'].'.id','left')
                    ->get();
    }
    
    public function get_sports($sports_id)
    {
        $this->db->where($this->tables['sports'].'.id', $sports_id);
        $this->db->group_by($this->tables['sports'].'.id');
        return $this->db->select($this->tables['sports'].'.id,'.$this->tables['sports'].'.id as sports_id,'.$this->tables['sports'].'.name,'.$this->tables['sports'].'.title, count('.$this->tables['tournaments'].'.sports_id) as total_tournaments')
                    ->from($this->tables['sports'])
                    ->join($this->tables['tournaments'], $this->tables['tournaments'].'.sports_id='.$this->tables['sports'].'.id','left')
                    ->get();
    }
    
    public function sports_identity_check($identity = '') {
        $this->trigger_events('sports_identity_check');
        if (empty($identity)) {
            return FALSE;
        }
        $this->db->where($this->sports_identity_column, $identity);
        return $this->db->count_all_results($this->tables['sports']) > 0;
    }
    
    public function create_sports($title, $additional_data)
    {
        $this->trigger_events('pre_create_sports');
        if ($this->sports_identity_column == 'title' && $this->sports_identity_check($title)) 
        {
            $this->set_error('sports_creation_duplicate_sports_name');
            return FALSE;
        }         
        $data = array(
            'name' => $title,
            'title' => $title,
            'created_on' => now()
        );
        //filter out any data passed that doesnt have a matching column in the users table
        //and merge the product data and the additional data
        $additional_data = array_merge($this->_filter_data($this->tables['sports'], $additional_data), $data);
        
        $this->db->insert($this->tables['sports'], $additional_data);

        $id = $this->db->insert_id();

        $this->trigger_events('post_create_sports');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_all_tournaments($sports_id)
    {
        $this->db->where('sports_id',$sports_id);
        $this->db->group_by($this->tables['tournaments'].'.id');
        return $this->db->select($this->tables['tournaments'].'.id,'.$this->tables['tournaments'].'.id as tournament_id,'.$this->tables['tournaments'].'.name,'.$this->tables['tournaments'].'.title, count('.$this->tables['teams_tournaments'].'.tournament_id) as total_teams')
                    ->from($this->tables['tournaments'])
                    ->join($this->tables['teams_tournaments'], $this->tables['teams_tournaments'].'.tournament_id='.$this->tables['tournaments'].'.id','left')
                    ->join($this->tables['teams'], $this->tables['teams'].'.id='.$this->tables['teams_tournaments'].'.team_id','left')
                    ->get();
    }
    
    public function get_tournament_info($tournament_id)
    {
        $this->db->where('id',$tournament_id);
        return $this->db->select('*')
                    ->from($this->tables['tournaments'])
                    ->get();
    }
    
    public function get_tournament($tournament_id)
    {
        $this->db->where($this->tables['tournaments'].'.id',$tournament_id);
        $this->db->group_by($this->tables['tournaments'].'.id');
        return $this->db->select($this->tables['tournaments'].'.id,'.$this->tables['tournaments'].'.id as tournament_id,'.$this->tables['tournaments'].'.name,'.$this->tables['tournaments'].'.title, count('.$this->tables['teams_tournaments'].'.tournament_id) as total_teams')
                    ->from($this->tables['tournaments'])
                    ->join($this->tables['teams_tournaments'], $this->tables['teams_tournaments'].'.tournament_id='.$this->tables['tournaments'].'.id','left')
                    ->join($this->tables['teams'], $this->tables['teams'].'.id='.$this->tables['teams_tournaments'].'.team_id','left')
                    ->get();
    }
    
    public function tournament_identity_check($identity = '') {
        $this->trigger_events('tournament_identity_check');
        if (empty($identity)) {
            return FALSE;
        }
        $this->db->where($this->tournament_identity_column, $identity);
        return $this->db->count_all_results($this->tables['tournaments']) > 0;
    }
    
    public function create_tournament($title, $additional_data)
    {
        $this->trigger_events('pre_create_tournament');
        if ($this->tournament_identity_column == 'title' && $this->tournament_identity_check($title)) 
        {
            $this->set_error('tournament_creation_duplicate_tournament_name');
            return FALSE;
        }         
        $data = array(
            'name' => $title,
            'title' => $title,
            'created_on' => now()
        );
        //filter out any data passed that doesnt have a matching column in the users table
        //and merge the product data and the additional data
        $additional_data = array_merge($this->_filter_data($this->tables['tournaments'], $additional_data), $data);
        
        $this->db->insert($this->tables['tournaments'], $additional_data);

        $id = $this->db->insert_id();

        $this->trigger_events('post_create_tournament');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_all_teams()
    {
        return $this->db->select($this->tables['teams'].'.id as team_id,'.$this->tables['teams'].'.*')
                    ->from($this->tables['teams'])
                    ->get();
    }
    
    public function get_all_teams_tournament($tournament_id)
    {
        $this->db->where('tournament_id',$tournament_id);
        return $this->db->select($this->tables['teams'].'.id,'.$this->tables['teams'].'.title,'.$this->tables['teams'].'.created_on')
                    ->from($this->tables['teams'])
                    ->join($this->tables['teams_tournaments'], $this->tables['teams_tournaments'].'.team_id='.$this->tables['teams'].'.id')
                    ->get();
    }
    
    public function get_all_teams_teams_tournaments()
    {
        $result = $this->db->select('*')
                    ->from($this->tables['teams'])
                    ->join($this->tables['teams_tournaments'], $this->tables['teams_tournaments'].'.team_id='.$this->tables['teams'].'.id','left')
                    ->get();
        return $result;
    }
    
    public function get_team($team_id)
    {
        $this->db->where('id',$team_id);
        return $this->db->select('*')
                    ->from($this->tables['teams'])
                    ->get();
    }
    
    public function team_identity_check($identity = '') {
        $this->trigger_events('team_identity_check');
        if (empty($identity)) {
            return FALSE;
        }
        $this->db->where($this->team_identity_column, $identity);
        return $this->db->count_all_results($this->tables['teams']) > 0;
    }
    
    public function create_team($title)
    {
        $this->trigger_events('pre_create_team');
        if ($this->team_identity_column == 'title' && $this->team_identity_check($title)) 
        {
            $this->set_error('team_creation_duplicate_team_name');
            return FALSE;
        }         
        $data = array(
            'name' => $title,
            'title' => $title,
            'created_on' => now()
        );
        //filter out any data passed that doesnt have a matching column in the users table
        //and merge the product data and the additional data
        $additional_data = $this->_filter_data($this->tables['teams'], $data);
        
        $this->db->insert($this->tables['teams'], $additional_data);

        $id = $this->db->insert_id();

        $this->trigger_events('post_create_team');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function assign_teams_tournament($data = array())
    {
        if(!empty($data))
        {
            $this->db->insert_batch($this->tables['teams_tournaments'], $data);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function create_match($additional_data)
    {
        $this->trigger_events('pre_create_match');
        $data = array(
            'created_on' => now()
        );
        //filter out any data passed that doesnt have a matching column in the users table
        $additional_data = array_merge($this->_filter_data($this->tables['matches'], $additional_data), $data);
        $this->db->insert($this->tables['matches'], $additional_data);

        $id = $this->db->insert_id();

        $this->trigger_events('post_create_match');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_matche_info($match_id)
    {
        $this->db->where($this->tables['matches'].'.id',$match_id);
        return $this->db->select($this->tables['matches'].'.id,'.$this->tables['matches'].'.id as match_id, team1.title as team1_title, team2.title as team2_title,'.$this->tables['matches'].'.date,'.$this->tables['matches'].'.time')
                    ->from($this->tables['matches'])
                    ->join($this->tables['teams'].' as team1', 'team1.id='.$this->tables['matches'].'.team1_id')
                    ->join($this->tables['teams'].' as team2', 'team2.id='.$this->tables['matches'].'.team2_id')
                    ->get();
    }
    
    public function get_all_matches($tournament_id)
    {
        $this->db->where('tournament_id',$tournament_id);
        return $this->db->select($this->tables['matches'].'.id,'.$this->tables['matches'].'.id as match_id, team1.title as team1_title, team2.title as team2_title,'.$this->tables['matches'].'.date,'.$this->tables['matches'].'.time')
                    ->from($this->tables['matches'])
                    ->join($this->tables['teams'].' as team1', 'team1.id='.$this->tables['matches'].'.team1_id')
                    ->join($this->tables['teams'].' as team2', 'team2.id='.$this->tables['matches'].'.team2_id')
                    ->get();
    }
    
    /*
     * This method will reutnr total users of each team of a match
     */
    public function get_team_total_users($match_id)
    {
        
    }
    
    /*
     * This method will return all chat rooms of a match
     */
    public function get_all_chat_rooms($match_id)
    {
        return $this->db->select($this->tables['xb_chat_rooms'].'.group_access_code,'.$this->tables['xb_chat_rooms'].'.id,'.$this->tables['xb_chat_rooms'].'.created_on,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name')
                ->from($this->tables['xb_chat_rooms'])
                ->join($this->tables['users'],  $this->tables['xb_chat_rooms'].'.user_id='.$this->tables['users'].'.id')
                ->where($this->tables['xb_chat_rooms'].'.match_id',$match_id)
                ->get();
    }
    
    /*
     * This method will return all messages of a chat room
     */
    public function get_all_messages_char_room($char_room_id)
    {
        
    }
    
    public function remove_team_from_tournament($tournament_id, $team_id)
    {
        $this->db->trans_begin();
        
        $this->remove_match_from_tournament($tournament_id, $team_id);
        
        $this->db->delete($this->tables['teams_tournaments'], array('team_id' => $team_id, 'tournament_id' => $tournament_id));
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;
    }
    
    public function remove_match_from_tournament($tournament_id, $team_id)
    {
        $where = "(tournament_id=".$tournament_id." AND (team1_id=".$team_id." OR team2_id=".$team_id."))";
        $this->db->where($where);
        $this->db->delete($this->tables['matches']);
    }
    
    public function get_room_conversation_match_info($xb_chat_room_id)
    {
        $this->db->where($this->tables['xb_chat_rooms'].'.id',$xb_chat_room_id);
        return $this->db->select($this->tables['matches'].'.id,'.$this->tables['matches'].'.id as match_id, team1.id as team1_id, team1.title as team1_title, team2.id as team2_id, team2.title as team2_title,'.$this->tables['matches'].'.date,'.$this->tables['matches'].'.time')
                    ->from($this->tables['xb_chat_rooms'])
                    ->join($this->tables['matches'], $this->tables['matches'].'.id='.$this->tables['xb_chat_rooms'].'.match_id')
                    ->join($this->tables['teams'].' as team1', 'team1.id='.$this->tables['matches'].'.team1_id')
                    ->join($this->tables['teams'].' as team2', 'team2.id='.$this->tables['matches'].'.team2_id')
                    ->get();
    }
    public function get_users_chat_room_mapping($xb_chat_room_id)
    {
        $this->db->where('xb_chat_room_id',$xb_chat_room_id);
        $this->db->group_by('user_id');
        return $this->db->select('team_id, count(user_id) as total_users')
                    ->from($this->tables['xb_chat_rooms_map'])
                    ->get();
    }
    
    /*
     * This method will store match info imported by xlsx file
     * @param $data, any array with content of all columns of a row
     * @Author Nazmul on 14 June 2014
     */
    public function add_imported_match_info($data)
    {
        //implement code here with transaction begin, roll back and commit
        
        $this->db->trans_begin();
        
        $sports_name = $data['sports_name'];
        $tournament_name = $data['tournament_name'];
        $team_a_name = $data['team_a_name'];
        $team_b_name = $data['team_b_name'];
        $date = $data['date'];
        $time = $data['time'];
        $sports_name_id_map = array();
        $tournament_name_id_map = array();
        $team_name_id_map = array();
        $team_id_tournament_id_exist_map = array();
        $sports_list_array = $this->get_all_sports()->result_array();
        foreach($sports_list_array as $sports_info)
        {
            $sports_name_id_map[$sports_info['title']] = $sports_info['sports_id'];
        }
        $sports_id = 0;
        if(array_key_exists($sports_name, $sports_name_id_map))
        {
            $sports_id = $sports_name_id_map[$sports_name];
        }
        else
        {
            //creating a new sports
            $data = array(
                'application_id' => APPLICATION_XSTREAM_BANTER_ID
            );
            $sports_id = $this->create_sports($sports_name, $data);
            if($sports_id==FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }
        $tournament_list_array = $this->get_all_tournaments($sports_id)->result_array();
        foreach($tournament_list_array as $tournament_info)
        {
            $tournament_name_id_map[$tournament_info['title']] = $tournament_info['tournament_id'];
        }
        $tournament_id = 0;
        if(array_key_exists($tournament_name, $tournament_name_id_map))
        {
            $tournament_id = $tournament_name_id_map[$tournament_name];
        }
        else
        {
            //creating a new tournament
            $additional_data = array(
                'sports_id' => $sports_id
            );
            $tournament_id = $this->create_tournament($tournament_name, $additional_data);
            
            if($tournament_id==FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }
        $team_list_array = $this->get_all_teams()->result_array();
        foreach($team_list_array as $team_info)
        {
            $team_name_id_map[$team_info['title']] = $team_info['team_id'];
        }
        $team_a_id = 0;
        if(array_key_exists($team_a_name, $team_name_id_map))
        {
            $team_a_id = $team_name_id_map[$team_a_name];
        }
        else
        {
            //creating a new team
            $team_a_id = $this->create_team($team_a_name);
            
            if($team_a_id==FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }
        $team_b_id = 0;
        if(array_key_exists($team_b_name, $team_name_id_map))
        {
            $team_b_id = $team_name_id_map[$team_b_name];
        }
        else
        {
            //creating a new team
            $team_b_id = $this->create_team($team_b_name);
            if($team_b_id==FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }
        $team_tournament_list_array = $this->get_all_teams_teams_tournaments()->result_array();
        foreach($team_tournament_list_array as $team_tournament_info)
        {
            $team_id_tournament_id_exist_map[$team_tournament_info['team_id'].'_'.$team_tournament_info['tournament_id']] = 1;
        }
        $data = array();
        if(!array_key_exists($team_a_id.'_'.$tournament_id, $team_id_tournament_id_exist_map))
        {
            $team_tournament = array(
                'team_id' => $team_a_id,
                'tournament_id' => $tournament_id
            );
            $data[] = $team_tournament;
        }
        if(!array_key_exists($team_b_id.'_'.$tournament_id, $team_id_tournament_id_exist_map))
        {
            $team_tournament = array(
                'team_id' => $team_b_id,
                'tournament_id' => $tournament_id
            );
            $data[] = $team_tournament;
        }
        //mapping team under tournament
        if(!empty($data))
        {
            $teams_assign = $this->assign_teams_tournament($data);
        
            if($teams_assign==FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }        
        $match_data = array(
            'tournament_id' => $tournament_id,
            'team1_id' => $team_a_id,
            'team2_id' => $team_b_id,
            'date' => $date,
            'time' => $time
        );
        //creating a new match
        $match_id = $this->create_match($match_data);
    
        if($match_id==FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        
        $this->db->trans_commit();
        
        return TRUE;
    }
}
