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
class Admin_application_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    } 
    
    public function get_all_applications()
    {
        return $this->db->select('*')
                    ->from($this->tables['applications'])
                    ->get();
    }
    
    public function get_healthy_recipes_user_counter_comments()
    {
        $this->db->group_by('gender_id');
        return $this->db->select($this->tables['basic_profile'].".gender_id, count(DISTINCT ".$this->tables['basic_profile'].'.user_id) as total_users')
                    ->from($this->tables['recipe_comments'])
                    ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['recipe_comments'].'.user_id')
                    ->get();
    }
    
    public function get_services_user_counter_comments()
    {
        $this->db->group_by('gender_id');
        return $this->db->select($this->tables['basic_profile'].".gender_id, count(DISTINCT ".$this->tables['basic_profile'].'.user_id) as total_users')
                    ->from($this->tables['service_comments'])
                    ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['service_comments'].'.user_id')
                    ->get();
    }
    public function get_news_user_counter_comments()
    {
        $this->db->group_by('gender_id');
        return $this->db->select($this->tables['basic_profile'].".gender_id, count(DISTINCT ".$this->tables['basic_profile'].'.user_id) as total_users')
                    ->from($this->tables['news_comments'])
                    ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['news_comments'].'.user_id')
                    ->get();
    }
    public function get_blogs_user_counter_comments()
    {
        $this->db->group_by('gender_id');
        return $this->db->select($this->tables['basic_profile'].".gender_id, count(DISTINCT ".$this->tables['basic_profile'].'.user_id) as total_users')
                    ->from($this->tables['blog_comments'])
                    ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['blog_comments'].'.user_id')
                    ->get();
    }
    
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
    
    public function get_user_info($id)
    {
        $this->db->where($this->tables['users'].'.id',$id);
        
        return $this->db->select($this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['users'])
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();
    }
    
}
