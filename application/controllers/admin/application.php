<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Application extends Admin_Controller{
    public $user_group_array = array();
    public $allow_view = FALSE;
    public $allow_access = FALSE;
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/application/admin_application_library');
        $this->load->library('org/admin/application/admin_xstream_banter');
        $this->load->library('org/application/xstream_banter_library');
        $this->load->library('org/admin/access_level/admin_access_level_library'); 
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        $selected_user_group = $this->session->userdata('user_type');
        if(isset($selected_user_group ) && $selected_user_group != ""){
            $this->user_group_array = array($selected_user_group);
        }
        else
        {
            $this->user_group_array = $this->ion_auth->get_current_user_types();
        } 
        if (in_array(ADMIN, $this->user_group_array)) {
            $this->allow_view = TRUE;
            $this->allow_access = TRUE;
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->allow_view = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->allow_access = TRUE;
            }
            if(!$this->allow_view)
            {
                redirect('admin/overview', 'refresh');
            }
        } 
    }
    
    function index()
    {
        $this->application_manage();
    }
    
    function application_manage()
    {
        $this->data['message'] = '';
        $this->data['application_list'] = $this->admin_application_library->get_all_applications();
        
        /*if (in_array(ADMIN, $this->user_group_array)) {
            $this->template->load(ADMIN_DASHBOARD_TEMPLATE, "admin/applications/application_manage", $this->data);
        }
        else if (in_array(PUBLISHER, $this->user_group_array)) {
            $this->template->load(PUBLISHER_DASHBOARD_TEMPLATE, "admin/applications/application_manage", $this->data);
        }*/        
        $this->template->load(null, "admin/applications/application_manage", $this->data);
    }
    
    //---------------------------------------Xstream Banter---------------------------
    function xstream_banter()
    {
        $this->data['message'] = '';
        $sports_list = array();
        $sports_list_array = $this->admin_xstream_banter->get_all_sports()->result_array();
        if(!empty($sports_list_array))
        {
            $sports_list = $sports_list_array;
        }
        $this->data['sports_list'] = $sports_list;
        $this->template->load(null, "admin/applications/xstream_banter/sports", $this->data);
    }
    
    function xstream_banter_sports($sports_id)
    {
        $this->data['message'] = '';
        $tournament_list = array();
        $tournament_list_array = $this->admin_xstream_banter->get_all_tournaments($sports_id)->result_array();
        if(!empty($tournament_list_array))
        {
            $tournament_list = $tournament_list_array;
        }
        $this->data['tournament_list'] = $tournament_list;
        $team_list = $this->admin_xstream_banter->get_all_teams();
        $this->data['team_list'] = $team_list;
        $this->data['sports_id'] = $sports_id;
        $this->template->load(null, "admin/applications/xstream_banter/tournaments", $this->data);
    }
    
    function xstream_banter_tournament($tournament_id)
    {
        $this->data['message'] = '';
        $this->data['tournament_id'] = $tournament_id;
        $tournament_info = array();
        $tournament_info_array = $this->admin_xstream_banter->get_tournament_info($tournament_id)->result_array();
        if(!empty($tournament_info_array))
        {
            $tournament_info = $tournament_info_array[0];
        }
        $this->data['tournament_info'] = $tournament_info;
        $team_list = $this->admin_xstream_banter->get_all_teams_tournament($tournament_id);
        $this->data['team_list'] = $team_list;
        $team_list_match = array();
        foreach($team_list as $team)
        {
            $team_list_match[$team['id']] = $team['title'];
        }
        $this->data['team_list_match'] = $team_list_match;
        $new_team_list = $this->admin_xstream_banter->get_all_teams_not_in_tournament($tournament_id);
        $this->data['new_team_list'] = $new_team_list;
        $match_list = $this->admin_xstream_banter->get_all_matches($tournament_id)->result_array();
        $this->data['match_list'] = $match_list;
        $this->template->load(null, "admin/applications/xstream_banter/tournament", $this->data);
    }
    
    
    function xstream_banter_match($match_id)
    {
        $this->data['message'] = '';
        $match_info = array();
        $match_info_array = $this->admin_xstream_banter->get_matche_info($match_id)->result_array();
        if(!empty($match_info_array))
        {
            $match_info = $match_info_array[0];
        }
        $this->data['match_info'] = $match_info;
        $chat_room_list = $this->admin_xstream_banter->get_all_chat_rooms($match_id)->result_array();
        $this->data['chat_room_list'] = $chat_room_list;
        $this->template->load(null, "admin/applications/xstream_banter/match", $this->data);
    }
    function xstream_banter_room_conversation($room_id)
    {
        $this->data['message'] = '';
        $room_conversation_match_info = array();
        $room_conversation_match_info_array = $this->admin_xstream_banter->get_room_conversation_match_info($room_id)->result_array();
        if(!empty($room_conversation_match_info_array))
        {
            $room_conversation_match_info = $room_conversation_match_info_array[0];
        }
        $team_total_users_map = array(
            $room_conversation_match_info['team1_id'] => 0,
            $room_conversation_match_info['team2_id'] => 0,
        );
        $users_chat_room_mapping_array = $this->admin_xstream_banter->get_users_chat_room_mapping($room_id)->result_array();
        foreach($users_chat_room_mapping_array as $users_chat_room_mapping)
        {
            $team_total_users_map[$users_chat_room_mapping['team_id']] = $users_chat_room_mapping['total_users'];
        }
        $this->data['room_conversation_match_info'] = $room_conversation_match_info;
        $this->data['team_total_users_map'] = $team_total_users_map;
        
        $this->data['chat_room_message_list'] = $this->xstream_banter_library->get_chat_room_messages($room_id);
        
        $this->template->load(null, "admin/applications/xstream_banter/room_conversation", $this->data);
    }
    //Ajax calls
    function create_sports()
    {
        $response = array();
        $sports_name = $_POST['sports_name'];
        $additional_data = array(
            'application_id' => APPLICATION_XSTREAM_BANTER_ID
        );
        $id = $this->admin_xstream_banter->create_sports($sports_name, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Sports is added successfully.';
            $sports_info_array = $this->admin_xstream_banter->get_sports($id)->result_array();
            if(!empty($sports_info_array))
            {
                $response['sports_info'] = $sports_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_xstream_banter->errors_alert();
        }
        echo json_encode($response);
    }
    
    function create_tournament()
    {
        $response = array();
        $tournament_name = $_POST['tournament_name'];
        $sports_id = $_POST['sports_id'];
        $additional_data = array(
            'sports_id' => $sports_id
        );
        $id = $this->admin_xstream_banter->create_tournament($tournament_name, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Tournament is added successfully.';
            $tournament_info_array = $this->admin_xstream_banter->get_tournament($id)->result_array();
            if(!empty($tournament_info_array))
            {
                $response['tournament_info'] = $tournament_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_xstream_banter->errors_alert();
        }
        echo json_encode($response);
    }
    
    function create_team()
    {
        $response = array();
        $team_name = $_POST['team_name'];
        $id = $this->admin_xstream_banter->create_team($team_name);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Team is added successfully.';
            $team_info_array = $this->admin_xstream_banter->get_team($id);
            if(!empty($team_info_array))
            {
                $response['team_info'] = $team_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_xstream_banter->errors_alert();
        }
        echo json_encode($response);
    }
    
    function assign_teams_tournament()
    {
        $response = array();
        $tournament_id = $_POST['tournament_id'];
        $team_id_list = $_POST['team_id_list'];
        $data = array();
        foreach($team_id_list as $team_id){
            $team_tournament = array(
                'team_id' => $team_id,
                'tournament_id' => $tournament_id
            );
            $data[] = $team_tournament;
        }
        if($this->admin_xstream_banter->assign_teams_tournament($data))
        {
            $response['status'] = 1;
        }
        else
        {
            $response['status'] = 0;
        }
        echo json_encode($response);
    }
    
    function create_match()
    {
        $response = array();
        $tournament_id = $_POST['tournament_id'];
        $team1_id = $_POST['team1_id']; 
        $team2_id = $_POST['team2_id']; 
        $date = $_POST['date']; 
        $time = $_POST['time'];
        $additional_data = array(
            'tournament_id' => $tournament_id,
            'team1_id' => $team1_id,
            'team2_id' => $team2_id,
            'date' => $date,
            'time' => $time
        );
        $match_id = $this->admin_xstream_banter->create_match($additional_data);
        if($match_id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Match is stored successfully.';
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = 'Error while creating a match.';
        }
        echo json_encode($response);
    }
    
    function remove_team_from_tournament()
    {
        $result = array();
        $team_id = $_POST['team_id']; 
        $tournament_id = $_POST['tournament_id']; 
        if($this->admin_xstream_banter->remove_team_from_tournament($tournament_id, $team_id))
        {
            $result['status'] = 1;
            $result['message'] = 'Team is removed successfully.';
        }
        else
        {
            $result['status'] = 0;
            $result['message'] = 'Error while removing the team. Please try again.';
        }
        echo json_encode($result);
    }
    public function import_time_validation($time)
    {
        if(preg_match("/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $time) === 0) {
            return 0;
        } else {
           return 1;
        }
    }
    
    public function import_date_validation($date)
    {
        if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\-(0[1-9]|1[0-2])\-[0-9]{4}$/", $date) === 0) {
           RETURN 0;
        } else {
           RETURN 1;
        }
    }
    
    function page_import_xstream()
    {
        $success_counter = 0;
        $result_array = array();
        $this->data['message'] = '';
        if($this->input->post('button_submit'))
        {
            $config['upload_path'] = './././resources/import/applications/xstream_banter/';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = 'xstream.xlsx';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                
                $this->data['message'] = $this->upload->display_errors();
            }
            else
            {
                $file = 'resources/import/applications/xstream_banter/xstream.xlsx';

                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);

                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                //task_tanvir validate each row before extracting information
                foreach ($cell_collection as $cell) {

                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();

                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = $data_value;
                    } else {
                        $arr_data[$row][$column] = $data_value;
                    }
                }
                
                $header_len = sizeof($header[1]);
                
                $i=0;
                foreach ($arr_data as $result_data)
                {
                    $i++;
                    
                    
                    if(sizeof($result_data)!=$header_len || (array_key_exists('E', $result_data) && !$this->import_date_validation($result_data['E'])) || (array_key_exists('F', $result_data) && !$this->import_time_validation($result_data['F']))){ 
                        
                        $result_array[$i] = 'Row no '.$i.' is not containing valid data';
                        continue;
                    }
                    
                    $data = array(
                        'sports_name' => strip_tags($result_data['A']),
                        'tournament_name' => strip_tags($result_data['B']),
                        'team_a_name' => strip_tags($result_data['C']),
                        'team_b_name' => strip_tags($result_data['D']),
                        'date' => $result_data['E'],
                        'time' => $result_data['F']
                    );
                    //task_redwan
                    $flag = $this->admin_xstream_banter_model->add_imported_match_info($data);
                    //$this->import_xstream_banter_match($data);
                
                     if ($flag !== FALSE) {
                        $success_counter++;
                    } else {
                        $result_array[$i] = 'row no ' . $i . ' contain duplicated recipe title';
                    }
                }
            }
            
            $message = $success_counter.' rows are inserted '.'<br>';
            if(!empty($result_array)) $message = $message.'';
            foreach($result_array as $result)
            {
                $message = $message.' '.$result.'<br>';
            }
            $this->data['message'] = $message;
            
        }
        $this->template->load(null, "admin/applications/xstream_banter/import_xstream_view", $this->data);
    }
    
    /*
     * This method will insert one match into the database 
     * @Author Nazmul on 11th June 2014
     * @param $data, match info
     */
