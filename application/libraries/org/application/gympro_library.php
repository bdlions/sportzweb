<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Gympro Library *
 * Author: Nazmul on 17th November 2014
 * Requirements: PHP5 or above
 *
 */
class Gympro_library {
    public $client_info;
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('org/utility/Utils');
        $this->load->library("statuses");
        $this->load->library('notification');
        $this->load->library("follower");
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('org/application/gympro_model');

        $this->gympro_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->gympro_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in gympro_model');
        }

        return call_user_func_array(array($this->gympro_model, $method), $arguments);
    }
    

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }
    
    public function create_client($client_info)
    {
        $client_id = $this->gympro_model->create_client($client_info);
        if($client_id !== FALSE)
        {
            $result = $this->follower->get_relation_with_user($client_info['member_id']);
            if($result['profile_type'] == PROFILE_NON_FOLLOWER)
            {
                //sending add request to the client
                $this->follower->add_follower($client_info['user_id'], $client_info['member_id']);
                //sending follower notification to the client
                $current_time = now();
                $notification_info_list = new stdClass();
                $notification_info_list->id = '';
                $notification_info_list->created_on = $current_time;
                $notification_info_list->modified_on = $current_time;
                $notification_info_list->type_id = NOTIFICATION_WHILE_START_FOLLOWING;
                $notification_info_list->status = UNREAD_NOTIFICATION;
                $notification_info_list->reference_id = $client_info['user_id'];
                $notification_info_list->reference_id_list = array();
                $this->notification->add_notification($client_info['member_id'], $notification_info_list);

            }
        }
        return $client_id;
    }
    
    public function get_follower_clients($user_id = 0)
    {
        $client_list = array();
        $follower_id_list = $this->follower->get_follower_user_id_list($user_id);
        $client_list_array = $this->gympro_model->get_all_clients($user_id)->result_array();
        foreach($client_list_array as $client_info)
        {
            if(in_array($client_info['member_id'], $follower_id_list))
            {
                $client_list[] = $client_info;
            }
        }
        return $client_list;
    }
    
    public function create_assessment($assessment_info)
    {
        $assessment_id = $this->gympro_model->create_assessment($assessment_info);
        if($assessment_id !== FALSE)
        {
            $client_info_array = $this->gympro_model->get_client_information($assessment_info['client_id'])->result_array();
            if(!empty($client_info_array))
            {
                $client_info = $client_info_array[0];
                $this->create_notification($client_info['user_id'], $client_info['member_id'], $assessment_id, NOTIFICATION_WHILE_CREATE_GYMPRO_ASSESSMENT);
            }
        }
        return $assessment_id;
    }
    
    public function create_program($program_info)
    {
        $program_id = $this->gympro_model->create_program($program_info);
        if($program_id !== FALSE)
        {
            $client_info_array = $this->gympro_model->get_client_information($program_info['client_id'])->result_array();
            if(!empty($client_info_array))
            {
                $client_info = $client_info_array[0];
                $this->create_notification($client_info['user_id'], $client_info['member_id'], $program_id, NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM);
            }
        }
        return $program_id;
    }
    
    public function create_mission($mission_info)
    {
        $mission_id = $this->gympro_model->create_mission($mission_info);
        if($mission_id !== FALSE)
        {
            $client_info_array = $this->gympro_model->get_client_information($mission_info['client_id'])->result_array();
            if(!empty($client_info_array))
            {
                $client_info = $client_info_array[0];
                $this->create_notification($client_info['user_id'], $client_info['member_id'], $mission_id, NOTIFICATION_WHILE_CREATE_GYMPRO_MISSION);
            }
        }
        return $mission_id;
    }
    
    public function create_exercise($exercise_info)
    {
        $exercise_id = $this->gympro_model->create_exercise($exercise_info);
        if($exercise_id !== FALSE)
        {
            $client_info_array = $this->gympro_model->get_client_information($exercise_info['client_id'])->result_array();
            if(!empty($client_info_array))
            {
                $client_info = $client_info_array[0];
                $this->create_notification($client_info['user_id'], $client_info['member_id'], $exercise_id, NOTIFICATION_WHILE_CREATE_GYMPRO_EXERCISE);
            }
        }
        return $exercise_id;
    }
    
    public function create_nutrition($nutrition_info)
    {
        $nutrition_id = $this->gympro_model->create_nutrition($nutrition_info);
        if($nutrition_id !== FALSE)
        {
            $client_info_array = $this->gympro_model->get_client_information($nutrition_info['client_id'])->result_array();
            if(!empty($client_info_array))
            {
                $client_info = $client_info_array[0];
                $this->create_notification($client_info['user_id'], $client_info['member_id'], $nutrition_id, NOTIFICATION_WHILE_CREATE_GYMPRO_NUTRITION);
            }
        }
        return $nutrition_id;
    }
    
    public function create_notification($sender_user_id, $receiver_user_id, $reference_id, $type_id)
    {
        $current_time = now();
        $reference_info_list = new stdClass();
        $reference_info_list->user_id = $sender_user_id;
        $reference_info_list->status_type = UNREAD_NOTIFICATION;
        $reference_info_list->created_on = $current_time;

        $notification_info_list = new stdClass();
        $notification_info_list->id = '';
        $notification_info_list->created_on = $current_time;
        $notification_info_list->modified_on = $current_time;
        $notification_info_list->type_id = $type_id;
        $notification_info_list->status = UNREAD_NOTIFICATION;
        $notification_info_list->reference_id = $reference_id;
        $notification_info_list->reference_id_list = array();
        $notification_info_list->reference_id_list[] = $reference_info_list;
        $this->notification->add_notification($receiver_user_id, $notification_info_list);
    }
    
    //------------------------Gympro User ------------------------------//
    /*
     * This method will store gympro user info
     * @param $addition_data, user info data
     * @param $user_id, gympro user id
     * @Author Nazmul on 30th December 2014
     */
    public function store_gympro_user_info($user_id, $additional_data)
    {
        if($this->gympro_model->is_gympro_user_exist($user_id))
        {
            return $this->gympro_model->update_gympro_user_info($user_id, $additional_data);
        }
        else
        {
            $additional_data['user_id'] = $user_id;
            return $this->gympro_model->create_gympro_user($additional_data);
        }
    }
    /*
     * This method will return answers of questions of a client
     * @param $client_id, client id
     * @Author Nazmul on 11th December 2014
     */
    public function get_question_answers($client_id)
    {
        $question_id_answer_map = array();
        $client_info_array = $this->gympro_model->get_client_info($client_id)->result_array();
        if(!empty($client_info_array))
        {
            $question_list = $client_info_array[0]['question_answer_list'];
            if( $question_list != "" && $question_list != NULL )
            {
                $answers_array = json_decode($question_list);   
                foreach($answers_array as $answer_info)
                {
                    $answer = array(
                        'answer' => $answer_info->answer,
                        'additional_info' => $answer_info->additional_info
                    );  
                    $question_id_answer_map[$answer_info->id] = $answer;
                }
            }
        }
        return $question_id_answer_map;
    }
    
    /*
     * This method will return all groups after converting date format
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_groups($user_id = 0)
    {
        $group_list = array();
        $groups_array = $this->gympro_model->get_all_groups($user_id)->result_array();
        foreach($groups_array as $group_info)
        {
            $group_info['created_on'] = $this->utils->get_unix_to_human_date($group_info['created_on']);
            $group_list[] = $group_info;
        }
        return $group_list;
    }
    /*
     * This method will return client id list of a group
     * @param $group_id, group id
     * @Author Nazmul on 11th December 2014
     */
    public function get_client_id_list_in_group($group_id)
    {
        $client_id_list = array();
        $group_clients_array = $this->gympro_model->get_group_clients_info($group_id)->result_array();
        foreach($group_clients_array as $group_client_info)
        {
            $client_id_list[] = $group_client_info['client_id'];
        }
        return $client_id_list;
    }

    /*
     * This method will return all client info of a group
     * @param $group_id, group id
     * @Author Nazmul on 11th December 2014
     */
    public function get_clients_info_in_group($group_id){
        $user_id = $this->session->userdata('user_id');
        $clients_array = $this->gympro_model->get_all_clients($user_id)->result_array();
        $client_ids = $this->get_client_id_list_in_group($group_id);
        foreach ($clients_array as $key => $client) {
            if(!in_array($client['client_id'], $client_ids)){
                unset($clients_array[$key]);
            }
        }
        return array_values($clients_array);
    }
    /*
     * This method will return all programs after converting date format
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_programs($user_id = 0, $order_by = '')
    {
        $program_list = array();
        $programs_array = $this->gympro_model->get_all_programs($user_id, $order_by)->result_array();
        foreach($programs_array as $program_info)
        {
            $program_info['created_on'] = $this->utils->get_unix_to_human_date($program_info['created_on']);
            $program_list[] = $program_info;
        }
        return $program_list;
    }
    /*
     * This method will return all exercises after converting date format
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_exercises($user_id = 0)
    {
        $exercise_list = array();
        $exercises_array = $this->gympro_model->get_all_exercises($user_id)->result_array();
        foreach($exercises_array as $exercise_info)
        {
            $exercise_info['created_on'] = $this->utils->get_unix_to_human_date($exercise_info['created_on']);
            $exercise_list[] = $exercise_info;
        }
        return $exercise_list;
    }
    /*
     * This method will return all nutritions after converting date format
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_nutritions($user_id = 0)
    {
        $nutrition_list = array();
        $nutritions_array = $this->gympro_model->get_all_nutritions($user_id)->result_array();
        foreach($nutritions_array as $nutrition_info)
        {
            $nutrition_info['created_on'] = $this->utils->get_unix_to_human_date($nutrition_info['created_on']);
            $nutrition_list[] = $nutrition_info;
        }
        return $nutrition_list;
    }
    /*
     * This method will return all assessments after converting date format
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_assessments($user_id = 0, $order_by = '')
    {
        $assessment_list = array();
        $assessments_array = $this->gympro_model->get_all_assessments($user_id, $order_by)->result_array();
        foreach($assessments_array as $assessment_info)
        {
            $assessment_info['created_on'] = $this->utils->get_unix_to_human_date($assessment_info['created_on']);
            $assessment_list[] = $assessment_info;
        }
        return $assessment_list;
    }
    /*
     * This method will return all mission after converting date format
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_missions($user_id = 0, $order_by = '')
    {
        $mission_list = array();
        $missions_array = $this->gympro_model->get_all_missions($user_id, $order_by)->result_array();
        foreach($missions_array as $mission_info)
        {
            $mission_info['created_on'] = $this->utils->get_unix_to_human_date($mission_info['created_on']);
            $mission_list[] = $mission_info;
        }
        return $mission_list;
    }
    
    /*
     * This method will return all nutrition after converting date format
     * @param $member_id, user id of the site
     * @param $client_id, client id of a client
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_client_nutritions($member_id = 0, $client_id = 0)
    {
        $nutrition_list = array();
        $nutritions_array = $this->gympro_model->get_all_client_nutritions($member_id, $client_id)->result_array();
        foreach($nutritions_array as $nutrition_info)
        {
            $nutrition_info['created_on'] = $this->utils->get_unix_to_human_date($nutrition_info['created_on']);
            $nutrition_list[] = $nutrition_info;
        }
        return $nutrition_list;
    }
    
    //---------------------------------------Session Module -----------------------------------//
    /*
     * This method will convert session into calendar displayed format
     * @Author Nazmul on 24th January 2015
     * modified by Tanveer Ahmed on 16 Feb 2015 (implemented repeat processing)
     */
    public function get_sessions_in_calendar($user_id = 0, $account_type_id = APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL ){
        if($user_id == 0){
            $user_id = $this->session->userdata('user_id');
        }
        $session_list = array();
        $session_list_array = array();
        $where = array();
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL)
        {
            return array();
        }
        else if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $session_list_array = $this->gympro_model->get_client_sessions($user_id)->result_array();
        }
        else
        {
            $where = array(
                'user_id' => $user_id
            );
            //$session_list_array = $this->gympro_model->where($where)->get_all_sessions()->result_array();
            $session_list_array = $this->get_sessions($where);
        }        
        foreach($session_list_array as $session_info){
            $rep_date = $session_info['date'];
            if($session_info['type_id'] != GYMPRO_SINGLE_SESSION_TYPE_ID) {
                $repeat_text =  $session_info['type_id']    == GYMPRO_REPEATED_DAILY_TYPE_ID    ?'+1 Day'
                                :($session_info['type_id']  == GYMPRO_REPEATED_WEEKLY_TYPE_ID   ?'+1 Week'
                                :($session_info['type_id']  == GYMPRO_REPEATED_BIWEEKLY_TYPE_ID ?'+2 Week'
                                :($session_info['type_id']  == GYMPRO_REPEATED_MONTHLY_TYPE_ID  ?'+1 Month'
                                :NULL)));
                for( $repeat_times = $session_info['repeat']; $repeat_times>0; $repeat_times-- ){
                    $calendar_session_info = array(
                        'session_info' => $session_info,
                        //'title' => $session_info['title'],
                        'title' => $session_info['created_for'],
                        'start' => $rep_date.'T'.$session_info['start'],
                        'end' => $rep_date.'T'.$session_info['end']
                    );
                    $session_list[] = $calendar_session_info;
                    $new_date = new DateTime($rep_date);
                    $new_date->modify($repeat_text);
                    $rep_date = $new_date->format('Y-m-d');
                }
            } elseif ($session_info['type_id'] == GYMPRO_SINGLE_SESSION_TYPE_ID) {
                $calendar_session_info = array(
                    'session_info' => $session_info,
                    //'title' => $session_info['title'],
                    'title' => $session_info['created_for'],
                    'start' => $rep_date.'T'.$session_info['start'],
                    'end' => $rep_date.'T'.$session_info['end']
                );
                $session_list[] = $calendar_session_info;
            }
        }
        return $session_list;
    }
    
    /*
     * This method will return sessions including relevant information from different tables
     * @Author Nazmul on 9th August 2015
     */
    public function get_sessions($where = array())
    {
        $session_list = array();
        $group_id_list = array();
        $group_id_group_info_map = array();
        $client_id_list = array();
        $client_id_client_info_map = array();
        $session_list_array = $this->gympro_model->where($where)->get_sessions()->result_array();
        foreach($session_list_array as $session_info)
        {
            if($session_info['created_for_type_id'] == SESSION_CREATED_FOR_GROUP_TYPE_ID && !in_array($session_info['reference_id'], $group_id_list))
            {
                $group_id_list[] = $session_info['reference_id'];
            }
            else if($session_info['created_for_type_id'] == SESSION_CREATED_FOR_CLIENT_TYPE_ID && !in_array($session_info['reference_id'], $client_id_list))
            {
                $client_id_list[] = $session_info['reference_id'];
            }
        }
        if(!empty($group_id_list))
        {
            $group_list_array = $this->gympro_model->get_groups_info($group_id_list)->result_array();
            foreach($group_list_array as $group_info)
            {
                $group_id_group_info_map[$group_info['group_id']] = $group_info;
            }
        }
        if(!empty($client_id_list))
        {
            $client_list_array = $this->gympro_model->get_clients_info($client_id_list)->result_array();
            foreach($client_list_array as $client_info)
            {
                $client_id_client_info_map[$client_info['client_id']] = $client_info;
            }
        }
        foreach($session_list_array as $session_info)
        {
            if($session_info['created_for_type_id'] == SESSION_CREATED_FOR_GROUP_TYPE_ID)
            {
                $session_info['created_for'] = $group_id_group_info_map[$session_info['reference_id']]['title'];
            }
            else if($session_info['created_for_type_id'] == SESSION_CREATED_FOR_CLIENT_TYPE_ID)
            {
                $session_info['created_for'] = $client_id_client_info_map[$session_info['reference_id']]['first_name'].' '.$client_id_client_info_map[$session_info['reference_id']]['last_name'];
            }
            $session_list[] = $session_info;
        }
        return $session_list;
    }
    
    public function create_session($session_data)
    {
        $session_id = $this->gympro_model->create_session($session_data);
        //if session is created for a user with cash then add a new status here
        if($session_id !== FALSE && $session_data['status_id'] == GYMPRO_SESSION_STATUS_PAY_CASH_ID && $session_data['created_for_type_id'] == SESSION_CREATED_FOR_CLIENT_TYPE_ID)
        {
            $this->share_session($session_data['reference_id']);
        }
        //add session notification to the client
        if($session_id !== FALSE && $session_data['created_for_type_id'] == SESSION_CREATED_FOR_CLIENT_TYPE_ID)
        {
            $client_info = array();
            if(empty($this->client_info))
            {
                $client_info_array = $this->gympro_model->get_client_information($session_data['reference_id'])->result_array();
                if(!empty($client_info_array))
                {
                    $client_info = $client_info_array[0];                    
                }
            }
            else
            {
                $client_info = $this->client_info;
            }
            $this->create_notification($client_info['user_id'], $client_info['member_id'], $session_id, NOTIFICATION_WHILE_CREATE_GYMPRO_SESSION);
        }
        return $session_id;
    }
    
    /*
     * This method will share a session of a client
     * @param $session_id, session id
     * @param $client_id, client id
     * @author nazmul hasan on 4th November 2015
     */
    public function share_session($session_id, $client_id = 0)
    {
        if($client_id <= 0)
        {
            $session_info_array = $this->gympro_model->get_session($session_id)->result_array();
            if(!empty($session_info_array))
            {
                $session_info = $session_info_array[0];
                if($session_info['created_for_type_id'] == SESSION_CREATED_FOR_CLIENT_TYPE_ID)
                {
                    $client_id = $session_info['reference_id'];
                }
            }
            else
            {
                return;
            }
        }
        $client_info_array = $this->gympro_model->get_client_information($client_id)->result_array();
        if(!empty($client_info_array))
        {
            $client_info = $client_info_array[0];
            $this->client_info = $client_info;
            $shared_status_data = array(
                'user_id' => $client_info['member_id'],
                'via_user_id' => $client_info['user_id'],
                'reference_id' => $session_id,
                'status_type_id' => STATUS_TYPE_GENERAL,
                'status_category_id' => STATUS_CATEGORY_USER_NEWSFEED,
                'shared_type_id' => STATUS_SHARE_GYMPRO_SESSION
             );
            $this->statuses->post_status($shared_status_data);
        }
        
    }
   
}
