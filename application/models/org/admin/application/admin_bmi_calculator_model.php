<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Dataprovider Model
 * 
 * Author: Redwan
 * 
 * Requirement: PHP 5 and more
 */

class Admin_bmi_calculator_model extends Ion_auth_model
{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    /*
     * @param type question_id
     * This method will return question/answer based
     * on a question_id
     */
    public function get_question_info($question_id)
    {
        
        $this->db->where('id',$question_id);
        
        return $this->db->select("*")
                    ->from($this->tables['bmi_questions'])
                    ->get();
    }
    
    /*
     * @param type question_id_list
     * if question_id_list is empty then
     * this method will return all question
     * othewrwise,only questions based on the question_id_list
     */
    
    public function get_question_list($question_id_list=array())
    {
        if(!empty($question_id_list))
        {
            $this->db->where_in('id',$question_id_list);
        }
        
        return $this->db->select("*")
                    ->from($this->tables['bmi_questions'])
                    ->get();
    }
    
    /*
     * @param type data
     * This method will add question on database
     * Return question_id for success and FALSE for failure
     */
    public function add_question($data)
    {
        $data  = $this->_filter_data($this->tables['bmi_questions'], $data);
        
        $this->db->insert($this->tables['bmi_questions'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)?$id:FALSE;
    }
    
    /**
     * 
     * @param type $question_id
     * @param type $data
     * This method update a question info based on question_id 
     * Return TRUE for success and FALSE for failure
     */
    public function update_question($question_id,$data)
    {
        $data  = $this->_filter_data($this->tables['bmi_questions'], $data);
        
        $this->db->where('id',$question_id);
        
        $this->db->update($this->tables['bmi_questions'],$data);
        
        if($this->db->affected_rows()==0)
            return FALSE;
        
        return TRUE;
    }
    
    /*
     *@param type question_id
     * This will delete a question by question_id
     * Return TRUE for success and FALSE for failure 
     */
    
    public function delete_question($question_id)
    {
        $this->db->where('id',$question_id);
        
        $this->db->delete($this->tables['bmi_questions']);
        
        if($this->db->affected_rows()==0)
            return FALSE;
        
        return TRUE;
    }
    
    /*
     * @param type data
     * Will add homepage configuration
     * Return latest inserted id for success and FALSE for failure
     */
    public function add_homepage_question_list_configuration($data)
    {
        $data = $this->_filter_data($this->tables['bmi_home_page_configuration'], $data);
        
        $this->db->insert($this->tables['bmi_home_page_configuration'], $data);
        
        $id = $this->db->insert_id();
        
        return isset($id)?$id:FALSE;
    }
    
    /*
     * @param type date
     * Will return homepage configuration based on a date
     * If not configured then return empty result
     */
    public function get_homepage_question_list_configuration($date)
    {
        $this->db->where('selected_date <=',$date);
        
        return $this->db->select("*")
                    ->from($this->tables['bmi_home_page_configuration'])
                    ->order_by('id', 'desc')
                    ->limit(1)
                    ->get();
    }
    
    /**
     * 
     * @param type $date
     * Will delete all entry based on that date
     * Return TRUE for success and FALSE for failure
     */
    public function delete_homepage_question_list_configuration($date)
    {
        $this->db->where('selected_date',$date);
        
        $this->db->delete($this->tables['bmi_home_page_configuration']);
        
        if($this->db->affected_rows() == 0)
        {
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function get_initial_homepage_question_list()
    {
        return $this->db->select('*')
                    ->from($this->tables['bmi_questions'])
                    ->limit(3)
                    ->get();
    }
    
    public function get_configuration($date)
    {
        $this->db->where('selected_date >=',$date);
        
        return $this->db->select("*")
                    ->from($this->tables['bmi_home_page_configuration'])
                    ->order_by('id', 'desc')
                    ->get();
    }
    
    public function delete_homepage_configuration($date_array)
    {
        $this->db->where_in('selected_date',$date_array);
        
        $this->db->delete($this->tables['bmi_home_page_configuration']);
        
        if($this->db->affected_rows() == 0)
        {
            return FALSE;
        }
        
        return TRUE;
    }
}