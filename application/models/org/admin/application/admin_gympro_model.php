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
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will check identity of account type table
     * @param $identity, identity of account type table
     * @Author Nazmul on 16th November 2014
     */
    public function account_type_identity_check($identity = '')
    {
        
    }
    
    /*
     * This method will create account type info
     * @param $additional_data, account type data to be added
     * @Author Nazmul on 16th November 2014
     */
    public function create_account_type($additional_data)
    {
        
    }
    
    /*
     * This method will update account type info
     * @param $account_type_id, account type id
     * @param $additional_data, account type data to be updated
     * @Author Nazmul on 16th November 2014
     */
    public function update_account_type($account_type_id, $additional_data)
    {
        
    }
    
    /*
     * This method will return account type info
     * @param $account_type_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function get_account_type_info($account_type_id)
    {
        
    }
    
    /*
     * This method will return all account types
     * @Author Nazmul on 16th November 2014
     */
    public function get_all_account_types()
    {
        
    }
    
    /*
     * This method will delete account type info
     * @param $account_type_id, account type id
     * @Author Nazmul on 16th November 2014
     */
    public function delete_account_type($account_type_id)
    {
        
    }
}