<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Contact Us Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Contact_us_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return all topics 
     * @Author Nazmul on 14th October 2014
     */
    public function get_all_topics()
    {
        return $this->db->select('*')
                ->from($this->tables['footer_cu_topics'])
                ->get();
    }
    
    /*
     * This method will return all operating systems 
     * @Author Nazmul on 14th October 2014
     */
    public function get_all_operating_systems()
    {
        return $this->db->select('*')
                ->from($this->tables['footer_cu_operating_systems'])
                ->get();
    }
    
    /*
     * This method will return all browers 
     * @Author Nazmul on 14th October 2014
     */
    public function get_all_browers()
    {
        return $this->db->select('*')
                ->from($this->tables['footer_cu_browsers'])
                ->get();
    }
    
    /*
     * This method will add a new feedback 
     * @Author Nazmul on 14th October 2014
     */
    public function add_feedback($additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_cu_feedbacks'], $additional_data);
        $this->db->insert($this->tables['footer_cu_feedbacks'], $data);
    }
    
}
