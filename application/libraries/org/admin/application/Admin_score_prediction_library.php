<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin Score Prediction Library
 *
 * Author: @Nazmul
 * 
 * Requirements: PHP5 or above
 *
 */
class Admin_score_prediction_library {
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
                        $this->load->model('org/admin/application/admin_score_prediction_model');

        $this->admin_score_prediction_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_score_prediction_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_score_prediction_model');
        }

        return call_user_func_array(array($this->admin_score_prediction_model, $method), $arguments);
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
    
    public function get_all_matches($tournament_id)
    {
        $match_list = array();
        $match_list_array = $this->admin_score_prediction_model->get_all_matches($tournament_id)->result_array();
        foreach($match_list_array as $match_info)
        {
            $match_info['date'] = $this->utils->convert_date_from_yyyymmdd_to_ddmmyyyy($match_info['date']);
            $match_list[] = $match_info;
        }
        return $match_list;
    }
}