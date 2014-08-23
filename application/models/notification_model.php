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
class Notification_model extends Ion_auth_model {
    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->current_user_id = $this->ion_auth->get_user_id();
    }

    public function get_notification_types(){
        $query = $this->db->select('*')
                          ->get($this->tables['notification_types']);
        return $query -> result();
    }
    
    public function get_user_notification($user_id = 0){
        if($user_id == 0){
            $user_id = $this->current_user_id;
        }
        
        $query = $this->db->select("*")
                          ->where('user_id', $user_id)
                          ->get($this->tables['users_notifications']);
        if($query ->num_rows() > 0){
            $result = $query -> row();
        
            return json_decode($result -> notifications);
        }
        else{
            return null;
        }
    }
    
    /*
     * param notifications should be an array
     * and key sould be prefix notification_ and the notificaiton value
     * example: array('notificaion_1' => 'on');
     */
    public function set_user_notification($notifications, $user_id = 0){
        if($user_id == 0){
            $user_id = $this->current_user_id;
        }
        $json_encoded_notifications = json_encode($notifications);
        $data = array('user_id' => $user_id, 'notifications' => $json_encoded_notifications);
        if( $this->get_user_notification($user_id) == null){
            /*
             * No notifations are available
             * so we need to insert new notification
             */
            $this->db->insert($this->tables['users_notifications'], $data);
            return $this->db->insert_id() >= 0;
        }
        else{
            /**
             * Notifications exists in database but we need to clear
             * all notifaciton
             */
            if(empty($notifications)){
                $this->db->where(array('user_id' => $user_id));
                return $this->db->delete($this->tables['users_notifications']);
            }
            else{
                /**
                * Notifications exists in database need to update
                */
                $this->db->update($this->tables['users_notifications'], $data, array('user_id' => $user_id));
                return $this->db->affected_rows() == 1;
            }
        }
    }
}