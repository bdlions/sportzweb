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

    protected $group_identity_column;
    public function __construct() {
        parent::__construct();
        $this->group_identity_column = $this->config->item('group_identity_column', 'ion_auth');
    }
    
    /**
     * Group Identity check
     * Group will be unique
     * @return bool
     * @author Nazmul on 4September2014
     * */
    public function group_identity_check($identity = '') {
        $this->trigger_events('group_identity_check');
        if (empty($identity)) {
            return FALSE;
        }
        $this->db->where($this->group_identity_column, $identity);
        return $this->db->count_all_results($this->tables['groups']) > 0;
    }
    
    /**
     * @author Nazmul on 4September2014
     * Creating a new group
     * @return false if there is any error, otherwise will return newly created group id
     * 
     * */
    public function create_group($additional_data)
    {
        $this->trigger_events('pre_create_group');
        if ($this->group_identity_column == 'name' && array_key_exists('name', $additional_data) && $this->group_identity_check($additional_data['name'])) 
        {
            $this->set_error('group_creation_duplicate_group_name');
            return FALSE;
        }         
        $data = $this->_filter_data($this->tables['groups'], $additional_data);
        $this->db->insert($this->tables['groups'], $data);
        $id = $this->db->insert_id();
        if(isset($id))
        {
            $this->set_message('group_creation_success_message');
        }
        $this->trigger_events('post_create_group');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_access_level_groups()
    {
        $this->db->where('id >= ', ACCESS_LEVEL_PUBLISHER_ID);
        return $this->db->select($this->tables['groups'].'.id as group_id,'.$this->tables['groups'].'.*')
                ->from($this->tables['groups'])
                ->get();
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
        //$this->ion_auth_model->update();
        //$this->db->where('id', $user_id);
        //$user_data = $this->_filter_data($this->tables['users'], $user_info_data);
        //$this->db->update($this->tables['users'], $user_data);
        
        if ($this->ion_auth_model->update($user_info_data['user_id'], $user_info_data) === FALSE) {
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
        $this->response = $this->db->select($this->tables['users'] . '.id as user_id,'.$this->tables['users'] . '.*,'.$this->tables['groups'] . '.id as group_id, '.$this->tables['groups'].'.*')
                ->from($this->tables['users'])
                ->join($this->tables['users_groups'], $this->tables['users'].'.id='.$this->tables['users_groups'].'.user_id')
                ->join($this->tables['groups'], $this->tables['groups'].'.id='.$this->tables['users_groups'].'.group_id')
                ->get();
        return $this;
    }
    
    public function get_all_users_groups()
    {
        $this->db->where($this->tables['users_groups'].'.group_id >= ', ACCESS_LEVEL_PUBLISHER_ID);
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
