<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Albums
 *
 * Author: Nazmul on 27th July 2014
 *
 * Description:  Photo related functionalities
 *
 * Requirements: PHP5 or above
 *
 */
class Albums {
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
                        $this->load->model('albums_model');

        $this->albums_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->albums_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in albums_model');
        }

        return call_user_func_array(array($this->albums_model, $method), $arguments);
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
    
    public function add_photo($photo_data)
    {
        $user_id = $this->session->userdata('user_id');
        $current_time = now();
        $album_id = 0;
        $album_info_array = $this->albums_model->get_user_album_info(ALBUM_TYPE_USER_PHOTOS, $user_id)->result_array();
        if(!empty($album_info_array))
        {
            $album_info = $album_info_array[0];
            $album_id = $album_info['album_id'];
        }
        else
        {
            $additional_data = array(
                'reference_id' => $user_id,
                'album_type_id' => ALBUM_TYPE_USER_PHOTOS,
                'created_on' => $current_time,
                'creation_complete' => TRUE
            );
            $album_id = $this->albums_model->create_album($additional_data);
        }
        if($album_id !== FALSE && $album_id > 0)
        {
            $photo_data['album_id'] = $album_id;
            $photo_data['created_on'] = $current_time;
            $photo_id = $this->albums_model->add_photo($photo_data);
            return $photo_id;
        }
        return FALSE;
    }
    
    public function add_profile_picture($photo_data)
    {
        $user_id = $this->session->userdata('user_id');
        $current_time = now();
        $album_id = 0;
        $album_info_array = $this->albums_model->get_user_album_info(ALBUM_TYPE_USER_PROFILE_PHOTOS, $user_id)->result_array();
        if(!empty($album_info_array))
        {
            $album_info = $album_info_array[0];
            $album_id = $album_info['album_id'];
        }
        else
        {
            $additional_data = array(
                'title' => 'Profile Picture',
                'reference_id' => $user_id,
                'album_type_id' => ALBUM_TYPE_USER_PROFILE_PHOTOS,
                'created_on' => $current_time,
                'creation_complete' => TRUE
            );
            $album_id = $this->albums_model->create_album($additional_data);
        }
        if($album_id !== FALSE && $album_id > 0)
        {
            $photo_data['album_id'] = $album_id;
            $photo_data['created_on'] = $current_time;
            $photo_id = $this->albums_model->add_photo($photo_data);
            return $photo_id;
        }
        return FALSE;
    }
    
    /*
     * This method will add a photo in an album, 
     * If there is no album then at first album will be created and then photo will be stored
     * @param $album_type_id, album type id
     * @param $reference_id, reference id i.e. user id/business profile id
     * @Author Nazmul on 30th September 2014
     */
    public function add_photo_in_album($album_type_id, $reference_id, $photo_data)
    {
        $current_time = now();
        $album_id = 0;
        $album_info_array = $this->albums_model->get_reference_album_info($album_type_id, $reference_id)->result_array();
        if(!empty($album_info_array))
        {
            $album_info = $album_info_array[0];
            $album_id = $album_info['album_id'];
        }
        else
        {
            $album_title = '';
            if($album_type_id == ALBUM_TYPE_USER_PROFILE_PHOTOS)
            {
                $album_title = ALBUM_TYPE_USER_PROFILE_PHOTOS_TITLE;
            }
            $additional_data = array(
                'title' => $album_title,
                'reference_id' => $reference_id,
                'album_type_id' => $album_type_id,
                'created_on' => $current_time,
                'creation_complete' => TRUE
            );
            $album_id = $this->albums_model->create_album($additional_data);
        }
        if($album_id !== FALSE && $album_id > 0)
        {
            $photo_data['album_id'] = $album_id;
            $photo_data['created_on'] = $current_time;
            $photo_id = $this->albums_model->add_photo($photo_data);
            return $photo_id;
        }
        return FALSE;
    }
    
    public function get_photo_details($photo_id)
    {
        $current_user_id = $this->session->userdata('user_id');
        $is_liked_by_current_user = 0;
        $result = array();
        $user_id_list = array($current_user_id);
        $user_id_user_info_map = array();
        $album_photos_info = array();
        $album_photos_array = $this->albums_model->get_photo_info($photo_id)->result_array();
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
    
    public function add_feedback($photo_id, $feedback)
    {
        $album_photos_array = $this->albums_model->get_photo_info($photo_id)->result_array();
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
            $this->albums_model->update_photo_info($photo_id, $additional_data);
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
        $album_photos_array = $this->albums_model->get_photo_info($photo_id)->result_array();
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
        $this->albums_model->update_photo_info($photo_id, $additional_data);
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
        $album_photos_array = $this->albums_model->get_photo_info($photo_id)->result_array();
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
        $this->albums_model->update_photo_info($photo_id, $additional_data);
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
