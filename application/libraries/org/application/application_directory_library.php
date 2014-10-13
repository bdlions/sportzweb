<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Application Directory
 *
 * Author: Nazmul Hasan
 *
 * Requirements: PHP5 or above
 *
 */
class Application_directory_library {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
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
                        $this->load->model('org/application/application_directory_model');

        $this->application_directory_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->application_directory_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in application_directory_model');
        }

        return call_user_func_array(array($this->application_directory_model, $method), $arguments);
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
     * This method will return all applications adding a new column named gallery_image_list including
     * all images from json object of gallery images
     * @Author Nazmul on 13th October 2014
     */
    public function get_all_applications()
    {
        $application_list = array();
        $application_list_array = $this->application_directory_model->get_all_applications()->result_array();
        foreach($application_list_array as $application_info)
        {
            $img_gallery = $application_info['img_gallery'];
            $application_info['gallery_image_list'] = array();
            if( $img_gallery != "" && $img_gallery != NULL )
            {
                $gallery_image_list = array();
                $img_gallery_array = json_decode($img_gallery); 
                foreach($img_gallery_array as $img_gallery_info)
                {
                    $gallery_image_list[] = $img_gallery_info->img;
                }
                $application_info['gallery_image_list'] = $gallery_image_list;
            }
            $application_list[] = $application_info;
        }
        return $application_list;
    }
    
    /*
     * This method will add an application under a user
     * @Author Nazmul on 13th October 2014
     */
    public function add_user_application($application_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $app_list = array();
        $user_basic_profile_array = $this->application_directory_model->get_user_basic_profile($user_id)->result_array();
        if(!empty($user_basic_profile_array))
        {
            $basic_profile = $user_basic_profile_array[0];
            $application_list = $basic_profile['application_list'];
            if( $application_list != "" && $application_list != NULL )
            {
                $application_list_array = json_decode($application_list); 
                foreach($application_list_array as $application_info)
                {
                    $app_list[] = $application_info;
                }
            }
        }
        $app_info = new stdClass();
        $app_info->id = $application_id;        
        $app_list[] = $app_info;
        $additional_data = array(
            'application_list' => json_encode($app_list)
        );
        $this->application_directory_model->update_user_basic_profile($user_id, $additional_data);
    }
    
    /*
     * This method will remove an application from a user
     * @Author Nazmul on 13th October 2014
     */
    public function remove_user_application($application_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $app_list = array();
        $user_basic_profile_array = $this->application_directory_model->get_user_basic_profile($user_id)->result_array();
        if(!empty($user_basic_profile_array))
        {
            $basic_profile = $user_basic_profile_array[0];
            $application_list = $basic_profile['application_list'];
            if( $application_list != "" && $application_list != NULL )
            {
                $application_list_array = json_decode($application_list); 
                foreach($application_list_array as $application_info)
                {
                    if($application_info->id != $application_id)
                    {
                        $app_list[] = $application_info;
                    }                    
                }
            }
        }
        $additional_data = array(
            'application_list' => json_encode($app_list)
        );
        $this->application_directory_model->update_user_basic_profile($user_id, $additional_data);
    }
    
    /*
     * This method will return application id list of a user
     * @Author Nazmul on 13th October 2014
     */
    public function get_user_application_id_list($user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $application_id_list = array();
        $user_basic_profile_array = $this->application_directory_model->get_user_basic_profile($user_id)->result_array();
        if(!empty($user_basic_profile_array))
        {
            $basic_profile = $user_basic_profile_array[0];
            $application_list = $basic_profile['application_list'];
            if( $application_list != "" && $application_list != NULL )
            {
                $application_list_array = json_decode($application_list); 
                foreach($application_list_array as $application_info)
                {
                    $application_id_list[] = $application_info->id;
                }
            }
        }
        return $application_id_list;
    }
}
