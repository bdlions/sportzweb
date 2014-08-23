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
class Permission_model extends Ion_auth_model {
    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->current_user_id = $this->ion_auth->get_user_id();
    }
    
    private function get_default_permissions_state() {
        $query = $this->db->select($this->tables['collaborate_permission_types'].".id as collaborate_permission_type, ".$this->tables['collaborate_permission_types'].'.default_collaborator_type as collaborator_type, '.$this->tables['collaborator_types']. ".type")
                          ->join($this->tables['collaborator_types'], $this->tables['collaborator_types'] . '.id'. '=' . $this->tables['collaborate_permission_types'] . '.default_collaborator_type')
                          ->get($this->tables['collaborate_permission_types']);
        return $query -> result();
    }
    
    private function get_default_permission_state($permission_type) {
        $query = $this->db->select($this->tables['collaborate_permission_types'].'.default_collaborator_type as collaborator_type, '.$this->tables['collaborator_types']. ".type")
                          ->where($this->tables['collaborate_permission_types'].'.id', $permission_type)
                          ->join($this->tables['collaborator_types'], $this->tables['collaborator_types'] . '.id'. '=' . $this->tables['collaborate_permission_types'] . '.default_collaborator_type')
                          ->get($this->tables['collaborate_permission_types']);
        return $query -> result();
    }
    
    private function merge_all_permission($permission_list){
        $default_permissions = $this->get_default_permissions_state();
        
        foreach ($default_permissions as $key => $default_permission) {
            $member_permission = $this->extract_permissions_state($permission_list, $default_permission->collaborate_permission_type);
            if($member_permission != NULL){
                $default_permissions[ $key ] = $member_permission;
            }
        }
        return $default_permissions;
    }

    public function get_permissions_state($user_id = 0) {
        if ($user_id <= 0) {
            $user_id = $this->current_user_id;
        }
         $query = $this->db->select('collaborate_permission_type, collaborator_type, '.$this->tables['collaborator_types']. ".type")
                ->where($this->tables['collaborate_permission'].'.user_id', $user_id)
                ->join($this->tables['collaborator_types'], $this->tables['collaborate_permission'] . '.collaborator_type'."=".$this->tables['collaborator_types'] . '.id' )
                ->get($this->tables['collaborate_permission']);
        
        if ($query->num_rows() <= 0) {
            $result = array();
        } else {
            $result = $query->result();
        }
        return $this->merge_all_permission($result);
        //return array_merge($this->get_default_permissions_state(), $result);
    }

    public function get_permission_state($permission_type, $user_id = 0) {
        if ($user_id <= 0) {
            $user_id = $this->current_user_id;
        }
        $query = $this->db->select('collaborate_permission_type, collaborator_type, '.$this->tables['collaborator_types']. ".type")
                ->where($this->tables['collaborate_permission'].'.user_id', $user_id)
                ->where($this->tables['collaborate_permission'].'.collaborate_permission_type', $permission_type)
                ->join($this->tables['collaborator_types'], $this->tables['collaborate_permission'] . '.collaborate_permission_type'."=".$this->tables['collaborator_types'] . '.id' )
                ->get($this->tables['collaborate_permission']);

        //print_r($query);
        if ($query->num_rows() <= 0) {
            $result = $this->get_default_permission_state($permission_type);
        } else {
            $result = $query->result();
        }
        return $result[ 0 ];
    }
    
    public function extract_permissions_state($permission_list, $permission_type){
        foreach ($permission_list as $permission){
            if($permission->collaborate_permission_type == $permission_type){
                return $permission;
            }
        }
        return null;
    }
    
    public function change_permission($permission_type, $collaborator_type, $user_id = 0, $additional_data = array()){
        if($user_id == 0){
            $user_id = $this->current_user_id;
        }
        $query = $this->db->select('*')
                ->where('user_id', $user_id)
                ->where('collaborate_permission_type', $permission_type)
                ->get($this->tables['collaborate_permission']);

        $data = array('collaborate_permission_type' => $permission_type, 'user_id' => $user_id, 'collaborator_type' => $collaborator_type);
        if (!empty($additional_data))
            $data = array_merge($this->_filter_data($this->tables['collaborate_permission'], $additional_data), $data);

        if ($query->num_rows() <= 0) {
            $this->db->insert($this->tables['collaborate_permission'], $data);
            return $this->db->insert_id() >= 0;

        } else {
            $this->db->update($this->tables['collaborate_permission'], $data, array('collaborate_permission_type' => $permission_type));
            return $this->db->affected_rows() == 1;
        }
    }
}