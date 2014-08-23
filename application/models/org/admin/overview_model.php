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
class Overview_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    } 
    
    public function get_user_list()
    {
        $this->db->where($this->tables['groups'].'.id', 3);
        $this->db->group_by($this->tables['basic_profile'].'.gender_id');
        $this->response = $this->db->select($this->tables['basic_profile'].".gender_id, count(".$this->tables['basic_profile'].'.user_id) as total_users')
                ->from($this->tables['users'])
                ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['users'].'.id')
                ->join($this->tables['users_groups'], $this->tables['users_groups'].'.user_id='.$this->tables['basic_profile'].'.id')
                ->join($this->tables['groups'], $this->tables['groups'].'.id='.$this->tables['users_groups'].'.group_id')
                ->get();
        return $this;
    }
    
    public function get_total_applications()
    {
        $query = $this->db->select('*')
                ->from($this->tables['applications'])
                ->get();
        return $query->num_rows();
    }
    
    public function get_total_business_profiles()
    {
        $query = $this->db->select('*')
                ->from($this->tables['business_profile'])
                ->get();
        return $query->num_rows();
    }
}
