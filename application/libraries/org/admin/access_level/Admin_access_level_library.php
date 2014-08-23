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

class Admin_access_level_library{
    
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
                        $this->load->model('org/admin/access_level/admin_access_level_model');

        $this->admin_access_level_model->trigger_events('library_constructor');
    }
    
   /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_access_level_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_access_level_model');
        }

        return call_user_func_array(array($this->admin_access_level_model, $method), $arguments);
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
    
    public function store_access_level_info($user_id, $access_level_mapping, $user_info_data = array())
    {
        $access_level_info = array();
        $access_level_info_array = $this->admin_access_level_model->get_users_access_level($user_id)->result_array();
        if(!empty($access_level_info_array))
        {
            $access_level_info = $access_level_info_array[0];
        }
        $access_level_array = array();
        foreach($access_level_mapping as $key => $value)
        {
            $splited_content = explode('_', $key);
            $access_item_id = $splited_content[0];
            $access_type_id = $splited_content[1];
            $access_level = new stdClass();
            $access_level->access_item_id = $access_item_id;
            $access_level->access_type_id = $access_type_id;
            $access_level->access_type_value = $value;
            $access_level_array[] = $access_level;
        }
        $additional_data = array(
            'user_id' => $user_id,
            'access_level' => json_encode($access_level_array)
        );
        if(empty($access_level_info))
        {
            $this->admin_access_level_model->create_users_access($additional_data);
        }
        else
        {
            $this->admin_access_level_model->update_users_access($user_id, $additional_data, $user_info_data);
        }
    }
    
    public function get_access_level_info($user_id)
    {
        $access_level_mapping = array();
        $users_access_info = array();
        $users_access_info_array = $this->admin_access_level_model->get_users_access_level($user_id)->result_array();
        if(!empty($users_access_info_array))
        {
            $users_access_info = $users_access_info_array[0];
            $access_level = $users_access_info['access_level'];
            if( $access_level != "" && $access_level != NULL )
            {
                $access_level_array = json_decode($access_level);
                foreach($access_level_array as $access_level_info)
                {
                    $access_level_mapping[$access_level_info->access_item_id.'_'.$access_level_info->access_type_id] = $access_level_info->access_type_value;
                }
            }
        }
        return $access_level_mapping;
    }
}
 