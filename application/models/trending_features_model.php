<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  dataprovider Model
 *
 * Author:  alamgir kabir
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Trending_features_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }   
    
    public function test()
    {
        print_r('trending features model');
    }
    
    public function get_users_at($search_value)
    {
        $this->db->like($this->tables['users'].'.first_name', $search_value);
        $this->db->or_like($this->tables['users'].'.last_name', $search_value);
        $this->db->limit(5);
        $query = $this->db->select($this->tables['users'].'.id as user_id,'. $this->tables['users'].'.*')
                    ->from($this->tables['users'])
                    ->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
    public function get_user_info($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->select($this->tables['users'].'.id as user_id,'. $this->tables['users'].'.*')
                    ->from($this->tables['users'])
                    ->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
    public function get_hashtags($search_value)
    {
        $this->db->like($this->tables['hashtags'].'.hashtag', $search_value);
        $this->db->limit(5);
        $query = $this->db->select('*')
                    ->from($this->tables['hashtags'])
                    ->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
    public function get_hashtag_info($hashtag)
    {
        $this->db->where('hashtag', $hashtag);
        $this->response = $this->db->select('*')
                    ->from($this->tables['hashtags'])
                    ->get();
        return $this;
    }
    
    public function add_hashtag_info($data)
    {
        $data = $this->_filter_data($this->tables['hashtags'], $data);        
        $this->db->insert($this->tables['hashtags'],$data);
        $id = $this->db->insert_id();        
        return isset($id)?$id:FALSE;
    }
    
    public function update_hashtag_info($hashtag, $data)
    {
        $data = $this->_filter_data($this->tables['hashtags'], $data);
        $this->db->where('hashtag',$hashtag);        
        $this->db->update($this->tables['hashtags'],$data);
    }
    
    public function get_popular_trends()
    {
        $this->db->order_by($this->tables['hashtags'].'.counter', 'desc');
        $this->db->limit(5);
        $this->response = $this->db->select('*')
                    ->from($this->tables['hashtags'])
                    ->get();
        return $this;
    }
    
}
?>
