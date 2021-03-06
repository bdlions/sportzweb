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
class Admin_about_us {
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
                        $this->load->model('org/admin/footer/admin_about_us_model');

        $this->admin_about_us_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_about_us_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_about_us_model');
        }

        return call_user_func_array(array($this->admin_about_us_model, $method), $arguments);
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
    
    public function save_about_us_text_info($region_id, $text)
    {
        $region_list = array();
        $about_us_info = array();
        $about_us_info_array = $this->admin_about_us_model->get_about_us_info()->result_array();
        if(!empty($about_us_info_array))
        {
            $about_us_info = $about_us_info_array[0];
            $text_region = $about_us_info['text_region'];
            if( $text_region != "" && $text_region != NULL )
            {
                $text_region_array = json_decode($text_region);
                foreach($text_region_array as $text_region_info)
                {
                    if($text_region_info->region_id != $region_id)
                    {
                        $region_list[] = $text_region_info;
                    }                    
                }
            }
        }
        $region_info = new stdClass();
        $region_info->region_id = $region_id;
        $region_info->text = $text;
        $region_list[] = $region_info;
        $additional_data = array(
            'text_region' => json_encode($region_list)
        );
        if(!empty($about_us_info_array))
        {
            $this->admin_about_us_model->update_about_us_info($additional_data);
        }
        else
        {
            $this->admin_about_us_model->add_about_us_info($additional_data);
        }
    }
    
    public function save_about_us_image_info($region_id, $image)
    {
        $region_list = array();
        $about_us_info = array();
        $about_us_info_array = $this->admin_about_us_model->get_about_us_info()->result_array();
        
        if(!empty($about_us_info_array))
        {
            $about_us_info = $about_us_info_array[0];
            $image_region = $about_us_info['image_region'];
            if( $image_region != "" && $image_region != NULL )
            {
                $image_region_array = json_decode($image_region);
                foreach($image_region_array as $image_region_info)
                {
                    if($image_region_info->region_id != $region_id)
                    {
                        $region_list[] = $image_region_info;
                    }                    
                }
            }
        }
        
        $region_info = new stdClass();
        $region_info->region_id = $region_id;
        $region_info->image = $image;
        $region_list[] = $region_info;
        $additional_data = array(
            'image_region' => json_encode($region_list)
        );
        
        if(!empty($about_us_info_array))
        {
            $this->admin_about_us_model->update_about_us_info($additional_data);
        }
        else
        {
            $this->admin_about_us_model->add_about_us_info($additional_data);
        }
        return TRUE;
    }
    
    public function get_about_us_info()
    {
        $result = array();
        $region_id_text_map = array();
        $region_id_image_map = array();
        $about_us_info_array = $this->admin_about_us_model->get_about_us_info()->result_array();
        if(!empty($about_us_info_array))
        {
            $about_us_info = $about_us_info_array[0];
            $text_region = $about_us_info['text_region'];
            if( $text_region != "" && $text_region != NULL )
            {
                $text_region_array = json_decode($text_region);
                foreach($text_region_array as $text_region_info)
                {
                    $region_id_text_map[$text_region_info->region_id] = $text_region_info->text;
                }
            }
            $image_region = $about_us_info['image_region'];
            if( $image_region != "" && $image_region != NULL )
            {
                $image_region_array = json_decode($image_region);
                foreach($image_region_array as $image_region_info)
                {
                    $region_id_image_map[$image_region_info->region_id] = $image_region_info->image;
                }
            }
        }
        $result['region_id_text_map'] = $region_id_text_map;
        $result['region_id_image_map'] = $region_id_image_map;
        return $result;
    }
    
    public function get_about_us_text_info($region_id)
    {
        $region_text = '';
        $about_us_info_array = $this->admin_about_us_model->get_about_us_info()->result_array();
        if(!empty($about_us_info_array))
        {
            $about_us_info = $about_us_info_array[0];
            $text_region = $about_us_info['text_region'];
            if( $text_region != "" && $text_region != NULL )
            {
                $text_region_array = json_decode($text_region);
                foreach($text_region_array as $text_region_info)
                {
                    if($text_region_info->region_id == $region_id)
                    {
                        return $text_region_info->text;
                    }
                }
            }
        }
        return $region_text;
    }
}

?>
