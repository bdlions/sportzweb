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
class Recent_activities {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('users_album');
        $this->load->model('org/application/blog_app_model');
        
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
                        $this->load->model('recent_activities_model');

        $this->recent_activities_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->recent_activities_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in recent_activities_model');
        }

        return call_user_func_array(array($this->recent_activities_model, $method), $arguments);
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
    
    public function get_recent_activites()
    {
        $user_id = $this->session->userdata('user_id');
        $recent_activities = array();
        
        $recent_activities[RECENT_ACTIVITIES_FOLLOWERS] = array();
        $user_followers_info_array = $this->recent_activities_model->get_user_mutual_relation_info($user_id)->result_array();
        $follower_id_list = array();
        $latest_follower_id = 0;
        if(!empty($user_followers_info_array))
        {
            $user_followers_info = $user_followers_info_array[0];
            $relations = $user_followers_info['relations'];
            if( $relations != "" && $relations != NULL )
            {
                $relations_array = json_decode($relations);   
                foreach($relations_array as $relation)
                {
                    //checking only followers
                    if(!in_array($relation->user_id, $follower_id_list) && $relation->is_follower == 1)
                    {
                        $follower_id_list[] = $relation->user_id;
                        $latest_follower_id = $relation->user_id;
                    }                    
                }
            }
            if($latest_follower_id != 0)
            {
                $user_id_list = array($user_id, $latest_follower_id);
                $user_info_array = $this->recent_activities_model->get_users($user_id_list)->result_array();
                foreach($user_info_array as $user_info)
                {
                    if($user_info['user_id'] == $user_id)
                    {
                        $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info'] = $user_info;
                    }
                    else if($user_info['user_id'] == $latest_follower_id)
                    {
                        $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['follower_info'] = $user_info;
                    }
                }
            }
        }
        
        $recent_activities[RECENT_ACTIVITIES_STATUS] = array();
        $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info'] = array();
        
        if(!empty($follower_id_list))
        {
            $status_info_array = $this->recent_activities_model->get_status($follower_id_list)->result_array();
            if(!empty($status_info_array))
            {
                $status_info = $status_info_array[0];
                $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info'] = $status_info;
                $user_info_array = $this->recent_activities_model->get_users(array($status_info['user_id']))->result_array();
                $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info'] = $user_info_array[0];
            }
        }
        
        $recent_activities[RECENT_ACTIVITIES_CONNECTIONS] = array();
        $user_info_array = $this->recent_activities_model->get_connections()->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
            $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][] = $user_info;
        }
        
        $recent_activities[RECENT_ACTIVITIES_PHOTOS] = array();
        if(!empty($follower_id_list))
        {
            $photo_info_array = $this->users_album->get_latest_photo($follower_id_list)->result_array();
            if(!empty($photo_info_array))
            {
                $photo_info = $photo_info_array[0];
                $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info'] = $photo_info;
                $user_info_array = $this->recent_activities_model->get_users(array($photo_info['user_id']))->result_array();
                $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info'] = $user_info_array[0];
            }
        }
        
        $recent_activities[RECENT_ACTIVITIES_LIKES] = array();
        $recent_activities[RECENT_ACTIVITIES_COMMENTS] = array();
        if(!empty($follower_id_list))
        {
            $like_from_user_id = 0;
            $like_to_user_id = 0;
            $comment_from_user_id = 0;
            $comment_to_user_id = 0;
            $max_time_like = 0;
            $max_time_comment = 0;
            /*if(!in_array($user_id, $follower_id_list))
            {
                $follower_id_list[] = $user_id;
            }*/
            $status_info_array = $this->recent_activities_model->get_recent_statuses(array_merge($follower_id_list, array($user_id)))->result_array();
            foreach($status_info_array as $status)
            {
                $likes = $status['likes'];
                if( $likes != "" && $likes != NULL )
                {
                    $likes_array = json_decode($likes);
                    foreach($likes_array as $like_info)
                    {
                        //checking latest like from one user to another user
                        if($like_info->time > $max_time_like && $status['user_id'] != $like_info->user_id)
                        {
                            $max_time_like = $like_info->time;
                            $like_from_user_id = $status['user_id'];
                            $like_to_user_id = $like_info->user_id;
                        }
                     }
                }
                $feedbacks = $status['feedbacks'];
                $feedbacks_array = array();
                if( $feedbacks != "" && $feedbacks != NULL )
                {
                    $feedbacks_array = json_decode($feedbacks);   
                    foreach($feedbacks_array as $feedback)
                    {
                        //checking latest comment from one user to another user
                        if($feedback->created_on > $max_time_comment && $status['user_id'] != $feedback->user_id)
                        {
                            $max_time_comment = $feedback->created_on;
                            $comment_from_user_id = $status['user_id'];
                            $comment_to_user_id = $feedback->user_id;
                        }
                    }
                }
            }
            $user_id_list = array();
            $user_id_info_map = array();
            if($like_from_user_id != 0 && !in_array($like_from_user_id, $user_id_list))
            {
                $user_id_list[] = $like_from_user_id;
            }
            if($like_to_user_id != 0 && !in_array($like_to_user_id, $user_id_list))
            {
                $user_id_list[] = $like_to_user_id;
            }
            if($comment_from_user_id != 0 && !in_array($comment_from_user_id, $user_id_list))
            {
                $user_id_list[] = $comment_from_user_id;
            }
            if($comment_to_user_id != 0 && !in_array($comment_to_user_id, $user_id_list))
            {
                $user_id_list[] = $comment_to_user_id;
            }
            if(!empty($user_id_list))
            {
                $user_info_array = $this->recent_activities_model->get_users($user_id_list)->result_array();
            }            
            foreach($user_info_array as $user_info)
            {
                $user_id_info_map[$user_info['user_id']] = $user_info;
            }
            if($max_time_like != 0)
            {
                $recent_activities[RECENT_ACTIVITIES_LIKES]['from_user_info'] = $user_id_info_map[$like_from_user_id];
                $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info'] = $user_id_info_map[$like_to_user_id];
            }
            if($max_time_comment != 0)
            {
                $recent_activities[RECENT_ACTIVITIES_COMMENTS]['from_user_info'] = $user_id_info_map[$comment_from_user_id];
                $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info'] = $user_id_info_map[$comment_to_user_id];
            }
        }
        
        $recent_activities[RECENT_ACTIVITIES_BLOGS] = array();
        $blog_info = array();   
        if(!empty($follower_id_list))
        {
            $blog_list_array = $this->blog_app_model->get_blog_for_recent_activity($follower_id_list, array(APPROVED))->result_array();
            if(!empty($blog_list_array))
            {
                $blog_info = $blog_list_array[0];
            }
        }        
        $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info'] = $blog_info;
        
        return $recent_activities;
    }
    
    
}

?>
