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
    protected $app_gympro_account_type_identity_column;
    protected $app_gympro_height_unit_type_identity_column;
    protected $app_gympro_weight_unit_type_identity_column;
    protected $app_gympro_girth_unit_type_identity_column;
    protected $app_gympro_time_zone_identity_column;
    protected $app_gympro_hourly_rate_identity_column;
    protected $app_gympro_currency_identity_column;
    protected $app_gympro_clients_identity_column;

    public function __construct() {
        parent::__construct();
        $this->app_gympro_account_type_identity_column      = $this->config->item('app_gympro_account_type_identity_column', 'ion_auth');
        $this->app_gympro_height_unit_type_identity_column  = $this->config->item('app_gympro_height_unit_type_identity_column', 'ion_auth');
        $this->app_gympro_weight_unit_type_identity_column  = $this->config->item('app_gympro_weight_unit_type_identity_column', 'ion_auth');
        $this->app_gympro_girth_unit_type_identity_column   = $this->config->item('app_gympro_girth_unit_type_identity_column', 'ion_auth');
        $this->app_gympro_time_zone_identity_column         = $this->config->item('app_gympro_time_zone_identity_column', 'ion_auth');
        $this->app_gympro_hourly_rate_identity_column       = $this->config->item('app_gympro_hourly_rate_identity_column', 'ion_auth');
        $this->app_gympro_currency_identity_column          = $this->config->item('app_gympro_currency_identity_column', 'ion_auth');
        $this->app_gympro_clients_identity_column           = $this->config->item('app_gympro_clients_identity_column', 'ion_auth');
    }

    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function account_type_identity_check($identity = '')
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_gympro_account_type_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_gympro_account_types']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_account_type($additional_data)
    {
        if ( array_key_exists($this->app_gympro_account_type_identity_column, $additional_data) && $this->account_type_identity_check($additional_data[$this->app_gympro_account_type_identity_column]) )
        {
            $this->set_error('create_account_type_duplicate_' . $this->app_gympro_account_type_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_account_types'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_account_types'], $additional_data);
        $insert_id = $this->db->insert_id();
        $this->set_message('create_account_type_successful');
        return (isset($insert_id)) ? $insert_id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $account_type_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_account_type($account_type_id, $additional_data)
    {
        $account_type_info = $this->get_account_type_info($account_type_id)->row();
        if (array_key_exists($this->app_gympro_account_type_identity_column, $additional_data) && $this->account_type_identity_check($additional_data[$this->app_gympro_account_type_identity_column]) && $account_type_info->{$this->app_gympro_account_type_identity_column} !== $additional_data[$this->app_gympro_account_type_identity_column])
        {
            $this->set_error('update_account_type_duplicate_' . $this->app_gympro_account_type_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_account_types'], $additional_data);
        $this->db->update($this->tables['app_gympro_account_types'], $data, array('id' => $account_type_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_account_type_fail');
            return FALSE;
        }
        $this->set_message('update_account_type_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $account_type_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_account_type_info($account_type_id)
    {
        $this->db->where($this->tables['app_gympro_account_types'].'.id', $account_type_id);
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
     * @param $account_type_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_account_type($account_type_id)
    {
        if(!isset($account_type_id) || $account_type_id <= 0)
        {
            $this->set_error('delete_account_type_fail');
            return FALSE;
        }
        $this->db->where('id', $account_type_id);
        $this->db->delete($this->tables['app_gympro_account_types']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_account_type_fail');
            return FALSE;
        }
        $this->set_message('delete_account_type_successful');
        return TRUE;
    }
}