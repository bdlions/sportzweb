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
class Follower_model extends Ion_auth_model {
    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->current_user_id = $this->ion_auth->get_user_id();
        $this->load->model('tempdatabase_model');
    }
    
    public function get_types(){
        $query = $this->db->select("*")
                          ->get($this->tables['following_acceptance_types']);
        return $query -> result();
    }
    
    private function get_default_acceptance_type(){
        $query = $this->db->select("value, description")
                          ->where('is_default_type', true)
                          ->get($this->tables['following_acceptance_types']);
        return $query->row();
    }
    
    public function get_acceptance_type($user_id = 0){
        if($user_id == 0){
            $user_id = $this->current_user_id;
        }
        $query = $this->db->select($this->tables['following_acceptance_types'].".id as value, ".$this->tables['following_acceptance_types'].".description as description")
                          ->where('user_id', $user_id)
                          ->join($this->tables['following_acceptance_types'], $this->tables['following_acceptance_types'] . '.id'. '=' . $this->tables['usres_following_acceptance'] . '.following_acceptance_type')
                          ->get($this->tables['usres_following_acceptance']);
        if($query -> num_rows() <= 0){
            return $this->get_default_acceptance_type();
        }
        else{
            return $query -> row(); 
        }
    }
    
    public function set_acceptance_type($acceptance_type, $user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->current_user_id;
        }
        $query = $this->db->select('*')
                ->where('user_id', $user_id)
                ->get($this->tables['usres_following_acceptance']);

        $data = array('following_acceptance_type' => $acceptance_type, 'user_id' => $user_id);
        
        if ($query->num_rows() <= 0) {
            $this->db->insert($this->tables['usres_following_acceptance'], $data);
            return $this->db->insert_id() >= 0;
        } else {
            $this->db->update($this->tables['usres_following_acceptance'], $data, array('user_id' => $user_id));
            return $this->db->affected_rows() == 1;
        }
    }
    
    public function follow_user($follower_id){
        /*add follower for current user*/
        if($this->get_acceptance_type($follower_id)->value == FOLLOWER_ACCEPTANCE_TYPE_MANUAL){
            $this->tempdatabase_model->create_followers($follower_id);
            $data = array('user_id' => $this->current_user_id, 'is_pending' => TRUE, 'time' => now());
            return $this->tempdatabase_model->add_relation($data, $follower_id);
        }else{
            $this->tempdatabase_model->create_followers($this->current_user_id);
            $data = array('user_id' => $follower_id, 'is_follower' => TRUE, 'time' => now());
            if($this->tempdatabase_model->add_relation($data, $this->current_user_id) == true){
                /*add follower to the follower user*/
                $this->tempdatabase_model->create_followers($follower_id);
                $data = array('user_id' => $this->current_user_id, 'is_follower' => TRUE, 'time' => now());
                return $this->tempdatabase_model->add_relation($data, $follower_id);
            }
        }
        return false;
        
    }
    
    public function unfollow_user($follower_id){
        $this->tempdatabase_model->create_followers($this->current_user_id);
        if($this->tempdatabase_model->remove_relation( $this->current_user_id, $follower_id) == true){
            $this->tempdatabase_model->create_followers($follower_id);
            return $this->tempdatabase_model->remove_relation($follower_id, $this->current_user_id);
        }
    }
    
    public function accept_request($follower_id){
        $this->tempdatabase_model->create_followers($this->current_user_id);
        $data = array('user_id' => $follower_id, 'is_follower' => TRUE, 'is_pending' => FALSE);
        if($this->tempdatabase_model->update_relation($data, $this->current_user_id, $follower_id) == true){
            /*add follower to the follower user*/
            $this->tempdatabase_model->create_followers($follower_id);
            $data = array('user_id' => $this->current_user_id, 'is_follower' => TRUE ,'is_pending' => FALSE);
            return $this->tempdatabase_model->add_relation($data, $follower_id);
        }
    }
    
    public function is_follower($follower_id){
        $this->tempdatabase_model->create_followers($this->current_user_id);
        $query = $this->db->select("*")
                          ->where("user_id", $follower_id)
                          ->where("is_follower", TRUE)
                          ->get("temp_mutual_realations");
        return $query -> num_rows() >= 1;
    }
    public function is_follower_pending($follower_id){
        $this->tempdatabase_model->create_followers($follower_id);
        $query = $this->db->select("*")
                          ->where("user_id", $this->current_user_id)
                          ->where("is_pending", TRUE)
                          ->get("temp_mutual_realations");
        return $query -> num_rows() >= 1;
    }
    public function is_follower_blocked($follower_id){
        $this->tempdatabase_model->create_followers($this->current_user_id);
        $query = $this->db->select("*")
                          ->where("user_id", $follower_id)
                          ->where("is_blocked", TRUE)
                          ->get("temp_mutual_realations");
        return $query -> num_rows() >= 1;
    }
    public function is_follower_reported($follower_id){
        $this->tempdatabase_model->create_followers($this->current_user_id);
        $query = $this->db->select("*")
                          ->where("user_id", $follower_id)
                          ->where("is_reported", TRUE)
                          ->get("temp_mutual_realations");
        return $query -> num_rows() >= 1;
    }
    public function get_followers($user_id = 0){
        if($user_id == 0){
            $user_id = $this->current_user_id;
        }
        $this->tempdatabase_model->create_followers($user_id);
        $query = $this->db->select("first_name, last_name, (FROM_UNIXTIME(`last_activity`) > (NOW() - INTERVAL 1 MINUTE)) as online_status, ". $this->tables["basic_profile"]. ".*, temp_mutual_realations.user_id as follower_id, ".$this->tables["usres_mutual_relations"].".relations")
                          ->where("is_follower", TRUE)
                          ->join($this->tables["basic_profile"], $this->tables["basic_profile"].".user_id = "."temp_mutual_realations".".user_id")
                          ->join($this->tables["users"], $this->tables["users"].".id = "."temp_mutual_realations".".user_id")
                          ->join($this->tables["usres_mutual_relations"], $this->tables["usres_mutual_relations"].".user_id="."temp_mutual_realations".".user_id")
                          ->get("temp_mutual_realations");
        //print_r($query->result());
        return $query -> result();
    }
    public function get_pending_followers(){
        $this->tempdatabase_model->create_followers($this->current_user_id);
        $query = $this->db->select("*")
                          ->where("is_pending", TRUE)
                          ->join($this->tables["basic_profile"], $this->tables["basic_profile"].".user_id = "."temp_mutual_realations".".user_id")
                          ->join($this->tables["users"], $this->tables["users"].".id = "."temp_mutual_realations".".user_id")
                          ->join($this->tables["usres_mutual_relations"], $this->tables["usres_mutual_relations"].".user_id="."temp_mutual_realations".".user_id")
                          ->get("temp_mutual_realations");
        return $query -> result();
    }
}
?>
