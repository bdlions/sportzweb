<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comments extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('auth');        
        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/application/healthy_recipes_library');
        $this->load->library('org/application/service_directory_library');
        $this->load->library('org/application/news_app_library');
        $this->load->library('org/application/blog_app_library');
    }
    
    public function post_comment()
    {
        $response = array();
        $application_id = $this->input->post('application_id');
        $item_id = $_POST['item_id'];
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }
        
        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'created_on' => now()
        );
        $id = FALSE;
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $data['recipe_id'] = $item_id;
            $id = $this->healthy_recipes_library->create_comment($data);
        }
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $data['service_id'] = $item_id;
            $id = $this->service_directory_library->create_comment($data);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $data['news_id'] = $item_id;
            $id = $this->news_app_library->create_comment($data);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $data['blog_id'] = $item_id;
            $id = $this->blog_app_library->create_comment($data);
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
        echo json_encode($response);
    }
    
    public function edit_comment()
    {
        $response = array();
        $application_id = $this->input->post('application_id');
        $item_id = $_POST['item_id'];
        $comment_id = trim($_POST['comment_id']);
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }        
        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'modified_on' => now()
        );
        $id = FALSE;
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $id = $this->healthy_recipes_library->update_comment($comment_id, $data);
        }
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $id = $this->service_directory_library->update_comment($comment_id, $data);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $id = $this->news_app_library->update_comment($comment_id, $data);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $id = $this->blog_app_library->update_comment($comment_id, $data);
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
        echo json_encode($response);
    }
    
    public function remove_comment()
    {
        $response = array();
        $application_id = $this->input->post('application_id');
        $comment_id = $this->input->post('comment_id');
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
        echo json_encode($response);
    }
    
    public function search_comment_list()
    {
        $result=array();
        $application_id = $this->input->post('application_id');
        $value = $_POST['value'];
        $item_id = $_POST['item_id'];
        $list = $_POST['list'];
        $recipe_list = array();
        if($application_id == APPLICATION_HEALTYY_RECIPES_ID)
        {
            $recipe_list = $this->healthy_recipes_library->get_all_comments($item_id, $value, $list);
        }   
        else if($application_id == APPLICATION_SERVICE_DIRECTORY_ID)
        {
            $recipe_list = $this->service_directory_library->get_all_comments($item_id, $value, $list);
        }
        else if($application_id == APPLICATION_NEWS_APP_ID)
        {
            $recipe_list = $this->news_app_library->get_all_comments($item_id, $value, $list);
        }
        else if($application_id == APPLICATION_BLOG_APP_ID)
        {
            $recipe_list = $this->blog_app_library->get_all_comments($item_id, $value, $list);
        }
        $result['comment_list'] = $recipe_list;
        echo json_encode($result);
    }
    
    //ajax call
    public function like_comment()
    {
        $application_id = $this->input->post('application_id');
        $comment_id = $_POST['comment_id'];
        $user_id = $this->session->userdata('user_id');
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
    
    public function unlike_comment()
    {
        $application_id = $this->input->post('application_id');
        $comment_id = $_POST['comment_id'];
        $user_id = $this->session->userdata('user_id');
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
}

?>
