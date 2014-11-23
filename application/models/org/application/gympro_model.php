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
    /*
     * This method will update client info
     * @param $client_id, client id
     * @param $additional_data, client data to be updated
     * @Author Nazmul on 17th November 2014
     */
    public function update_client($client_id, $additional_data)
    {
        
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
}
