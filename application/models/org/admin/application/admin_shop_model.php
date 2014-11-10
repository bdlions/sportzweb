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
    protected $app_shop_product_color_identity_column;
    protected $app_shop_product_feature_identity_column;
    protected $app_shop_product_size_identity_column;
    public function __construct() {
        parent::__construct();
        $this->app_shop_product_identity_column             = $this->config->item('app_shop_product_identity_column', 'ion_auth');
        $this->app_shop_product_color_identity_column       = $this->config->item('app_shop_product_color_identity_column', 'ion_auth');
        $this->app_shop_product_feature_identity_column     = $this->config->item('app_shop_product_feature_identity_column', 'ion_auth');
        $this->app_shop_product_size_identity_column        = $this->config->item('app_shop_product_size_identity_column', 'ion_auth');
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
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_shop_product_color_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_shop_product_color']) > 0;
    }
    /*
     * This method will create a product color
     * @param $additional_data, product color data to be added
     * @Author Nazmul on 5th November 2014
     */
    public function create_product_color($additional_data)
    {
        if ( array_key_exists($this->app_shop_product_color_identity_column, $additional_data) && $this->product_color_identity_check($additional_data[$this->app_shop_product_color_identity_column]) )
        {
            $this->set_error('create_product_color_duplicate_' . $this->app_shop_product_color_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_shop_product_color'], $additional_data); 
        $this->db->insert($this->tables['app_shop_product_color'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_color_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*
     * This method will update product color info
     * @param $color_id, color id
     * @param $additional_data, product color data to be updated
     * @Author Nazmul on 5th November 2014
     */
    public function update_product_color($color_id, $additional_data)
    {
        $color_info = $this->get_product_color_info($color_id)->row();
        if (array_key_exists($this->app_shop_product_color_identity_column, $additional_data) && $this->product_color_identity_check($additional_data[$this->app_shop_product_color_identity_column]) && $color_info->{$this->app_shop_product_color_identity_column} !== $additional_data[$this->app_shop_product_color_identity_column])
        {
            $this->set_error('update_product_color_duplicate_' . $this->app_shop_product_color_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_shop_product_color'], $additional_data);
        $this->db->update($this->tables['app_shop_product_color'], $data, array('id' => $color_id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_color_fail');
            return FALSE;
        }
        $this->set_message('update_product_color_successful');
        return TRUE;
    }
    
    /*
     * This method will return product color info
     * @param $color_id, color id
     * @Author Nazmul on 5th November 2014
     */
    public function get_product_color_info($color_id)
    {
        $this->db->where($this->tables['app_shop_product_color'].'.id', $color_id);
        return $this->db->select($this->tables['app_shop_product_color'].'.id as id,'.$this->tables['app_shop_product_color'].'.*')
                    ->from($this->tables['app_shop_product_color'])
                    ->get();
    }
    
    /*
     * This method will return all product colors
     * @Author Nazmul on 5th November 2014
     */
    public function get_all_product_colors()
    {
        return $this->db->select($this->tables['app_shop_product_color'].'.id as id,'.$this->tables['app_shop_product_color'].'.*')
                    ->from($this->tables['app_shop_product_color'])
                    ->get();
    }
    
    /*
     * This method will delete product color info
     * @param $color_id, color id
     * @Author Nazmul on 5th November 2014
     */
    public function delete_product_color($color_id)
    {
        if(!isset($color_id) || $color_id <= 0)
        {
            $this->set_error('delete_product_color_fail');
            return FALSE;
        }
        $this->db->where('id', $color_id);
        $this->db->delete($this->tables['app_shop_product_color']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_color_fail');
            return FALSE;
        }
        $this->set_message('delete_product_color_successful');
        return TRUE;
    }
    
    
    // -------------------------------- Product SIZE Module --------------------------------------

    public function size_men_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_shop_product_size_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_shop_sizing_chart_men']) > 0;
    }
//    public function get_size_info_men($id)
//    {
//        $this->db->where($this->tables['app_shop_sizing_chart_men'].'.id', $category_id);
//        return $this->db->select($this->tables['app_shop_product_category'].'.id as category_id,'.$this->tables['app_shop_product_category'].'.*')
//                    ->from($this->tables['app_shop_product_category'])
//                    ->get();
//    }
    
    public function get_all_sizes_men()
    {
        return $this->db->select($this->tables['app_shop_sizing_chart_men'].'.id as category_id,'.$this->tables['app_shop_sizing_chart_men'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_men'])
                    ->get();
    }
    
    public function delete_size_men($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_shop_sizing_chart_men']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->set_message('delete_product_size_successful');
        return TRUE;
    }
    
    public function create_size_men($additional_data)
    {
        if ( array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->product_color_identity_check($additional_data[$this->app_shop_product_size_identity_column]) )
        {
            $this->set_error('create_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_shop_sizing_chart_men'], $additional_data); 
        $this->db->insert($this->tables['app_shop_sizing_chart_men'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_size_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_size_info_men($id)
    {
        $this->db->where($this->tables['app_shop_sizing_chart_men'].'.id', $id);
        return $this->db->select($this->tables['app_shop_sizing_chart_men'].'.id as id,'.$this->tables['app_shop_sizing_chart_men'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_men'])
                    ->get();
    }
    
    public function update_size_men($id, $additional_data)
    {
        $size_info = $this->get_size_info_men($id)->row();
        if (array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->size_men_identity_check($additional_data[$this->app_shop_product_size_identity_column]) && $size_info->{$this->app_shop_product_size_identity_column} !== $additional_data[$this->app_shop_product_size_identity_column])
        {
            $this->set_error('update_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_shop_sizing_chart_men'], $additional_data);
        $this->db->update($this->tables['app_shop_sizing_chart_men'], $data, array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_size_fail');
            return FALSE;
        }
        $this->set_message('update_product_size_successful');
        return TRUE;
    }
    
    
    // WOMEN ----------------------------------
    public function get_all_sizes_women()
    {
        return $this->db->select($this->tables['app_shop_sizing_chart_women'].'.id as id,'.$this->tables['app_shop_sizing_chart_women'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_women'])
                    ->get();
    }
    
    public function create_size_women($additional_data)
    {
        if ( array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->product_color_identity_check($additional_data[$this->app_shop_product_size_identity_column]) )
        {
            $this->set_error('create_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_shop_sizing_chart_women'], $additional_data); 
        $this->db->insert($this->tables['app_shop_sizing_chart_women'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_size_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function size_women_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_shop_product_size_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_shop_sizing_chart_women']) > 0;
    }
    
    
    public function delete_size_women($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_shop_sizing_chart_women']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->set_message('delete_product_size_successful');
        return TRUE;
    }
    
    public function get_size_info_women($id)
    {
        $this->db->where($this->tables['app_shop_sizing_chart_women'].'.id', $id);
        return $this->db->select($this->tables['app_shop_sizing_chart_women'].'.id as id,'.$this->tables['app_shop_sizing_chart_women'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_women'])
                    ->get();
    }
    
    public function update_size_women($id, $additional_data)
    {
        $size_info = $this->get_size_info_women($id)->row();
        if (array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->size_women_identity_check($additional_data[$this->app_shop_product_size_identity_column]) && $size_info->{$this->app_shop_product_size_identity_column} !== $additional_data[$this->app_shop_product_size_identity_column])
        {
            $this->set_error('update_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_shop_sizing_chart_women'], $additional_data);
        $this->db->update($this->tables['app_shop_sizing_chart_women'], $data, array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_size_fail');
            return FALSE;
        }
        $this->set_message('update_product_size_successful');
        return TRUE;
    }
    
//    // TINYTOSM ----------------------------------
    public function get_all_sizes_tinytoms()
    {
        return $this->db->select($this->tables['app_shop_sizing_chart_tiny_toms'].'.id as id,'.$this->tables['app_shop_sizing_chart_tiny_toms'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_tiny_toms'])
                    ->get();
    }
    
    public function create_size_tinytoms($additional_data)
    {
        if ( array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->product_color_identity_check($additional_data[$this->app_shop_product_size_identity_column]) )
        {
            $this->set_error('create_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_shop_sizing_chart_tiny_toms'], $additional_data); 
        $this->db->insert($this->tables['app_shop_sizing_chart_tiny_toms'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_size_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    
    public function size_tinytoms_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_shop_product_size_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_shop_sizing_chart_tiny_toms']) > 0;
    }
    
    
    public function delete_size_tinytoms($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_shop_sizing_chart_tiny_toms']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->set_message('delete_product_size_successful');
        return TRUE;
    }
    
    public function get_size_info_tinytoms($id)
    {
        $this->db->where($this->tables['app_shop_sizing_chart_tiny_toms'].'.id', $id);
        return $this->db->select($this->tables['app_shop_sizing_chart_tiny_toms'].'.id as id,'.$this->tables['app_shop_sizing_chart_tiny_toms'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_tiny_toms'])
                    ->get();
    }
    
    public function update_size_tinytoms($id, $additional_data)
    {
        $size_info = $this->get_size_info_tinytoms($id)->row();
        if (array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->size_tinytoms_identity_check($additional_data[$this->app_shop_product_size_identity_column]) && $size_info->{$this->app_shop_product_size_identity_column} !== $additional_data[$this->app_shop_product_size_identity_column])
        {
            $this->set_error('update_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_shop_sizing_chart_tiny_toms'], $additional_data);
        $this->db->update($this->tables['app_shop_sizing_chart_tiny_toms'], $data, array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_size_fail');
            return FALSE;
        }
        $this->set_message('update_product_size_successful');
        return TRUE;
    }
    
//    // Youth ----------------------------------
    public function get_all_sizes_youth()
    {
        return $this->db->select($this->tables['app_shop_sizing_chart_youth'].'.id as id,'.$this->tables['app_shop_sizing_chart_youth'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_youth'])
                    ->get();
    }
    
    public function create_size_youth($additional_data)
    {
        if ( array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->product_color_identity_check($additional_data[$this->app_shop_product_size_identity_column]) )
        {
            $this->set_error('create_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_shop_sizing_chart_youth'], $additional_data); 
        $this->db->insert($this->tables['app_shop_sizing_chart_youth'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_size_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function size_youth_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_shop_product_size_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_shop_sizing_chart_youth']) > 0;
    }
    
    
    public function delete_size_youth($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_shop_sizing_chart_youth']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_size_fail');
            return FALSE;
        }
        $this->set_message('delete_product_size_successful');
        return TRUE;
    }
    
    public function get_size_info_youth($id)
    {
        $this->db->where($this->tables['app_shop_sizing_chart_youth'].'.id', $id);
        return $this->db->select($this->tables['app_shop_sizing_chart_youth'].'.id as id,'.$this->tables['app_shop_sizing_chart_youth'].'.*')
                    ->from($this->tables['app_shop_sizing_chart_youth'])
                    ->get();
    }
    
    public function update_size_youth($id, $additional_data)
    {
        $size_info = $this->get_size_info_youth($id)->row();
        if (array_key_exists($this->app_shop_product_size_identity_column, $additional_data) && $this->size_youth_identity_check($additional_data[$this->app_shop_product_size_identity_column]) && $size_info->{$this->app_shop_product_size_identity_column} !== $additional_data[$this->app_shop_product_size_identity_column])
        {
            $this->set_error('update_product_size_duplicate_' . $this->app_shop_product_size_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_shop_sizing_chart_youth'], $additional_data);
        $this->db->update($this->tables['app_shop_sizing_chart_youth'], $data, array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_size_fail');
            return FALSE;
        }
        $this->set_message('update_product_size_successful');
        return TRUE;
    }
    
    
    // -------------------------------- Product SIZE Module --------------------------------------    
   
    public function get_all_product_feature()
    {
        return $this->db->select($this->tables['app_shop_product_feature'].'.id as id,'.$this->tables['app_shop_product_feature'].'.*')
                    ->from($this->tables['app_shop_product_feature'])
                    ->get();
    }
    /*
     * This method will return product feature info
     * @param $id, product feature id
     * @Author Nazmul on 11th November 2014
     */
    public function get_product_feature_info($id)
    {
        $this->db->where($this->tables['app_shop_product_feature'].'.id', $id);
        return $this->db->select($this->tables['app_shop_product_feature'].'.id as feature_id,'.$this->tables['app_shop_product_feature'].'.*')
                    ->from($this->tables['app_shop_product_feature'])
                    ->get();
    }
    public function product_feature_identity_check($identity = '') {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->app_shop_product_feature_identity_column, $identity);
        return $this->db->count_all_results($this->tables['app_shop_product_feature']) > 0;
    }
    
    public function create_product_feature($additional_data)
    {
        if ( array_key_exists($this->app_shop_product_feature_identity_column, $additional_data) && $this->product_feature_identity_check($additional_data[$this->app_shop_product_feature_identity_column]) )
        {
            $this->set_error('create_product_feature_duplicate_' . $this->app_shop_product_feature_identity_column);
            return FALSE;
        }
        $additional_data['created_on'] = now();
        $additional_data = $this->_filter_data($this->tables['app_shop_product_feature'], $additional_data); 
        $this->db->insert($this->tables['app_shop_product_feature'], $additional_data);
        $id = $this->db->insert_id();
        $this->set_message('create_product_feature_successful');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_product_feature($id, $additional_data)
    {
        $feature_info = $this->get_product_feature_info($id)->row();
        if (array_key_exists($this->app_shop_product_feature_identity_column, $additional_data) && $this->product_feature_identity_check($additional_data[$this->app_shop_product_feature_identity_column]) && $feature_info->{$this->app_shop_product_feature_identity_column} !== $additional_data[$this->app_shop_product_feature_identity_column])
        {
            $this->set_error('update_product_feature_duplicate_' . $this->app_shop_product_feature_identity_column);
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['app_shop_product_feature'], $additional_data);
        $this->db->update($this->tables['app_shop_product_feature'], $data, array('id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_product_feature_fail');
            return FALSE;
        }
        $this->set_message('update_product_feature_successful');
        return TRUE;
    }
    
    public function delete_product_feature($id)
    {
        if(!isset($id) || $id <= 0)
        {
            $this->set_error('delete_product_feature_fail');
            return FALSE;
        }
        $this->db->where('id', $id);
        $this->db->delete($this->tables['app_shop_product_feature']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_product_feature_fail');
            return FALSE;
        }
        $this->set_message('delete_product_feature_successful');
        return TRUE;
    }
    
    
}