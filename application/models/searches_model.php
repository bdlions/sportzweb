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
class Searches_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }  
    
    public function get_healthy_recipes($search_value)
    {
        $like = "(title LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->response = $this->db->get($this->tables['recipes']);
        return $this;
    }
    
    public function get_services($search_value)
    {
        $like = "(name LIKE '%".$search_value."%' OR title LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->response = $this->db->get($this->tables['services']);
        return $this;
    }
    
    public function get_news($search_value)
    {
        $like = "(headline LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->response = $this->db->get($this->tables['news']);
        return $this;
    }
    
    public function get_blogs($search_value)
    {
        $like = "(title LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->response = $this->db->get($this->tables['blogs']);
        return $this;
    }
}
?>
