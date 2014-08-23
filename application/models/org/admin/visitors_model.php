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
            $this->db->where($this->tables['page_visitor'].'.user_id', $user_id);
        }
        $this->response = $this->db->select($this->tables['page_visitor'].'.*,'.$this->tables['pages'].'.title')
                ->from($this->tables['page_visitor'])
                ->join($this->tables['pages'],  $this->tables['page_visitor'].'.page_id='.$this->tables['pages'].'.id')
                ->get();
        return $this;
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
            $this->db->where($this->tables['application_visitor'].'.user_id', $user_id);
        }
        $this->response = $this->db->select($this->tables['application_visitor'].'.*,'.$this->tables['applications'].'.title')
                ->from($this->tables['application_visitor'])
                ->join($this->tables['applications'],  $this->tables['application_visitor'].'.application_id='.$this->tables['applications'].'.id')
                ->get();
        return $this;
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
            $this->db->where($this->tables['business_profile_visitor'].'.user_id', $user_id);
        }
        $this->response = $this->db->select($this->tables['business_profile_visitor'].'.*,'.$this->tables['business_profile'].'.business_name')
                ->from($this->tables['business_profile_visitor'])
                ->join($this->tables['business_profile'],  $this->tables['business_profile_visitor'].'.business_profile_id='.$this->tables['business_profile'].'.id')
                ->get();
        
        return $this;
    }
    
    public function get_all_pages()
    {
        return $this->db->select("*")
                    ->from($this->tables['pages'])
                    ->get();
    }
    
    public function get_all_applications()
    {
        return $this->db->select("*")
                    ->from($this->tables['applications'])
                    ->get();
    }
    
    public function get_all_business_profile()
    {
        return $this->db->select("*")
                    ->from($this->tables['business_profile'])
                    ->get();
    }
    
    public function get_page_visitors()
    {
        $this->db->group_by($this->tables['page_visitor'].'.page_id');
        $this->db->group_by($this->tables['basic_profile'].'.gender_id');
        return $this->db->select($this->tables['page_visitor'].".page_id,".$this->tables['pages'].".title,".$this->tables['basic_profile'].".gender_id, count(".$this->tables['basic_profile'].'.user_id) as total_users')
                    ->from($this->tables['page_visitor'])
                    ->join($this->tables['basic_profile'],  $this->tables['basic_profile'].'.user_id='.$this->tables['page_visitor'].'.user_id')
                    ->join($this->tables['pages'],  $this->tables['pages'].'.id='.$this->tables['page_visitor'].'.page_id')
                    ->get();
    }
}
?>
