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
class Statuses {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('org/application/blog_app_library');
        $this->load->model('statuses_model');
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
        $this->load->library('org/utility/Utils');
        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('likes_model');

        $this->statuses_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->statuses_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in statuses_model');
        }

        return call_user_func_array(array($this->statuses_model, $method), $arguments);
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
    
    public function get_statuses($status_category_id = STATUS_LIST_NEWSFEED, $mapping_id = 0, $limit = STATUS_LIMIT_PER_REQUEST, $offset = 0, $status_id_list = array())
    {
        //this array will store all user id list related to statuses
        $user_id_list = array();
        //each key of this array is user id and value of the key is user info
        $user_id_user_info_map = array();
        
        $shared_recipe_id_list = array();
        $shared_service_id_list = array();
        $shared_news_id_list = array();
        $shared_blog_id_list = array();
        
        $photo_id_list = array();
        $photo_id_photo_info_map = array();
        $recipe_id_info_map = array();
        $service_id_info_map = array();
        $news_id_info_map = array();
        $blog_id_info_map = array();
        
        $user_id = $this->session->userdata('user_id');
        $filtered_user_id_list = array($user_id);
        $user_mutual_relation_info_array = $this->statuses_model->get_user_mutual_relation_info($user_id)->result_array();
        if(!empty($user_mutual_relation_info_array))
        {
            $relations = $user_mutual_relation_info_array[0]['relations'];
            if( $relations != "" && $relations != NULL )
            {
                $relations_array = json_decode($relations);   
                foreach($relations_array as $relation)
                {
                    if(!in_array($relation->user_id, $filtered_user_id_list) && $relation->is_follower == 1)
                    {
                        $filtered_user_id_list[] = $relation->user_id;
                    }                    
                }
            }
        }
        $shared_status_id_list = array();
        $status_list = array();
        $statuses = $this->statuses_model->get_statuses($status_category_id, $mapping_id, $limit, $offset, $filtered_user_id_list, $status_id_list)->result_array();
        if($statuses != null)
        {
            foreach ($statuses as $status)
            {
                if($status['shared_type_id'] == STATUS_SHARE_OTHER_STATUS)
                {
                    if(!in_array($status['reference_id'], $shared_status_id_list))
                    {
                        $shared_status_id_list[] = $status['reference_id'];
                    }
                }
                if($status['shared_type_id'] == STATUS_SHARE_HEALTHY_RECIPE)
                {
                    if(!in_array($status['reference_id'], $shared_recipe_id_list))
                    {
                        $shared_recipe_id_list[] = $status['reference_id'];
                    }
                }
                else if($status['shared_type_id'] == STATUS_SHARE_SERVICE_DIRECTORY)
                {
                    if(!in_array($status['reference_id'], $shared_service_id_list))
                    {
                        $shared_service_id_list[] = $status['reference_id'];
                    }
                }
                else if($status['shared_type_id'] == STATUS_SHARE_NEWS)
                {
                    if(!in_array($status['reference_id'], $shared_news_id_list))
                    {
                        $shared_news_id_list[] = $status['reference_id'];
                    }
                }
                else if($status['shared_type_id'] == STATUS_SHARE_BLOG)
                {
                    if(!in_array($status['reference_id'], $shared_blog_id_list))
                    {
                        $shared_blog_id_list[] = $status['reference_id'];
                    }
                }
                else if($status['shared_type_id'] == STATUS_SHARE_PHOTO)
                {
                    if(!in_array($status['reference_id'], $photo_id_list))
                    {
                        $photo_id_list[] = $status['reference_id'];
                    }
                }
                //we have photo id for changing profile picture or status with image
                if(($status['status_type_id'] == STATUS_TYPE_PROFILE_PIC_CHANGE || $status['status_type_id'] == STATUS_TYPE_IMAGE_ATTACHMENT) && $status['reference_id'] != null)
                {
                    if(!in_array($status['reference_id'], $photo_id_list))
                    {
                        $photo_id_list[] = $status['reference_id'];
                    }
                }
                
                $likes = $status['likes'];
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
                
                $feedbacks = $status['feedbacks'];
                $feedbacks_array = array();
                if( $feedbacks != "" && $feedbacks != NULL )
                {
                    $feedbacks_array = json_decode($feedbacks);   
                    foreach($feedbacks_array as $feedback)
                    {
                        if(!in_array($feedback->user_id, $user_id_list))
                        {
                            $user_id_list[] = $feedback->user_id;
                        }
                    }
                }
                
                $reference_list = $status['reference_list'];
                $reference_list_array = array();
                if( $reference_list != "" && $reference_list != NULL )
                {
                    $reference_list_array = json_decode($reference_list);   
                    foreach($reference_list_array as $reference)
                    {
                        if(!in_array($reference->id, $user_id_list))
                        {
                            $user_id_list[] = $reference->id;
                        }
                    }
                }
                if( $status['via_user_id'] != "" && $status['via_user_id'] != NULL )
                {
                    if(!in_array($status['via_user_id'], $user_id_list))
                    {
                        $user_id_list[] = $status['via_user_id'];
                    }
                }
            }
            $shared_status_id_info_map = array();
            $shared_statuse_info_array = $this->statuses_model->get_statuses(0, 0, 0, 0, 0, $shared_status_id_list)->result_array();
            foreach($shared_statuse_info_array as $shared_status_info)
            {
                $shared_status_info['description'] = html_entity_decode($shared_status_info['description']);
                $shared_status_id_info_map[$shared_status_info['status_id']] = $shared_status_info;
            }
            if(!empty($shared_recipe_id_list))
            {
                $recipe_info_array = $this->statuses_model->get_recipes($shared_recipe_id_list)->result_array();
                foreach($recipe_info_array as $recipe_info)
                {
                    $recipe_id_info_map[$recipe_info['id']] = $recipe_info;
                }
            }
            if(!empty($shared_service_id_list))
            {
                $service_info_array = $this->statuses_model->get_services($shared_service_id_list)->result_array();
                foreach($service_info_array as $service_info)
                {
                    $service_id_info_map[$service_info['id']] = $service_info;
                }
            }
            if(!empty($shared_news_id_list))
            {
                $news_info_array = $this->statuses_model->get_news($shared_news_id_list)->result_array();
                foreach($news_info_array as $news_info)
                {
                    $news_id_info_map[$news_info['id']] = $news_info;
                }
            }
            if(!empty($shared_blog_id_list))
            {
                $blog_info_array = $this->blog_app_library->get_blogs($shared_blog_id_list)->result_array();
                foreach($blog_info_array as $blog_info)
                {
                    $blog_id_info_map[$blog_info['blog_id']] = $blog_info;
                }
            }
            if(!empty($photo_id_list))
            {
                $photo_info_array = $this->statuses_model->get_photos($photo_id_list)->result_array();
                foreach($photo_info_array as $photo_info)
                {
                    $photo_id_photo_info_map[$photo_info['photo_id']] = $photo_info;
                }
            }
            if(!empty($user_id_list))
            {
                $user_info_array = $this->statuses_model->get_users($user_id_list)->result_array();
                foreach($user_info_array as $user_info)
                {
                    $user_id_user_info_map[$user_info['user_id']] = $user_info;
                }
            }
            
            
            /*$status_id_list = array();
            foreach ($statuses as $status)
            {
                $status_id_list[] = $status->status_id;
            }
            $status_id_usre_list_map = $this->likes->get_status_liked_user_list($status_id_list);*/
            $current_user_id = $this->session->userdata('user_id');
            foreach ($statuses as $status)
            {
                $status['allow_to_delete'] = FALSE;
                if($current_user_id == $status['user_id'])
                {
                    $status['allow_to_delete'] = TRUE;
                }
                $status['description'] = html_entity_decode($status['description']);
                //$status->liked_user_list = $status_id_usre_list_map[$status->status_id];
                //$status->reference_user_list = $this->likes->get_status_reference_user_list($status->status_id);
                
                $reference_user_list = array();
                $reference_list = $status['reference_list'];
                $reference_list_array = array();
                if( $reference_list != "" && $reference_list != NULL )
                {
                    $reference_list_array = json_decode($reference_list);   
                    foreach($reference_list_array as $reference)
                    {
                        $reference_user_list[] = $user_id_user_info_map[$reference->id];
                    }
                }
                $status['reference_list'] = array();
                $status['reference_list']['user_list'] = $reference_user_list;
                
                $attachments = $status['attachments'];
                $attachment_list = array();
                if( $attachments != "" && $attachments != NULL )
                {
                    $attachments_array = json_decode($attachments); 
                    foreach($attachments_array as $attachment)
                    {
                        $current_attachment = array();
                        $current_attachment['type'] = STATUS_ATTACHMENT_IMAGE;
                        $current_attachment['name'] = $attachment->name;
                        $attachment_list[] = $current_attachment;
                    }
                }
                $status['attachments'] = $attachment_list;                
                
                $likes = $status['likes'];
                $user_list = array();
                if( $likes != "" && $likes != NULL )
                {
                    $likes_array = json_decode($likes);
                    foreach($likes_array as $like_info)
                    {
                        $user_list[] = $user_id_user_info_map[$like_info->user_id];
                    }
                }
                $status['liked_user_list'] = $user_list;                
                
                $feedbacks = $status['feedbacks'];
                $feedback_list = array();
                if( $feedbacks != "" && $feedbacks != NULL )
                {
                    $feedbacks_array = json_decode($feedbacks); 
                    foreach($feedbacks_array as $feedback)
                    {
                        $current_feedback = array();
                        $current_feedback['id'] = $feedback->id;
                        $current_feedback['user_info'] = $user_id_user_info_map[$feedback->user_id];
                        $current_feedback['description'] = $feedback->description;
                        //$current_feedback['created_on'] = $feedback->created_on;
                        $current_feedback['created_on'] = $this->utils->convert_time($feedback->created_on);
                        $feedback_list[] = $current_feedback;
                    }
                }
                $status['feedbacks'] = $feedback_list;
                //storing shared object info
                $status['reference_info'] = array();
                if($status['shared_type_id'] == STATUS_SHARE_OTHER_STATUS && isset($shared_status_id_info_map[$status['reference_id']]) )
                {                    
                    $status['reference_info'] = $shared_status_id_info_map[$status['reference_id']];
                }
                else if($status['shared_type_id'] == STATUS_SHARE_HEALTHY_RECIPE && isset($recipe_id_info_map[$status['reference_id']]) )
                {
                    $status['reference_info'] = $recipe_id_info_map[$status['reference_id']];
                }
                else if($status['shared_type_id'] == STATUS_SHARE_SERVICE_DIRECTORY && isset($service_id_info_map[$status['reference_id']]) )
                {
                    $status['reference_info'] = $service_id_info_map[$status['reference_id']];
                }
                else if($status['shared_type_id'] == STATUS_SHARE_NEWS && isset($news_id_info_map[$status['reference_id']]) )
                {
                    $status['reference_info'] = $news_id_info_map[$status['reference_id']];
                }
                else if($status['shared_type_id'] == STATUS_SHARE_BLOG && isset($blog_id_info_map[$status['reference_id']]) )
                {
                    $status['reference_info'] = $blog_id_info_map[$status['reference_id']];
                }
                else if($status['shared_type_id'] == STATUS_SHARE_PHOTO && isset($photo_id_photo_info_map[$status['reference_id']]) )
                {
                    $status['reference_info'] = $photo_id_photo_info_map[$status['reference_id']];
                }
                if( $status['via_user_id'] != "" && $status['via_user_id'] != NULL )
                {
                    $status['via_user_info'] = $user_id_user_info_map[$status['via_user_id']];
                }
                
                if(($status['status_type_id'] == STATUS_TYPE_PROFILE_PIC_CHANGE || $status['status_type_id'] == STATUS_TYPE_IMAGE_ATTACHMENT) && isset($photo_id_photo_info_map[$status['reference_id']]) )
                {
                    $status['reference_info'] = $photo_id_photo_info_map[$status['reference_id']];
                }
                $status['status_created_on'] = $this->utils->convert_time($status['status_created_on']);
                $status_list[] = $status;
            }
            
        }
        return $status_list;
    }
    
    /*
     * This method will add a feedback under status
     * @param $status_id, status id
     * @param $feedback, description of feedback/comment
     * @Author Nazmul on 3rd May 2014
     */
    public function add_feedback($status_id, $feedback)
    {
        $status_info_array = $this->statuses_model->get_status_info($status_id)->result_array();
        if(!empty($status_info_array))
        {
            $status_info = $status_info_array[0];
            $feedbacks = $status_info['feedbacks'];
            $feedbacks_array = array();
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
                'feedbacks' => json_encode($feedbacks_array),
                'modified_on' => now()
            );
            $this->statuses_model->update_status($status_id, $additional_data);
            return TRUE;
        }
        return FALSE;
    }
    
    //------------------Status image related methods -----------------------------//
    /*
     * This method will upload an image into a temp directory for status
     * @Author Nazmul on 3rd May 2014
     */
    function status_upload_image($image_relative_path)
    {
        $image_absolute_path = FCPATH.$image_relative_path;
        if( !is_dir($image_absolute_path) )
        {
            mkdir($image_absolute_path, 0777, TRUE);
        }
        $upload_path_url = base_url() . $image_relative_path;
        $config['upload_path'] = FCPATH . $image_relative_path;
        
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = STATUS_IMAGE_UPLOAD_MAX_SIZE;
        $config['file_name'] = $this->utils->generateRandomString();
        $this->load->library("upload", $config);

        $info = array();
        if (!$this->upload->do_upload()) 
        {
            $error = array('error' => $this->upload->display_errors());            
            $info['status'] = 0;
            $info['error'] = $error;
        } 
        else 
        {
            $data = $this->upload->data();
            $info['status'] = 1;
            $info['name'] = $data['file_name'];
            $info['size'] = $data['file_size'];
            $info['type'] = $data['file_type'];
            $info['url'] = $upload_path_url . $data['file_name'];            
        }        
        return $info;
    }    
}

?>
