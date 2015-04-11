<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Application Directory Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Application_directory_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }

    public function test() {
        echo "application directory model";
    }

    /*
     * This method will return all applications for application directory feature
     * @Author Nazmul on 11th October 2014
     *
     */

    public function get_all_applications() {
        return $this->db->select("*")
                        ->from($this->tables['application_directory'])
                        ->order_by('applications_order', 'asc')
                        ->get();
    }

    public function get_user_basic_profile($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->where('user_id', $user_id);
        return $this->db->select("*")
                        ->from($this->tables['basic_profile'])
                        ->get();
    }

    public function update_user_basic_profile($user_id, $additional_data) {
        $data = $this->_filter_data($this->tables['basic_profile'], $additional_data);
        $this->db->update($this->tables['basic_profile'], $data, array('user_id' => $user_id));
    }

}
