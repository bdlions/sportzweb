<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_comments extends JsonRPCServer {
//class App_comments extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/healthy_recipes_library');
        $this->load->library('org/application/service_directory_library');
        $this->load->library('org/application/news_app_library');
        $this->load->library('org/application/blog_app_library');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }   
    
    /*
     * This method will add a comment of an application
     * @Author Nazmul on 15th November 2014
     */
    public function post_comment($comment_data = '')
    {
        $response = array();
        
        $data = json_decode($comment_data);
        
        /*$data = new stdClass();
        $data->application_id = 2;
        $data->user_id = 4;
        $data->item_id = 1;
        $data->comment = 'sample comment';
        $data->rate_id = '2';*/
        
        $application_id = $data->application_id;
        $item_id = $data->item_id;
        $comment = $data->comment;
        $rate_id = $data->rate_id;
        $user_id = $data->user_id;
        
        $additional_data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $user_id,
            'created_on' => now()
        );
        $id = FALSE;
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $additional_data['recipe_id'] = $item_id;
            $id = $this->healthy_recipes_library->create_comment($additional_data);
        }
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $additional_data['service_id'] = $item_id;
            $id = $this->service_directory_library->create_comment($additional_data);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $additional_data['news_id'] = $item_id;
            $id = $this->news_app_library->create_comment($additional_data);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $additional_data['blog_id'] = $item_id;
            $id = $this->blog_app_library->create_comment($additional_data);
        }
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is added successfully.';
            $comment_info_array = array();
            if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
            {
                $comment_info_array = $this->healthy_recipes_library->get_all_comments(0, 0, 0, $id);
            }
            if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
            {
                $comment_info_array = $this->healthy_recipes_library->get_all_comments(0, 0, 0, $id);
            }
            else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
            {
                $comment_info_array = $this->service_directory_library->get_all_comments(0, 0, 0, $id);
            }
            else if($application_id == APPLICATION_NEWS_APP_ID)
            {
                $comment_info_array = $this->news_app_library->get_all_comments(0, 0, 0, $id);
            }
            else if($application_id == APPLICATION_BLOG_APP_ID)
            {
                $comment_info_array = $this->blog_app_library->get_all_comments(0, 0, 0, $id);
            }
            
            if(!empty($comment_info_array))
            {
                $response['comment_info'] = $comment_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $message = '';
            if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
            {
                $message = $this->healthy_recipes_library->errors_alert();
            }   
            else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
            {
                $message = $this->service_directory_library->errors_alert();
            }
            else if($application_id == APPLICATION_NEWS_APP_ID)
            {
                $message = $this->news_app_library->errors_alert();
            }
            else if($application_id == APPLICATION_BLOG_APP_ID)
            {
                $message = $this->blog_app_library->errors_alert();
            }
            $response['message'] = $message;
        }        
        //echo json_encode($response);
        return json_encode($response);
    }
    
    /*
     * This method will edit a comment of an application
     * @Author Nazmul on 15th November 2014
     */
    public function edit_comment($comment_data = '')
    {
        $response = array();
        $data = json_decode($comment_data);
        
        /*$data = new stdClass();
        $data->application_id = 2;
        $data->comment_id = 4;
        $data->user_id = 4;
        $data->comment = 'sample edited comment';
        $data->rate_id = '2';*/
        
        $application_id = $data->application_id;
        $comment_id = $data->comment_id;
        $comment = $data->comment;
        $rate_id = $data->rate_id;
        $user_id = $data->user_id;
              
        $additional_data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $user_id,
            'modified_on' => now()
        );
        $id = FALSE;
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $id = $this->healthy_recipes_library->update_comment($comment_id, $additional_data);
        }
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $id = $this->service_directory_library->update_comment($comment_id, $additional_data);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $id = $this->news_app_library->update_comment($comment_id, $additional_data);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $id = $this->blog_app_library->update_comment($comment_id, $additional_data);
        }
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is update successfully.';
            $comments_array = array();
            if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
            {
                $comments_array = $this->healthy_recipes_library->get_all_comments(0, 0, 0, $comment_id);
            }   
            else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
            {
                $comments_array = $this->service_directory_library->get_all_comments(0, 0, 0, $comment_id);
            }
            else if($application_id == APPLICATION_NEWS_APP_ID)
            {
                $comments_array = $this->news_app_library->get_all_comments(0, 0, 0, $comment_id);
            }
            else if($application_id == APPLICATION_BLOG_APP_ID)
            {
                $comments_array = $this->blog_app_library->get_all_comments(0, 0, 0, $comment_id);
            }
            if(!empty($comments_array))
            {
                $response['comment_info'] = $comments_array[0];                
            }     
        }
        else
        {
            $response['status'] = 0;
            $message = '';
            if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
            {
                $message = $this->healthy_recipes_library->errors_alert();
            }   
            else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
            {
                $message = $this->service_directory_library->errors_alert();
            }
            else if($application_id == APPLICATION_NEWS_APP_ID)
            {
                $message = $this->news_app_library->errors_alert();
            }
            else if($application_id == APPLICATION_BLOG_APP_ID)
            {
                $message = $this->blog_app_library->errors_alert();
            }
            $response['message'] = $message;
            
        }        
        //echo json_encode($response);
        return json_encode($response);
    }
    
    /*
     * This method will remove a comment from an application
     * @Author Nazmul on 15th November 2014
     */
    public function remove_comment($application_id = 0, $comment_id = 0)
    {
        $response = array();
        $id = FALSE;
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $id = $this->healthy_recipes_library->remove_comment($comment_id);
        }   
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $id = $this->service_directory_library->remove_comment($comment_id);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $id = $this->news_app_library->remove_comment($comment_id);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $id = $this->blog_app_library->remove_comment($comment_id);
        }
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is removed successfully.';   
        }
        else
        {
            $response['status'] = 0;
            $message = '';
            if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
            {
                $message = $this->healthy_recipes_library->errors_alert();
            }   
            else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
            {
                $message = $this->service_directory_library->errors_alert();
            }
            else if($application_id == APPLICATION_NEWS_APP_ID)
            {
                $message = $this->news_app_library->errors_alert();
            }
            else if($application_id == APPLICATION_BLOG_APP_ID)
            {
                $message = $this->blog_app_library->errors_alert();
            }
            $response['message'] = $message;
        }        
        //echo json_encode($response);
        return json_encode($response);
    }
    
    /*
     * This method will add a user to the liked list under a comment of an application
     * @Author Nazmul on 15th November 2014
     */
    public function like_comment($application_id = 0, $comment_id = 0, $user_id = 0)
    {
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $this->healthy_recipes_library->store_like($comment_id, $user_id);
        }
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $this->service_directory_library->store_like($comment_id, $user_id);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $this->news_app_library->store_like($comment_id, $user_id);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $this->blog_app_library->store_like($comment_id, $user_id);
        }
    }
    
    /*
     * This method will remove a user from liked list under a comment of an application
     * @Author Nazmul on 15th November 2014
     */
    public function unlike_comment($application_id = 0, $comment_id = 0, $user_id = 0)
    {
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $this->healthy_recipes_library->remove_like($comment_id, $user_id);
        }
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $this->service_directory_library->remove_like($comment_id, $user_id);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $this->news_app_library->remove_like($comment_id, $user_id);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $this->blog_app_library->remove_like($comment_id, $user_id);
        }
    }
	
	public function share_recipe ($application_id = 0, $item_id = 0, $user_id = 0) {
		if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
           
        }
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
           
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            
        }
	}
}