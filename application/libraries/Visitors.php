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
class Visitors {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
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
                        $this->load->model('visitors_model');

        $this->visitors_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->visitors_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in visitors_model');
        }

        return call_user_func_array(array($this->visitors_model, $method), $arguments);
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
    
    public function store_page_visitor($page_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        //store page visitor
        $data = $this->visitors_model->get_page_visitor_list($page_id,$user_id)->result_array();
        //echo "HI";exit;
        if(empty($data))
        {
                
            $data = new stdClass();
            $data->access_time = now();
            $data = json_encode(array($data));
            $data = array('access_history' => $data);
            //echo "<pre/>";print_r($data);exit;
            $this->visitors_model->add_page_visitor($page_id,$user_id,$data);
        }
        else
        {
            //$data = json_decode($data['access_history']);
            $data = $data[0]; 
            $data = json_decode($data['access_history']);
            $data1 = new stdClass();
            $data1->access_time = now();
            array_push($data, $data1);
            $data = json_encode($data);
            $data = array('access_history' => $data);
            
            $this->visitors_model->update_page_visitor($page_id,$user_id,$data);
            
        }
        
        
    }
    
    public function store_application_visitor($application_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        //store application visitor
        $data = $this->visitors_model->get_application_visitor_list($application_id,$user_id)->result_array();
        
        if(empty($data))
        {

            $data = new stdClass();
            $data->access_time = now();
            $data = json_encode(array($data));
            $data = array('access_history' => $data);
            $this->visitors_model->add_application_visitor($application_id,$user_id,$data);
        }
        else
        {
            //$data = json_decode($data['access_history']);
            $data = $data[0]; 
            $data = json_decode($data['access_history']);
            $data1 = new stdClass();
            $data1->access_time = now();
            array_push($data, $data1);
            $data = json_encode($data);
            $data = array('access_history' => $data);
            
            $this->visitors_model->update_application_visitor($application_id,$user_id,$data);
            
        }
        
    }
    
    public function store_business_profile_visitor($business_profile_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        //store business profile visitor
    
        $data = $this->visitors_model->get_business_profile_visitor_list($business_profile_id,$user_id)->result_array();
        
        if(empty($data))
        {

            $data = new stdClass();
            $data->access_time = now();
            $data = json_encode(array($data));
            $data = array('access_history' => $data);
            $this->visitors_model->add_business_profile_visitor($business_profile_id,$user_id,$data);
        }
        else
        {
            //$data = json_decode($data['access_history']);
            $data = $data[0]; 
            $data = json_decode($data['access_history']);
            $data1 = new stdClass();
            $data1->access_time = now();
            array_push($data, $data1);
            $data = json_encode($data);
            $data = array('access_history' => $data);
            
            $this->visitors_model->update_business_profile_visitor($business_profile_id,$user_id,$data);
            
        }
    }
    
}

?>
