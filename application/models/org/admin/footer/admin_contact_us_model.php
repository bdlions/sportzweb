<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin Contact Us Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Admin_contact_us_model extends Ion_auth_model {

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
     * This method will return topic info
     * @param $topic_id, topic id
     * @Author Nazmul on 14th October 2014
     */
    public function get_topic_info($topic_id)
    {
        $this->db->where('id', $topic_id);
        return $this->db->select('*')
                ->from($this->tables['footer_cu_topics'])
                ->get();
    }
    
    /*
     * This method will update a topic 
     * @Author Nazmul on 14th October 2014
     */
    public function update_topic($topic_id, $additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_cu_topics'], $additional_data);
        $this->db->update($this->tables['footer_cu_topics'], $data, array('id' => $topic_id));
    }
    
    /*
     * This method will add a new topic 
     * @Author Nazmul on 14th October 2014
     */
    public function add_topic($additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_cu_topics'], $additional_data);
        $this->db->insert($this->tables['footer_cu_topics'], $data);
    }
    
    /*
     * This method will delete a topic 
     * @Author Nazmul on 14th October 2014
     */
    public function delete_topic($topic_id)
    {
        $this->db->where($this->tables['footer_cu_topics'].'.id', $topic_id);
        $this->db->delete($this->tables['footer_cu_topics']);
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
     * This method will return operating system info
     * @param $os_id, operating system id
     * @Author Nazmul on 14th October 2014
     */
    public function get_operating_system_info($os_id)
    {
        $this->db->where('id', $os_id);
        return $this->db->select('*')
                ->from($this->tables['footer_cu_operating_systems'])
                ->get();
    }
    
    /*
     * This method will update an operating system 
     * @Author Nazmul on 14th October 2014
     */
    public function update_operating_system($operating_system_id, $additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_cu_operating_systems'], $additional_data);
        $this->db->update($this->tables['footer_cu_operating_systems'], $data, array('id' => $operating_system_id));
    }
    
    /*
     * This method will add a new operating system
     * @Author Nazmul on 14th October 2014
     */
    public function add_operaging_system($additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_cu_operating_systems'], $additional_data);
        $this->db->insert($this->tables['footer_cu_operating_systems'], $data);
    }
    
    /*
     * This method will delete an operating system 
     * @Author Nazmul on 14th October 2014
     */
    public function delete_operaging_system($operating_system_id)
    {
        $this->db->where($this->tables['footer_cu_operating_systems'].'.id', $operating_system_id);
        $this->db->delete($this->tables['footer_cu_operating_systems']);
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
     * This method will return topic info
     * @param $browser_id, browser_id id
     * @Author Nazmul on 14th October 2014
     */
    public function get_browser_info($browser_id)
    {
        $this->db->where('id', $browser_id);
        return $this->db->select('*')
                ->from($this->tables['footer_cu_browsers'])
                ->get();
    }
    
    /*
     * This method will update a brower 
     * @Author Nazmul on 14th October 2014
     */
    public function update_browser($browser_id, $additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_cu_browsers'], $additional_data);
        $this->db->update($this->tables['footer_cu_browsers'], $data, array('id' => $browser_id));
    }
    
    /*
     * This method will add a new brower 
     * @Author Nazmul on 14th October 2014
     */
    public function add_browser($additional_data)
    {
        $data = $this->_filter_data($this->tables['footer_cu_browsers'], $additional_data);
        $this->db->insert($this->tables['footer_cu_browsers'], $data);
    }
    
    /*
     * This method will delete a brower 
     * @Author Nazmul on 14th October 2014
     */
    public function delete_browser($browser_id)
    {
        $this->db->where($this->tables['footer_cu_browsers'].'.id', $browser_id);
        $this->db->delete($this->tables['footer_cu_browsers']);
    }
    
    /*
     * This method will return all feedbacks of users 
     * @Author Nazmul on 14th October 2014
     */
    public function get_all_feedbacks()
    {
        
    }
    
    /*
     * This method will update a feedback 
     * @Author Nazmul on 14th October 2014
     */
    public function update_feedback($feedback_id, $additional_data)
    {
        
    }
    
    /*
     * This method will delete a feedback 
     * @Author Nazmul on 14th October 2014
     */
    public function delete_feedback($feedback_id)
    {
        
    }
}