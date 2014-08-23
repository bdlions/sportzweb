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
class Profile_model extends Ion_auth_model {

    private $user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->user_id = $this->ion_auth->get_user_id();
                
    }

    public function get_users() {
        $query = $this->db->select("username, first_name, last_name, " . $this->tables['users']. ".id as user_id, ". $this->tables['basic_profile']. ".*")
                ->join($this->tables['basic_profile'], $this->tables['users'] . '.id = ' . $this->tables['basic_profile'] . '.user_id')
                ->join($this->tables['countries'], $this->tables['basic_profile'] . '.' . $this->join['countries'] . '=' . $this->tables['countries'] . '.id')
                ->limit(10)
                ->get($this->tables['users']);
        
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    public function get_user($user_id = 0){
        if($user_id == 0){
            $user_id = $this->user_id ;
        }
        $query = $this->db->select("username, first_name, last_name, " . $this->tables['users']. ".id as user_id, ". $this->tables['basic_profile']. ".*")
                           ->where($this->tables['users'].'.id', $user_id)
                           ->join($this->tables['basic_profile'], $this->tables['users'] . '.id = ' . $this->tables['basic_profile'] . '.user_id')
                           ->limit(1)
                           ->get($this->tables['users']);
        return $query->row();
    }
    
    /*create photo list for photo bar on profile page
     *Written by Redwan
     *19 May,2014
     */
    
    public function create_photo_list($data)
    {
        $data = $this->_filter_data($this->tables['user_profile_photos'], $data);
        
        $this->db->insert($this->tables['user_profile_photos'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)?$id:False;
    }
    
    
    //update photo list
    //param: $user_id,$additional_data
    
    public function update_photo_list($user_id,$additional_data)
    {
        $additional_data = $this->_filter_data($this->tables['user_profile_photos'], $additional_data);

        $this->db->where($this->tables['user_profile_photos'].'.user_id',$user_id);
        
        $this->db->update($this->tables['user_profile_photos'],$additional_data);
        
    }


    //get_photo list on a particular user_id
    
    public function get_photo_list($user_id)
    {
        $this->db->where($this->tables['user_profile_photos'].'.user_id',$user_id);
        
        return $this->db->select('*')
                    ->from($this->tables['user_profile_photos'])
                    ->get();
    }
    
    public function remove_photo_list($user_id)
    {
        $this->db->where($this->tables['user_profile_photos'].'.user_id',$user_id);
        
        $this->db->delete($this->tables['user_profile_photos']);
    }
    
    

}

?>