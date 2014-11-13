<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_xstream_banter extends JsonRPCServer {
//class App_xstream_banter extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/xstream_banter_library');
        $this->load->library('org/utility/utils');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    /*
     * This method will return sports list of xstream banter application
     * @Author Nazmul on 29October 2014
     */
    public function get_all_sports()
    {
        $response = array();
        $sports_list = array();
        $sports_list_array = $this->xstream_banter_library->get_all_sports()->result_array();
        foreach($sports_list_array as $sports_info)
        {
            $sports = array(
                'id' => $sports_info['id'],
                'title' => $sports_info['title']
            );
            $sports_list[] = $sports;
        }
        $response['sports_list'] = $sports_list;
        //print_r(json_encode($response));
        return json_encode($response);
    }
    
    /*
     * This method will return all tournaments of a sports
     * @param $sports_id, sports id
     * @Author Nazmul on 29th October 2014
     */
    public function get_all_tournaments($sports_id = 0)
    {
        $response = array();
        $tournament_list = $this->xstream_banter_library->get_all_tournaments($sports_id)->result_array();
        $response['tournament_list'] = $tournament_list;
        //print_r(json_encode($response));
        return json_encode($response);
    }
    
    /*
     * This method will return all matches of a tournament of current date
     * @Author Nazmul on 29th October 2014
     */
    public function get_all_matches($tournament_id = 0)
    {
        $response = array();
        $current_date = $this->utils->get_current_date_yyyymmdd();
        $match_list = $this->xstream_banter_library->get_all_matches($tournament_id, $current_date)->result_array();
        $response['match_list'] = $match_list;
        //print_r(json_encode($response));
        return json_encode($response);
    }
    
    /*
     * This method will create a new chat room of a match under a user
     * @Author Nazmul on 29th October 2014
     */
    public function create_chat_rooom($match_id = 0, $user_id = 0)
    {
        $result = array();
        
        $group_access_code = $this->utils->generateRandomString(10);
        $result['group_access_code'] = $group_access_code;
        
        $additional_data = array(
            'group_access_code' => $group_access_code,
            'match_id' => $match_id,
            'user_id' => $user_id
        );
        $xb_chat_room_id = $this->xstream_banter_library->create_chat_room($additional_data);
        $result['xb_chat_room_id'] = $xb_chat_room_id;
        
        $response = array_merge($result, $this->process_chat_room_map($match_id));
        //print_r(json_encode($response));
        return json_encode($response);
    }
    
    /*
     * This method will store chat room mapping of a user
     * @Author Nazmul on 29th October 2014
     */
    function store_chat_room_map()
    {
        $result = array();
        $xb_chat_room_id = 12;
        /*$data = json_decode($map_data);
        $data = new stdClass();
        $data->xb_chat_room_id = 12;
        $data->team_id = 2;
        $data->user_id = 4;
        $additional_data = array(
            'xb_chat_room_id' => $data->xb_chat_room_id,
            'team_id' => $data->team_id,
            'user_id' => $data->user_id,
            'created_on' => now()
        );
        $this->xstream_banter_library->store_chat_room_mapping($additional_data);
        $result['xb_chat_room_id'] = $data->xb_chat_room_id;*/
        $response = array_merge($result, $this->process_access_room($xb_chat_room_id));
        //print_r(json_encode($response));
        return json_encode($response);
    }
    
    /*
     * This method will return previously accessed room code of a match of a user
     * @Author Nazmul on 29th October 2014
     */
    function join_chat_room($match_id = 0, $user_id = 0)
    {
        $response = array();
        //$room_data = '[{"user_id":4,"match_id":"1"}]';
        //$data = json_decode($room_data);
        //$data = $data[0];
        $match_info = array();
        $match_info_array = $this->xstream_banter_library->get_match($match_id)->result_array();
        if(!empty($match_info_array))
        {
            $match_info = $match_info_array[0];
        }
        $response['match_info'] = $match_info;
        $response['previous_chat_rooms'] = $this->xstream_banter_library->previous_joined_chat_rooms($match_id,$user_id)->result_array();
        //print_r(json_encode($response));
        return json_encode($response);
    }
    
    function enter_chat_room($room_data = '')
    {
        $response = array();
        $result = array();
        $data = json_decode($room_data);
        $data = new stdClass();
        $data->group_access_code = 'AqNt4nqq6J';
        $data->user_id = 4;
        
        $chat_room_info_array = $this->xstream_banter_library->get_chat_room_info(0, $data->group_access_code)->result_array();
        if(!empty($chat_room_info_array))
        {
            $char_room_info = $chat_room_info_array[0];
            //check whether team is selected or not
            if($this->xstream_banter_library->is_chat_room_mapping_stored($char_room_info['id'], $data->user_id))
            {
                $result['room_map_exists'] = 1;
                $result['group_access_code'] = $data->group_access_code;
                $response = array_merge($result, $this->process_access_room($char_room_info['id']));
            }
            else
            {
                //allow user to select map
                $result['room_map_exists'] = 0;
                $result['xb_chat_room_id'] = $char_room_info['id'];
                $response = array_merge($result, $this->process_chat_room_map($char_room_info['match_id']));
            }
        }
        //print_r(json_encode($response));
        return json_encode($response);
    }
    
    function process_chat_room_map($match_id)
    {
        $result = array();
        $match_info = array();
        $match_info_array = $this->xstream_banter_library->get_match($match_id)->result_array();
        if(!empty($match_info_array))
        {
            $match_info = $match_info_array[0];
        }
        
        $team_list = array();
        $home_team = array(
            'id' => $match_info['team_id_home'],
            'title' => $match_info['team1_title']
        );
        $away_team = array(
            'id' => $match_info['team_id_away'],
            'title' => $match_info['team2_title']
        );
        $team_list[] = $home_team;
        $team_list[] = $away_team;
        
        $result['team_list'] = $team_list;
        return $result;
    }
    
    function process_access_room($xb_chat_room_id)
    {
        $response = array();
        $match_info = array();
        $chat_room_info_array = $this->xstream_banter_library->get_chat_room_info($xb_chat_room_id, 0)->result_array();
        if(!empty($chat_room_info_array))
        {
            $chat_room_info = $chat_room_info_array[0];
            $response['group_access_code'] = $chat_room_info['group_access_code'];
            $match_info_array = $this->xstream_banter_library->get_match($chat_room_info['match_id'])->result_array();
            if(!empty($match_info_array))
            {
                $match_info = $match_info_array[0];
            }
        }
        $response['match_info'] = $match_info;
        $match_date = $match_info['date'];
        $formatted_date = $this->utils->formate_date($match_date);
        $response['match_date'] = $formatted_date;
        $response['chat_room_message_list'] = $this->xstream_banter_library->get_chat_room_messages($xb_chat_room_id);
        return $response;
    }
}