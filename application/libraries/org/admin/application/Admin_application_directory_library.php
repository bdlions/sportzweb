<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin Application Directory
 *
 * Author: Nazmul Hasan
 *
 * Requirements: PHP5 or above
 *
 */
class Admin_application_directory_library {
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
                        $this->load->model('org/admin/application/admin_application_directory_model');

        $this->admin_application_directory_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_application_directory_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_application_directory_model');
        }

        return call_user_func_array(array($this->admin_application_directory_model, $method), $arguments);
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
    
    public function add_gallery_image($application_id, $data)
    {
        $application_info_array = $this->admin_application_directory_model->get_application_info($application_id)->result_array();
        if(!empty($application_info_array) && isset($data['img']) )
        {
            $image_info = new stdClass();
            $image_info->img = $data['img'];
            $image_list = array();
            $image_list[] = $image_info;
            $image_counter = 1;
            $application_info = $application_info_array[0];
            $img_gallery = $application_info['img_gallery'];
            if( $img_gallery != "" && $img_gallery != NULL )
            {
                $img_gallery_array = json_decode($img_gallery); 
                foreach($img_gallery_array as $img_gallery_info)
                {
                    $image_list[] = $img_gallery_info;
                    $image_counter++;
                    if($image_counter == APPLICATION_DIRECTORY_IMAGE_GALLERY_TOTAL_IMAGES)
                    {
                        break;
                    }
                }
            }
            $additional_data = array(
                'img_gallery' => json_encode($image_list)
            );
            return $this->admin_application_directory_model->update_application($application_id, $additional_data);
        }
        return FALSE;
    }
}

?>
