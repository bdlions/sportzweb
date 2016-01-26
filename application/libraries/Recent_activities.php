<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Recent Activities
 * Author: Nazmul Hasan
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
        $this->load->model('org/application/score_prediction_model');
        
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
    
    public function get_recent_activites($user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        $sort_key = array();
        $recent_activities = array(); 
        //follower
        $user_followers_info_array = $this->recent_activities_model->get_user_mutual_relation_info($user_id)->result_array();
        $follower_id_list = array();
        $latest_follower_id = 0;
        $created_on = 0;
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
                       
                    }  
                    if($relation->created_on > $created_on)
                    {
                        $latest_follower_id = $relation->user_id;
                        $created_on = $relation->created_on; 
                    }
                }
            }
            if($latest_follower_id != 0)
            {
                $recent_activity = array(
                    'type' => RECENT_ACTIVITIES_FOLLOWERS,
                    'sort_key' => $created_on
                );
                $user_id_list = array($user_id, $latest_follower_id);
                $user_info_array = $this->recent_activities_model->get_users($user_id_list)->result_array();
                foreach($user_info_array as $user_info)
                {
                    if($user_info['user_id'] == $user_id)
                    {
                        $recent_activity['user_info'] = $user_info;
                    }
                    else if($user_info['user_id'] == $latest_follower_id)
                    {
                        $recent_activity['follower_info'] = $user_info;
                    }
                }
                $sort_key[] = $created_on;
                $recent_activities[] = $recent_activity;
            }
        }
        //recent connection
        $user_info_array = $this->recent_activities_model->get_connections()->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
            $recent_activity = array(
                'type' => RECENT_ACTIVITIES_CONNECTIONS,
                'user_info' => $user_info,
                'sort_key' => $user_info['created_on']
            );
            $sort_key[] = $user_info['created_on'];
            $recent_activities[] = $recent_activity;
        }
        //score prediction
        $match_predictions_array = $this->score_prediction_model->get_all_matches_predictions()->result_array();
        $match_id = 0;
        $prediction_follower_id = 0;
        $created_on = 0;
        foreach($match_predictions_array as $match_prediction_info)
        {
            $p_list = $match_prediction_info['prediction_list'];
            if($p_list != NULL && $p_list != "")
            {
                $prediction_list = json_decode($p_list);
                foreach($prediction_list as $prediction_info)
                {
                    if(in_array($prediction_info->user_id, $follower_id_list))
                    {
                        if($prediction_info->created_on > $created_on)
                        {
                            $match_id = $match_prediction_info['match_id'];
                            $prediction_follower_id = $prediction_info->user_id;
                            $created_on = $prediction_info->created_on; 
                        }
                    }
                }
            }    
        }
        if($prediction_follower_id != 0 && $match_id > 0)
        {
            $user_info_array = $this->recent_activities_model->get_users(array($prediction_follower_id))->result_array();
            if(!empty($user_info_array))
            {
                $prediction_user_info = $user_info_array[0];
                $recent_activity = array(
                    'type' => RECENT_ACTIVITIES_FIXTURES_RESULTS,
                    'match_id' => $match_id,
                    'user_info' => $prediction_user_info,
                    'sort_key' => $created_on
                );  
                $recent_activities[] = $recent_activity;
                $sort_key[] = $created_on;
            }
        } 
        //latest status
        if(!empty($follower_id_list))
        {
            $status_info_array = $this->recent_activities_model->get_status($follower_id_list)->result_array();
            if(!empty($status_info_array))
            {
                $status_info = $status_info_array[0];
                $user_info_array = $this->recent_activities_model->get_users(array($status_info['user_id']))->result_array();
                $recent_activity = array(
                    'type' => RECENT_ACTIVITIES_STATUS,
                    'status_info' => $status_info,
                    'user_info' => $user_info_array[0],
                    'sort_key' => $status_info['created_on']
                );  
                $recent_activities[] = $recent_activity;
                $sort_key[] = $status_info['created_on'];
            }
        }
        //latest blog
        if(!empty($follower_id_list))
        {
            $blog_list_array = $this->blog_app_model->get_blog_for_recent_activity($follower_id_list, array(APPROVED))->result_array();
            if(!empty($blog_list_array))
            {
                $blog_info = $blog_list_array[0];
                $recent_activity = array(
                    'type' => RECENT_ACTIVITIES_BLOGS,
                    'blog_info' => $blog_info,
                    'sort_key' => $blog_info['created_on']
                );  
                $recent_activities[] = $recent_activity;
                $sort_key[] = $blog_info['created_on'];
            }
        }  
        //latest photo
        if(!empty($follower_id_list))
        {
            $photo_info_array = $this->recent_activities_model->get_latest_photo($follower_id_list)->result_array();
            if(!empty($photo_info_array))
            {
                $photo_info = $photo_info_array[0];
                $user_info_array = $this->recent_activities_model->get_users(array($photo_info['user_id']))->result_array();
                $recent_activity = array(
                    'type' => RECENT_ACTIVITIES_PHOTOS,
                    'user_info' => $user_info_array[0],
                    'sort_key' => $photo_info['created_on']
                );  
                $recent_activities[] = $recent_activity;
                $sort_key[] = $photo_info['created_on'];
            }
        }        
        //latest like and comment
        if(!empty($follower_id_list))
        {
            $like_from_user_id = 0;
            $like_to_user_id = 0;
            $like_status_info = array();
            $comment_from_user_id = 0;
            $comment_to_user_id = 0;
            $comment_status_info = array();
            $max_time_like = 0;
            $max_time_comment = 0;
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
                            $like_from_user_id = $like_info->user_id;
                            $like_to_user_id = $status['user_id'];
                            $like_status_info = $status;
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
                            $comment_from_user_id = $feedback->user_id;
                            $comment_to_user_id = $status['user_id'];
                            $comment_status_info = $status;
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
                $recent_activity = array(
                    'type' => RECENT_ACTIVITIES_LIKES,
                    'status_info' => $like_status_info,
                    'from_user_info' => $user_id_info_map[$like_from_user_id],
                    'to_user_info' => $user_id_info_map[$like_to_user_id],
                    'sort_key' => $max_time_like
                );  
                $recent_activities[] = $recent_activity;
                $sort_key[] = $max_time_like;
            }
            if($max_time_comment != 0)
            {
                $recent_activity = array(
                    'type' => RECENT_ACTIVITIES_COMMENTS,
                    'status_info' => $comment_status_info,
                    'from_user_info' => $user_id_info_map[$comment_from_user_id],
                    'to_user_info' => $user_id_info_map[$comment_to_user_id],
                    'sort_key' => $max_time_comment
                );  
                $recent_activities[] = $recent_activity;
                $sort_key[] = $max_time_comment;
            }
        }   
        array_multisort($sort_key, SORT_DESC, $recent_activities);
        return $recent_activities;
    }
    
    
}

?>
