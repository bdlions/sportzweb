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
class Users_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_users()
    {
        $this->db->where($this->tables['groups'].'.id', 3);
        $this->response = $this->db->select($this->tables['users'].'.*,'.$this->tables['users'].'.id as user_id')
                ->from($this->tables['users'])
                ->join($this->tables['users_groups'], $this->tables['users_groups'].'.user_id='.$this->tables['users'].'.id')
                ->join($this->tables['groups'], $this->tables['groups'].'.id='.$this->tables['users_groups'].'.group_id')
                ->get();
        return $this;
    }
    
    public function get_user_info($user_id)
    {
        $this->db->where($this->tables['users'].'.id', $user_id);
        $this->response = $this->db->select($this->tables['users'].'.*,'.$this->tables['users'].'.id as user_id,'.$this->tables['basic_profile'].'.*,'.$this->tables['business_profile'].'.*,'.$this->tables['countries'].'.*,'.$this->tables['gender'].'.*')
                ->from($this->tables['users'])
                ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['users'].'.id','left')
                ->join($this->tables['countries'], $this->tables['countries'].'.id='.$this->tables['basic_profile'].'.country_id')
                ->join($this->tables['gender'], $this->tables['gender'].'.id='.$this->tables['basic_profile'].'.gender_id')
                ->join($this->tables['business_profile'], $this->tables['business_profile'].'.user_id='.$this->tables['basic_profile'].'.user_id','left')
                ->get();
        return $this;
    }
    
    public function get_users_country($country_id_list = array(), $min_age = 0, $max_age = 0)
    {
        if($max_age != 0)
        {
            $start_date = date("Y-m-d", time() - 60 * 60 * 24 * 365 * $max_age);
            $end_date = date("Y-m-d", time() - 60 * 60 * 24 * 365 * $min_age);
            $this->db->where($this->tables['basic_profile'].'.dob >= ', $start_date);
            $this->db->where($this->tables['basic_profile'].'.dob <= ', $end_date);
        }
        
        $this->db->order_by($this->tables['countries'].'.country_name','asc');
        $this->db->group_by($this->tables['countries'].'.id');
        $this->db->group_by($this->tables['basic_profile'].'.gender_id');
        $this->db->where_in($this->tables['countries'].'.id', $country_id_list);
        //$this->db->where('DATEDIFF(basic_profile.dob, '.$current_date.') / 365.25 >', 0);
        $this->response = $this->db->select($this->tables['countries'].'.*,'.$this->tables['countries'].'.id as country_id,count('.$this->tables['basic_profile'].'.gender_id) as total_users,'.$this->tables['basic_profile'].'.gender_id')
                ->from($this->tables['users'])
                ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['users'].'.id')
                ->join($this->tables['countries'], $this->tables['countries'].'.id='.$this->tables['basic_profile'].'.country_id')
                ->get();
        return $this;
    }
    
    public function get_user_list($user_id_list)
    {
        $this->db->where_in($this->tables['users'].'.id', $user_id_list);
        $this->response = $this->db->select($this->tables['users'].'.*,'.$this->tables['users'].'.id as user_id,'.$this->tables['basic_profile'].'.*,'.$this->tables['gender'].'.*')
                ->from($this->tables['users'])
                ->join($this->tables['basic_profile'], $this->tables['basic_profile'].'.user_id='.$this->tables['users'].'.id','left')
                ->join($this->tables['gender'], $this->tables['gender'].'.id='.$this->tables['basic_profile'].'.gender_id')
                ->get();
        return $this;
    }
    
    public function get_user_mutual_relations($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->response = $this->db->select('*')
                ->from($this->tables['usres_mutual_relations'])
                ->get();
        return $this;
    }
    
    public function get_user_application_visitor_info($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->response = $this->db->select('*')
                ->from($this->tables['application_visitor'])
                ->join($this->tables['applications'], $this->tables['applications'].'.id='.$this->tables['application_visitor'].'.application_id')
                ->get();
        return $this;
    }
    
    public function get_users_messages($user_id)
    {
        $this->db->where('from', $user_id);
        $this->db->or_where('to', $user_id);
        $this->response = $this->db->select('*')
                ->from($this->tables['users_messages'])
                ->get();
        return $this;
    }
    
    public function get_user_conversation_messages($user_id, $message_user_id)
    {
        $this->db->where(array('from'=>$user_id,'to'=>$message_user_id));
        $this->db->or_where(array('from'=>$message_user_id,'to'=>$user_id));
        $this->response = $this->db->select($this->tables['users'].'.*,'.$this->tables['users_messages'].'.*')
                ->from($this->tables['users_messages'])
                ->join($this->tables['users'], $this->tables['users'].'.id='.$this->tables['users_messages'].'.from')
                ->get();
        return $this;
    }
}
