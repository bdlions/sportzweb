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
        
    }
    /*
     * This method will return client info
     * @param $client_id, client id
     * @Author Nazmul on 17th November 2014
     */
    public function get_client_info($client_id)
    {
        
    }
}
