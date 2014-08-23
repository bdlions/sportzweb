<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsfeed {
    public function __construct() {
        $this->load->helper('cookie');
        $this->load->library('likes');
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->load->model("newsfeed_model");

        $this->newsfeed_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->newsfeed_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in business_profile_model');
        }

        return call_user_func_array(array($this->newsfeed_model, $method), $arguments);
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
    
    public function get_statuses($posted_in = STATUS_POSTED_IN_WALL, $limit = 8, $start_index = 0 , $user_id = 0)
    {
        $status_list = array();
        $statuses = $this->newsfeed_model->get_statuses($posted_in, $limit, $start_index , $user_id);
        if($statuses != null)
        {
            $status_id_list = array();
            foreach ($statuses as $status)
            {
                $status_id_list[] = $status->status_id;
            }
            $status_id_usre_list_map = $this->likes->get_status_liked_user_list($status_id_list);
            foreach ($statuses as $status)
            {
                $status->liked_user_list = $status_id_usre_list_map[$status->status_id];
                $status->reference_user_list = $this->likes->get_status_reference_user_list($status->status_id);
                $status_list[] = $status;
            }
            
        }
        //print_r($status_list);
        return $status_list;
    }

}

?>
