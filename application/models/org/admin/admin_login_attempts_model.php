<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin login attemts model
 * Author:  Nazmul on 25th January 2015
 * Requirements: PHP5 or above
 *
 */
class Admin_login_attempts_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return all login attempts
     * @Author Nazmul on 25th January 2015
     */
    public function get_all_login_attempts()
    {
          return $this->db->select($this->tables['login_attempts'].'.*')
                    ->from($this->tables['login_attempts'])
                    ->get(); 
    }
    
    /*
     * This method will delete login attemtps
     * @param $id, login attemtps id
     * @Author Nazmul on 25th January 2015
     */
    public function delete_login_attempt($delete_id)
    {
     if(!isset($delete_id) || $delete_id <= 0)
        {
            $this->set_error('delete_login_attempt_fail');
            return FALSE;
        }
        $this->db->where('id', $delete_id);
        $this->db->delete($this->tables['login_attempts']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_login_attempts_fail');
            return FALSE;
        }
        $this->set_message('delete_login_attempts_successful');
        return TRUE;   
    }
}
