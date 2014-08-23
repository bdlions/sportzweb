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
class Likes {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('basic_profile');
        $this->load->library('follower');
        $this->load->library('statuses');

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
                        $this->load->model('likes_model');

        $this->likes_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->likes_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in likes_model');
        }

        return call_user_func_array(array($this->likes_model, $method), $arguments);
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
     * This method will store liked user id of a status
     * @param $status_id, status id
     * @param $user_id, user id
     * @Author Nazmul on 3rd May 2014
     */
    public function store_status_like($status_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }        
        $likes_array = array();
        $status_list_array = $this->statuses->get_status_info($status_id)->result_array();
        if(!empty($status_list_array))
        {
            $user_status_info = $status_list_array[0];
            $likes = $user_status_info['likes'];
            if( $likes != "" && $likes != NULL )
            {
                $likes_array = json_decode($likes);                
            }
        }
        $current_like = new stdClass();
        $current_like->user_id = $user_id;
        $current_like->time = now();
        $likes_array[] = $current_like;
        
        $additional_data = array(
            'id' => $status_id,
            'likes' => json_encode($likes_array)
        );
        $this->statuses->update_status($status_id, $additional_data);
    }
    /*
     * This method will removed liked user id of a status
     * @param $status_id, status id
     * @param $user_id, user id
     * @Author Nazmul on 3rd May 2014
     */
    public function remove_status_like($status_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }        
        $likes_array = array();
        $updated_like_array = array();
        $status_list_array = $this->statuses->get_status_info($status_id)->result_array();
        if(!empty($status_list_array))
        {
            $user_status_info = $status_list_array[0];
            $likes = $user_status_info['likes'];
            if( $likes != "" && $likes != NULL )
            {
                $likes_array = json_decode($likes); 
                foreach($likes_array as $like_info)
                {
                    if($like_info->user_id != $user_id)
                    {
                        $updated_like_array[] = $like_info;
                    }
                }
            }
        }
        $additional_data = array(
            'id' => $status_id,
            'likes' => json_encode($updated_like_array)
        );
        $this->statuses->update_status($status_id, $additional_data);
    }
    
    
    public function get_status_liked_user_list($status_id, $user_id = 0)
    {
        $user_id_list = array();
        $user_info_list = array();
        $status_list_array = $this->statuses->get_status_info($status_id)->result_array();
        if(!empty($status_list_array))
        {
            $status_info = $status_list_array[0];
            $likes = $status_info['likes'];
            if( $likes != "" && $likes != NULL )
            {
                $likes_array = json_decode($likes);
                foreach($likes_array as $like_info)
                {
                    if(!in_array($like_info->user_id, $user_id_list))
                    {
                        $user_id_list[] = $like_info->user_id;
                    }
                 }
            }           
        }
        if(!empty($user_id_list))
        {
            if($user_id == 0)
            {
                $user_id = $this->session->userdata('user_id');
            }
            $follower_list_array = $this->follower->get_followers($user_id);
            $follower_user_id_list = array();
            foreach($follower_list_array as $follower_info)
            {
                $follower_user_id_list[] = $follower_info->user_id;
            }
            $user_info_array = $this->statuses_model->get_users($user_id_list)->result_array(); 
            foreach($user_info_array as $user_info)
            {
                if($user_info['user_id'] == $user_id)
                {
                    $user_info['is_follower'] = STATUS_LIKE_SELF;
                }
                else if(in_array($user_info['id'], $follower_user_id_list))
                {
                    $user_info['is_follower'] = STATUS_LIKE_FOLLOWER;
                }
                else
                {
                    $user_info['is_follower'] = STATUS_LIKE_NON_FOLLOWER;
                }
                $user_info_list[] = $user_info;
            }
        }
        return $user_info_list;
    }
    
    /*public function get_status_liked_user_list($status_id_list = array())
    {
        $status_id_user_info_map = array();
        $user_id_list = array();
        $user_id_user_info_map = array();
        $status_id_user_id_map = array();
        $status_list_array = $this->likes_model->get_status_list($status_id_list)->result_array();
        if(!empty($status_list_array))
        {
            foreach($status_list_array as $status_info)
            {
                $likes = $status_info['likes'];
                $status_id = $status_info['id'];
                if( $likes != "" && $likes != NULL )
                {
                    $likes_array = json_decode($likes);
                    foreach($likes_array as $like_info)
                    {
                        if(!in_array($like_info->user_id, $user_id_list))
                        {
                            $user_id_list[] = $like_info->user_id;
                        }
                        $status_id_user_id_map[$status_id][] =  $like_info->user_id;
                     }
                }
            }            
        }
        $follower_list_array = $this->follower->get_followers($this->likes_model->current_user_id);
        $follower_user_id_list = array();
        foreach($follower_list_array as $follower_info)
        {
            $follower_user_id_list[] = $follower_info->user_id;
        }
        $user_list = $this->basic_profile->get_profile_list($user_id_list);
        foreach($user_list as $user_info)
        {
            $user_info->ip_address = '';
            if($user_info->id == $this->likes_model->current_user_id)
            {
                $user_info->is_follower = '';
            }
            else if(in_array($user_info->id, $follower_user_id_list))
            {
                $user_info->is_follower = '1';
            }
            else
            {
                $user_info->is_follower = '0';
            }
            $user_id_user_info_map[$user_info->id] = $user_info;
        }
        foreach($status_id_user_id_map as $status_id => $user_id_list)
        {
            foreach($user_id_list as $user_id)
            {
                $status_id_user_info_map[$status_id][] = $user_id_user_info_map[$user_id];
            }
        }
        
        return $status_id_user_info_map;
    }*/
    
    public function get_status_reference_user_list($status_id)
    {
        $user_id_list = array();
        $status_list_array = $this->likes_model->get_status($status_id)->result_array();
        if(!empty($status_list_array))
        {
            $status_info = $status_list_array[0];
            $reference_list = $status_info['reference_list'];
            $status_id = $status_info['id'];
            if( $reference_list != "" && $reference_list != NULL )
            {
                $reference_list_array = json_decode($reference_list);
                foreach($reference_list_array as $reference_info)
                {
                    if(!in_array($reference_info->user_id, $user_id_list))
                    {
                        $user_id_list[] = $reference_info->user_id;
                    }
                 }
            }
        }
        if(empty($user_id_list))
        {
            return array();
        }
        $user_list = $this->basic_profile->get_profile_list($user_id_list);
        return $user_list;
    }

}

?>
