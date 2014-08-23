<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */

class Admin_bmi_calculator_library{
    
    public function __construct() {
        $this->load->config('ion_auth',TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        
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
                        $this->load->model('org/admin/application/admin_bmi_calculator_model');

        $this->admin_bmi_calculator_model->trigger_events('library_constructor');
    }
    
   /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_bmi_calculator_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_blog_model');
        }

        return call_user_func_array(array($this->admin_bmi_calculator_model, $method), $arguments);
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
    
    
    public function get_homepage_question_list_configuration()
    {
        $present_date = date('d-m-Y');
        $show_advertise = 0;
        $question_list = array();
        $homepage_data = $this->admin_bmi_calculator_model->get_homepage_question_list_configuration($present_date)->result_array();

        if(!empty($homepage_data))
        {
            $homepage_data = $homepage_data[0];
            $question_list_array = json_decode($homepage_data['question_list']);
            $question_id_list = array();
            foreach ($question_list_array as $question)
            {
                $question_id_list[$question->order_id] = $question->question_id;
            }
            $question_list = $this->admin_bmi_calculator_model->get_question_list($question_id_list)->result_array();
            
            $data = array();
            foreach($question_list as $question)
            {
                $data[$question['id']] = $question;
            }
            $question_list  = $data;
            $data = array();
            foreach ($question_id_list as $key=>$id)
            {
                $data[$key] = $question_list[$id];
            }

            $question_list = $data;
            ksort($question_list);
                
            $show_advertise = $homepage_data['show_advertise'];
        }
        else
        {
            $question_list = $this->admin_bmi_calculator_model->get_initial_homepage_question_list()->result_array();
        }
        $data = array();
        $data['question_list'] = $question_list;
        $data['show_advertise'] = $show_advertise;
        
        return $data;
    }
    
    public function check_for_homepage_configuration($date,$question_id)
    {
        
        $homepage_data  = $this->admin_bmi_calculator_model->get_configuration($date)->result_array();
        
        $date_array = array();
        foreach($homepage_data as $data)
        {
            $configed_data = json_decode($data['question_list']);
            
            foreach ($configed_data as $question)
            {
                if($question->question_id == $question_id)
                    $date_array[] = $data['selected_date'];
            }
        }
        $date_array = array_unique($date_array);
        sort($date_array);
        return $date_array;
    }
}