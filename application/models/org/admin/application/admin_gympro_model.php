<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Admin Gympro Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Admin_gympro_model extends Ion_auth_model
{
    protected $app_gympro_account_types_identity_column;
    protected $app_gympro_height_unit_types_identity_column;
    protected $app_gympro_weight_unit_types_identity_column;
    protected $app_gympro_girth_unit_types_identity_column;
    protected $app_gympro_time_zones_identity_column;
    protected $app_gympro_hourly_rates_identity_column;
    protected $app_gympro_currencies_identity_column;
    protected $app_gympro_clients_identity_column;
    protected $app_gympro_client_statuses_identity_column;
    protected $app_gympro_health_questions_identity_column;
    protected $app_gympro_meal_times_identity_column;
    protected $app_gympro_reassess_identity_column;
    protected $app_gympro_reviews_identity_column;
    protected $app_gympro_workouts_identity_column;

    public function __construct() {
        parent::__construct();
        $this->app_gympro_account_types_identity_column         = $this->config->item('app_gympro_account_types_identity_column', 'ion_auth');
        $this->app_gympro_height_unit_types_identity_column     = $this->config->item('app_gympro_height_unit_types_identity_column', 'ion_auth');
        $this->app_gympro_weight_unit_types_identity_column     = $this->config->item('app_gympro_weight_unit_types_identity_column', 'ion_auth');
        $this->app_gympro_girth_unit_types_identity_column      = $this->config->item('app_gympro_girth_unit_types_identity_column', 'ion_auth');
        $this->app_gympro_time_zones_identity_column            = $this->config->item('app_gympro_time_zones_identity_column', 'ion_auth');
        $this->app_gympro_hourly_rates_identity_column          = $this->config->item('app_gympro_hourly_rates_identity_column', 'ion_auth');
        $this->app_gympro_currencies_identity_column            = $this->config->item('app_gympro_currencies_identity_column', 'ion_auth');
        $this->app_gympro_clients_identity_column               = $this->config->item('app_gympro_clients_identity_column', 'ion_auth');
        $this->app_gympro_client_statuses_identity_column       = $this->config->item('app_gympro_client_statuses_identity_column', 'ion_auth');
        $this->app_gympro_health_questions_identity_column      = $this->config->item('app_gympro_health_questions_identity_column', 'ion_auth');
        $this->app_gympro_meal_times_identity_column            = $this->config->item('app_gympro_meal_times_identity_column', 'ion_auth');
        $this->app_gympro_reassess_identity_column              = $this->config->item('app_gympro_reassess_identity_column', 'ion_auth');
        $this->app_gympro_reviews_identity_column               = $this->config->item('app_gympro_reviews_identity_column', 'ion_auth');
        $this->app_gympro_workouts_identity_column              = $this->config->item('app_gympro_workouts_identity_column', 'ion_auth');
    }

    
//    ======================== ACCOUNT TYPE ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function account_types_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_account_types_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_account_types']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_account_types($additional_data)
    {
        if ( array_key_exists($this->app_gympro_account_types_identity_column, $additional_data) && $this->account_types_identity_check($additional_data[$this->app_gympro_account_types_identity_column]) )
        {
            $this->set_error('create_account_types_duplicate_' . $this->app_gympro_account_types_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_account_types'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_account_types'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_account_types_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $account_types_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_account_types($account_types_id, $additional_data)
    {
        $account_types_info = $this->get_account_types_info($account_types_id)->row();
        if (array_key_exists($this->app_gympro_account_types_identity_column, $additional_data) && $this->account_types_identity_check($additional_data[$this->app_gympro_account_types_identity_column]) && $account_types_info->{$this->app_gympro_account_types_identity_column} !== $additional_data[$this->app_gympro_account_types_identity_column])
        {
            $this->set_error('update_account_types_duplicate_' . $this->app_gympro_account_types_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_account_types'], $additional_data);
        $this->db->update($this->tables['app_gympro_account_types'], $data, array('id' => $account_types_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_account_types_fail');
            return FALSE;
        }
        $this->set_message('update_account_types_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $account_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_account_types_info($account_types_id)
    {
        $this->db->where($this->tables['app_gympro_account_types'].'.id', $account_types_id);
        return $this->db->select($this->tables['app_gympro_account_types'].'.id as id,'.$this->tables['app_gympro_account_types'].'.*')
                    ->from($this->tables['app_gympro_account_types'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_account_types()
    {
        return $this->db->select($this->tables['app_gympro_account_types'].'.id as id,'.$this->tables['app_gympro_account_types'].'.*')
                    ->from($this->tables['app_gympro_account_types'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $account_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_account_types($account_types_id)
    {
        if(!isset($account_types_id) || $account_types_id <= 0)
        {
            $this->set_error('delete_account_types_fail');
            return FALSE;
        }
        $this->db->where('id', $account_types_id);
        $this->db->delete($this->tables['app_gympro_account_types']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_account_types_fail');
            return FALSE;
        }
        $this->set_message('delete_account_types_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== PREFERENCES ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function preferences_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_preferences_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_preferences']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_preferences($additional_data)
    {
        if ( array_key_exists($this->app_gympro_preferences_identity_column, $additional_data) && $this->preferences_identity_check($additional_data[$this->app_gympro_preferences_identity_column]) )
        {
            $this->set_error('create_preferences_duplicate_' . $this->app_gympro_preferences_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_preferences'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_preferences'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_preferences_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $preferences_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_preferences($preferences_id, $additional_data)
    {
        $preferences_info = $this->get_preferences_info($preferences_id)->row();
        if (array_key_exists($this->app_gympro_preferences_identity_column, $additional_data) && $this->preferences_identity_check($additional_data[$this->app_gympro_preferences_identity_column]) && $preferences_info->{$this->app_gympro_preferences_identity_column} !== $additional_data[$this->app_gympro_preferences_identity_column])
        {
            $this->set_error('update_preferences_duplicate_' . $this->app_gympro_preferences_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_preferences'], $additional_data);
        $this->db->update($this->tables['app_gympro_preferences'], $data, array('id' => $preferences_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_preferences_fail');
            return FALSE;
        }
        $this->set_message('update_preferences_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $preferences_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_preferences_info($preferences_id)
    {
        $this->db->where($this->tables['app_gympro_preferences'].'.id', $preferences_id);
        return $this->db->select($this->tables['app_gympro_preferences'].'.id as id,'.$this->tables['app_gympro_preferences'].'.*')
                    ->from($this->tables['app_gympro_preferences'])
                    ->get();
    }
    
    /*
     * This method will return all users under gympro
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_users()
    {
        return $this->db->select($this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name,'.$this->tables['app_gympro_account_types'].'.title as account_type_title,'.$this->tables['app_gympro_height_unit_types'].'.title as height_unit_title,'.$this->tables['app_gympro_weight_unit_types'].'.title as weight_unit_title,'.$this->tables['app_gympro_girth_unit_types'].'.title as girth_unit_title,'.$this->tables['app_gympro_time_zones'].'.title as time_zone_title,'.$this->tables['app_gympro_hourly_rates'].'.title as hourly_rate_title,'.$this->tables['app_gympro_currencies'].'.title as currency_title,'.$this->tables['app_gympro_users'].'.*')
                    ->from($this->tables['app_gympro_users'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['app_gympro_users'].'.user_id')
                    ->join($this->tables['app_gympro_account_types'],  $this->tables['app_gympro_account_types'].'.id='.$this->tables['app_gympro_users'].'.account_type_id')
                    ->join($this->tables['app_gympro_height_unit_types'],  $this->tables['app_gympro_height_unit_types'].'.id='.$this->tables['app_gympro_users'].'.height_unit_id')
                    ->join($this->tables['app_gympro_weight_unit_types'],  $this->tables['app_gympro_weight_unit_types'].'.id='.$this->tables['app_gympro_users'].'.weight_unit_id')
                    ->join($this->tables['app_gympro_girth_unit_types'],  $this->tables['app_gympro_girth_unit_types'].'.id='.$this->tables['app_gympro_users'].'.girth_unit_id')
                    ->join($this->tables['app_gympro_time_zones'],  $this->tables['app_gympro_time_zones'].'.id='.$this->tables['app_gympro_users'].'.time_zone_id')
                    ->join($this->tables['app_gympro_hourly_rates'],  $this->tables['app_gympro_hourly_rates'].'.id='.$this->tables['app_gympro_users'].'.hourly_rate_id')
                    ->join($this->tables['app_gympro_currencies'],  $this->tables['app_gympro_currencies'].'.id='.$this->tables['app_gympro_users'].'.currency_id')
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $preferences_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_preferences($preferences_id)
    {
        if(!isset($preferences_id) || $preferences_id <= 0)
        {
            $this->set_error('delete_preferences_fail');
            return FALSE;
        }
        $this->db->where('id', $preferences_id);
        $this->db->delete($this->tables['app_gympro_preferences']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_preferences_fail');
            return FALSE;
        }
        $this->set_message('delete_preferences_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== CLIENTS ========================
    // ----------------------Client Statuses Module of Client ------------------------//
    
    /*
     * This method will return all statuses of client
     * @Author Nazmul on 21st November 2014
     */
    public function get_all_client_statuses()
    {
        return $this->db->select($this->tables['app_gympro_client_statuses'].'.id as client_status_id,'.$this->tables['app_gympro_client_statuses'].'.*')
                    ->from($this->tables['app_gympro_client_statuses'])
                    ->get();
    }
    
    public function client_statuses_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_client_statuses_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_client_statuses']) > 0;
    }
    
    public function create_client_statuses($additional_data)
    {
        if ( array_key_exists($this->app_gympro_client_statuses_identity_column, $additional_data) && $this->client_statuses_identity_check($additional_data[$this->app_gympro_client_statuses_identity_column]) )
        {
            $this->set_error('create_client_statuses_duplicate_' . $this->app_gympro_client_statuses_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_client_statuses'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_client_statuses'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_client_statuses_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    public function update_client_statuses($client_statuses_id, $additional_data)
    {
        $client_statuses_info = $this->get_client_statuses_info($client_statuses_id)->row();
        $additional_data['modified_on'] = now();
        if (array_key_exists($this->app_gympro_client_statuses_identity_column, $additional_data) && $this->client_statuses_identity_check($additional_data[$this->app_gympro_client_statuses_identity_column]) && $client_statuses_info->{$this->app_gympro_client_statuses_identity_column} !== $additional_data[$this->app_gympro_client_statuses_identity_column])
        {
            $this->set_error('update_client_statuses_duplicate_' . $this->app_gympro_client_statuses_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_client_statuses'], $additional_data);
        $this->db->update($this->tables['app_gympro_client_statuses'], $data, array('id' => $client_statuses_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_client_statuses_fail');
            return FALSE;
        }
        $this->set_message('update_client_statuses_successful');
        return TRUE;
    }
    
    public function get_client_statuses_info($client_statuses_id)
    {
        $this->db->where($this->tables['app_gympro_client_statuses'].'.id', $client_statuses_id);
        return $this->db->select($this->tables['app_gympro_client_statuses'].'.id as id,'.$this->tables['app_gympro_client_statuses'].'.*')
                    ->from($this->tables['app_gympro_client_statuses'])
                    ->get();
    }
    
    public function delete_client_statuses($client_statuses_id)
    {
        if(!isset($client_statuses_id) || $client_statuses_id <= 0)
        {
            $this->set_error('delete_client_statuses_fail');
            return FALSE;
        }
        $this->db->where('id', $client_statuses_id);
        $this->db->delete($this->tables['app_gympro_client_statuses']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_client_statuses_fail');
            return FALSE;
        }
        $this->set_message('delete_client_statuses_successful');
        return TRUE;
    }
    
    
//    =========================CLIENTS-==========================
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function clients_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_clients_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_clients']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_clients($additional_data)
    {
        if ( array_key_exists($this->app_gympro_clients_identity_column, $additional_data) && $this->clients_identity_check($additional_data[$this->app_gympro_clients_identity_column]) )
        {
            $this->set_error('create_clients_duplicate_' . $this->app_gympro_clients_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_clients'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_clients'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_clients_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $clients_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_clients($clients_id, $additional_data)
    {
        $clients_info = $this->get_clients_info($clients_id)->row();
        if (array_key_exists($this->app_gympro_clients_identity_column, $additional_data) && $this->clients_identity_check($additional_data[$this->app_gympro_clients_identity_column]) && $clients_info->{$this->app_gympro_clients_identity_column} !== $additional_data[$this->app_gympro_clients_identity_column])
        {
            $this->set_error('update_clients_duplicate_' . $this->app_gympro_clients_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_clients'], $additional_data);
        $this->db->update($this->tables['app_gympro_clients'], $data, array('id' => $clients_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_clients_fail');
            return FALSE;
        }
        $this->set_message('update_clients_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $clients_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_clients_info($clients_id)
    {
        $this->db->where($this->tables['app_gympro_clients'].'.id', $clients_id);
        return $this->db->select($this->tables['app_gympro_clients'].'.id as id,'.$this->tables['app_gympro_clients'].'.*')
                    ->from($this->tables['app_gympro_clients'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_clients()
    {
        return $this->db->select($this->tables['app_gympro_clients'].'.id as id,'.$this->tables['app_gympro_clients'].'.*')
                    ->from($this->tables['app_gympro_clients'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $clients_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_clients($clients_id)
    {
        if(!isset($clients_id) || $clients_id <= 0)
        {
            $this->set_error('delete_clients_fail');
            return FALSE;
        }
        $this->db->where('id', $clients_id);
        $this->db->delete($this->tables['app_gympro_clients']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_clients_fail');
            return FALSE;
        }
        $this->set_message('delete_clients_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== ACCOUNT TYPE ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function health_questions_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_health_questions_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_health_questions']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_health_questions($additional_data)
    {
        if ( array_key_exists($this->app_gympro_health_questions_identity_column, $additional_data) && $this->health_questions_identity_check($additional_data[$this->app_gympro_health_questions_identity_column]) )
        {
            $this->set_error('create_health_questions_duplicate_' . $this->app_gympro_health_questions_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_health_questions'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_health_questions'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_health_questions_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $health_questions_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_health_questions($health_questions_id, $additional_data)
    {
        $health_questions_info = $this->get_health_questions_info($health_questions_id)->row();
        if (array_key_exists($this->app_gympro_health_questions_identity_column, $additional_data) && $this->health_questions_identity_check($additional_data[$this->app_gympro_health_questions_identity_column]) && $health_questions_info->{$this->app_gympro_health_questions_identity_column} !== $additional_data[$this->app_gympro_health_questions_identity_column])
        {
            $this->set_error('update_health_questions_duplicate_' . $this->app_gympro_health_questions_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_health_questions'], $additional_data);
        $this->db->update($this->tables['app_gympro_health_questions'], $data, array('id' => $health_questions_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_health_questions_fail');
            return FALSE;
        }
        $this->set_message('update_health_questions_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $health_questions_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_health_questions_info($health_questions_id)
    {
        $this->db->where($this->tables['app_gympro_health_questions'].'.id', $health_questions_id);
        return $this->db->select($this->tables['app_gympro_health_questions'].'.id as id,'.$this->tables['app_gympro_health_questions'].'.*')
                    ->from($this->tables['app_gympro_health_questions'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_health_questions()
    {
        return $this->db->select($this->tables['app_gympro_health_questions'].'.id as id,'.$this->tables['app_gympro_health_questions'].'.*')
                    ->from($this->tables['app_gympro_health_questions'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $health_questions_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_health_questions($health_questions_id)
    {
        if(!isset($health_questions_id) || $health_questions_id <= 0)
        {
            $this->set_error('delete_health_questions_fail');
            return FALSE;
        }
        $this->db->where('id', $health_questions_id);
        $this->db->delete($this->tables['app_gympro_health_questions']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_health_questions_fail');
            return FALSE;
        }
        $this->set_message('delete_health_questions_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== ACCOUNT TYPE ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function height_unit_types_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_height_unit_types_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_height_unit_types']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_height_unit_types($additional_data)
    {
        if ( array_key_exists($this->app_gympro_height_unit_types_identity_column, $additional_data) && $this->height_unit_types_identity_check($additional_data[$this->app_gympro_height_unit_types_identity_column]) )
        {
            $this->set_error('create_height_unit_types_duplicate_' . $this->app_gympro_height_unit_types_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_height_unit_types'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_height_unit_types'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_height_unit_types_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $height_unit_types_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_height_unit_types($height_unit_types_id, $additional_data)
    {
        $height_unit_types_info = $this->get_height_unit_types_info($height_unit_types_id)->row();
        if (array_key_exists($this->app_gympro_height_unit_types_identity_column, $additional_data) && $this->height_unit_types_identity_check($additional_data[$this->app_gympro_height_unit_types_identity_column]) && $height_unit_types_info->{$this->app_gympro_height_unit_types_identity_column} !== $additional_data[$this->app_gympro_height_unit_types_identity_column])
        {
            $this->set_error('update_height_unit_types_duplicate_' . $this->app_gympro_height_unit_types_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_height_unit_types'], $additional_data);
        $this->db->update($this->tables['app_gympro_height_unit_types'], $data, array('id' => $height_unit_types_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_height_unit_types_fail');
            return FALSE;
        }
        $this->set_message('update_height_unit_types_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $height_unit_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_height_unit_types_info($height_unit_types_id)
    {
        $this->db->where($this->tables['app_gympro_height_unit_types'].'.id', $height_unit_types_id);
        return $this->db->select($this->tables['app_gympro_height_unit_types'].'.id as id,'.$this->tables['app_gympro_height_unit_types'].'.*')
                    ->from($this->tables['app_gympro_height_unit_types'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_height_unit_types()
    {
        return $this->db->select($this->tables['app_gympro_height_unit_types'].'.id as id,'.$this->tables['app_gympro_height_unit_types'].'.*')
                    ->from($this->tables['app_gympro_height_unit_types'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $height_unit_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_height_unit_types($height_unit_types_id)
    {
        if(!isset($height_unit_types_id) || $height_unit_types_id <= 0)
        {
            $this->set_error('delete_height_unit_types_fail');
            return FALSE;
        }
        $this->db->where('id', $height_unit_types_id);
        $this->db->delete($this->tables['app_gympro_height_unit_types']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_height_unit_types_fail');
            return FALSE;
        }
        $this->set_message('delete_height_unit_types_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== ACCOUNT TYPE ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function weight_unit_types_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_weight_unit_types_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_weight_unit_types']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_weight_unit_types($additional_data)
    {
        if ( array_key_exists($this->app_gympro_weight_unit_types_identity_column, $additional_data) && $this->weight_unit_types_identity_check($additional_data[$this->app_gympro_weight_unit_types_identity_column]) )
        {
            $this->set_error('create_weight_unit_types_duplicate_' . $this->app_gympro_weight_unit_types_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_weight_unit_types'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_weight_unit_types'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_weight_unit_types_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $weight_unit_types_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_weight_unit_types($weight_unit_types_id, $additional_data)
    {
        $weight_unit_types_info = $this->get_weight_unit_types_info($weight_unit_types_id)->row();
        if (array_key_exists($this->app_gympro_weight_unit_types_identity_column, $additional_data) && $this->weight_unit_types_identity_check($additional_data[$this->app_gympro_weight_unit_types_identity_column]) && $weight_unit_types_info->{$this->app_gympro_weight_unit_types_identity_column} !== $additional_data[$this->app_gympro_weight_unit_types_identity_column])
        {
            $this->set_error('update_weight_unit_types_duplicate_' . $this->app_gympro_weight_unit_types_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_weight_unit_types'], $additional_data);
        $this->db->update($this->tables['app_gympro_weight_unit_types'], $data, array('id' => $weight_unit_types_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_weight_unit_types_fail');
            return FALSE;
        }
        $this->set_message('update_weight_unit_types_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $weight_unit_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_weight_unit_types_info($weight_unit_types_id)
    {
        $this->db->where($this->tables['app_gympro_weight_unit_types'].'.id', $weight_unit_types_id);
        return $this->db->select($this->tables['app_gympro_weight_unit_types'].'.id as id,'.$this->tables['app_gympro_weight_unit_types'].'.*')
                    ->from($this->tables['app_gympro_weight_unit_types'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_weight_unit_types()
    {
        return $this->db->select($this->tables['app_gympro_weight_unit_types'].'.id as id,'.$this->tables['app_gympro_weight_unit_types'].'.*')
                    ->from($this->tables['app_gympro_weight_unit_types'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $weight_unit_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_weight_unit_types($weight_unit_types_id)
    {
        if(!isset($weight_unit_types_id) || $weight_unit_types_id <= 0)
        {
            $this->set_error('delete_weight_unit_types_fail');
            return FALSE;
        }
        $this->db->where('id', $weight_unit_types_id);
        $this->db->delete($this->tables['app_gympro_weight_unit_types']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_weight_unit_types_fail');
            return FALSE;
        }
        $this->set_message('delete_weight_unit_types_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== ACCOUNT TYPE ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function girth_unit_types_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_girth_unit_types_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_girth_unit_types']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_girth_unit_types($additional_data)
    {
        if ( array_key_exists($this->app_gympro_girth_unit_types_identity_column, $additional_data) && $this->girth_unit_types_identity_check($additional_data[$this->app_gympro_girth_unit_types_identity_column]) )
        {
            $this->set_error('create_girth_unit_types_duplicate_' . $this->app_gympro_girth_unit_types_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_girth_unit_types'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_girth_unit_types'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_girth_unit_types_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $girth_unit_types_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_girth_unit_types($girth_unit_types_id, $additional_data)
    {
        $girth_unit_types_info = $this->get_girth_unit_types_info($girth_unit_types_id)->row();
        if (array_key_exists($this->app_gympro_girth_unit_types_identity_column, $additional_data) && $this->girth_unit_types_identity_check($additional_data[$this->app_gympro_girth_unit_types_identity_column]) && $girth_unit_types_info->{$this->app_gympro_girth_unit_types_identity_column} !== $additional_data[$this->app_gympro_girth_unit_types_identity_column])
        {
            $this->set_error('update_girth_unit_types_duplicate_' . $this->app_gympro_girth_unit_types_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_girth_unit_types'], $additional_data);
        $this->db->update($this->tables['app_gympro_girth_unit_types'], $data, array('id' => $girth_unit_types_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_girth_unit_types_fail');
            return FALSE;
        }
        $this->set_message('update_girth_unit_types_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $girth_unit_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_girth_unit_types_info($girth_unit_types_id)
    {
        $this->db->where($this->tables['app_gympro_girth_unit_types'].'.id', $girth_unit_types_id);
        return $this->db->select($this->tables['app_gympro_girth_unit_types'].'.id as id,'.$this->tables['app_gympro_girth_unit_types'].'.*')
                    ->from($this->tables['app_gympro_girth_unit_types'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_girth_unit_types()
    {
        return $this->db->select($this->tables['app_gympro_girth_unit_types'].'.id as id,'.$this->tables['app_gympro_girth_unit_types'].'.*')
                    ->from($this->tables['app_gympro_girth_unit_types'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $girth_unit_types_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_girth_unit_types($girth_unit_types_id)
    {
        if(!isset($girth_unit_types_id) || $girth_unit_types_id <= 0)
        {
            $this->set_error('delete_girth_unit_types_fail');
            return FALSE;
        }
        $this->db->where('id', $girth_unit_types_id);
        $this->db->delete($this->tables['app_gympro_girth_unit_types']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_girth_unit_types_fail');
            return FALSE;
        }
        $this->set_message('delete_girth_unit_types_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== ACCOUNT TYPE ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function time_zones_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_time_zones_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_time_zones']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_time_zones($additional_data)
    {
        if ( array_key_exists($this->app_gympro_time_zones_identity_column, $additional_data) && $this->time_zones_identity_check($additional_data[$this->app_gympro_time_zones_identity_column]) )
        {
            $this->set_error('create_time_zones_duplicate_' . $this->app_gympro_time_zones_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_time_zones'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_time_zones'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_time_zones_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $time_zones_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_time_zones($time_zones_id, $additional_data)
    {
        $time_zones_info = $this->get_time_zones_info($time_zones_id)->row();
        if (array_key_exists($this->app_gympro_time_zones_identity_column, $additional_data) && $this->time_zones_identity_check($additional_data[$this->app_gympro_time_zones_identity_column]) && $time_zones_info->{$this->app_gympro_time_zones_identity_column} !== $additional_data[$this->app_gympro_time_zones_identity_column])
        {
            $this->set_error('update_time_zones_duplicate_' . $this->app_gympro_time_zones_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_time_zones'], $additional_data);
        $this->db->update($this->tables['app_gympro_time_zones'], $data, array('id' => $time_zones_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_time_zones_fail');
            return FALSE;
        }
        $this->set_message('update_time_zones_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $time_zones_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_time_zones_info($time_zones_id)
    {
        $this->db->where($this->tables['app_gympro_time_zones'].'.id', $time_zones_id);
        return $this->db->select($this->tables['app_gympro_time_zones'].'.id as id,'.$this->tables['app_gympro_time_zones'].'.*')
                    ->from($this->tables['app_gympro_time_zones'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_time_zones()
    {
        return $this->db->select($this->tables['app_gympro_time_zones'].'.id as id,'.$this->tables['app_gympro_time_zones'].'.*')
                    ->from($this->tables['app_gympro_time_zones'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $time_zones_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_time_zones($time_zones_id)
    {
        if(!isset($time_zones_id) || $time_zones_id <= 0)
        {
            $this->set_error('delete_time_zones_fail');
            return FALSE;
        }
        $this->db->where('id', $time_zones_id);
        $this->db->delete($this->tables['app_gympro_time_zones']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_time_zones_fail');
            return FALSE;
        }
        $this->set_message('delete_time_zones_successful');
        return TRUE;
    }
    
    
    
    
//    ======================== ACCOUNT TYPE ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function hourly_rates_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_hourly_rates_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_hourly_rates']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_hourly_rates($additional_data)
    {
        if ( array_key_exists($this->app_gympro_hourly_rates_identity_column, $additional_data) && $this->hourly_rates_identity_check($additional_data[$this->app_gympro_hourly_rates_identity_column]) )
        {
            $this->set_error('create_hourly_rates_duplicate_' . $this->app_gympro_hourly_rates_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_hourly_rates'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_hourly_rates'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_hourly_rates_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $hourly_rates_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_hourly_rates($hourly_rates_id, $additional_data)
    {
        $hourly_rates_info = $this->get_hourly_rates_info($hourly_rates_id)->row();
        if (array_key_exists($this->app_gympro_hourly_rates_identity_column, $additional_data) && $this->hourly_rates_identity_check($additional_data[$this->app_gympro_hourly_rates_identity_column]) && $hourly_rates_info->{$this->app_gympro_hourly_rates_identity_column} !== $additional_data[$this->app_gympro_hourly_rates_identity_column])
        {
            $this->set_error('update_hourly_rates_duplicate_' . $this->app_gympro_hourly_rates_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_hourly_rates'], $additional_data);
        $this->db->update($this->tables['app_gympro_hourly_rates'], $data, array('id' => $hourly_rates_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_hourly_rates_fail');
            return FALSE;
        }
        $this->set_message('update_hourly_rates_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $hourly_rates_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_hourly_rates_info($hourly_rates_id)
    {
        $this->db->where($this->tables['app_gympro_hourly_rates'].'.id', $hourly_rates_id);
        return $this->db->select($this->tables['app_gympro_hourly_rates'].'.id as id,'.$this->tables['app_gympro_hourly_rates'].'.*')
                    ->from($this->tables['app_gympro_hourly_rates'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_hourly_rates()
    {
        return $this->db->select($this->tables['app_gympro_hourly_rates'].'.id as id,'.$this->tables['app_gympro_hourly_rates'].'.*')
                    ->from($this->tables['app_gympro_hourly_rates'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $hourly_rates_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_hourly_rates($hourly_rates_id)
    {
        if(!isset($hourly_rates_id) || $hourly_rates_id <= 0)
        {
            $this->set_error('delete_hourly_rates_fail');
            return FALSE;
        }
        $this->db->where('id', $hourly_rates_id);
        $this->db->delete($this->tables['app_gympro_hourly_rates']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_hourly_rates_fail');
            return FALSE;
        }
        $this->set_message('delete_hourly_rates_successful');
        return TRUE;
    }
    
    
    
    
    
//    ======================== Currencies ========================
    
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function currencies_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_currencies_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_currencies']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_currencies($additional_data)
    {
        if ( array_key_exists($this->app_gympro_currencies_identity_column, $additional_data) && $this->currencies_identity_check($additional_data[$this->app_gympro_currencies_identity_column]) )
        {
            $this->set_error('create_currencies_duplicate_' . $this->app_gympro_currencies_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_currencies'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_currencies'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_currencies_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $currencies_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_currencies($currencies_id, $additional_data)
    {
        $currencies_info = $this->get_currencies_info($currencies_id)->row();
        if (array_key_exists($this->app_gympro_currencies_identity_column, $additional_data) && $this->currencies_identity_check($additional_data[$this->app_gympro_currencies_identity_column]) && $currencies_info->{$this->app_gympro_currencies_identity_column} !== $additional_data[$this->app_gympro_currencies_identity_column])
        {
            $this->set_error('update_currencies_duplicate_' . $this->app_gympro_currencies_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_currencies'], $additional_data);
        $this->db->update($this->tables['app_gympro_currencies'], $data, array('id' => $currencies_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_currencies_fail');
            return FALSE;
        }
        $this->set_message('update_currencies_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $currencies_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_currencies_info($currencies_id)
    {
        $this->db->where($this->tables['app_gympro_currencies'].'.id', $currencies_id);
        return $this->db->select($this->tables['app_gympro_currencies'].'.id as id,'.$this->tables['app_gympro_currencies'].'.*')
                    ->from($this->tables['app_gympro_currencies'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_currencies()
    {
        return $this->db->select($this->tables['app_gympro_currencies'].'.id as id,'.$this->tables['app_gympro_currencies'].'.*')
                    ->from($this->tables['app_gympro_currencies'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $currencies_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_currencies($currencies_id)
    {
        if(!isset($currencies_id) || $currencies_id <= 0)
        {
            $this->set_error('delete_currencies_fail');
            return FALSE;
        }
        $this->db->where('id', $currencies_id);
        $this->db->delete($this->tables['app_gympro_currencies']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_currencies_fail');
            return FALSE;
        }
        $this->set_message('delete_currencies_successful');
        return TRUE;
    }
    //----------------------------Program Module---------------------------------//
    //----------------------------Review Module of Program--------------------//
    /*
     * This method will return all reviews
     * @Author Nazmul on 21st November 2014
     */
//    public function get_all_reviews()
//    {
//        return $this->db->select($this->tables['app_gympro_reviews'].'.id as review_id,'.$this->tables['app_gympro_reviews'].'.*')
//                    ->from($this->tables['app_gympro_reviews'])
//                    ->get();
//    }
    
    public function reviews_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_reviews_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_reviews']) > 0;
    }
    
    public function create_reviews($additional_data)
    {
        if ( array_key_exists($this->app_gympro_reviews_identity_column, $additional_data) && $this->reviews_identity_check($additional_data[$this->app_gympro_reviews_identity_column]) )
        {
            $this->set_error('create_reviews_duplicate_' . $this->app_gympro_reviews_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_reviews'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_reviews'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_reviews_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    public function update_reviews($reviews_id, $additional_data)
    {
        $reviews_info = $this->get_reviews_info($reviews_id)->row();
        $additional_data['modified_on'] = now();

        if (array_key_exists($this->app_gympro_reviews_identity_column, $additional_data) && $this->reviews_identity_check($additional_data[$this->app_gympro_reviews_identity_column]) && $reviews_info->{$this->app_gympro_reviews_identity_column} !== $additional_data[$this->app_gympro_reviews_identity_column])
        {
            $this->set_error('update_reviews_duplicate_' . $this->app_gympro_reviews_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_reviews'], $additional_data);
        $this->db->update($this->tables['app_gympro_reviews'], $data, array('id' => $reviews_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_reviews_fail');
            return FALSE;
        }
        $this->set_message('update_reviews_successful');
        return TRUE;
    }
    
    public function get_reviews_info($reviews_id)
    {
        $this->db->where($this->tables['app_gympro_reviews'].'.id', $reviews_id);
        return $this->db->select($this->tables['app_gympro_reviews'].'.id as id,'.$this->tables['app_gympro_reviews'].'.*')
                    ->from($this->tables['app_gympro_reviews'])
                    ->get();
    }
    
    public function get_all_reviews()
    {
        return $this->db->select($this->tables['app_gympro_reviews'].'.id as id,'.$this->tables['app_gympro_reviews'].'.*')
                    ->from($this->tables['app_gympro_reviews'])
                    ->get();
    }
    
    public function delete_reviews($reviews_id)
    {
        if(!isset($reviews_id) || $reviews_id <= 0)
        {
            $this->set_error('delete_reviews_fail');
            return FALSE;
        }
        $this->db->where('id', $reviews_id);
        $this->db->delete($this->tables['app_gympro_reviews']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_reviews_fail');
            return FALSE;
        }
        $this->set_message('delete_reviews_successful');
        return TRUE;
    }
    
    
    
    
    
    
    
    //-----------------------------Exercise Category of Program-----------------------//
     /*
     * This method will return all exercise categories
     * @Author Nazmul on 21st November 2014
     */
    public function get_all_exercise_categories()
    {
        return $this->db->select($this->tables['app_gympro_exercise_categories'].'.id as exercise_category_id,'.$this->tables['app_gympro_exercise_categories'].'.*')
                    ->from($this->tables['app_gympro_exercise_categories'])
                    ->get();
    }
    //-----------------------------Exercise Subcategory of Program-----------------------//
     /*
     * This method will return all exercise subcategories
     * @Author Nazmul on 21st November 2014
     */
    public function get_all_exercise_subcategories($exercise_category_id)
    {
        return $this->db->select($this->tables['app_gympro_exercise_subcategories'].'.id as exercise_subcategory_id,'.$this->tables['app_gympro_exercise_subcategories'].'.*')
                    ->from($this->tables['app_gympro_exercise_subcategories'])
                    ->get();
    }
    //----------------------------Assessment Module------------------------------//
    //----------------------------Reassess Module of Assessment------------------//
    /*
     * This method will return all reassess
     * @Author Nazmul on 21st November 2014
     */
    public function reassess_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_reassess_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_reassess']) > 0;
    }
    
    public function get_all_reassess()
    {
        return $this->db->select($this->tables['app_gympro_reassess'].'.id as id,'.$this->tables['app_gympro_reassess'].'.*')
                    ->from($this->tables['app_gympro_reassess'])
                    ->get();
    }
    
    public function delete_reassess($reassess_id)
    {
        if(!isset($reassess_id) || $reassess_id <= 0)
        {
            $this->set_error('delete_reassess_fail');
            return FALSE;
        }
        $this->db->where('id', $reassess_id);
        $this->db->delete($this->tables['app_gympro_reassess']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_reassess_fail');
            return FALSE;
        }
        $this->set_message('delete_reassess_successful');
        return TRUE;
    }
    
    public function create_reassess($additional_data)
    {
        if ( array_key_exists($this->app_gympro_reassess_identity_column, $additional_data) && $this->reassess_identity_check($additional_data[$this->app_gympro_reassess_identity_column]) )
        {
            $this->set_error('create_reassess_duplicate_' . $this->app_gympro_reassess_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_reassess'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_reassess'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_reassess_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }    
    public function get_reassess_info($reassess_id)
    {
        $this->db->where($this->tables['app_gympro_reassess'].'.id', $reassess_id);
        return $this->db->select($this->tables['app_gympro_reassess'].'.id as id,'.$this->tables['app_gympro_reassess'].'.*')
                    ->from($this->tables['app_gympro_reassess'])
                    ->get();
    }
    public function update_reassess($reassess_id, $additional_data)
    {
        $reassess_info = $this->get_reassess_info($reassess_id)->row();
        $additional_data['modified_on'] = now();

        if (array_key_exists($this->app_gympro_reassess_identity_column, $additional_data) && $this->reassess_identity_check($additional_data[$this->app_gympro_reassess_identity_column]) && $reassess_info->{$this->app_gympro_reassess_identity_column} !== $additional_data[$this->app_gympro_reassess_identity_column])
        {
            $this->set_error('update_reassess_duplicate_' . $this->app_gympro_reassess_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_reassess'], $additional_data);
        $this->db->update($this->tables['app_gympro_reassess'], $data, array('id' => $reassess_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_reassess_fail');
            return FALSE;
        }
        $this->set_message('update_reassess_successful');
        return TRUE;
    }
    /*
     * This method will update reassess info
     * @param $reassess_id, reassess id
     * @param $additional_data, reassess data to be updated
     * @Author Nazmul on 21st November 2014
     */
    //-----------------------------Nutrition Module -----------------------------//
    //-----------------------------Meal Time Module of Nutrition -----------------------------//
    /*
     * This method will create a new meal time
     * @param $additional_data, meal time data to be added
     * @Author Nazmul on 21st November 2014
     */
    public function meal_times_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_meal_times_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_meal_times']) > 0;
    }
    
    public function get_all_meal_times()
    {
        return $this->db->select($this->tables['app_gympro_meal_times'].'.id as id,'.$this->tables['app_gympro_meal_times'].'.*')
                    ->from($this->tables['app_gympro_meal_times'])
                    ->get();
    }
    
    public function delete_meal_times($meal_times_id)
    {
        if(!isset($meal_times_id) || $meal_times_id <= 0)
        {
            $this->set_error('delete_meal_times_fail');
            return FALSE;
        }
        $this->db->where('id', $meal_times_id);
        $this->db->delete($this->tables['app_gympro_meal_times']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_meal_times_fail');
            return FALSE;
        }
        $this->set_message('delete_meal_times_successful');
        return TRUE;
    }
    
    public function create_meal_times($additional_data)
    {
        if ( array_key_exists($this->app_gympro_meal_times_identity_column, $additional_data) && $this->meal_times_identity_check($additional_data[$this->app_gympro_meal_times_identity_column]) )
        {
            $this->set_error('create_meal_times_duplicate_' . $this->app_gympro_meal_times_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_meal_times'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_meal_times'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_meal_times_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }    
    public function get_meal_times_info($meal_times_id)
    {
        $this->db->where($this->tables['app_gympro_meal_times'].'.id', $meal_times_id);
        return $this->db->select($this->tables['app_gympro_meal_times'].'.id as id,'.$this->tables['app_gympro_meal_times'].'.*')
                    ->from($this->tables['app_gympro_meal_times'])
                    ->get();
    }
    public function update_meal_times($meal_times_id, $additional_data)
    {
        $meal_times_info = $this->get_meal_times_info($meal_times_id)->row();
        $additional_data['modified_on'] = now();

        if (array_key_exists($this->app_gympro_meal_times_identity_column, $additional_data) && $this->meal_times_identity_check($additional_data[$this->app_gympro_meal_times_identity_column]) && $meal_times_info->{$this->app_gympro_meal_times_identity_column} !== $additional_data[$this->app_gympro_meal_times_identity_column])
        {
            $this->set_error('update_meal_times_duplicate_' . $this->app_gympro_meal_times_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_meal_times'], $additional_data);
        $this->db->update($this->tables['app_gympro_meal_times'], $data, array('id' => $meal_times_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_meal_times_fail');
            return FALSE;
        }
        $this->set_message('update_meal_times_successful');
        return TRUE;
    }
    //--------------------------------------------Workout Module of Nutrition -------------------------------//
    public function workouts_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_workouts_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_workouts']) > 0;
    }
    
    public function get_all_workouts()
    {
        return $this->db->select($this->tables['app_gympro_workouts'].'.id as id,'.$this->tables['app_gympro_workouts'].'.*')
                    ->from($this->tables['app_gympro_workouts'])
                    ->get();
    }
    
    public function delete_workouts($workouts_id)
    {
        if(!isset($workouts_id) || $workouts_id <= 0)
        {
            $this->set_error('delete_workouts_fail');
            return FALSE;
        }
        $this->db->where('id', $workouts_id);
        $this->db->delete($this->tables['app_gympro_workouts']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_workouts_fail');
            return FALSE;
        }
        $this->set_message('delete_workouts_successful');
        return TRUE;
    }
    
    public function create_workouts($additional_data)
    {
        if ( array_key_exists($this->app_gympro_workouts_identity_column, $additional_data) && $this->workouts_identity_check($additional_data[$this->app_gympro_workouts_identity_column]) )
        {
            $this->set_error('create_workouts_duplicate_' . $this->app_gympro_workouts_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_workouts'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_workouts'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_workouts_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }    
    public function get_workouts_info($workouts_id)
    {
        $this->db->where($this->tables['app_gympro_workouts'].'.id', $workouts_id);
        return $this->db->select($this->tables['app_gympro_workouts'].'.id as id,'.$this->tables['app_gympro_workouts'].'.*')
                    ->from($this->tables['app_gympro_workouts'])
                    ->get();
    }
    public function update_workouts($workouts_id, $additional_data)
    {
        $workouts_info = $this->get_workouts_info($workouts_id)->row();
        $additional_data['modified_on'] = now();

        if (array_key_exists($this->app_gympro_workouts_identity_column, $additional_data) && $this->workouts_identity_check($additional_data[$this->app_gympro_workouts_identity_column]) && $workouts_info->{$this->app_gympro_workouts_identity_column} !== $additional_data[$this->app_gympro_workouts_identity_column])
        {
            $this->set_error('update_workouts_duplicate_' . $this->app_gympro_workouts_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_workouts'], $additional_data);
        $this->db->update($this->tables['app_gympro_workouts'], $data, array('id' => $workouts_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_workouts_fail');
            return FALSE;
        }
        $this->set_message('update_workouts_successful');
        return TRUE;
    }
    
    // -----------------------------------Session Module ---------------------------------------//
    /*
     * This method will return all sesssion times
     * @Author Nazmul on 22nd January 2015
     */
    public function create_time($data)
    {
        $data['created_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_session_times'], $data); 
        $this->db->insert($this->tables['app_gympro_session_times'], $data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    public function get_all_session_times()
    {
        return $this->db->select($this->tables['app_gympro_session_times'] . ".*")
                ->from($this->tables['app_gympro_session_times'])
                ->get();
    }
    
    public function get_time_info($id)
    {
        $this->db->where($this->tables['app_gympro_session_times'].'.id', $id);
        return $this->db->select($this->tables['app_gympro_session_times'].'.id as id,'.$this->tables['app_gympro_session_times'].'.*')
                    ->from($this->tables['app_gympro_session_times'])
                    ->get();
    }
    
    public function update_time($id, $additional_data)
    {
       
        $data = $this->_filter_data($this->tables['app_gympro_session_times'], $additional_data);
        $this->db->where($this->tables['app_gympro_session_times'].'.id', $id);
        $this->db->update($this->tables['app_gympro_session_times'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_time_fail');
            return FALSE;
        }
        $this->set_message('update_time_successful');
        return TRUE;
    }
    
    public function delete_session_time($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_time_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_gympro_session_times']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_time_fail');
            return FALSE;
        }
        $this->set_message('delete_time_successful');
        return TRUE;
    }
    
    /*
     * This method will return all sesssion types
     * @Author Nazmul on 22nd January 2015
     */
    public function create_type($data)
    {
        $data['created_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_session_types'], $data); 
        $this->db->insert($this->tables['app_gympro_session_types'], $data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    public function get_all_session_types()
    {
        return $this->db->select($this->tables['app_gympro_session_types'] . ".*")
                ->from($this->tables['app_gympro_session_types'])
                ->get();
    }
    
    public function get_type_info($id)
    {
        $this->db->where($this->tables['app_gympro_session_types'].'.id', $id);
        return $this->db->select($this->tables['app_gympro_session_types'].'.id as id,'.$this->tables['app_gympro_session_types'].'.*')
                    ->from($this->tables['app_gympro_session_types'])
                    ->get();
    }
    
    public function update_type($id, $additional_data)
    {
       
        $data = $this->_filter_data($this->tables['app_gympro_session_types'], $additional_data);
        $this->db->where($this->tables['app_gympro_session_types'].'.id', $id);
        $this->db->update($this->tables['app_gympro_session_types'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_type_fail');
            return FALSE;
        }
        $this->set_message('update_type_successful');
        return TRUE;
    }
    
    public function delete_session_type($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_type_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_gympro_session_types']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_type_fail');
            return FALSE;
        }
        $this->set_message('delete_type_successful');
        return TRUE;
    }
    /*
     * This method will return all sesssion repeats
     * @Author Nazmul on 22nd January 2015
     */
    public function create_repeat($data)
    {
        $data['created_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_session_repeats'], $data); 
        $this->db->insert($this->tables['app_gympro_session_repeats'], $data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }

    public function get_all_session_repeats()
    {
        return $this->db->select($this->tables['app_gympro_session_repeats'] . ".*")
                ->from($this->tables['app_gympro_session_repeats'])
                ->get();
    }
    
    public function get_repeat_info($id)
    {
        $this->db->where($this->tables['app_gympro_session_repeats'].'.id', $id);
        return $this->db->select($this->tables['app_gympro_session_repeats'].'.id as id,'.$this->tables['app_gympro_session_repeats'].'.*')
                    ->from($this->tables['app_gympro_session_repeats'])
                    ->get();
    }
    
    public function update_repeat($id, $additional_data)
    {
       
        $data = $this->_filter_data($this->tables['app_gympro_session_repeats'], $additional_data);
        $this->db->where($this->tables['app_gympro_session_repeats'].'.id', $id);
        $this->db->update($this->tables['app_gympro_session_repeats'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_repeats_fail');
            return FALSE;
        }
        $this->set_message('update_repeats_successful');
        return TRUE;
    }
    
    public function delete_session_repeat($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_repeats_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_gympro_session_repeats']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_repeats_fail');
            return FALSE;
        }
        $this->set_message('delete_repeats_successful');
        return TRUE;
    }
    /*
     * This method will return all sesssion costs
     * @Author Nazmul on 22nd January 2015
     */
    public function create_cost($data)
    {
        $data['created_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_session_costs'], $data); 
        $this->db->insert($this->tables['app_gympro_session_costs'], $data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    public function get_all_session_costs()
    {
        return $this->db->select($this->tables['app_gympro_session_costs'] . ".*")
                ->from($this->tables['app_gympro_session_costs'])
                ->get();
    }
    
    public function get_cost_info($id)
    {
        $this->db->where($this->tables['app_gympro_session_costs'].'.id', $id);
        return $this->db->select($this->tables['app_gympro_session_costs'].'.id as id,'.$this->tables['app_gympro_session_costs'].'.*')
                    ->from($this->tables['app_gympro_session_costs'])
                    ->get();
    }
    
    public function update_cost($id, $additional_data)
    {
       
        $data = $this->_filter_data($this->tables['app_gympro_session_costs'], $additional_data);
        $this->db->where($this->tables['app_gympro_session_costs'].'.id', $id);
        $this->db->update($this->tables['app_gympro_session_costs'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_cost_fail');
            return FALSE;
        }
        $this->set_message('update_cost_successful');
        return TRUE;
    }
    
    public function delete_session_cost($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_cost_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_gympro_session_costs']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_cost_fail');
            return FALSE;
        }
        $this->set_message('delete_cost_successful');
        return TRUE;
    }
    
    /*
     * This method will return all sesssion statuses
     * @Author Nazmul on 22nd January 2015
     */
    public function create_status($data)
    {
        $data['created_on'] = now();
        $data = $this->_filter_data($this->tables['app_gympro_session_statuses'], $data); 
        $this->db->insert($this->tables['app_gympro_session_statuses'], $data);
        $insert_id = $this->db->insert_id();
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    public function get_all_session_statuses()
    {
        return $this->db->select($this->tables['app_gympro_session_statuses'] . ".*")
                ->from($this->tables['app_gympro_session_statuses'])
                ->get();
    }
    
    public function get_status_info($id)
    {
        $this->db->where($this->tables['app_gympro_session_statuses'].'.id', $id);
        return $this->db->select($this->tables['app_gympro_session_statuses'].'.id as id,'.$this->tables['app_gympro_session_statuses'].'.*')
                    ->from($this->tables['app_gympro_session_statuses'])
                    ->get();
    }
    
    public function update_status($id, $additional_data)
    {
       
        $data = $this->_filter_data($this->tables['app_gympro_session_statuses'], $additional_data);
        $this->db->where($this->tables['app_gympro_session_statuses'].'.id', $id);
        $this->db->update($this->tables['app_gympro_session_statuses'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_status_fail');
            return FALSE;
        }
        $this->set_message('update_status_successful');
        return TRUE;
    }
    
    public function delete_session_status($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_status_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_gympro_session_statuses']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_status_fail');
            return FALSE;
        }
        $this->set_message('delete_status_successful');
        return TRUE;
    }
    
////    ======================== ACCOUNT TYPE ========================
//    
//    
//    /*
//     * This method will check identity of account type table
//     * @param $identity, identity of account type table
//     * @Author Nazmul on 16th November 2014
//     */
//    public function account_types_identity_check($identity = '')
//    {
//        if(empty($identity))
//        {
//            return FALSE;
//        }
//        $this->db->where($this->app_gympro_account_types_identity_column, $identity);
//        return $this->db->count_all_results($this->tables['app_gympro_account_types']) > 0;
//    }
//    
//    /*
//     * This method will create account type info
//     * @param $additional_data, account type data to be added
//     * @Author Nazmul on 16th November 2014
//     */
//    public function create_account_types($additional_data)
//    {
//        if ( array_key_exists($this->app_gympro_account_types_identity_column, $additional_data) && $this->account_types_identity_check($additional_data[$this->app_gympro_account_types_identity_column]) )
//        {
//            $this->set_error('create_account_types_duplicate_' . $this->app_gympro_account_types_identity_column);
//            return FALSE;
//        }
//        $additional_data['created_on'] = now();
//        $additional_data = $this->_filter_data($this->tables['app_gympro_account_types'], $additional_data); 
//        $this->db->insert($this->tables['app_gympro_account_types'], $additional_data);
//        $insert_id = $this->db->insert_id();
//        $this->set_message('create_account_types_successful');
//        return (isset($insert_id)) ? $insert_id : FALSE;
//    }
//    
//    /*
//     * This method will update account type info
//     * @param $account_types_id, account type id
//     * @param $additional_data, account type data to be updated
//     * @Author Nazmul on 16th November 2014
//     */
//    public function update_account_types($account_types_id, $additional_data)
//    {
//        $account_types_info = $this->get_account_types_info($account_types_id)->row();
//        if (array_key_exists($this->app_gympro_account_types_identity_column, $additional_data) && $this->account_types_identity_check($additional_data[$this->app_gympro_account_types_identity_column]) && $account_types_info->{$this->app_gympro_account_types_identity_column} !== $additional_data[$this->app_gympro_account_types_identity_column])
//        {
//            $this->set_error('update_account_types_duplicate_' . $this->app_gympro_account_types_identity_column);
//            return FALSE;
//        }
//        $data = $this->_filter_data($this->tables['app_gympro_account_types'], $additional_data);
//        $this->db->update($this->tables['app_gympro_account_types'], $data, array('id' => $account_types_id));
//        if ($this->db->trans_status() === FALSE) {
//            $this->set_error('update_account_types_fail');
//            return FALSE;
//        }
//        $this->set_message('update_account_types_successful');
//        return TRUE;
//    }
//    
//    /*
//     * This method will return account type info
//     * @param $account_types_id, account type id
//     * @Author Nazmul on 16th November 2014
//     */
//    public function get_account_types_info($account_types_id)
//    {
//        $this->db->where($this->tables['app_gympro_account_types'].'.id', $account_types_id);
//        return $this->db->select($this->tables['app_gympro_account_types'].'.id as id,'.$this->tables['app_gympro_account_types'].'.*')
//                    ->from($this->tables['app_gympro_account_types'])
//                    ->get();
//    }
//    
//    /*
//     * This method will return all account types
//     * @Author Nazmul on 16th November 2014
//     */
//    public function get_all_account_types()
//    {
//        return $this->db->select($this->tables['app_gympro_account_types'].'.id as id,'.$this->tables['app_gympro_account_types'].'.*')
//                    ->from($this->tables['app_gympro_account_types'])
//                    ->get();
//    }
//    
//    /*
//     * This method will delete account type info
//     * @param $account_types_id, account type id
//     * @Author Nazmul on 16th November 2014
//     */
//    public function delete_account_types($account_types_id)
//    {
//        if(!isset($account_types_id) || $account_types_id <= 0)
//        {
//            $this->set_error('delete_account_types_fail');
//            return FALSE;
//        }
//        $this->db->where('id', $account_types_id);
//        $this->db->delete($this->tables['app_gympro_account_types']);
//        
//        if ($this->db->affected_rows() == 0) {
//            $this->set_error('delete_account_types_fail');
//            return FALSE;
//        }
//        $this->set_message('delete_account_types_successful');
//        return TRUE;
//    }
    
    
    
    
    
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
    
    
}