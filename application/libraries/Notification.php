<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification {

    public function __construct() {
        $this->load->helper('cookie');

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->load->model("notification_model");

        $this->notification_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->notification_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in business_profile_model');
        }

        return call_user_func_array(array($this->notification_model, $method), $arguments);
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
     * Ajax Call
     * This method will return every  types  notifications best on  parameter
     * Parameter type or Status  
     * @Author Rashida on 13th April 2015
     */

    public function get_notification_list($user_id = 0, $type_id = 0, $reference_id = 0) {
        $notification_list_array = array();
        $result_array = $this->notification_model->get_notification_list($user_id)->result_array();
        if (!empty($result_array)) {
            foreach ($result_array as $result) {
                $notification_list = json_decode($result['list']);
                $notification_list = $notification_list[0];
                if ($type_id != 0 && $reference_id != 0) {
                    if ($notification_list->type_id == $type_id && $notification_list->reference_id == $reference_id) {
                        $notification_list_array[] = $result;
                    } else {
                        continue;
                    }
                } else if ($type_id != 0 && $reference_id == 0) {
                    if ($notification_list->type_id == $type_id) {
                        $notification_list_array[] = $result;
                    } else {
                        continue;
                    }
                } else if ($type_id == 0 && $reference_id != 0) {
                    if ($notification_list->reference_id == $reference_id) {
                        $notification_list_array[] = $result;
                    } else {
                        continue;
                    }
                } else {
                    $notification_list_array[] = $result;
                }
            }
            return $notification_list_array;
        }
    }

    public function add_notification($referenced_user_id, $notification_info_list) {
        $total_notifications = 0;
        $notification_list = array();
        if ($notification_info_list->type_id != 0) {
            $notification_info_list->id = ++$total_notifications;
        }
        $notification_list_array = $this->notification->get_notification_list($referenced_user_id);
        if (!empty($notification_list_array)) {
            $notification_list_array = $notification_list_array[0];
            $n_list_array = json_decode($notification_list_array['list']);
            $isexist = FALSE;
            $notification_id = 0;
            foreach ($n_list_array as $n_info) {
                
                if ($n_info->type_id == $notification_info_list->type_id && $n_info->reference_id == $notification_info_list->reference_id) {
                    $isexist = TRUE;
                    $n_info->reference_id_list[] =$notification_info_list->reference_id_list[0] ; 
                    $n_info->modified_on = now();
                }
                $notification_id = $n_info->id;
                $notification_list[] = $n_info;
            }
            if (!$isexist) {
                $notification_info_list->id = ++$notification_id;
                $notification_list[] = $notification_info_list;                
            } 
            $additional_data = array(
                'user_id' => $referenced_user_id,
                'list' => json_encode($notification_list)
            );
            $response = $this->notification_model->update_notification($referenced_user_id, $additional_data);            
        } else {
            $notification_list[] = $notification_info_list;
            $additional_data = array(
                'user_id' => $referenced_user_id,
                'list' => json_encode($notification_list)
            );
            $response = $this->notification_model->add_notification($referenced_user_id, $additional_data);
        }
        return $response;
    }
    
      public function get_all_notification_list($user_id = 0) {
        $user_id = 1 ; 
        $notification_array_list = array();
        $result_array = array();
        $result_array = $this->notification->get_notification_list($user_id);
        $result_array = $result_array[0];
        $result_array = json_decode($result_array['list']);
         function cmp($result_array, $compare_list) {

                   return strcmp($result_array->modified_on, $compare_list->modified_on);
                }
        usort($result_array, "cmp");
        foreach ($result_array as $n_info) {
                $reference_array_list = $n_info->reference_id_list;
                $notification_type[] = $n_info->type_id;
                $notification_reference_id_list[] = $n_info->reference_id;
                foreach ($reference_array_list as $reference_array_info) {
                    $reference_user_id = $reference_array_info->user_id ;
                    $notification_user_info[] = $this->ion_auth->get_user_info($reference_user_id);
                }
        }
        $this->data['notification_status_id_list'] = $reference_array_list;
        $this->data['notification_type'] = $notification_type;
        $this->data['referenced_user_info'] = $notification_user_info;
        $this->template->load();
  
    }
    


}

?>
