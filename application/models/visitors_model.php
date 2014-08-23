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
class Visitors_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }   
    
    //------------------Page visitor module--------------------------
    public function get_page_visitor_list($page_id = 0, $user_id = 0)
    {
        if($page_id != 0)
        {
            $this->db->where('page_id', $page_id);
        }
        if($user_id != 0)
        {
            $this->db->where('user_id', $user_id);
        }
        $this->response = $this->db->select('*')
                ->from($this->tables['page_visitor'])
                ->get();
        return $this;
    }
    
    public function add_page_visitor($page_id, $user_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'page_id' => $page_id,
            'user_id' => $user_id,
            'created_on' => $current_time,
            'modified_on' => $current_time
        );
        $page_visitor_data = array_merge($this->_filter_data($this->tables['page_visitor'], $additional_data), $data);
        $this->db->insert($this->tables['page_visitor'], $page_visitor_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_page_visitor($page_id, $user_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'modified_on' => $current_time
        );
        $page_visitor_data = array_merge($this->_filter_data($this->tables['page_visitor'], $additional_data), $data);
        $this->db->where('page_id', $page_id);
        $this->db->where('user_id', $user_id);
        $this->db->update($this->tables['page_visitor'], $page_visitor_data);
    }
    //-------------------Application visitor module-----------------------
    public function get_application_visitor_list($application_id = 0, $user_id = 0)
    {
        if($application_id != 0)
        {
            $this->db->where('application_id', $application_id);
        }
        if($user_id != 0)
        {
            $this->db->where('user_id', $user_id);
        }
        $this->response = $this->db->select('*')
                ->from($this->tables['application_visitor'])
                ->get();
        return $this;
    }
    
    public function add_application_visitor($application_id, $user_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'application_id' => $application_id,
            'user_id' => $user_id,
            'created_on' => $current_time,
            'modified_on' => $current_time
        );
        $application_visitor_data = array_merge($this->_filter_data($this->tables['application_visitor'], $additional_data), $data);
        $this->db->insert($this->tables['application_visitor'], $application_visitor_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_application_visitor($application_id, $user_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'modified_on' => $current_time
        );
        $application_visitor_data = array_merge($this->_filter_data($this->tables['application_visitor'], $additional_data), $data);
        $this->db->where('application_id', $application_id);
        $this->db->where('user_id', $user_id);
        $this->db->update($this->tables['application_visitor'], $application_visitor_data);
    }
    
    //-----------------Business profile visitor module-------------------------
    public function get_business_profile_visitor_list($business_profile_id = 0, $user_id = 0)
    {
        if($business_profile_id != 0)
        {
            $this->db->where('business_profile_id', $business_profile_id);
        }
        if($user_id != 0)
        {
            $this->db->where('user_id', $user_id);
        }
        $this->response = $this->db->select('*')
                ->from($this->tables['business_profile_visitor'])
                ->get();
        return $this;
    }
    public function add_business_profile_visitor($business_profile_id, $user_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'business_profile_id' => $business_profile_id,
            'user_id' => $user_id,
            'created_on' => $current_time,
            'modified_on' => $current_time
        );
        $business_profile_visitor_data = array_merge($this->_filter_data($this->tables['business_profile_visitor'], $additional_data), $data);
        $this->db->insert($this->tables['business_profile_visitor'], $business_profile_visitor_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    public function update_business_profile_visitor($business_profile_id, $user_id, $additional_data)
    {
        $current_time = now();
        $data = array(
            'modified_on' => $current_time
        );
        $business_profile_visitor_data = array_merge($this->_filter_data($this->tables['business_profile_visitor'], $additional_data), $data);
        $this->db->where('business_profile_id', $business_profile_id);
        $this->db->where('user_id', $user_id);
        $this->db->update($this->tables['business_profile_visitor'], $business_profile_visitor_data);
    }
}
?>
