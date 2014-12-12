<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Gympro Model *
 * Author:  Nazmul on 17th November 2014
 * Requirements: PHP5 or above
 */
class Gympro_model extends Ion_auth_model {
    
    public function __construct() {
        parent::__construct();
    }
    //------------------------------------- Gympro User Module ------------------------------//
    /*
     * This method will check whether gympro user exists or not
     * @param $user_id, user id
     * @Author Nazmul on 19th November 2014
     */
    public function is_gympro_user_exist($user_id)
    {
        if($user_id == 0)
        {
            return FALSE;
        }
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results($this->tables['app_gympro_users']) > 0;
    }
    /*
     * This method will create a new gympro user
     * @param $additional_data, gympro user data
     * @Author Nazmul on 19th November 2014
     */
    public function create_gympro_user($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_users'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_users'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    /*
     * This method will return gympor user info
     * @param $user_id, user id
     * @Author Nazmul on 19th November 2014
     */
    public function get_gympro_user_info($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select('*')
                    ->from($this->tables['app_gympro_users'])
                    ->get();
    }
    /*
     * This method will update gympro user info
     * @param $user_id, user id
     * @param $additional_data, 
     */
    public function update_gympro_user_info($user_id, $additional_data)
    {
        $additional_data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_users'], $additional_data);
        $this->db->update($this->tables['app_gympro_users'], $data, array('user_id' => $user_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_gympro_user_fail');
            return FALSE;
        }
        $this->set_message('update_gympro_user_successful');
        return TRUE;
    }
    //------------------------------------- Account Type Module -----------------------------//
    /*
     * This method will return account types
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_account_types()
    {
        return $this->db->select($this->tables['app_gympro_account_types'].'.id as account_type_id,'.$this->tables['app_gympro_account_types'].'.*')
                    ->from($this->tables['app_gympro_account_types'])
                    ->get();
    }
    
    //------------------------------------- Preference Module -------------------------------//
    /*
     * This method will return all height units
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_height_units()
    {
        return $this->db->select($this->tables['app_gympro_height_unit_types'].'.id as height_unit_id,'.$this->tables['app_gympro_height_unit_types'].'.*')
                    ->from($this->tables['app_gympro_height_unit_types'])
                    ->get();
    }
    /*
     * This method will return all weight units
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_weight_units()
    {
        return $this->db->select($this->tables['app_gympro_weight_unit_types'].'.id as weight_unit_id,'.$this->tables['app_gympro_weight_unit_types'].'.*')
                    ->from($this->tables['app_gympro_weight_unit_types'])
                    ->get();
    }
    /*
     * This method will return all girth units
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_girth_units()
    {
        return $this->db->select($this->tables['app_gympro_girth_unit_types'].'.id as girth_unit_id,'.$this->tables['app_gympro_girth_unit_types'].'.*')
                    ->from($this->tables['app_gympro_girth_unit_types'])
                    ->get();
    }
    /*
     * This method will return all time zones
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_time_zones()
    {
        return $this->db->select($this->tables['app_gympro_time_zones'].'.id as time_zone_id,'.$this->tables['app_gympro_time_zones'].'.*')
                    ->from($this->tables['app_gympro_time_zones'])
                    ->get();
    }
    /*
     * This method will return all hourly rates
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_hourly_rates()
    {
        return $this->db->select($this->tables['app_gympro_hourly_rates'].'.id as hourly_rate_id,'.$this->tables['app_gympro_hourly_rates'].'.*')
                    ->from($this->tables['app_gympro_hourly_rates'])
                    ->get();
    }
    /*
     * This method will return all currencies
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_hourly_currencies()
    {
        return $this->db->select($this->tables['app_gympro_currencies'].'.id as currency_id,'.$this->tables['app_gympro_currencies'].'.*')
                    ->from($this->tables['app_gympro_currencies'])
                    ->get();
    }
    /*
     * This method will store preference info of a client
     * @param $additional_data, preference data to be stored
     * @Author Nazmul on 17th November 2014
     */
    public function create_preference_info($additional_data)
    {
        
    }
    
    /*
     * This method will return preference info of a client
     * @param $client_id, client id
     * @Author Nazmul on 17th November 2014
     */
    public function get_preference_info($client_id)
    {
        
    }
    /*
     * This method will update preference info of a client
     * @param $client_id, client id
     * @param $additional_data, preference data to be updated
     * @Author Nazmul on 17th November 2014
     */
    public function update_preference_info($client_id, $additional_data)
    {
        
    }
    //------------------------------------ Client Module ------------------------------//
    /*
     * This method will return all genders
     * @Author Nazmul on 10th December 2014
     */
    public function get_all_genders()
    {
        return $this->db->select($this->tables['gender'].'.id as gender_id,'.$this->tables['gender'].'.*')
                    ->from($this->tables['gender'])
                    ->get();
    }
    /*
     * This method will return all client statuses
     * @Author Nazmul on 10th December 2014
     */
    public function get_all_client_statuses()
    {
        return $this->db->select($this->tables['app_gympro_client_statuses'].'.id as client_status_id,'.$this->tables['app_gympro_client_statuses'].'.*')
                    ->from($this->tables['app_gympro_client_statuses'])
                    ->get();
    }
    /*
     * This method will return all health questions
     * @Author Nazmul on 10th December 2014
     */
    public function get_all_health_questions()
    {
        return $this->db->select($this->tables['app_gympro_health_questions'].'.id as question_id,'.$this->tables['app_gympro_health_questions'].'.*')
                    ->from($this->tables['app_gympro_health_questions'])
                    ->get();
    }
    /*
     * This method will create a new client
     * @param $additional_data, client data to be created
     * @Author Nazmul on 17th November 2014
     */
    public function create_client($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_clients'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_clients'], $additional_data);
        $insert_id = $this->db->insert_id();
        if($insert_id > 0)
        {
            $this->set_message('create_client_successful');
        }
        else
        {
            $this->set_error('create_client_fail');
        }
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    /*
     * This method will update client info
     * @param $client_id, client id
     * @param $additional_data, client data to be updated
     * @Author Nazmul on 17th November 2014
     */
    public function update_client($client_id, $additional_data)
    {
        $additional_data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_clients'], $additional_data);
        $this->db->update($this->tables['app_gympro_clients'], $data, array('id' => $client_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_client_fail');
            return FALSE;
        }
        $this->set_message('update_client_successful');
        return TRUE;
    }
    /*
     * This method will return all clients of a user
     * @param $user id, userid
     * @Author Nazmul on 17th November 2014
     */
    public function get_all_clients($user_id)
    {
        return $this->db->select($this->tables['app_gympro_clients'].'.id as client_id,'.$this->tables['app_gympro_clients'].'.*')
                    ->from($this->tables['app_gympro_clients'])
                    ->get();
    }
    /*
     * This method will return client info
     * @param $client_id, client id
     * @Author Nazmul on 17th November 2014
     */
    public function get_client_info($client_id)
    {
        $this->db->where($this->tables['app_gympro_clients'].'.id', $client_id);
        return $this->db->select($this->tables['app_gympro_clients'].'.id as client_id,'.$this->tables['app_gympro_clients'].'.*')
                    ->from($this->tables['app_gympro_clients'])
                    ->get();
    }
    
    //----------------------------------Group Module--------------------------------------//
    /*
     * This method will return all groups of a gympro user
     * @param $user_id, user id of gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_groups($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select($this->tables['app_gympro_groups'].'.id as group_id,'.$this->tables['app_gympro_groups'].'.*')
                    ->from($this->tables['app_gympro_groups'])
                    ->get();
    }
    /*
     * This method will return group info
     * @param $group_id, group id
     * @Author Nazmul on 7th December 2014
     */
    public function get_group_info($group_id)
    {         
        $this->db->where($this->tables['app_gympro_groups'].'.id', $group_id);
        return $this->db->select($this->tables['app_gympro_groups'].'.id as group_id, '.$this->tables['app_gympro_groups'].'.*')
                    ->from($this->tables['app_gympro_groups'])
                    ->get();
    }
    /*
     * This method will create a new group
     * @param $additional_data, group data to be inserted
     * @Author Nazmul on 7th December 2014
     */
    public function create_group($additional_data, $client_id_list)
    {
        $current_time = now();
        $this->db->trans_begin();
        $additional_data['created_on'] = $current_time;
        $additional_data = $this->_filter_data($this->tables['app_gympro_groups'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_groups'], $additional_data);
        $insert_id = $this->db->insert_id();
        if($insert_id > 0)
        {
            $this->set_message('create_group_successful');
            if(!empty($client_id_list))
            {
                $group_client_array = array();
                foreach($client_id_list as $client_id)
                {
                    $group_client_info = array(
                        'group_id' => $insert_id,
                        'client_id' => $client_id,
                        'created_on' => $current_time
                    );
                    $group_client_array[] = $group_client_info;
                }
                $this->db->insert_batch($this->tables['app_gympro_groups_clients'], $group_client_array);
            }            
        }
        else
        {
            $this->db->trans_rollback();
            $this->set_error('create_group_fail');
        }
        $this->db->trans_commit();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }   
    /*
     * This method will update group info
     * @param $group_id, group id to be updated
     * @param $additional_data, group data to be updated
     * @Author Nazmul on 7th December 2014
     */
    public function update_group($group_id, $additional_data, $client_id_list)
    {
        $current_time = now();
        $this->db->trans_begin();
        $additional_data['modified_on'] = $current_time;
        $data = $this->_filter_data($this->tables['app_gympro_groups'], $additional_data);
        $this->db->update($this->tables['app_gympro_groups'], $data, array('id' => $group_id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->set_error('update_group_fail');
            return FALSE;
        }
        else
        {
            //removing current clients of this group
            $this->db->where($this->tables['app_gympro_groups_clients'].'.group_id', $group_id);
            $this->db->delete($this->tables['app_gympro_groups_clients']);
            //adding clients under this group
            if(!empty($client_id_list))
            {
                $group_client_array = array();
                foreach($client_id_list as $client_id)
                {
                    $group_client_info = array(
                        'group_id' => $group_id,
                        'client_id' => $client_id,
                        'created_on' => $current_time
                    );
                    $group_client_array[] = $group_client_info;
                }
                $this->db->insert_batch($this->tables['app_gympro_groups_clients'], $group_client_array);
            } 
        }
        $this->db->trans_commit();
        $this->set_message('update_group_successful');
        return TRUE;
    }
    /*
     * This method will delete a group
     * @param $group_id, group id to be deleted
     * @Author Nazmul on 7th December 2014
     */
    public function delete_group($group_id)
    {
        if(!isset($group_id) || $group_id <= 0)
        {
            $this->set_error('delete_group_fail');
            return FALSE;
        }
        $this->db->where('id', $group_id);
        $this->db->delete($this->tables['app_gympro_groups']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_group_fail');
            return FALSE;
        }
        $this->set_message('delete_group_successful');
        return TRUE;
    }
    /*
     * This method will return client list of a group
     * @param $group_id, group id
     * @Author Nazmul on 11th December 2014
     */
    public function get_group_clients_info($group_id)
    {
        $this->db->where($this->tables['app_gympro_groups_clients'].'.group_id', $group_id);
        return $this->db->select($this->tables['app_gympro_groups_clients'].'.*')
                    ->from($this->tables['app_gympro_groups_clients'])
                    ->get();
    }
    //----------------------------------Program Module---------------------------------------//
    /*
     * This method will return all programs of a gympro user
     * @param $user_id, user id of gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_programs($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select($this->tables['app_gympro_programs'].'.id as program_id,'.$this->tables['app_gympro_programs'].'.*')
                    ->from($this->tables['app_gympro_programs'])
                    ->get();
    }
    /*
     * This method will return program info
     * @param $program_id, program id
     * @Author Nazmul on 7th December 2014
     */
    public function get_program_info($program_id)
    {         
        $this->db->where($this->tables['app_gympro_programs'].'.id', $program_id);
        return $this->db->select('*')
                    ->from($this->tables['app_gympro_programs'])
                    ->get();
    }
    /*
     * This method will create a new program
     * @param $additional_data, mission data to be inserted
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_reviews()
    {
        return $this->db->select($this->tables['app_gympro_reviews'].'.*')
                    ->from($this->tables['app_gympro_reviews'])
                    ->get();
    }
    public function create_program($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_programs'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_programs'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }   
    /*
     * This method will update program info
     * @param $program_id, program id to be updated
     * @param $additional_data, program data to be updated
     * @Author Nazmul on 7th December 2014
     */
    public function update_program($program_id, $additional_data)
    {
        $additional_data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_programs'], $additional_data);
        $this->db->update($this->tables['app_gympro_programs'], $data, array('id' => $program_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_program_fail');
            return FALSE;
        }
        $this->set_message('update_program_successful');
        return TRUE;
    }
    /*
     * This method will delete a program
     * @param $program_id, program id to be deleted
     * @Author Nazmul on 7th December 2014
     */
    public function delete_program($program_id)
    {
        if(!isset($program_id) || $program_id <= 0)
        {
            $this->set_error('delete_program_fail');
            return FALSE;
        }
        $this->db->where('id', $program_id);
        $this->db->delete($this->tables['app_gympro_programs']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_program_fail');
            return FALSE;
        }
        $this->set_message('delete_program_successful');
        return TRUE;
    }
    //----------------------------------Exercise Module--------------------------------------//
    /*
     * This method will return all exercise categories
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_exercise_categories()
    {
        return $this->db->select($this->tables['app_gympro_exercise_categories'].'.*')
                    ->from($this->tables['app_gympro_exercise_categories'])
                    ->get();
    }
    /*
     * This method will return all exercises of a gympro user
     * @param $user_id, user id of gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_exercises($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select($this->tables['app_gympro_exercises'].'.id as exercise_id,'.$this->tables['app_gympro_exercises'].'.*')
                    ->from($this->tables['app_gympro_exercises'])
                    ->get();
    }
    /*
     * This method will return exercise info
     * @param $exercise_id, exercise id
     * @Author Nazmul on 7th December 2014
     */
    public function get_exercise_info($exercise_id)
    {         
        $this->db->where($this->tables['app_gympro_exercises'].'.id', $exercise_id);
        return $this->db->select('*')
                    ->from($this->tables['app_gympro_exercises'])
                    ->get();
    }
    /*
     * This method will create a new exercise
     * @param $additional_data, exercise data to be inserted
     * @Author Nazmul on 7th December 2014
     */
    public function create_exercise($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_exercises'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_exercises'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }   
    /*
     * This method will update exercise info
     * @param $exercise_id, exercise id to be updated
     * @param $additional_data, exercise data to be updated
     * @Author Nazmul on 7th December 2014
     */
    public function update_exercise($exercise_id, $additional_data)
    {
        $additional_data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_exercises'], $additional_data);
        $this->db->update($this->tables['app_gympro_exercises'], $data, array('id' => $exercise_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_exercise_fail');
            return FALSE;
        }
        $this->set_message('update_exercise_successful');
        return TRUE;
    }
    /*
     * This method will delete an exercise
     * @param $exercise_id, exercise id to be deleted
     * @Author Nazmul on 7th December 2014
     */
    public function delete_exercise($exercise_id)
    {
        if(!isset($exercise_id) || $exercise_id <= 0)
        {
            $this->set_error('delete_exercise_fail');
            return FALSE;
        }
        $this->db->where('id', $exercise_id);
        $this->db->delete($this->tables['app_gympro_exercises']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_exercise_fail');
            return FALSE;
        }
        $this->set_message('delete_exercise_successful');
        return TRUE;
    }
    //----------------------------------Nutrition Module--------------------------------------//
    /*
     * This method will return all meal times
     * @Author Nazmul on 21st November 2014
     */
    public function get_all_meal_times()
    {
        return $this->db->select($this->tables['app_gympro_meal_times'].'.id as meal_time_id,'.$this->tables['app_gympro_meal_times'].'.*')
                    ->from($this->tables['app_gympro_meal_times'])
                    ->get();
    }
    /*
     * This method will return all workouts
     * @Author Nazmul on 21st November 2014
     */
    public function get_all_workouts()
    {
        return $this->db->select($this->tables['app_gympro_workouts'].'.id as workout_id,'.$this->tables['app_gympro_workouts'].'.*')
                    ->from($this->tables['app_gympro_workouts'])
                    ->get();
    }
    /*
     * This method will return all nutritions of a gympro user
     * @param $user_id, user id of gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_nutritions($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select($this->tables['app_gympro_nutritions'].'.id as nutrition_id,'.$this->tables['app_gympro_nutritions'].'.*')
                    ->from($this->tables['app_gympro_nutritions'])
                    ->get();
    }
    /*
     * This method will return nutrition info
     * @param $nutrition_id, nutrition id
     * @Author Nazmul on 7th December 2014
     */
    public function get_nutrition_info($nutrition_id)
    {         
        $this->db->where($this->tables['app_gympro_nutritions'].'.id', $nutrition_id);
        return $this->db->select('*')
                    ->from($this->tables['app_gympro_nutritions'])
                    ->get();
    }
    /*
     * This method will create a new nutrition
     * @param $additional_data, nutrition data to be inserted
     * @Author Nazmul on 7th December 2014
     */
    public function create_nutrition($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_nutritions'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_nutritions'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }   
    /*
     * This method will update nutrition info
     * @param $nutrition_id, nutrition id to be updated
     * @param $additional_data, nutrition data to be updated
     * @Author Nazmul on 7th December 2014
     */
    public function update_nutrition($nutrition_id, $additional_data)
    {
        $additional_data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_nutritions'], $additional_data);
        $this->db->update($this->tables['app_gympro_nutritions'], $data, array('id' => $nutrition_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_nutrition_fail');
            return FALSE;
        }
        $this->set_message('update_nutrition_successful');
        return TRUE;
    }
    /*
     * This method will delete a nutrition
     * @param $nutrition_id, nutrition id to be deleted
     * @Author Nazmul on 7th December 2014
     */
    public function delete_nutrition($nutrition_id)
    {
        if(!isset($nutrition_id) || $nutrition_id <= 0)
        {
            $this->set_error('delete_nutrition_fail');
            return FALSE;
        }
        $this->db->where('id', $nutrition_id);
        $this->db->delete($this->tables['app_gympro_nutritions']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_nutrition_fail');
            return FALSE;
        }
        $this->set_message('delete_nutrition_successful');
        return TRUE;
    }
    //-------------------------------- Assessment Module -------------------------------------//
    /*
     * This method will return reassess list of assessment
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_reassess()
    {
        return $this->db->select($this->tables['app_gympro_reassess'].'.*')
                    ->from($this->tables['app_gympro_reassess'])
                    ->get();
    }
    /*
     * This method will return all assessments of a gympro user
     * @param $user_id, gympro user id
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_assessments($user_id = 0)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select($this->tables['app_gympro_assessments'].'.id as assessment_id,'.$this->tables['app_gympro_assessments'].'.*')
                    ->from($this->tables['app_gympro_assessments'])
                    ->get();
    }
    /*
     * This method will return all assessment info
     * @param $assessment_id, assessment id
     * @Author Nazmul on 7th December 2014
     */
    public function get_assessment_info($assessment_id = 0)
    {
        $this->db->where($this->tables['app_gympro_assessments'].'.id', $assessment_id);
        return $this->db->select('*')
                    ->from($this->tables['app_gympro_assessments'])
                    ->get();
    }
    /*
     * This method will create a new assessment
     * @param $additional_data, assessment data to be inserted
     * @Author Nazmul on 7th December 2014
     */
    public function create_assessment($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_assessments'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_assessments'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    } 
    /*
     * This method will update assessment info
     * @param $assessment_id, assessment id to be updated
     * @param $additional_data, assessment data to be updated
     * @Author Nazmul on 7th December 2014
     */
    public function update_assessment($assessment_id, $additional_data)
    {
        $additional_data['modified_on'] = now();        
        $data = $this->_filter_data($this->tables['app_gympro_assessments'], $additional_data);
        $this->db->update($this->tables['app_gympro_assessments'], $data, array('id' => $assessment_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_assessment_fail');
            return FALSE;
        }
        $this->set_message('update_assessment_successful');
        return TRUE;
    }
    /*
     * This method will delete an assessment
     * @param $assessment_id, assessment id to be deleted
     * @Author Nazmul on 7th December 2014
     */
    public function delete_assessment($assessment_id)
    {
        if(!isset($assessment_id) || $assessment_id <= 0)
        {
            $this->set_error('delete_assessment_fail');
            return FALSE;
        }
        $this->db->where('id', $assessment_id);
        $this->db->delete($this->tables['app_gympro_assessments']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_assessment_fail');
            return FALSE;
        }
        $this->set_message('delete_assessment_successful');
        return TRUE;
    }
    
    //----------------------------------Mission Module--------------------------------------//
    /*
     * This method will return alll mission of a gympro user
     * @param $user_id, user id of gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function get_all_missions($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select($this->tables['app_gympro_missions'].'.id as mission_id,'.$this->tables['app_gympro_missions'].'.*')
                    ->from($this->tables['app_gympro_missions'])
                    ->get();
    }
    /*
     * This method will return mission info
     * @param $missions_id, missions id
     * @Author Nazmul on 7th December 2014
     */
    public function get_mission_info($missions_id)
    {         
        $this->db->where($this->tables['app_gympro_missions'].'.id', $missions_id);
        return $this->db->select('*')
                    ->from($this->tables['app_gympro_missions'])
                    ->get();
    }
    /*
     * This method will create a new mission
     * @param $additional_data, mission data to be inserted
     * @Author Nazmul on 7th December 2014
     */
    public function create_mission($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_missions'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_missions'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }   
    /*
     * This method will update mission info
     * @param $mission_id, mission id to be updated
     * @param $additional_data, mission data to be updated
     * @Author Nazmul on 7th December 2014
     */
    public function update_mission($mission_id, $additional_data)
    {
        $additional_data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_missions'], $additional_data);
        $this->db->update($this->tables['app_gympro_missions'], $data, array('id' => $mission_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_mission_fail');
            return FALSE;
        }
        $this->set_message('update_mission_successful');
        return TRUE;
    }
    /*
     * This method will delete a mission
     * @param $mission_id, mission id to be deleted
     * @Author Nazmul on 7th December 2014
     */
    public function delete_mission($mission_id)
    {
        if(!isset($mission_id) || $mission_id <= 0)
        {
            $this->set_error('delete_mission_fail');
            return FALSE;
        }
        $this->db->where('id', $mission_id);
        $this->db->delete($this->tables['app_gympro_missions']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_mission_fail');
            return FALSE;
        }
        $this->set_message('delete_mission_successful');
        return TRUE;
    }   
}