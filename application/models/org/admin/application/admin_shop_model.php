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
    protected $app_shop_product_identity_column;
    public function __construct() {
        parent::__construct();
        $this->app_shop_product_identity_column = $this->config->item('app_shop_product_identity_column', 'ion_auth');
    }
    
    // -------------------------------- Product Category Module --------------------------------------
    /*
     * This method will check identity of product category
     * @param $identity, identity of product category
     * @Author Nazmul on 5th November 2014
     */
    public function product_category_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_shop_product_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_shop_product_category']) > 0;
    }
    /*
     * This method will create a product category
     * @param $additional_data, product category data to be added
     * @Author Nazmul on 5th November 2014
     */
    public function create_product_category($additional_data)
    {
        if ( array_key_exists($this->app_shop_product_identity_column, $additional_data) && $this->product_category_identity_check($additional_data[$this->app_shop_product_identity_column]) )
        {
            $this->set_error('create_product_category_duplicate_' . $this->app_shop_product_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_shop_product_category'], $additional_data); 
        $this->db->insert($this->tables['app_shop_product_category'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_category_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will update product category info
     * @param $category_id, category id
     * @param $additional_data, product category data to be updated
     * @Author Nazmul on 5th November 2014
     */
    public function update_product_category($category_id, $additional_data)
    {
        $category_info = $this->get_product_category_info($category_id)->row();
        if (array_key_exists($this->app_shop_product_identity_column, $additional_data) && $this->product_category_identity_check($additional_data[$this->app_shop_product_identity_column]) && $category_info->{$this->app_shop_product_identity_column} !== $additional_data[$this->app_shop_product_identity_column])
        {
            $this->set_error('update_product_category_duplicate_' . $this->app_shop_product_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_shop_product_category'], $additional_data);
        $this->db->update($this->tables['app_shop_product_category'], $data, array('id' => $category_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_category_fail');
            return FALSE;
        }
        $this->set_message('update_product_category_successful');
        return TRUE;
    }
    
    /*
     * This method will return product category info
     * @param $category_id, category id
     * @Author Nazmul on 5th November 2014
     */
    public function get_product_category_info($category_id)
    {
        $this->db->where($this->tables['app_shop_product_category'].'.id', $category_id);
        return $this->db->select($this->tables['app_shop_product_category'].'.id as category_id,'.$this->tables['app_shop_product_category'].'.*')
                    ->from($this->tables['app_shop_product_category'])
                    ->get();
    }
    
    /*
     * This method will return all product categories
     * @Author Nazmul on 5th November 2014
     */
    public function get_all_product_categories()
    {
        return $this->db->select($this->tables['app_shop_product_category'].'.id as category_id,'.$this->tables['app_shop_product_category'].'.*')
                    ->from($this->tables['app_shop_product_category'])
                    ->get();
    }
    
    /*
     * This method will delete product category info
     * @param $category_id, category id
     * @Author Nazmul on 5th November 2014
     */
    public function delete_product_category($category_id)
    {
        if(!isset($category_id) || $category_id <= 0)
        {
            $this->set_error('delete_product_category_fail');
            return FALSE;
        }
        $this->db->where('id', $category_id);
        $this->db->delete($this->tables['app_shop_product_category']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_category_fail');
            return FALSE;
        }
        $this->set_message('delete_product_category_successful');
        return TRUE;
    }
    
    // -------------------------------- Product Color Module --------------------------------------
    /*
     * This method will check identity of product color
     * @param $identity, identity of product color
     * @Author Nazmul on 5th November 2014
     */
    public function product_color_identity_check($identity = '') {
        
    }
    /*
     * This method will create a product color
     * @param $additional_data, product color data to be added
     * @Author Nazmul on 5th November 2014
     */
    public function create_product_color($additional_data)
    {
        
    }
    
    /*
     * This method will update product color info
     * @param $color_id, color id
     * @param $additional_data, product color data to be updated
     * @Author Nazmul on 5th November 2014
     */
    public function update_product_color($color_id, $additional_data)
    {
        
    }
    
    /*
     * This method will return product color info
     * @param $color_id, color id
     * @Author Nazmul on 5th November 2014
     */
    public function get_product_color_info($color_id)
    {
        
    }
    
    /*
     * This method will return all product colors
     * @Author Nazmul on 5th November 2014
     */
    public function get_all_product_colors()
    {
        
    }
    
    /*
     * This method will delete product color info
     * @param $color_id, color id
     * @Author Nazmul on 5th November 2014
     */
    public function delete_product_color($color_id)
    {
        
    }
}