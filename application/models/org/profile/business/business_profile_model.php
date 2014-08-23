<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth Model
 *
 * Author:  Ben Edmunds
 * 		   ben.edmunds@gmail.com
 * 	  	   @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 * 
 * Last Change: 3.22.13
 *
 * Changelog:
 * * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
 * 
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Business_profile_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    /*
     * This method will add all special interests into the database
     */
    public function add_all_business_profile_types($data)
    {
        $this->db->insert_batch('business_profile_type', $data);         
    }
    public function get_all_business_profile(){
        $query = $this->db->select('*')
                        ->get($this->tables['business_profile']);
        return $query->result();
    }
    public function get_business_types_profile(){
        $query = $this->db->select('*')
                ->from($this->tables['business_profile_type'])
                ->get();
        
        $result = $query->result();
        $business_profile_types = array();
        
        foreach ($result as $value) {
            $business_profile_types[] = array('id'=>$value->id, 
                'description' => $value->description, 
                'sub_type_list' => json_decode($value->sub_type_list));
        }
        return $business_profile_types;
    }
    
    public function create_business_profile($data){
        $this->trigger_events('pre_create_business_profile');

        $this->db->trans_begin();

        $id = $this->ion_auth->get_user_id();
        if($id > 0){
            $additional_data = array(
                "user_id" => $id
            );
            //$profile_data = array_merge($this->_filter_data($this->tables['basic_profile'], $data), $additional_data);
            //$this->db->insert($this->tables['basic_profile'], $profile_data);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                
                $this->trigger_events(array('business_profile_insert_unsuccessful', 'insertion_basic_profile_unsuccessful'));
                $this->set_error('business_profile_insert_unsuccessful');
                return FALSE;
            
            }
            else{
                $business_profile_data = array_merge($this->_filter_data($this->tables['business_profile'], $data), $additional_data);
                if(array_key_exists('business_name', $business_profile_data))
                {
                    $business_profile_data['business_name'] = ucwords($business_profile_data['business_name']);
                }
                $this->db->insert($this->tables['business_profile'], $business_profile_data);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();

                    $this->trigger_events(array('business_profile_insert_unsuccessful', 'insertion_basic_profile_unsuccessful'));
                    $this->set_error('business_profile_insert_unsuccessful');
                    return FALSE;

                }
                
            }
        }
        
        $this->db->trans_commit();
        return TRUE ;
    }
    
    public function get_profile_id($user_id = 0){
        if($user_id <= 0){
            $user_id = $this->ion_auth->get_user_id();
        }
        $query = $this->db->select('id')
                        ->where('user_id', $user_id)
                        ->get($this->tables['business_profile']);
        if($query->num_rows() <= 0){
            return -1;
        }
        else{
            $result = $query->row();
            return $result->{'id'};
        }
    }
    public function get_profile_info($user_id = 0){
        if($user_id <= 0){
            $user_id = $this->ion_auth->get_user_id();
        }
        $query = $this->db->select($this->tables['business_profile']. ".id as business_profile_id, ".$this->tables['business_profile']. ".*, ". $this->tables['business_profile_type']. ".*,". $this->tables['countries'].".id as country_id, country_name, country_code")
                          ->where($this->tables['business_profile'].'.user_id', $user_id)
                          ->join($this->tables['business_profile_type'], $this->tables['business_profile'] . '.business_profile_type = ' . $this->tables['business_profile_type'] . '.id')
                          ->join($this->tables['countries'], $this->tables['business_profile'] . '.business_country' . '=' . $this->tables['countries'] . '.id')
                          ->limit(1)
                          ->get($this->tables['business_profile']);
        $profile_info = array();
        if ($query->num_rows() >= 1) {
            $profile_info = $query->row();
            $sub_type_list = $profile_info->sub_type_list;
            $profile_info->sub_type = $this->jsondb->select('id, description')
                         ->where('id', $profile_info->business_profile_sub_type)
                         ->from(json_decode($sub_type_list))->row();
            
            return $profile_info;
        } else {
            return FALSE;
        }
    }
    
    public function get_business_profile_info($business_profile_id = 0){
        $this->db->where($this->tables['business_profile'].'.id', $business_profile_id);
        $query = $this->db->select($this->tables['business_profile']. ".id as business_profile_id, ".$this->tables['business_profile']. ".*, ". $this->tables['business_profile_type']. ".*,". $this->tables['countries'].".id as country_id, country_name, country_code")
                          ->join($this->tables['business_profile_type'], $this->tables['business_profile'] . '.business_profile_type = ' . $this->tables['business_profile_type'] . '.id')
                          ->join($this->tables['countries'], $this->tables['business_profile'] . '.business_country' . '=' . $this->tables['countries'] . '.id')
                          ->limit(1)
                          ->get($this->tables['business_profile']);
        $profile_info = array();
        if ($query->num_rows() >= 1) {
            $profile_info = $query->row();
            $sub_type_list = $profile_info->sub_type_list;
            $profile_info->sub_type = $this->jsondb->select('id, description')
                         ->where('id', $profile_info->business_profile_sub_type)
                         ->from(json_decode($sub_type_list))->row();
            
            return $profile_info;
        } else {
            return FALSE;
        }
    }
    
    public function create_profile($profile_data){
        $this->trigger_events('update_profile');

        if (!isset($profile_data['user_id']) || $profile_data['user_id'] <= 0) {
            $this->set_error('create_profile_unsuccessful');
            return FALSE;
        }

        $this->trigger_events('extra_where');
        $this->db->insert($this->tables['business_profile'], $profile_data);

        return $this->db->insert_id() >= 0;
    }
    
    public function update_profile($profile_data, $profile_id = 0){
        $this->trigger_events('update_profile');

        if($profile_id <= 0){
            $profile_id = $this->get_profile_id();
        }

        $data = array(
            'id' => $profile_id
        );

        $profile_data = array_merge($this->_filter_data($this->tables['business_profile'], $profile_data), $data);
        $this->trigger_events('extra_where');
        if(array_key_exists('business_name', $profile_data))
        {
            $profile_data['business_name'] = ucwords($profile_data['business_name']);
        }
        $this->db->update($this->tables['business_profile'], $profile_data, array('id' => $profile_id));

        $return = $this->db->affected_rows() >= 0;
        if ($return){
            $this->set_message('update_profile_successful');
        }
        else{
            $this->set_error('update_profile_unsuccessful');
        }

        return $return;
    }
    
    public function get_business_profile_connection($business_profile_id)
    {
        $this->db->where('business_profile_id', $business_profile_id);
        $this->response = $this->db->select('*')
                ->from($this->tables['business_profile_connection'])
                ->get();
        return $this;
    }
    
    public function add_business_profile_connection($business_profile_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'business_profile_id' => $business_profile_id,
            'created_on' => $current_time,
            'modified_on' => $current_time
        );
        $business_profile_connection_data = array_merge($this->_filter_data($this->tables['business_profile_connection'], $additional_data), $data);
        $this->db->insert($this->tables['business_profile_connection'], $business_profile_connection_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_business_profile_connection($business_profile_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'modified_on' => $current_time
        );
        $business_profile_connection_data = array_merge($this->_filter_data($this->tables['business_profile_connection'], $additional_data), $data);
        $this->db->where('business_profile_id', $business_profile_id);
        $this->db->update($this->tables['business_profile_connection'], $business_profile_connection_data);
    }
}
