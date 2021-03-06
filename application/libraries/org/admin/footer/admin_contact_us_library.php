<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin Contact Us Library
 *
 * Author: Nazmul on 14 October 2014
 * 
 * Requirements: PHP5 or above
 *
 */
class Admin_contact_us_library {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('org/utility/utils');
        
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('org/admin/footer/admin_contact_us_model');

        $this->admin_contact_us_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_contact_us_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_contact_us_model');
        }

        return call_user_func_array(array($this->admin_contact_us_model, $method), $arguments);
    }
    

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    } 
    
    /*
     * This method will return member feedback list
     * @Author Nazmul on 27th January 2015
     */
    public function get_member_feedbacks()
    {
        $feedback_list = array();
        $feedbacks_array = $this->admin_contact_us_model->get_member_feedbacks()->result_array();
        foreach($feedbacks_array as $feedback)
        {
            $feedback['created_on'] = $this->utils->get_unix_to_human_date($feedback['created_on'], 1);
            $feedback_list[] = $feedback;
        }
        return $feedback_list;
    }
    /*
     * This method will return non member feedback list
     * @Author Nazmul on 27th January 2015
     */
    public function get_non_member_feedbacks()
    {
        $feedback_list = array();
        $feedbacks_array = $this->admin_contact_us_model->get_non_member_feedbacks()->result_array();
        foreach($feedbacks_array as $feedback)
        {
            $feedback['created_on'] = $this->utils->get_unix_to_human_date($feedback['created_on'], 1);
            $feedback_list[] = $feedback;
        }
        return $feedback_list;
    }
}
