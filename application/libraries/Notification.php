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
        $this->load->library('org/utility/Utils');
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
                    if ($notification_info_list->reference_id_list != null) {
                        $n_info->reference_id_list[] = $notification_info_list->reference_id_list[0];
                    }
                    $n_info->modified_on = now();
                    $n_info->status = UNREAD_NOTIFICATION;
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
        $result = array(
            'total_unread_followers' => 0,
            'total_unread_notifications' => 0,
            'notification_list' => array()
        );

        $result_notification_list = array();
        $notification_array = array();
        $reference_user_id_list = array();
        $user_info_array = array();
        $notification_info_array = array();
        $status_id_status_info_map = array();
        $user_id_user_info_map = array();
        $status_id_list = array();
        $status_info_array = array();
        $notification_info = array();
        $notification_result_array = $this->notification->get_notification_list($user_id);
        $notification_array = $notification_result_array[0];
        $notification_list = json_decode($notification_array['list']);
        if ($notification_list == null) {
            return $result;
        }

        function cmp($notification_list, $compare_list) {

            return strcmp($compare_list->modified_on, $notification_list->modified_on);
        }

        if (!empty($notification_list)) {
            usort($notification_list, "cmp");
        }
        foreach ($notification_list as $n_info) {
            if ($n_info->type_id == NOTIFICATION_WHILE_START_FOLLOWING) {
                if ($n_info->status == UNREAD_NOTIFICATION) {
                    $result['total_unread_followers'] = $result['total_unread_followers'] + 1;
                }
                $reference_user_id_list[] = $n_info->reference_id;
                if (!in_array($n_info->reference_id, $reference_user_id_list)) {
                    $reference_user_id_list[] = $n_info->reference_id;
                }
            } else {
                if ($n_info->status == UNREAD_NOTIFICATION) {
                    $result['total_unread_notifications'] = $result['total_unread_notifications'] + 1;
                }
            }
            $reference_array_list = $n_info->reference_id_list;
            foreach ($reference_array_list as $reference_array_info) {
                if (!in_array($reference_array_info->user_id, $reference_user_id_list)) {
                    $reference_user_id_list[] = $reference_array_info->user_id;
                }
            }
        }
        if ($reference_user_id_list != null) {
            $user_info_array = $this->notification_model->get_users($reference_user_id_list)->result_array();
            foreach ($user_info_array as $user_info) {
                $user_id_user_info_map[$user_info['user_id']] = $user_info;
            }
        }
        foreach ($notification_list as $n_list_info) {
            $notification_info = array();
            $notification_info['type_id'] = $n_list_info->type_id;
            $notification_info['reference_id'] = $n_list_info->reference_id;
            $notification_info['reference_info'] = array();
            if ($n_list_info->type_id == NOTIFICATION_WHILE_START_FOLLOWING) {
                $notification_info['reference_info'] = $user_id_user_info_map[$n_list_info->reference_id];
            }
            $notification_info['reference_list'] = array();
            $reference_array_list = $n_list_info->reference_id_list;
            foreach ($reference_array_list as $notification_info_array) {
                $notification_info['reference_list'][] = $user_id_user_info_map[$notification_info_array->user_id];
            }
            $notification_info['created_on'] = $this->utils->convert_time($n_list_info->modified_on);
            $result_notification_list[] = $notification_info;
        }
        $result['notification_list'] = $result_notification_list;
        return $result;
    }

}

?>
