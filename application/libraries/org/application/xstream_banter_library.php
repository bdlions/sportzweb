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
class Xstream_banter_library {
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
                        $this->load->model('org/application/xstream_banter_model');

        $this->xstream_banter_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->xstream_banter_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in xstream_banter_model');
        }

        return call_user_func_array(array($this->xstream_banter_model, $method), $arguments);
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
    
    public function get_chat_room_messages($xb_chat_room_id)
    {
        $chat_room_message_list = array();
        $chat_room_messages_array = $this->xstream_banter_model->get_chat_room_messages($xb_chat_room_id)->result_array();
        foreach($chat_room_messages_array as $chat_room_messages_info)
        {
            $message_list = $chat_room_messages_info['message_list'];
            if( $message_list != "" && $message_list != NULL )
            {
                $message_list_array = json_decode($message_list);
                foreach($message_list_array as $message_info)
                {
                    $message_time = $message_info->created_on; 
                    $custom_time_array = explode(" ", unix_to_human($message_time));
                    $custom_time = $custom_time_array[1].' '.$custom_time_array[2];
                    $chat_room_message_info = array(
                        'created_on' => $message_time,
                        'time' => $custom_time,
                        'first_name' => $chat_room_messages_info['first_name'],
                        'last_name' => $chat_room_messages_info['last_name'],
                        'team_name' => $chat_room_messages_info['team_name'],
                        'message' => $message_info->message
                    );
                    $chat_room_message_list[] = $chat_room_message_info;                    
                }
            }
        }
        $created_time = array();
        foreach ($chat_room_message_list as $key => $row)
        {
            $created_time[$key] = $row['created_on'];
        }
        array_multisort($created_time, SORT_DESC, $chat_room_message_list);
        return $chat_room_message_list;
    }
    
    public function store_chat_room_message($xb_chat_room_id, $user_id, $data)
    {
        $current_time = now();
        $current_message_info = new stdClass();
        $current_message_info->id = 1;
        $current_message_info->message = $data['message'];
        $current_message_info->created_on = $current_time;
        $current_message_info->modified_on = '';
        
        $message_info_array = array();            
        $char_room_message_info_array = $this->xstream_banter_model->get_chat_room_message_info($xb_chat_room_id, $user_id)->result_array();
        if(empty($char_room_message_info_array))
        {
            $message_info_array[] = $current_message_info;
            $additional_data = array(
                'xb_chat_room_id' => $xb_chat_room_id,
                'user_id' => $user_id,
                'message_list' => json_encode($message_info_array),
                'created_on' => $current_time
            );
            $this->xstream_banter_model->add_chat_room_message_info($additional_data);
        }
        else
        {
            $max_message_id = 0;
            foreach($char_room_message_info_array as $char_room_message_info)
            {
                $message_list = $char_room_message_info['message_list'];
                if( $message_list != "" && $message_list != NULL )
                {
                    $message_list_array = json_decode($message_list);
                    foreach($message_list_array as $message_info)
                    {
                        $message_info_array[] = $message_info;
                        if($message_info->id > $max_message_id)
                        {
                            $max_message_id = $message_info->id;
                        }
                    }
                }
            }
            $current_message_info->id = $max_message_id + 1;
            $message_info_array[] = $current_message_info;
            $additional_data = array(
                'message_list' => json_encode($message_info_array),
                'modified_on' => $current_time
            );
            $this->xstream_banter_model->update_chat_room_message_info($xb_chat_room_id, $user_id, $additional_data);
        }
    }
}

?>
