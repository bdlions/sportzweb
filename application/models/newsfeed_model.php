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
class NewsFeed_model extends Ion_auth_model {
    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->load->model('tempdatabase_model');
        $this->load->model("users_album_model");
        $this->current_user_id = $this->ion_auth->get_user_id();
    }
    
    public function post_status($data, $additional_data = array(), $follower_id = 0){
        $user_id = $this->current_user_id;
       
        if($additional_data['album_id'] > 0)
            $this->db->update("users_albums", array('creation_complete'=> TRUE), array('id' => $additional_data['album_id']));
        
        $additional_data = array_merge($additional_data, array("user_id" => $user_id, "status_date" => time(), "update_date" => time(), 'follower_id' => $follower_id));
        if($follower_id == 0 || $follower_id == $this->current_user_id){
            $data = array_merge($this->_filter_data($this->tables['users_statuses'], $additional_data), $this->_filter_data($this->tables['users_statuses'], $data));
            $this->db->insert($this->tables['users_statuses'], $data);
            if( $this->db->insert_id()){
                $statuses = $this->get_statuses($data['status_in'], 1);
                return $statuses[0];
            }
            else{
                return FALSE;
            }
        }
        else{
            $data = array_merge($this->_filter_data($this->tables['users_comments'], $additional_data), $this->_filter_data($this->tables['users_statuses'], $data));
            $this->db->insert($this->tables['users_comments'], $data);
            if( $this->db->insert_id()){
                $statuses = $this->get_statuses($data['status_in'], 1);
                return $statuses[0];
            }
            else{
                return FALSE;
            }
        }
    }
    
    public function get_statuses($posted_in = STATUS_POSTED_IN_WALL, $limit = 8, $start_index = 0 , $user_id = 0){
        if($user_id == 0){
            $user_id = $this->current_user_id;
        }
        $post_places = "(1)";
        if($posted_in == STATUS_POSTED_IN_WALL){
            //$post_places = array_merge($post_places, array(STATUS_POSTED_IN_BASIC_PROFILE, STATUS_POSTED_IN_BUSINESS_PROFILE, STATUS_POSTED_IN_WALL));
            $post_places = "(1,2,3)";
        }
        else if($posted_in == STATUS_POSTED_IN_BUSINESS_PROFILE){
            $post_places = "(2)";
        }
        
        $this->tempdatabase_model->create_followers($user_id);

        //$query = $this->db->query("(SELECT users.id AS user_id, first_name, last_name, description, status_in, update_date, users.id AS follower_id , photo, users_statuses.id as status_id, 0 as comment_id FROM users JOIN (basic_profile JOIN users_statuses) ON ((users.id = basic_profile.user_id) AND (basic_profile.user_id = users_statuses.user_id)) WHERE users.id = {$user_id} AND users_statuses.status_in IN (1,2,3))");
        $query = $this->db->query("(SELECT users.id AS user_id, first_name, last_name, description, status_in, status_date as created_date, update_date, attachments, users.id AS follower_id , photo, users_statuses.id as status_id, 0 as comment_id FROM users JOIN (basic_profile JOIN users_statuses) ON ((users.id = basic_profile.user_id) AND (basic_profile.user_id = users_statuses.user_id)) WHERE users.id = {$user_id} AND users_statuses.status_in IN {$post_places}) 
                                    UNION (SELECT users.id AS user_id, first_name, last_name, description,  status_in, status_date as created_date, update_date, attachments, follower_id , photo, 0 as status_id, users_comments.id as comment_id FROM users JOIN (basic_profile JOIN users_comments) ON ((users.id = basic_profile.user_id) AND (basic_profile.user_id = users_comments.user_id)) WHERE users_comments.status_in IN {$post_places})
                                    UNION (SELECT users.id AS user_id, first_name, last_name, description, status_in, status_date as created_date, update_date, attachments, users.id AS follower_id , photo, users_statuses.id as status_id, 0 as comment_id FROM users JOIN (basic_profile JOIN users_statuses JOIN temp_mutual_realations) ON ((users.id = basic_profile.user_id) AND (basic_profile.user_id = users_statuses.user_id) AND (temp_mutual_realations.user_id = basic_profile.user_id))   WHERE users_statuses.status_in IN {$post_places})
                                    ORDER BY update_date DESC LIMIT {$start_index}, {$limit}");
        
        
        if($query -> num_rows() > 0){
            $statuses = $query ->result();
            foreach ($statuses as $status){
                $status->description = html_entity_decode($status->description);
                if($status -> attachments > 0){
                    $status -> attachments = $this->users_album_model->get_album_photos($status -> attachments);
                    //print_r($status -> attachments);
                }
                else{
                    $status -> attachments = array();
                }
                
                $status->feedbacks = $this->tempdatabase_model->get_feedbacks($status->comment_id, $status->status_id);
            }
            return $statuses;
        }
        else{
            return null;
        }
    }
    
    public function add_feedback($comment_id, $status_id, $feedback){
        return $this->tempdatabase_model->add_feedback($comment_id, $status_id, $feedback);
    }
}
?>
