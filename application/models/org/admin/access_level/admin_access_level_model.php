<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin Access Level Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Admin_access_level_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_users_access_level($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->select('*')
                ->from($this->tables['users_access'])
                ->get();
    }
    
    public function create_users_access($additional_data)
    {
        $data = $this->_filter_data($this->tables['users_access'], $additional_data);
        $this->db->insert($this->tables['users_access'], $data);
    }
    
    public function update_users_access($user_id , $additional_data, $user_info_data = array())
    {
        $this->db->trans_begin();
        $this->db->where('user_id', $user_id);
        $data = $this->_filter_data($this->tables['users_access'], $additional_data);
        $this->db->update($this->tables['users_access'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return;
        }
        $this->db->where('id', $user_id);
        $user_data = $this->_filter_data($this->tables['users'], $user_info_data);
        $this->db->update($this->tables['users'], $user_data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return;
        }
        $this->db->trans_commit();
        return TRUE;
    }
    
    public function get_user_info($user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->where($this->tables['users'].'.id', $user_id);
        $this->response = $this->db->select($this->tables['users'] . '.id as user_id,'.$this->tables['users'] . '.*,'.$this->tables['groups'] . '.*')
                ->from($this->tables['users'])
                ->join($this->tables['users_groups'], $this->tables['users'].'.id='.$this->tables['users_groups'].'.user_id')
                ->join($this->tables['groups'], $this->tables['groups'].'.id='.$this->tables['users_groups'].'.group_id')
                ->get();
        return $this;
    }
    
    public function get_all_users_groups($group_id_array)
    {
        $this->db->where_in($this->tables['users_groups'].'.group_id', $group_id_array);
        $this->response = $this->db->select($this->tables['users'] . '.id as user_id,'.$this->tables['users'] . '.*,'.$this->tables['groups'] . '.*')
                ->from($this->tables['users'])
                ->join($this->tables['users_groups'], $this->tables['users'].'.id='.$this->tables['users_groups'].'.user_id')
                ->join($this->tables['groups'], $this->tables['groups'].'.id='.$this->tables['users_groups'].'.group_id')
                ->get();
        return $this;
    }
    
    public function delete_user($user_id)
    {
        $this->db->where($this->tables['users'].'.id', $user_id);
        $this->db->delete($this->tables['users']);
    }
}
