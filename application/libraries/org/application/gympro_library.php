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
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('org/utility/Utils');
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
     * This method will return all programs after converting date format
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_programs($user_id = 0)
    {
        $program_list = array();
        $programs_array = $this->gympro_model->get_all_programs($user_id)->result_array();
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
    public function get_all_assessments($user_id = 0)
    {
        $assessment_list = array();
        $assessments_array = $this->gympro_model->get_all_assessments($user_id)->result_array();
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
    public function get_all_missions($user_id = 0)
    {
        $mission_list = array();
        $missions_array = $this->gympro_model->get_all_missions($user_id)->result_array();
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
     */
    public function get_sessions_in_calendar()
    {
        $session_list = array();
        $session_list_array = $this->gympro_model->get_all_sessions()->result_array();
        foreach($session_list_array as $session_info)
        {
            $calendar_session_info = array(
                'session_info' => $session_info,
                'title' => $session_info['title'],
                'start' => $session_info['date'].'T'.$session_info['start'],
                'end' => $session_info['date'].'T'.$session_info['end']
            );
            $session_list[] = $calendar_session_info;
        }
        return $session_list;
    }
}
