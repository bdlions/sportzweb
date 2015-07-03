<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Recent Activities Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Recent_activities_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_user_mutual_relation_info($user_id)
    {
        $this->db->where('user_id',$user_id);
        return $this->db->select('*')
                  ->from($this->tables['usres_mutual_relations'])
                  ->get();
    }
    /*
     * This method will return user info with basic profile info
     * @param $user_id_list, list of user ids
     * @Author Nazmul on 5th May 2014
     */
    public function get_users($user_id_list)
    {
        $this->db->where_in($this->tables['users'].'.id',$user_id_list);
        $result = $this->db->select($this->tables['users'] . '.id as user_id,'.$this->tables['users'] . '.*,'.$this->tables['basic_profile'] . '.*')
                ->from($this->tables['users'])
                ->join($this->tables['basic_profile'], $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                ->get();
        return $result;
    }
    
    public function get_status($follower_id_list)
    {
        $this->db->where($this->tables['statuses'].'.status_category_id',STATUS_LIST_USER_PROFILE);
        $this->db->where_in($this->tables['statuses'].'.user_id',$follower_id_list);
        $this->db->order_by($this->tables['statuses'].'.id', 'desc');
        return $this->db->select('*')
                  ->from($this->tables['statuses'])
                  ->limit(1)
                  ->get();
    }
    
    public function get_connections()
    {
        $this->db->order_by($this->tables['users'].'.id', 'desc');
        return $this->db->select($this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                  ->from($this->tables['users'])
                  ->join($this->tables['basic_profile'], $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                  ->limit(1)
                  ->get();
    }
    public function get_recent_statuses($follower_id_list)
    {
        $this->db->order_by($this->tables['statuses'].'.modified_on', 'desc');
        $this->db->where_in($this->tables['statuses'].'.user_id',$follower_id_list);
        $result = $this->db->select('*')
                ->from($this->tables['statuses'])
                ->get();
        return $result;
    }       
}
?>
