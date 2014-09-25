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
class User_rpc_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getALlUsers() {
        $this->db->order_by('id', 'desc');
        return $this->db->select("*")
                    ->from($this->tables['users'])
                    ->get();
    }
    
    public function user_registration($data) {
        $data = $this->_filter_data($this->tables['users'], $data);

        $this->db->insert($this->tables['users'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)? $id: False;
    }
    
     //check email address exist or not
    public function checkEmail($email) {
        $query = $this->db->query("SELECT * FROM `users` WHERE email = '$email' ");
        
        if ($query->num_rows() > 0){
            return TRUE;
        }else {
            return FALSE;
        }
    }
    
    // Notification number
    public function generateAccessToken($id) {
        $randomNumber = rand(1, 9999999);
        $time = time();
        $accessToken = md5($randomNumber . $time);

        $data = array(
            'salt' => $accessToken,
            'last_login' => $time
        );

        $this->db->where(array('id' => $id));
        if ($this->db->update('users', $data)){
            return $accessToken;
        } else {
            return FALSE;
        }
    }
    
    // signin
    public function signin($email,$password) {
        $data = array(
            'email' => trim($email),
            'password' => sha1($password)
        );

        $query = $this->db->get_where('users', $data);
        //echo $this->db->last_query();exit('sss');
        if ($query->num_rows() > 0){
            return $query->row();
        } else{
            return "ZERO";
        }
            
    }
}