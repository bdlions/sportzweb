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
        $this->set_message('create_client_statuses_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    public function get_all_health_questions()
    {
        return $this->db->select($this->tables['app_gympro_health_questions'].'.id as question_id,'.$this->tables['app_gympro_health_questions'].'.*')
                    ->from($this->tables['app_gympro_health_questions'])
                    ->get();
    }
    public function get_all_gender_info()
    {
        return $this->db->select($this->tables['gender'].'.*')
                    ->from($this->tables['gender'])
                    ->get();
    }
    public function get_all_status_info()
    {
        return $this->db->select($this->tables['app_gympro_client_statuses'].'.*')
                    ->from($this->tables['app_gympro_client_statuses'])
                    ->get();
    }
    /*
     * This method will update client info
     * @param $client_id, client id
     * @param $additional_data, client data to be updated
     * @Author Nazmul on 17th November 2014
     */
    public function update_client($client_id, $additional_data)
    {
        //incomplete
        $additional_data['modified_on'] = now();
//        $data = $this->_filter_data($this->tables['app_gympro_users'], $additional_data);
        $this->db->update($this->tables['app_gympro_clients'], $data, array('user_id' => $client_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_gympro_user_fail');
            return FALSE;
        }
        $this->set_message('update_gympro_user_successful');
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
        return $this->db->select($this->tables['app_gympro_clients'].'.id as id,'.$this->tables['app_gympro_clients'].'.*')
                    ->from($this->tables['app_gympro_clients'])
                    ->get();
    }
    
    //----------------------------------Group Module--------------------------------------//

    public function get_all_group_info()
    {
//        return $this->db->select($this->tables['app_gympro_groups'].'.id as group_id,'.$this->tables['app_gympro_groups'].'.*')
//                    ->from($this->tables['app_gympro_groups'])
//                    ->get();
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
    
    
    
    //----------------------------------Exercise Module--------------------------------------//

    public function create_exercise($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_exercises'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_exercises'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    
    //----------------------------------Mission Module--------------------------------------//
    /*
     * This method will return all meal times
     */
    public function get_all_missions()
    {
        return $this->db->select($this->tables['app_gympro_missions'].'.id as id,'.$this->tables['app_gympro_missions'].'.*')
                    ->from($this->tables['app_gympro_missions'])
                    ->get();
    }
    
    public function delete_mission($mission_id)
    {
        if(!isset($mission_id) || $mission_id <= 0)
        {
            $this->set_error('delete_missions_fail');
            return FALSE;
        }
        $this->db->where('id', $mission_id);
        $this->db->delete($this->tables['app_gympro_missions']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_missions_fail');
            return FALSE;
        }
        $this->set_message('delete_missions_successful');
        return TRUE;
    }
    
    
    

    public function create_mission($additional_data)
    {
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_missions'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_missions'], $additional_data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }   
    
     public function get_missions_info($missions_id)
    {         
        $this->db->where($this->tables['app_gympro_missions'].'.id', $missions_id);
        return $this->db->select('*')
                    ->from($this->tables['app_gympro_missions'])
                    ->get();
    }
   
    public function update_missions($missions_id, $additional_data)
    {
      // var_dump($additional_data);        exit();
        //var_dump($missions_id);        exit();
        $missions_info = $this->get_missions_info($missions_id)->row();
        $additional_data['modified_on'] = now();
        
        if (array_key_exists($this->app_gympro_missions_identity_column, $additional_data) && $this->missions_identity_check($additional_data[$this->app_gympro_missions_identity_column]) && $missions_info->{$this->app_gympro_missions_identity_column} !== $additional_data[$this->app_gympro_missions_identity_column])
        {
            $this->set_error('update_missions_duplicate_' . $this->app_gympro_missions_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_missions'], $additional_data);
        $this->db->update($this->tables['app_gympro_missions'], $data, array('id' => $missions_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_missions_fail');
            return FALSE;
        }
        $this->set_message('update_missions_successful');
        return TRUE;
    }
    

}



    
    //====================================TEMPLATE===========================================
    /*
    
    
    
    public function module_name_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_module_name_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_module_name']) > 0;
    }
    
    public function get_all_module_name()
    {
        return $this->db->select($this->tables['app_gympro_module_name'].'.id as id,'.$this->tables['app_gympro_module_name'].'.*')
                    ->from($this->tables['app_gympro_module_name'])
                    ->get();
    }
    
    public function delete_module_name($module_name_id)
    {
        if(!isset($module_name_id) || $module_name_id <= 0)
        {
            $this->set_error('delete_module_name_fail');
            return FALSE;
        }
        $this->db->where('id', $module_name_id);
        $this->db->delete($this->tables['app_gympro_module_name']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_module_name_fail');
            return FALSE;
        }
        $this->set_message('delete_module_name_successful');
        return TRUE;
    }
    
    public function create_module_name($additional_data)
    {
        if ( array_key_exists($this->app_gympro_module_name_identity_column, $additional_data) && $this->module_name_identity_check($additional_data[$this->app_gympro_module_name_identity_column]) )
        {
            $this->set_error('create_module_name_duplicate_' . $this->app_gympro_module_name_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_module_name'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_module_name'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_module_name_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }    
    public function get_module_name_info($module_name_id)
    {
        $this->db->where($this->tables['app_gympro_module_name'].'.id', $module_name_id);
        return $this->db->select($this->tables['app_gympro_module_name'].'.id as id,'.$this->tables['app_gympro_module_name'].'.*')
                    ->from($this->tables['app_gympro_module_name'])
                    ->get();
    }
    public function update_module_name($module_name_id, $additional_data)
    {
        $module_name_info = $this->get_module_name_info($module_name_id)->row();
        $additional_data['modified_on'] = now();

        if (array_key_exists($this->app_gympro_module_name_identity_column, $additional_data) && $this->module_name_identity_check($additional_data[$this->app_gympro_module_name_identity_column]) && $module_name_info->{$this->app_gympro_module_name_identity_column} !== $additional_data[$this->app_gympro_module_name_identity_column])
        {
            $this->set_error('update_module_name_duplicate_' . $this->app_gympro_module_name_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_module_name'], $additional_data);
        $this->db->update($this->tables['app_gympro_module_name'], $data, array('id' => $module_name_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_module_name_fail');
            return FALSE;
        }
        $this->set_message('update_module_name_successful');
        return TRUE;
    }

    
    
    
     */
    