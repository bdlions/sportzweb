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
class Users_album {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
        $this->load->library('org/utility/Utils');
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
                        $this->load->model('users_album_model');

        $this->users_album_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->users_album_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in business_profile_model');
        }

        return call_user_func_array(array($this->users_album_model, $method), $arguments);
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
    
    public function get_photo_comments()
    {
        $feedback_list = array();
        $feedback = array(
            'id' => '1',
            'description' => 'test message1',
            'created_on' => '7'
        );
        $feedback_list[] = $feedback;
        $feedback = array(
            'id' => '2',
            'description' => 'test message2',
            'created_on' => '8'
        );
        $feedback_list[] = $feedback;
        return $feedback_list;
    }
    
    public function get_album_photos_info($photo_id)
    {
        $current_user_id = $this->session->userdata('user_id');
        $is_liked_by_current_user = 0;
        $result = array();
        $user_id_list = array($current_user_id);
        $user_id_user_info_map = array();
        $album_photos_info = array();
        $album_photos_array = $this->users_album_model->get_album_photos_info($photo_id)->result_array();
        if(!empty($album_photos_array))
        {
            $album_photos_info = $album_photos_array[0];
            //getting user id list from liked users
            $likes_photo = $album_photos_info['likes'];
            if( $likes_photo != "" && $likes_photo != NULL )
            {
                $likes_array = json_decode($likes_photo);
                foreach($likes_array as $like_info)
                {
                    if($like_info->user_id == $current_user_id)
                    {
                        $is_liked_by_current_user = 1;
                    }
                    if(!in_array($like_info->user_id, $user_id_list))
                    {
                        $user_id_list[] = $like_info->user_id;
                    }
                 }
            }
            //getting user id list from users who posted comments on this picture
            $feedbacks_photo = $album_photos_info['feedbacks'];
            if( $feedbacks_photo != "" && $feedbacks_photo != NULL )
            {
                $feedbacks_array = json_decode($feedbacks_photo);   
                foreach($feedbacks_array as $feedback)
                {
                    if(!in_array($feedback->user_id, $user_id_list))
                    {
                        $user_id_list[] = $feedback->user_id;
                    }
                }
            }
            //getting all userd based on user id list
            if(!empty($user_id_list))
            {
                $user_info_array = $this->ion_auth->get_users_general_info($user_id_list)->result_array();
                foreach($user_info_array as $user_info)
                {
                    $user_id_user_info_map[$user_info['user_id']] = $user_info;
                }
            }
            
            $user_list = array();
            if( $likes_photo != "" && $likes_photo != NULL )
            {
                $likes_array = json_decode($likes_photo);
                foreach($likes_array as $like_info)
                {
                    $user_list[] = $user_id_user_info_map[$like_info->user_id];
                }
            }
            $result['liked_user_list'] = $user_list;
            
            $feedback_list = array();
            if( $feedbacks_photo != "" && $feedbacks_photo != NULL )
            {
                $feedbacks_array = json_decode($feedbacks_photo); 
                foreach($feedbacks_array as $feedback)
                {
                    $current_feedback = array();
                    $current_feedback['id'] = $feedback->id;
                    $current_feedback['user_info'] = $user_id_user_info_map[$feedback->user_id];
                    $current_feedback['description'] = $feedback->description;
                    $current_feedback['created_on'] = $this->utils->convert_time($feedback->created_on);
                    $feedback_list[] = $current_feedback;
                }
            }
            $result['feedbacks'] = $feedback_list;
            $result['user_info'] = $user_id_user_info_map[$current_user_id];
            $result['is_liked_by_current_user'] = $is_liked_by_current_user;
        }
        return $result;
    }
    
    /*
     * This method will add a feedback under a photo
     * @param $photo_id, photo id
     * @param $feedback, description of feedback/comment
     * @Author Nazmul on 17th June 2014
     */
    public function add_feedback($photo_id, $feedback)
    {
        $album_photos_array = $this->users_album_model->get_album_photos_info($photo_id)->result_array();
        if(!empty($album_photos_array))
        {
            $album_photo_info = $album_photos_array[0];
            $feedbacks = $album_photo_info['feedbacks'];
            $$feedbacks_array = array();
            if( $feedbacks != "" && $feedbacks != NULL )
            {
                $feedbacks_array = json_decode($feedbacks);                
            }
            $user_id = $this->session->userdata['user_id'];
            $current_time = now();
            $current_feedback = new stdClass();
            $current_feedback->id = $this->utils->generateRandomString();
            $current_feedback->user_id = $user_id;
            $current_feedback->description = $feedback;
            $current_feedback->created_on = $current_time;
            $feedbacks_array[] = $current_feedback;
            $additional_data = array(
                'feedbacks' => json_encode($feedbacks_array)
            );
            $this->users_album_model->update_album_photo($photo_id, $additional_data);
            return TRUE;
        }
        return FALSE;
    }
    
    public function store_photo_like($photo_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        } 
        $liked_user_id_list = array($user_id);
        
        $likes_array = array();
        $album_photos_array = $this->users_album_model->get_album_photos_info($photo_id)->result_array();
        if(!empty($album_photos_array))
        {
            $user_like_info = $album_photos_array[0];
            $likes = $user_like_info['likes'];
            if( $likes != "" && $likes != NULL )
            {
                $likes_array = json_decode($likes);   
                foreach($likes_array as $like_info)
                {
                    if(!in_array($like_info->user_id, $liked_user_id_list))
                    {
                        $liked_user_id_list[] = $like_info->user_id;
                    }
                 }
            }
        }
        $current_like = new stdClass();
        $current_like->user_id = $user_id;
        $current_like->time = now();
        $likes_array[] = $current_like;
        
        $additional_data = array(
            'id' => $photo_id,
            'likes' => json_encode($likes_array)
        );
        $this->users_album_model->update_album_photo($photo_id, $additional_data);
        $result = array(
            'liked_user_list' => array()
        );
        if(!empty($liked_user_id_list))
        {
            $user_info_array = $this->ion_auth->get_users_general_info($liked_user_id_list)->result_array();
            $result['liked_user_list'] = $user_info_array;
        }         
        return $result;        
    }
    
    public function remove_photo_like($photo_id, $user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }   
        $liked_user_id_list = array();
        $likes_array = array();
        $updated_like_array = array();
        $album_photos_array = $this->users_album_model->get_album_photos_info($photo_id)->result_array();
        if(!empty($album_photos_array))
        {
            $user_like_info = $album_photos_array[0];
            $likes = $user_like_info['likes'];
            if( $likes != "" && $likes != NULL )
            {
                $likes_array = json_decode($likes); 
                foreach($likes_array as $like_info)
                {
                    if($like_info->user_id != $user_id)
                    {
                        $updated_like_array[] = $like_info;
                        if(!in_array($like_info->user_id, $liked_user_id_list))
                        {
                            $liked_user_id_list[] = $like_info->user_id;
                        }
                    }
                }
            }
        }
        $additional_data = array(
            'id' => $photo_id,
            'likes' => json_encode($updated_like_array)
        );
        $this->users_album_model->update_album_photo($photo_id, $additional_data);
        $result = array(
            'liked_user_list' => array()
        );
        if(!empty($liked_user_id_list))
        {
            $user_info_array = $this->ion_auth->get_users_general_info($liked_user_id_list)->result_array();
            $result['liked_user_list'] = $user_info_array;
        }         
        return $result;   
    }

}

?>
