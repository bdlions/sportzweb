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
class User_logs_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_user_log_list($user_id = 0, $date = 0)
    {
        if($user_id != 0)
        {
            $this->db->where('user_id', $user_id);
        }
        if($date != 0)
        {
            $this->db->where('date', $date);
        }
        $this->response = $this->db->select('*')
                ->from($this->tables['user_log'])
                ->get();
        return $this;
        
    }
    
    public function add_user_log($user_id, $date, $additional_data)
    {
        $current_time = now();
        $data = array(
            'user_id' => $user_id,
            'date' => $date,
            'created_on' => $current_time,
            'modified_on' => $current_time
        );
        $user_log_data = array_merge($this->_filter_data($this->tables['user_log'], $additional_data), $data);
        $this->db->insert($this->tables['user_log'], $user_log_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_user_log($user_id, $date, $additional_data)
    {
        $current_time = now();
        $data = array(
            'modified_on' => $current_time
        );
        $user_log_data = array_merge($this->_filter_data($this->tables['user_log'], $additional_data), $data);
        $this->db->where('user_id', $user_id);
        $this->db->where('date', $date);        
        $this->db->update($this->tables['user_log'], $user_log_data);
    }
    
    public function get_total_user_log_by_day($date=0)
    {
        if($date!=0)
        {
            $this->db->where('date',$date);
        }
        return $this->db->select($this->tables['user_log'].'.*,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['user_log'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['user_log'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['basic_profile'].'.user_id='.$this->tables['user_log'].'.user_id')
                    ->get();
    }
    
    public function get_total_user_log_by_this_week($date)
    {
        $this->db->where('date >=',$date);
        $this->db->group_by($this->tables['user_log'].'.user_id');
        
        return $this->db->select($this->tables['user_log'].'.*,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['user_log'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['user_log'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['basic_profile'].'.user_id='.$this->tables['user_log'].'.user_id')
                    ->get();
    }
    
    public function get_total_user_log_between_dates($date1,$date2)
    {
        
        $this->db->where($this->tables['user_log'].'.date >=',$date1);
        $this->db->where($this->tables['user_log'].'.date <',$date2);
        $this->db->group_by($this->tables['user_log'].'.user_id');
        
        return $this->db->select($this->tables['user_log'].'.*,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['user_log'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['user_log'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['basic_profile'].'.user_id='.$this->tables['user_log'].'.user_id')
                    ->get();
    }

}
?>
