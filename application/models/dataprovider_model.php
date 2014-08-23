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
class DataProvider_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->config('ion_auth', TRUE);
        $this->load->helper('cookie');
        $this->load->helper('date');
        $this->lang->load('ion_auth');

        //initialize db tables data
        $this->tables = $this->config->item('tables', 'ion_auth');

        
       
        $this->join = $this->config->item('join', 'ion_auth');


        //initialize messages and error
        $this->messages = array();
        $this->errors = array();
        $this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
        $this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
        $this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
        $this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');

        //initialize our hooks object
        $this->_ion_hooks = new stdClass;

       
        $this->trigger_events('model_constructor');
    }
    
    public function getGenderList(){
        $this->response = $this->db->select('id, gender_code, gender_name')
                                   ->get($this->tables['gender'])->result();
        return $this;
    }
    public function getCountryList(){
        $this->response = $this->db->select('id, country_code, country_name')
                                   ->get($this->tables['countries'])->result();
        return $this;
    }
    
    public function dropDownList($label_field, $value_field){
        $resultList = array();
        foreach ($this->response as $item) {
            $label = "";
            $value = "";
            foreach ($item as $key => $v) {
                if($key == $label_field){
                    $label = $v;
                }
                if($key == $value_field){
                    $value = $v;
                }
            }
            if($label != "" && $value != ""){
                $resultList[$label] = $value;
            }
        }
        return $resultList;
    }
    
    public function dropDownListWithSource($source, $label_field, $value_field){
        $resultList = array();
        foreach ($source as $item) {
            $label = "";
            $value = "";
            foreach ($item as $key => $v) {
                if($key == $label_field){
                    $label = $v;
                }
                if($key == $value_field){
                    $value = $v;
                }
            }
            if($label != "" && $value != ""){
                $resultList[$label] = $value;
            }
        }
        return $resultList;
    }
    
    public function list_maker(){
        
    }
}
