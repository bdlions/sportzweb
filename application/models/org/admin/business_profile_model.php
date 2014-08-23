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
class Business_profile_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }   
    
    public function get_business_profile_connection_list($business_profile_id=0)
    {
        if($business_profile_id!=0)
        {
            $this->db->where($this->tables['business_profile_connection'].'.business_profile_id',$business_profile_id);
        }
        $this->response = $this->db->select('*')
                ->from($this->tables['business_profile_connection'])
                ->get();
        return $this;
    }
    
    public function get_all_business_profile_list()
    {
        
        return $this->db->select("*")
                    ->from($this->tables['business_profile'])
                    ->get();
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
?>
