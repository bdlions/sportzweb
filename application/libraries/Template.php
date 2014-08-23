<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    var $template_data = array();
    var $selected_user_group = "";

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function load($template = null, $view = '', $view_data = array(), $return = FALSE) {
        $this->CI = & get_instance();
        $current_template = $template;
        
        if( !empty($view) ){
            $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        }
        if ($template == null) {
            $current_template = $this->getDefaultTemplate();
        }
        return $this->CI->load->view($current_template, $this->template_data, $return);
    }
    
    function getDefaultTemplate(){
        $this->CI = & get_instance();
        $this->selected_user_group = $this->CI->session->userdata('user_type');
        if(isset($this->selected_user_group ) && $this->selected_user_group != ""){
            return $this->getUserTemplate($this->selected_user_group);
        }
        
        $current_template = NON_MEMBER_TEMPLATE;
        $user_group = array();
        $user_group = $this->CI->ion_auth->get_current_user_types();
        foreach ($user_group as $group) {
            $current_template = $this->getUserTemplate($group);
            if($current_template != false)
                break;
        }
        
        $this->CI->session->set_userdata(array('user_type'=>  $this->selected_user_group));
        
        return $current_template;
    }
    
    function getUserTemplate($group_name){
        if($group_name == MEMBER){
            $this->selected_user_group = MEMBER;
            return MEMBER_LOGIN_SUCCESS_TEMPLATE;
        }
        else if($group_name == PUBLISHER){
            $this->selected_user_group = PUBLISHER;
            return PUBLISHER_LOGIN_SUCCESS_TEMPLATE;
        }
        else if($group_name == ADMIN){
            $this->selected_user_group = ADMIN;
            return ADMIN_LOGIN_SUCCESS_TEMPLATE;
        }
        else if($group_name == BUSINESSMAN){
            $this->selected_user_group = BUSINESSMAN;
            return BUSINESSMAN_LOGIN_SUCCESS_TEMPLATE;
        }
        else false;
    }

}

?>