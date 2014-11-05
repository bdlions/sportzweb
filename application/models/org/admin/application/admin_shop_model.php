<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Admin Shop Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Admin_shop_model extends Ion_auth_model
{
    public function __construct() {
        parent::__construct();
    }
    
    // -------------------------------- Product Category Module --------------------------------------
    /*
     * This method will check identity of product category
     * @param $identity, identity of product category
     * @Author Nazmul on 5th November 2014
     */
    public function product_category_identity_check($identity = '') {
        
    }
    /*
     * This method will create a product category
     * @param $additional_data, product category data to be added
     * @Author Nazmul on 5th November 2014
     */
    public function create_product_category($additional_data)
    {
        
    }
    
    /*
     * This method will update product category info
     * @param $category_id, category id
     * @param $additional_data, product category data to be updated
     * @Author Nazmul on 5th November 2014
     */
    public function update_product_category($category_id, $additional_data)
    {
        
    }
    
    /*
     * This method will return product category info
     * @param $category_id, category id
     * @Author Nazmul on 5th November 2014
     */
    public function get_product_category_info($category_id)
    {
        
    }
    
    /*
     * This method will return all product categories
     * @Author Nazmul on 5th November 2014
     */
    public function get_all_product_categories()
    {
        
    }
    
    /*
     * This method will delete product category info
     * @param $category_id, category id
     * @Author Nazmul on 5th November 2014
     */
    public function delete_product_category($category_id)
    {
        
    }
}