<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Xstream_banter extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library("basic_profile");
        $this->load->library("follower");
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("org/application/xstream_banter_library");
        $this->load->library('org/utility/utils');
        $this->load->library('visitors');
        //$this->load->library("statuses");
        $this->load->helper('url');
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

    }    
    function index()
    {
        if($this->input->post('sports_list'))
        {
            $sports_id = $this->input->post('sports_list');
            redirect('applications/xstream_banter/step2/'.$sports_id,'refresh');
        }
        
        $sports_list = array();
        $sports_list_array = $this->xstream_banter_library->get_all_sports()->result_array();
        foreach($sports_list_array as $sports)
        {
            $sports_list[$sports['id']] = $sports['title'];
        }
        $this->data['sports_list'] = $sports_list;
        
        $visit_success = $this->visitors->store_application_visitor(APPLICATION_XSTREAM_BANTER_ID);
        $this->template->load(null, "applications/xstream_banter/index", $this->data);
    }
    
    function step2($sports_id = 0)
    {
        if( $sports_id == 0)
        {
            redirect('applications/xstream_banter','');
        }
        if($this->input->post('tournament_list'))
        {
            $tournament_id = $this->input->post('tournament_list');
            redirect('applications/xstream_banter/step3/'.$tournament_id,'refresh');
        }        
        $this->data['sports_id'] = $sports_id;
        $tournament_list = array();
        $tournament_list_array = $this->xstream_banter_library->get_tournaments_match_date($this->utils->get_current_date_db())->result_array();
        foreach($tournament_list_array as $tournament)
        {
            $tournament_list[$tournament['tournament_id']] = $tournament['title'];
        }
        $this->data['tournament_list'] = $tournament_list;
        
        $this->template->load(null, "applications/xstream_banter/step2", $this->data);
    }
    
    function step3($tournament_id = 0)
    {
        if( $tournament_id == 0)
        {
            redirect('applications/xstream_banter','');
        }
        $tournament_info = array();
        $tournament_info_array = $this->xstream_banter_library->get_tournament($tournament_id)->result_array();
        if(!empty($tournament_info_array))
        {
            $tournament_info = $tournament_info_array[0];
        }
        $this->data['tournament_info'] = $tournament_info;
        $current_date = $this->utils->get_current_date_yyyymmdd();
        $match_list = $this->xstream_banter_library->get_all_matches($tournament_id, $current_date)->result_array();
        $this->data['match_list'] = $match_list;
        $formatted_date = $this->utils->formate_date($current_date);
        $this->data['current_date'] = $formatted_date;
        
        $this->template->load(null, "applications/xstream_banter/step3", $this->data);
    }
    
    function step4($match_id = 0)
    {
        if( $match_id == 0)
        {
            redirect('applications/xstream_banter','');
        }
        $match_info = array();
        $match_info_array = $this->xstream_banter_library->get_match($match_id)->result_array();
        if(!empty($match_info_array))
        {
            $match_info = $match_info_array[0];
        }
        $this->data['match_info'] = $match_info;
        $match_date = $match_info['date'];
        $formatted_date = $this->utils->formate_date($match_date);
        $this->data['match_date'] = $formatted_date;
        $this->template->load(null, "applications/xstream_banter/step4", $this->data);
    }
    
    function step5($match_id = 0)
    {
        if( $match_id == 0)
        {
            redirect('applications/xstream_banter','');
        }
        
        if($this->input->post('submit_enter_chat_room'))
        {
            $additional_data = array(
                'xb_chat_room_id' => $this->input->post('xb_chat_room_id'),
                'team_id' => $this->input->post('team_list'),
                'user_id' => $this->session->userdata('user_id'),
                'created_on' => now()
            );
            $this->xstream_banter_library->store_chat_room_mapping($additional_data);
            redirect('applications/xstream_banter/step7/'.$this->input->post('xb_chat_room_id'),'refresh');
        }
        
        $match_info = array();
        $match_info_array = $this->xstream_banter_library->get_match($match_id)->result_array();
        if(!empty($match_info_array))
        {
            $match_info = $match_info_array[0];
        }
        $this->data['match_info'] = $match_info;
        $team_list = array();
        $team_list[$match_info['team_id_home']] = $match_info['team1_title'];
        $team_list[$match_info['team_id_away']] = $match_info['team2_title'];
        $this->data['team_list'] = $team_list;
        $group_access_code = $this->generateRandomString(10);
        $this->data['group_access_code'] = $group_access_code;
        
        $additional_data = array(
            'group_access_code' => $group_access_code,
            'match_id' => $match_id,
            'user_id' => $this->session->userdata('user_id'),
            'created_on' => now()
        );
        $xb_chat_room_id = $this->xstream_banter_library->create_chat_room($additional_data);
        $this->data['submit_enter_chat_room'] = array(
            'name' => 'submit_enter_chat_room',
            'id' => 'submit_enter_chat_room',
            'type' => 'submit',
            'value' => 'Enter chat room',
        );
        if( $xb_chat_room_id !== FALSE)
        {
            $this->data['xb_chat_room_id'] = $xb_chat_room_id;
            $this->template->load(null, "applications/xstream_banter/step5", $this->data);
        }
    }
    
    function step6($match_id = 0)
    {
        if( $match_id == 0)
        {
            redirect('applications/xstream_banter','');
        }
        $this->data['message'] = '';
        if($this->input->post('submit_enter_chat_room'))
        {
            if($this->input->post('group_access_code') && $this->input->post('group_access_code') != '')
            {
                $group_access_code = $this->input->post('group_access_code');
                $chat_room_info_array = $this->xstream_banter_library->get_chat_room_info(0, $group_access_code)->result_array();
                if(!empty($chat_room_info_array))
                {
                    $char_room_info = $chat_room_info_array[0];
                    //check whether team is selected or not
                    $user_id = $this->session->userdata('user_id');
                    if($this->xstream_banter_library->is_chat_room_mapping_stored($char_room_info['id'], $user_id))
                    {
                        redirect('applications/xstream_banter/step7/'.$char_room_info['id'],'refresh');
                    }
                    else
                    {
                        redirect('applications/xstream_banter/chat_room_team_map/'.$char_room_info['id'].'/'.$match_id,'refresh');
                    }
                    
                }
                else
                {
                    $this->data['message'] = 'Invalid code or room.';
                }
            }
            else
            {
                $this->data['message'] = 'Please assign code to join a room.';
            }
            
        }
        $this->data['match_id'] = $match_id;
        $this->data['group_access_code'] = array(
            'name' => 'group_access_code',
            'id' => 'group_access_code',
            'type' => 'text',
        );
        $this->data['submit_enter_chat_room'] = array(
            'name' => 'submit_enter_chat_room',
            'id' => 'submit_enter_chat_room',
            'type' => 'submit',
            'value' => 'Enter chat room',
        );
        $match_info = array();
        $match_info_array = $this->xstream_banter_library->get_match($match_id)->result_array();
        if(!empty($match_info_array))
        {
            $match_info = $match_info_array[0];
        }
        $this->data['match_info'] = $match_info;
        $user_id = $this->session->userdata('user_id');
        $this->data['previous_chat_rooms'] = $this->xstream_banter_library->previous_joined_chat_rooms($match_id,$user_id)->result_array();
        $this->template->load(null, "applications/xstream_banter/step6", $this->data);
    }
    
    function chat_room_team_map($xb_chat_room_id, $match_id)
    {
        if($this->input->post('submit_enter_chat_room'))
        {
            $additional_data = array(
                'xb_chat_room_id' => $xb_chat_room_id,
                'team_id' => $this->input->post('team_list'),
                'user_id' => $this->session->userdata('user_id'),
                'created_on' => now()
            );
            $this->xstream_banter_library->store_chat_room_mapping($additional_data);
            redirect('applications/xstream_banter/step7/'.$xb_chat_room_id,'refresh');
        }
        $match_info = array();
        $match_info_array = $this->xstream_banter_library->get_match($match_id)->result_array();
        if(!empty($match_info_array))
        {
            $match_info = $match_info_array[0];
        }
        $team_list = array();
        $team_list[$match_info['team_id_home']] = $match_info['team1_title'];
        $team_list[$match_info['team_id_away']] = $match_info['team2_title'];
        $this->data['team_list'] = $team_list;
        $this->data['xb_chat_room_id'] = $xb_chat_room_id;
        $this->data['match_id'] = $match_id;
        $this->data['submit_enter_chat_room'] = array(
            'name' => 'submit_enter_chat_room',
            'id' => 'submit_enter_chat_room',
            'type' => 'submit',
            'value' => 'Enter chat room',
        );
        $this->template->load(null, "applications/xstream_banter/chat_room_team_map", $this->data);
    }
    
    function step7($xb_chat_room_id = 0)
    {
        $this->data['message'] = '';
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['xb_chat_room_id'] = $xb_chat_room_id;
        $match_info = array();
        $chat_room_info_array = $this->xstream_banter_library->get_chat_room_info($xb_chat_room_id, 0)->result_array();
        if(!empty($chat_room_info_array))
        {
            $chat_room_info = $chat_room_info_array[0];
            $this->data['group_access_code'] = $chat_room_info['group_access_code'];
            $match_info_array = $this->xstream_banter_library->get_match($chat_room_info['match_id'])->result_array();
            if(!empty($match_info_array))
            {
                $match_info = $match_info_array[0];
            }
        }
        $this->data['match_info'] = $match_info;
        $match_date = $match_info['date'];
        $formatted_date = $this->utils->formate_date($match_date);
        $this->data['match_date'] = $formatted_date;
        $this->data['chat_room_message_list'] = $this->xstream_banter_library->get_chat_room_messages($xb_chat_room_id);
        $this->template->load(null, "applications/xstream_banter/step7", $this->data);
    }
    
    function generateRandomString( $length = 10 ) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    
    //Ajax call
    function store_chat_message()
    {
        $response = array();
        $user_id = $this->session->userdata('user_id');
        $xb_chat_room_id = $_POST['xb_chat_room_id'];
        $message = $_POST['message'];
        $data = array(
            'message' => $message
        );
        $this->xstream_banter_library->store_chat_room_message($xb_chat_room_id, $user_id, $data);
        $response['chat_room_message_list'] = $this->xstream_banter_library->get_chat_room_messages($xb_chat_room_id);
        echo json_encode($response);
    }
    
    function get_chat_messages()
    {
        $response = array();
        $xb_chat_room_id = $_POST['xb_chat_room_id'];
        $response['chat_room_message_list'] = $this->xstream_banter_library->get_chat_room_messages($xb_chat_room_id);
        echo json_encode($response);
    }
    
}
?>