//    function import_xstream_banter_match($data)
//    {
//        $sports_name = $data['sports_name'];
//        $tournament_name = $data['tournament_name'];
//        $team_a_name = $data['team_a_name'];
//        $team_b_name = $data['team_b_name'];
//        $date = $data['date'];
//        $time = $data['time'];
//        $sports_name_id_map = array();
//        $tournament_name_id_map = array();
//        $team_name_id_map = array();
//        $team_id_tournament_id_exist_map = array();
//        $sports_list_array = $this->admin_xstream_banter_model->get_all_sports()->result_array();
//        foreach($sports_list_array as $sports_info)
//        {
//            $sports_name_id_map[$sports_info['title']] = $sports_info['sports_id'];
//        }
//        $sports_id = 0;
//        if(array_key_exists($sports_name, $sports_name_id_map))
//        {
//            $sports_id = $sports_name_id_map[$sports_name];
//        }
//        else
//        {
//            //creating a new sports
//            $data = array(
//                'application_id' => APPLICATION_XSTREAM_BANTER_ID
//            );
//            $sports_id = $this->admin_xstream_banter_model->create_sports($sports_name, $data);
//        }
//        $tournament_list_array = $this->admin_xstream_banter_model->get_all_tournaments($sports_id)->result_array();
//        foreach($tournament_list_array as $tournament_info)
//        {
//            $tournament_name_id_map[$tournament_info['title']] = $tournament_info['tournament_id'];
//        }
//        $tournament_id = 0;
//        if(array_key_exists($tournament_name, $tournament_name_id_map))
//        {
//            $tournament_id = $tournament_name_id_map[$tournament_name];
//        }
//        else
//        {
//            //creating a new tournament
//            $additional_data = array(
//                'sports_id' => $sports_id
//            );
//            $tournament_id = $this->admin_xstream_banter_model->create_tournament($tournament_name, $additional_data);
//        }
//        $team_list_array = $this->admin_xstream_banter_model->get_all_teams()->result_array();
//        foreach($team_list_array as $team_info)
//        {
//            $team_name_id_map[$team_info['title']] = $team_info['team_id'];
//        }
//        $team_a_id = 0;
//        if(array_key_exists($team_a_name, $team_name_id_map))
//        {
//            $team_a_id = $team_name_id_map[$team_a_name];
//        }
//        else
//        {
//            //creating a new team
//            $team_a_id = $this->admin_xstream_banter_model->create_team($team_a_name);
//        }
//        $team_b_id = 0;
//        if(array_key_exists($team_b_name, $team_name_id_map))
//        {
//            $team_b_id = $team_name_id_map[$team_b_name];
//        }
//        else
//        {
//            //creating a new team
//            $team_b_id = $this->admin_xstream_banter_model->create_team($team_b_name);
//        }
//        $team_tournament_list_array = $this->admin_xstream_banter_model->get_all_teams_teams_tournaments()->result_array();
//        foreach($team_tournament_list_array as $team_tournament_info)
//        {
//            $team_id_tournament_id_exist_map[$team_tournament_info['team_id'].'_'.$team_tournament_info['tournament_id']] = 1;
//        }
//        $data = array();
//        if(!array_key_exists($team_a_id.'_'.$tournament_id, $team_id_tournament_id_exist_map))
//        {
//            $team_tournament = array(
//                'team_id' => $team_a_id,
//                'tournament_id' => $tournament_id
//            );
//            $data[] = $team_tournament;
//        }
//        if(!array_key_exists($team_b_id.'_'.$tournament_id, $team_id_tournament_id_exist_map))
//        {
//            $team_tournament = array(
//                'team_id' => $team_b_id,
//                'tournament_id' => $tournament_id
//            );
//            $data[] = $team_tournament;
//        }
//        //mapping team under tournament
//        if(!empty($data))
//        {
//            $this->admin_xstream_banter_model->assign_teams_tournament($data);
//        }        
//        $match_data = array(
//            'tournament_id' => $tournament_id,
//            'team1_id' => $team_a_id,
//            'team2_id' => $team_b_id,
//            'date' => $date,
//            'time' => $time
//        );
//        //creating a new match
//        $this->admin_xstream_banter_model->create_match($match_data);
//    }
    //---------------------------------------Xstream Banter Finish---------------------------
}
?>
