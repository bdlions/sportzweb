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
class Collaborator_model extends Ion_auth_model {
    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        $this->current_user_id = $this->ion_auth->get_user_id();
    }
    
    public function get_types(){
        $query = $this->db->select("*")
                          ->get($this->tables['collaborator_types']);
        return $query -> result();
    }
}
?>
