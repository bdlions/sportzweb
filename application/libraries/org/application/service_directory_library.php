<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Service Directory Library
 *
 * Author: Nazmul Hasan
 *
 * Requirements: PHP5 or above
 *
 */
class Service_directory_library {

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
                        $this->load->model('org/application/service_directory_model');

        $this->service_directory_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->service_directory_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in service_directory_model');
        }

        return call_user_func_array(array($this->service_directory_model, $method), $arguments);
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
    
    public function get_all_comments($service_id,$sorted=0,$limit_no=0, $comment_id = 0)
    {
        $recipe_comment_list = array();
        $comment_list = $this->service_directory_model->get_all_comments($service_id,$sorted,$limit_no, $comment_id)->result_array();
        foreach($comment_list as $comment_info)
        {
            $comment_info['ip_address'] = '';
            $comment_info['signature'] = $comment_info['first_name'][0].$comment_info['last_name'][0];
            $comment_info['comment_created_on'] = convert_time($comment_info['comment_created_on']);
            $likes = $comment_info['liked_user_list'];
            $user_id_list = array();
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
            $comment_info['liked_user_list'] = $user_id_list;  
            $recipe_comment_list[] = $comment_info;
        }
        return $recipe_comment_list;
    }
    
    public function store_like($comment_id, $user_id)
    {
        $comment_info_array = $this->service_directory_model->get_comment_info($comment_id)->result_array();
        if(!empty($comment_info_array))
        {
            $likes_array = array();
            $comment_info = $comment_info_array[0];
            $likes = $comment_info['liked_user_list'];
            if( $likes != "" && $likes != NULL )
            {
                $likes_array = json_decode($likes);                
            }
            $current_like = new stdClass();
            $current_like->user_id = $user_id;
            $current_like->time = now();
            $likes_array[] = $current_like;

            $additional_data = array(
                'id' => $comment_id,
                'liked_user_list' => json_encode($likes_array)
            );
            $this->service_directory_model->update_comment($comment_id, $additional_data);
        }
    }
    
    public function remove_like($comment_id, $user_id)
    {
        $comment_info_array = $this->service_directory_model->get_comment_info($comment_id)->result_array();
        if(!empty($comment_info_array))
        {
            $likes_array = array();
            $updated_like_array = array();
            $comment_info = $comment_info_array[0];
            $likes = $comment_info['liked_user_list'];
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
            $additional_data = array(
                'id' => $comment_id,
                'liked_user_list' => json_encode($updated_like_array)
            );
            $this->service_directory_model->update_comment($comment_id, $additional_data);
        }
    }
}

?>
