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

    public function get_notification_types() {
        $query = $this->db->select('*')
                ->get($this->tables['notification_types']);
        return $query->result();
    }

    public function get_user_notification($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->current_user_id;
        }

        $query = $this->db->select("*")
                ->where('user_id', $user_id)
                ->get($this->tables['users_notifications']);
        if ($query->num_rows() > 0) {
            $result = $query->row();

            return json_decode($result->notifications);
        } else {
            return null;
        }
    }

    /*
     * param notifications should be an array
     * and key sould be prefix notification_ and the notificaiton value
     * example: array('notificaion_1' => 'on');
     */

    public function set_user_notification($notifications, $user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->current_user_id;
        }
        $json_encoded_notifications = json_encode($notifications);
        $data = array('user_id' => $user_id, 'notifications' => $json_encoded_notifications);
        if ($this->get_user_notification($user_id) == null) {
            /*
             * No notifations are available
             * so we need to insert new notification
             */
            $this->db->insert($this->tables['users_notifications'], $data);
            return $this->db->insert_id() >= 0;
        } else {
            /**
             * Notifications exists in database but we need to clear
             * all notifaciton
             */
            if (empty($notifications)) {
                $this->db->where(array('user_id' => $user_id));
                return $this->db->delete($this->tables['users_notifications']);
            } else {
                /**
                 * Notifications exists in database need to update
                 */
                $this->db->update($this->tables['users_notifications'], $data, array('user_id' => $user_id));
                return $this->db->affected_rows() == 1;
            }
        }
    }
    /*
     * This add notification
     * Parameter  notification list array and user id
     * @Author Rashida on 13th April 2015
     */
    public function add_notification($user_id,$new_notification_list) {
        if ($user_id != 0) {
            $new_notification_list = $this->_filter_data($this->tables['notification_list'], $new_notification_list);
            $this->db->insert($this->tables['notification_list'], $new_notification_list);
            return $insert_id = $this->db->insert_id();
        }
    }
    /*
     * This update notification
     * Parameter  notification list array and user id
     * @Author Rashida on 13th April 2015
     */
    public function update_notification($user_id, $new_notification_list)
    {
        $this->db->where('user_id', $user_id);
        $new_notification_list = $this->_filter_data($this->tables['notification_list'], $new_notification_list);
        return $this->db->update($this->tables['notification_list'], $new_notification_list);
        
    }
    /*
     * This method will return notification list
     * Parameter user id
     * @Author Rashida on 13th April 2015
     */

   public function get_notification_list($user_id = 0) {
        $this->db->where('user_id', $user_id);
        return $this->db->select($this->tables['notification_list'] . ".*")
                        ->get($this->tables['notification_list']);
    }
    
//   public function get_all_notification_list($user_id = 0) {
////        $this->db->order_by($this->tables['notification_list'].'.created_on','asc');
//        $this->db->where('user_id', $user_id);
//        return $this->db->select($this->tables['notification_list'] . ".*")
//                        ->get($this->tables['notification_list']);
//    }

}
