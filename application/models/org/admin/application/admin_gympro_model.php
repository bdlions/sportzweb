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
    protected $app_gympro_health_questions_identity_column;

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
        $this->app_gympro_health_questions_identity_column               = $this->config->item('app_gympro_health_questions_identity_column', 'ion_auth');
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
    
    /*
     * This method will update client status info
     * @param $client_status_id, client status id
     * @param $additional_data, client status to be updated
     * @Author Nazmul on 21st November 2014
     */
    public function update_client_status($client_status_id, $additional_data)
    {
        
    }
    
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
    public function get_all_reviews()
    {
        return $this->db->select($this->tables['app_gympro_reviews'].'.id as review_id,'.$this->tables['app_gympro_reviews'].'.*')
                    ->from($this->tables['app_gympro_reviews'])
                    ->get();
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
    public function get_all_reassess()
    {
        return $this->db->select($this->tables['app_gympro_reassess'].'.id as reassess_id,'.$this->tables['app_gympro_reassess'].'.*')
                    ->from($this->tables['app_gympro_reassess'])
                    ->get();
    }
    /*
     * This method will update reassess info
     * @param $reassess_id, reassess id
     * @param $additional_data, reassess data to be updated
     * @Author Nazmul on 21st November 2014
     */
    public function update_reassess($reassess_id, $additional_data)
    {
        
    }  
    //-----------------------------Nutrition Module -----------------------------//
    //-----------------------------Meal Time Module of Nutrition -----------------------------//
    /*
     * This method will create a new meal time
     * @param $additional_data, meal time data to be added
     * @Author Nazmul on 21st November 2014
     */
    public function create_meal_time($additional_data)
    {
        
    }
    /*
     * This mehtod will return meal time info
     * @param $meal_time_id, meal time id
     * @Author Nazmul on 21st November 2014 
     */
    public function get_meal_time_info($meal_time_id)
    {
        
    }
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
     * This method will update meal time info
     * @param $meal_time_id, meal time id
     * @param $additional_data, meal time data to be updated
     * @Author Nazmul on 21st November 2014
     */
    public function update_meal_time($meal_time_id, $additional_data)
    {
        
    }    
    /*
     * This method will delete meal time info
     * @param $meal_time_id, meal time id
     * @Author Nazmul on 21st November 2014
     */
    public function delete_meal_time($meal_time_id)
    {
        
    }    
    //--------------------------------------------Workout Module of Nutrition -------------------------------//
    /*
     * This method will create a new workout
     * @param $additional_data, workout data to be added
     * @Author Nazmul on 21st November 2014
     */
    public function create_workout($additional_data)
    {
        
    }
    /*
     * This mehtod will return workout info
     * @param $workout_id, workout id
     * @Author Nazmul on 21st November 2014 
     */
    public function get_workout_info($workout_id)
    {
        
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
     * This method will update workout info
     * @param $workout_id, workout id
     * @param $additional_data, workout data to be updated
     * @Author Nazmul on 21st November 2014
     */
    public function update_workout($workout_id, $additional_data)
    {
        
    }
    
    /*
     * This method will delete workout info
     * @param $workout_id, work out id
     * @Author Nazmul on 21st November 2014
     */
    public function delete_workout($workout_id)
    {
        
    }
    
//    
//    
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
}