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
class Tempdatabase_model extends Ion_auth_model {
    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->current_user_id = $this->ion_auth->get_user_id();
    }
    public function create_feedback_table($comment_id, $status_id){
        if($comment_id == 0 && $status_id == 0){
            return FALSE;
        }

        $query = "DROP TEMPORARY TABLE IF EXISTS `temp_users_feedback`;";
        $this->db->query($query);
        
        $query = "CREATE TEMPORARY TABLE temp_users_feedback(
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) UNSIGNED NOT NULL,
	`description` TEXT,
        `created_date` int(11) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`)
        );";
        
        $this->db->query($query);
        if($comment_id){
            $query = $this->db->select("*")
                  ->where("id", $comment_id)
                  ->limit(1)
                  ->get("users_comments");
        }
        if($status_id){
            $query = $this->db->select("*")
                  ->where("id", $status_id)
                  ->limit(1)
                  ->get("users_statuses");
        }
        $feedbacks = array();
        if($query->num_rows() > 0){
            $user_feedbacks = $query -> row();
            $feedbacks = json_decode($user_feedbacks->feedbacks);
        }
        if(count($feedbacks) > 1){
            $feedback_lists = array();
            foreach ($feedbacks as $fback){
                $feedback_lists[] = get_object_vars($fback);
            }
            $this->db->insert_batch("temp_users_feedback", $feedback_lists);
        }else if(count($feedbacks) == 1){
            $this->db->insert("temp_users_feedback", $feedbacks[0]);
        }
    }
    
    public function add_feedback($comment_id, $status_id, $feedback){
        $this->create_feedback_table($comment_id, $status_id);
        $this->db->insert("temp_users_feedback", array("user_id" => $this->current_user_id, "description" => $feedback, 'created_date' => time()));
        
         $query = $this->db->select("*")
                              ->get("temp_users_feedback");
        if($comment_id){
            $this->db->update("users_comments", array("feedbacks"=>json_encode($query->result())), array('id' => $comment_id));
        }
        else{
            $this->db->update("users_statuses", array("feedbacks"=> json_encode($query->result())), array('id' => $status_id));
        }
    }
    
    public function get_feedbacks($comment_id, $status_id){
        $this->create_feedback_table($comment_id, $status_id);
        $query = $this->db->select("first_name, last_name, photo, description, created_date as feedback_created_date, temp_users_feedback.user_id as user_id")
                            ->join('basic_profile', "basic_profile.user_id = temp_users_feedback.user_id")
                            ->join('users', "users.id = temp_users_feedback.user_id")
                            ->get("temp_users_feedback");
        return $query->result();
    }
    
    public function create_followers($user_id){
        $query = "DROP TEMPORARY TABLE IF EXISTS `temp_mutual_realations`;";
        $this->db->query($query);
        
        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS `temp_mutual_realations` (" .
                 "`id` int(11) unsigned NOT NULL AUTO_INCREMENT," .
                 "`user_id` int(11) unsigned NOT NULL,".
                 "`is_pending` boolean default false,".
                 "`is_follower` boolean default false,".
                 "`time` int(11) unsigned DEFAULT NULL,".
                 "PRIMARY KEY (`id`),".
                 "UNIQUE KEY(`user_id`)".
                 ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
        $this->db->query($query);

        $query = $this->db->select("*")
              ->where("user_id", $user_id)
              ->limit(1)
              ->get($this->tables["usres_mutual_relations"]);

        $relations = array();
        if($query->num_rows() > 0){
            $user_relations = $query -> row();
            $relations = json_decode($user_relations->relations);
        }
        if(count($relations) > 1){
            $relation_lists = array();
            foreach ($relations as $relation){
                $relation_lists[] = get_object_vars($relation);
            }
            $this->db->insert_batch("temp_mutual_realations", $relation_lists);
        }else if(count($relations) == 1){
            
            $this->db->insert("temp_mutual_realations", $relations[0]);
        }
    }
    
    public function add_relation($data, $user_id){
        $query = $this->db->select("*")
                      ->where("user_id", $user_id)
                      ->get($this->tables["usres_mutual_relations"]);
        
        if($query -> num_rows() <= 0){
            $query = $this->db->insert($this->tables["usres_mutual_relations"], array('user_id'=> $user_id));
        }

        $this->db->insert("temp_mutual_realations", $data);
        return $this->transfer_temp_relation($user_id) >= 0;
    }
    public function update_relation($data, $user_id, $follower_id){
        $query = $this->db->select("*")
                      ->where("user_id", $user_id)
                      ->get($this->tables["usres_mutual_relations"]);
        
        if($query -> num_rows() <= 0){
            $query = $this->db->insert($this->tables["usres_mutual_relations"], array('user_id'=> $user_id));
        }

        $this->db->update("temp_mutual_realations", $data, array('user_id' => $follower_id));
        return $this->transfer_temp_relation($user_id) >= 0;
    }
    
    public function remove_relation($user_id, $follower_id){
        $this->db->delete("temp_mutual_realations", array('user_id' => $follower_id));
        return $this->transfer_temp_relation($user_id) >= 0;
    }
    
    private function transfer_temp_relation($user_id){
        $query = $this->db->select("*")
                          ->get("temp_mutual_realations");
        $this->db->update($this->tables["usres_mutual_relations"], array("relations" => json_encode($query -> result())), array("user_id" => $user_id));
        return $this->db->affected_rows();
    }
}
?>
