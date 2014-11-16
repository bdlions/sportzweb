<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include 'jsonRPCServer.php';

class App_blog extends JsonRPCServer {
//class App_blog extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/application/blog_app_library');
		
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
    }

    function index() {
        
    }
    
    function load_blog_app()
    {
        $response = array();        
        $blog_category_blog_list = array();
        $blog_custom_category_list = array();
        
        $blog_custom_category_list_array = $this->blog_app_model->get_all_blog_custom_categories()->result_array();
        foreach($blog_custom_category_list_array as $blog_custom_category)
        {
            if($blog_custom_category['id'] == 1)
            {
                $blog_list = array();
                $blog_home_page_configuration = $this->blog_app_library->get_home_page_blog_configuration();
                if(array_key_exists('blog_id_blog_info_map', $blog_home_page_configuration))
                {
                    $blog_list_array = $blog_home_page_configuration['blog_id_blog_info_map'];
                    foreach($blog_list_array as $blog_info)
                    {
                        $blog = array(
                            'id' => $blog_info['id'],
                            'title' => $blog_info['title'],
                            'picture' => $blog_info['picture']
                        );
                        $blog_list[] = $blog;
                    }
                    $category_blog = array(
                        'id' => 0,
                        'title' => $blog_custom_category['title'],
                        'blog_list' => $blog_list
                    );
                    $blog_category_blog_list[] = $category_blog;
                }
            }
            else
            {
                $category = array(
                    'id' => $blog_custom_category['id'],
                    'title' => $blog_custom_category['title']
                );
                $blog_custom_category_list[] = $category;
            }
            
        }
        
        $blog_category_list_array = $this->blog_app_model->get_all_blog_categories()->result_array();
        foreach($blog_category_list_array as $blog_category)
        {
            $blog_list = array();
            $blog_list_array = $this->blog_app_library->get_all_blog_by_category($blog_category['id']);
            foreach($blog_list_array as $blog_info)
            {
                $blog = array(
                    'id' => $blog_info['id'],
                    'title' => $blog_info['title'],
                    'picture' => $blog_info['picture']
                );
                $blog_list[] = $blog;
            }
            $category_blog = array(
                'id' => $blog_category['id'],
                'title' => $blog_category['title'],
                'blog_list' => $blog_list
            );
            $blog_category_blog_list[] = $category_blog;
        }        
        $response['blog_category_blog_list'] = $blog_category_blog_list;
        $response['blog_custom_category_list'] = $blog_custom_category_list;
        return json_encode($response);
    }
    
    /*
     * This method will return blog info
     * @param $blog_id, blog id
     * @Author Nazmul on 3rd November 2014
     */
    function get_blog_info($blog_id = 0)
    {
        $result = array();
        $blog_info = array();
        $blog_info_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(!empty($blog_info_array))
        {
            $blog_info = $blog_info_array[0];
            $blog_category_info = $this->blog_app_library->get_category_info_of_blog($blog_info['blog_id']);
            $blog_info['blog_category_list'] = $blog_category_info['blog_category_list'];
            $blog_info['selected_blog_category_list'] = $blog_category_info['selected_blog_category_list'];
            //$blog_info['category_id_list'] = $this->blog_app_library->get_category_id_list_of_blog($blog_info['blog_id']);
        }
        $result['blog_info'] = $blog_info;
        $result['comment_list'] = $this->blog_app_library->get_all_comments($blog_id);
        //echo(json_encode($result));
        return json_encode($result);
    }
    
    /*
     * This method will return my blog list
     * @Author Nazmul on 3rd November 2014
     */
    function get_my_blogs($user_id)
    {
        $result = array();
        $my_blog_list = $this->blog_app_library->get_all_blogs_by_user($user_id);
        $result['my_blog_list'] = $my_blog_list;
        //print_r(json_encode($result));
        return json_encode($result);
    }
    
    /*
     * This method will create a new blog
     * @Author Nazmul on 3rd November 2014
     */
    function create_blog($blog_data = '')
    {
        $result = array();
        $data = json_decode($blog_data);
        /*$data = new stdClass();
        $data->title = 'sample blog title';
        $data->description = 'sample description';
        $data->user_id = '2';
        $data->picture = 'a.jpg';
        $data->picture_description = 'pictuer description'; 
        $data->created_on = now(); 
        $data->blog_status_id = PENDING; 
         */
        $blog_id = $this->blog_app_library->create_blog($data);
        //based on the structure of your category id, update blog category table
        //$this->blog_app_library->blog_category_list_update($blog_category_id,$blog_id);
        $result['status'] = RPC_SUCCESS;
        return json_encode($result);
    }
    
    function update_blog($blog_data = '')
    {
        
    }
    
    /*
     * This method will send the delete request to the admin
     * @Author Nazmul on 3rd November 2014
     */
    function request_to_remove_blog($blog_id)
    {
        $result = array();
        $result['status'] = true;
        $result['message'] = "A request to delete your blog has been sent";

        $blog_info = array();
        $blog_info_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(!empty($blog_info_array)) {
            $blog_info = $blog_info_array[0];
            if($blog_info['blog_status_id'] == PENDING || $blog_info['blog_status_id'] == APPROVED)
            {
                //implement case 2,6
                unset($blog_info['id']);
                $blog_info['blog_status_id'] = DELETION_PENDING;
                $blog_info['reference_id'] = $blog_id;
                $id = $this->blog_app_library->create_blog($blog_info);

                if($id == FALSE)
                {
                    $result['status'] = false;
                    $result['message'] = "Your request to delete the blog is unsuccessful";
                }
            }
            else if($blog_info['blog_status_id'] == RE_APPROVAL)
            {
                //implement case 9
                $blog_info['blog_status_id'] = DELETION_PENDING;
                $flag = $this->blog_app_library->update_blog($blog_id,$blog_info);

                if($flag == FALSE)
                {
                    $result['status'] = false;
                    $result['message'] = "Your request to delete the blog is unsuccessful";
                }
            }
        }
        else
        {
            $result['status'] = false;
            $result['message'] = "Invalid blog. Please try again later.";
        }        
        //echo json_encode($result);
        return json_encode($result);
    }
	
	function get_blog_category_list(){
		$result = array();
		$blog_category_list = array();
		$category_list_array = $this->blog_app_library->get_all_blog_category()->result_array();
		foreach($category_list_array as $blog_category_info)
		{
			$blog_category = array(
				'id' => $blog_category_info['id'],
				'title' => $blog_category_info['title']
			);
			$blog_category_list[] = $blog_category;
		}
		$result['blog_category_list'] = $blog_category_list;
		//print_r(json_encode($result));
        return json_encode($result);
	}
}