<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Score Prediciton Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Score_prediction_model extends Ion_auth_model
{
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return all sports
     * @Author Nazmul on 26th October 2014
     */
    public function get_all_sports()
    {
        return $this->db->select($this->tables['app_sp_sports'].'.id as sports_id,'.$this->tables['app_sp_sports'].'.*')
                    ->from($this->tables['app_sp_sports'])
                    ->get();
    }
    
    /*
     * This method will return all tournaments
     * @Author Nazmul on 24th October 2014
     */
    public function get_all_tournaments($sports_id)
    {
        $this->db->where('sports_id', $sports_id);
        return $this->db->select($this->tables['app_sp_tournaments'].'.id as tournament_id,'.$this->tables['app_sp_tournaments'].'.*')
                    ->from($this->tables['app_sp_tournaments'])
                    ->get();
    }
    
    /*
     * This method will retrun home page configuration of a date
     * If there is no configuration for a date then it will return previously latest configured info
     * @param, $date, configuration date
     * @Author Namzul on 26th October 2014
     */
    public function get_home_page_configuration_info($date)
    {
        $this->db->where('selected_date <=',$date);
        $result = $this->db->select('*')
                        ->from($this->tables['app_sp_configure_homepage'])
                        ->order_by('id', 'desc')
                        ->limit(1)
                        ->get();
        return $result;
    }
    
}