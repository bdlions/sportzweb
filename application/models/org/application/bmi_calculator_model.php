<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Blog App Model
 *
 * Author:  Redwan Khaled
 *
 *
 * Requirements: PHP5 or above
 *
 */

class Bmi_calculator_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 
     * @param type $question_id
     * @return type full question info based on the param
     * otherwise return type will be empty
     */
    public function get_question_info($question_id)
    {
        
    }
    
    /**
     * 
     * @param type $date
     * Will return  the latest configured list <= date
     */
    public function get_homepage_question_list_configuration($date)
    {
        $this->db->where('selected_date <=', $date);
        
        return $this->db->select('*')
                    ->from($this->tables['bmi_home_page_configuration'])
                    ->order_by('id','desc')
                    ->limit(1)
                    ->get();
    }
    
    /**
     * 
     * @param type $question_id_list
     * Return all question based on the question_id_list
     * Otherwise empty object
     */
    public function get_question_list($question_id_list = array())
    {
        $this->db->where_in('id',$question_id_list);
        
        return $this->db->select('*')
                    ->from($this->tables['bmi_questions'])
                    ->get();
    }
    
    /**
     * Will return  3 random question from the database table
     */
    public function get_initial_homepage_question_list()
    {
        return $this->db->select('*')
                    ->from($this->tables['bmi_questions'])
                    ->limit(3)
                    ->get();
    }
    
}
