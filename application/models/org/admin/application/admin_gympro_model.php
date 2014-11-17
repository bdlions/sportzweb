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

    public function __construct() {
        parent::__construct();
        $this->app_gympro_account_type_identity_column = $this->config->item('app_gympro_account_type_identity_column', 'ion_auth');
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
        return $this->db->count_all_results($this->tables['app_gympro_account_type']) > 0;
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_account_type($additional_data)
    {
        if ( array_key_exists($this->app_gympro_account_type_identity_column, $additional_data) && $this->product_category_identity_check($additional_data[$this->app_gympro_account_type_identity_column]) )
        {
            $this->set_error('create_product_category_duplicate_' . $this->app_gympro_account_type_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_gympro_account_type'], $additional_data); 
        $this->db->insert($this->tables['app_gympro_account_type'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_category_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will update account type info
     * @param $account_type_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_account_type($account_type_id, $additional_data)
    {
        $category_info = $this->get_product_category_info($category_id)->row();
        if (array_key_exists($this->app_gympro_account_type_identity_column, $additional_data) && $this->product_category_identity_check($additional_data[$this->app_gympro_account_type_identity_column]) && $category_info->{$this->app_gympro_account_type_identity_column} !== $additional_data[$this->app_gympro_account_type_identity_column])
        {
            $this->set_error('update_product_category_duplicate_' . $this->app_gympro_account_type_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_gympro_account_type'], $additional_data);
        $this->db->update($this->tables['app_gympro_account_type'], $data, array('id' => $category_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_category_fail');
            return FALSE;
        }
        $this->set_message('update_product_category_successful');
        return TRUE;
    }
    
    /*
     * This method will return account type info
     * @param $account_type_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_account_type_info($account_type_id)
    {
        $this->db->where($this->tables['app_gympro_account_type'].'.id', $category_id);
        return $this->db->select($this->tables['app_gympro_account_type'].'.id as category_id,'.$this->tables['app_gympro_account_type'].'.*')
                    ->from($this->tables['app_gympro_account_type'])
                    ->get();
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_account_types()
    {
        $this->db->where($this->tables['app_gympro_account_type'].'.id', $category_id);
        return $this->db->select($this->tables['app_gympro_account_type'].'.id as category_id,'.$this->tables['app_gympro_account_type'].'.*')
                    ->from($this->tables['app_gympro_account_type'])
                    ->get();
    }
    
    /*
     * This method will delete account type info
     * @param $account_type_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_account_type($account_type_id)
    {
        if(!isset($category_id) || $category_id <= 0)
        {
            $this->set_error('delete_product_category_fail');
            return FALSE;
        }
        $this->db->where('id', $category_id);
        $this->db->delete($this->tables['app_gympro_account_type']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_category_fail');
            return FALSE;
        }
        $this->set_message('delete_product_category_successful');
        return TRUE;
    }
}