<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Blog App Library
 * Author: Nazmul Hasan
 * Requirements: PHP5 or above
 *
 */
class Blog_app_library {

    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('basic_profile');
        $this->load->library('org/utility/utils');
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
                        $this->load->model('org/application/blog_app_model');

        $this->blog_app_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->blog_app_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in blog_app_model');
        }

        return call_user_func_array(array($this->blog_app_model, $method), $arguments);
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
     * This method will return blogs based on blog category
     * @param $category_id, blog category id
     * @autor nazmul hasan
     * @created on 23rd September 2015
     * @modified on 23rd September 2015
     */
    public function get_all_blogs_by_category($category_id) {
        $blog_info_list = array();
        $blog_id_array = array();
        $blog_category_info_array = $this->blog_app_model->get_blog_category_info($category_id)->result_array();
        if(!empty($blog_category_info_array))
        {
            $blog_category_info = $blog_category_info_array[0];
            $blog_list = $blog_category_info['blog_list'];
            if($blog_list != "" && strtolower($blog_list) !="null" && $blog_list != null)
            {
                $blog_list_array = json_decode($blog_list);
                if(!empty($blog_list_array)) {
                    foreach ($blog_list_array as $blog_info) {
                        if(!in_array($blog_info->blog_id, $blog_id_array))
                        {
                            $blog_id_array[] = $blog_info->blog_id;
                        }
                    }
                }
            }            
        }
        if(!empty($blog_id_array))
        {
            $blogs_array = $this->blog_app_model->get_blogs($blog_id_array, array(APPROVED), 0, 'desc')->result_array();            
            $blogs_comment_counter_array = $this->blog_app_model->get_blogs_comment_counter($blog_id_array)->result_array();
            $blog_id_total_comments_map = array();
            foreach($blogs_comment_counter_array as $blog_comment_counter)
            {
                $blog_id_total_comments_map[$blog_comment_counter['blog_id']] = $blog_comment_counter['total_comments'];
            }
            foreach($blogs_array as $blog_info)
            {
                $total_comments = 0;
                if(array_key_exists($blog_info['blog_id'], $blog_id_total_comments_map))
                {
                    $total_comments = $blog_id_total_comments_map[$blog_info['blog_id']];
                }
                $blog_info['total_comments'] = $total_comments;
                $blog_info_list[] = $blog_info;
            }
        }
        return $blog_info_list;
    }
    
    /*
     * This method will return blog info indicating a parameter whether creator of the blog has member 
     * profile or not
     * @param $blog_id , blog id
     * @Author Nazmul on 15th December 2014
     */
    public function get_blog_info($blog_id)
    {
        $blog_info = array();
        $blog_info_array = $this->blog_app_model->get_blog_info($blog_id)->result_array();
        if(!empty($blog_info_array))
        {
            $blog_info = $blog_info_array[0];
            if( !isset($blog_info['ref_id']) && $this->basic_profile->is_basic_profile_exist($blog_info['user_id']))
            {
                $blog_info['is_user_member'] = 1;
            }
            else
            {
                $blog_info['is_user_member'] = 0;
            }
        }
        return $blog_info;
    }
    
    /*
     * This method will return comments
     * @param $blog_id, blog id
     * @param $sorted, order of the comments to be displayed
     * @param $limit, limit of total number of blogs
     * @param $comment_id, comment id of a blog
     * @author nazmul hasan
     * @created on 26th September 2015
     */
    public function get_all_comments($blog_id, $sorted=0, $limit=0, $comment_id = 0)
    {
        $comment_list = array();
        $comment_list_array = $this->blog_app_model->get_all_comments($blog_id, $sorted, $limit, $comment_id)->result_array();
        foreach($comment_list_array as $comment_info)
        {
            $comment_info['ip_address'] = '';
            $comment_info['signature'] = $comment_info['first_name'][0].$comment_info['last_name'][0];
            $comment_info['comment_created_on'] = convert_time($comment_info['comment_created_on']);
            $likes = $comment_info['liked_user_list'];
            $user_id_list = array();
            if( $likes != "" && strtolower($likes) !="null" && $likes != null )
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
            $comment_list[] = $comment_info;
        }
        return $comment_list;
    }
    
    /*
     * This method will return home page blog configuration
     * @author nazmul hasan
     * @created on 14 June 2014
     * @modified on 26th September 2015
     */
    public function get_home_page_blog_configuration()
    {
        $show_advertise = true;
        $region_id_blog_id_map = array();
        $blog_id_blog_info_map = array();
        $blog_id_list = array();
        $limit = 0;
        $present_date =  $this->utils->get_current_date_db();
        $blog_configuration_array = $this->blog_app_model->get_home_page_blog_configuration($present_date)->result_array();
        if(!empty($blog_configuration_array)) {
            $blog_configuration_info = $blog_configuration_array[0];            
            $show_advertise = $blog_configuration_info['show_advertise_home_page'];
            $blog_list =$blog_configuration_info['blog_list'];   
            if( $blog_list != "" && strtolower($blog_list) !="null" && $blog_list != null )
            {
                $config_blog_list = json_decode($blog_list);            
                foreach($config_blog_list as $blog_info)
                {
                    if(!in_array($blog_info->blog_id, $blog_id_list))
                    {
                        $blog_id_list[] = $blog_info->blog_id;
                        $region_id_blog_id_map[$blog_info->region_id] = $blog_info->blog_id;
                    }                    
                }
            }
        }
        else 
        {
            $limit = BLOG_CONFIGURATION_COUNTER;
        }
        $blog_list_array = $this->blog_app_model->get_blogs($blog_id_list, array(APPROVED), $limit)->result_array();
        if(empty($blog_configuration_array)) 
        {
            $counter = 0;
            foreach($blog_list_array as $blog_info)
            {
                if(!in_array($blog_info['blog_id'], $blog_id_list))
                {
                    $blog_id_list[] = $blog_info['blog_id'];
                    $region_id_blog_id_map[$counter++] = $blog_info['blog_id'];
                }
            }
        }
        $blog_info_list = array(); 
        if(!empty($blog_id_list))
        {
            $blogs_comment_counter_array = $this->blog_app_model->get_blogs_comment_counter($blog_id_list)->result_array();
            $blog_id_total_comments_map = array();
            foreach($blogs_comment_counter_array as $blog_comment_counter)
            {
                $blog_id_total_comments_map[$blog_comment_counter['blog_id']] = $blog_comment_counter['total_comments'];
            }
            foreach($blog_list_array as $blog_info)
            {
                $total_comments = 0;
                if(array_key_exists($blog_info['blog_id'], $blog_id_total_comments_map))
                {
                    $total_comments = $blog_id_total_comments_map[$blog_info['blog_id']];
                }
                $blog_info['total_comments'] = $total_comments;
                $blog_id_blog_info_map[$blog_info['blog_id']] = $blog_info;                
                $blog_info_list[] = $blog_info;
            }
        }  
        $result = array(
            'blog_list' => $blog_info_list,
            'region_id_blog_id_map' => $region_id_blog_id_map,
            'blog_id_blog_info_map' => $blog_id_blog_info_map,
            'show_advertise' => $show_advertise
        );
        return $result;
    }
    
    /*
     * This method will return blog list to be displayed on home page
     * @Omar faRUK
     * @Created on 05 May 2014
     */
    public function get_configed_blog_for_home_page()
    {
        $related_blogs_list = array();
        $present_date = date("d-m-Y");
        $configed_blog_list = $this->blog_app_model->get_configed_blog($present_date)->result_array();
        $region_id_blog_id_map = array();
        if(count($configed_blog_list)>0) {
            $blog_list = json_decode($configed_blog_list[0]['blog_list']);
            $blog_id_list = array();
            
            foreach($blog_list as $blog)
            {
                if(!in_array($blog->blog_id, $blog_id_list))
                {
                    $blog_id_list[] = $blog->blog_id;
                }
                $region_id_blog_id_map[$blog->region_id] = $blog->blog_id;
            }
            
            $related_blogs_list = $this->blog_app_model->get_config_blog_list($blog_id_list)->result_array();
            //echo '<pre/>';print_r($related_blogs_list);exit('HI d');
            $show_advertise = $configed_blog_list[0]['show_advertise_home_page'];
        } else {
            $related_blogs_list = $this->blog_app_library->get_config_blog_list()->result_array();
            $show_advertise = 0;
        }
        
        for($i=0;$i<count($related_blogs_list);$i++)
        {
            $related_blogs_list[$i]['counted_comment'] = count($this->get_all_comments($related_blogs_list[$i]['id']));
        }
        $related_blogs_list['show_advertise'] = $show_advertise;
        return $related_blogs_list;
    }
    
    public function store_like($comment_id, $user_id)
    {
        $comment_info_array = $this->blog_app_model->get_comment_info($comment_id)->result_array();
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
            $this->blog_app_model->update_comment($comment_id, $additional_data);
        }
    }
    
    public function remove_like($comment_id, $user_id)
    {
        $comment_info_array = $this->blog_app_model->get_comment_info($comment_id)->result_array();
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
            $this->blog_app_model->update_comment($comment_id, $additional_data);
        }
    }
    
    /*
     * This method will return blog list of a user
     * @Author Nazmul on 11 June 2014
     * @param $user_id, user id
     */
    public function get_all_blogs_by_user($user_id=0){
        
        $user_blog_list = array();
        if($user_id==0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        
        $status_id_list = array(PENDING,APPROVED,RE_APPROVAL,DELETION_PENDING);
        $blog_list_array = $this->blog_app_model->get_all_blogs_by_user($user_id,$status_id_list)->result_array();
        $reference_id_list = array();
        foreach($blog_list_array as $blog)
        {
            if( $blog['reference_id'] != NULL && !in_array($blog['reference_id'], $reference_id_list) )
            {
                $reference_id_list[] = $blog['reference_id'];
            }
        }
        
        foreach($blog_list_array as $blog)
        {
            if( !in_array($blog['blog_id'], $reference_id_list) )
            {
                $user_blog_list[] = $blog;
            }
        }
        return $user_blog_list;
    }
    
    //written by omar faruk
    public function blog_category_list_update($blog_category_id, $blog_id)
    {
        $new_blog_list_array = array();
        $blog_list_object = new stdClass();
        $blog_list_object->blog_id = $blog_id;
        $new_blog_list_array[] = $blog_list_object;
        
        $blog_category_info_array = $this->blog_app_model->get_blog_category_info($blog_category_id)->result_array();
        if(!empty($blog_category_info_array)){
             $blog_category_info_array = $blog_category_info_array[0];
             $blog_list = $blog_category_info_array['blog_list'];
        }
        
        $blog_id_list = array();
        if($blog_list != '' && $blog_list != NULL)
        {
            $blog_list_array = json_decode($blog_list);
            foreach($blog_list_array as $blog_info)
            {
                $new_blog_list_array[] = $blog_info;
            }
        }
        
        $additional_data = array(
            'blog_list' => json_encode($new_blog_list_array)
        );
       
        $this->blog_app_model->update_blog_categroy($blog_category_id, $additional_data);
    }
    
    /*
     * This method will return blog category id list of a blog
     * @param $blog_id , blog id
     * @Author Nazmul on 10th November 2014
     */
    public function get_blog_category_id_list_of_blog($blog_id)
    {
        $blog_category_id_list = array();
        $blog_category_list_array = $this->blog_app_model->get_all_blog_categories()->result_array();
        foreach ($blog_category_list_array as $blog_category_info) {
            $blog_list_array = json_decode($blog_category_info['blog_list']);
            if ($blog_list_array != null) {
                foreach ($blog_list_array as $blog_info) {
                    if ($blog_info->blog_id == $blog_id) {
                        if (!in_array($blog_category_info['id'], $blog_category_id_list)) {
                            $blog_category_id_list[] = $blog_category_info['id'];
                        }
                    }
                }
            }
        }
        return $blog_category_id_list;
    }

    /*
     * This method will store blog id in blog category table
     * @param $blog_id, blog id
     * @param $category_id_list, blog category id list
     * @Author Nazmul on 10th November 2014
     */
    public function add_blog_under_blog_category($blog_id, $category_id_list)
    {
        $blog_category_list = array();
        $blog_category_list_array = $this->blog_app_model->get_all_blog_categories()->result_array();
        foreach ($blog_category_list_array as $blog_category_info) {            
            if(in_array($blog_category_info['id'], $category_id_list))
            {
                $is_blog_id_exists = false;
                $blog_list_array = json_decode($blog_category_info['blog_list']);
                foreach ($blog_list_array as $blog_info) {
                    if($blog_info->blog_id == $blog_id){
                        $is_blog_id_exists = true;
                    }
                }
                if(!$is_blog_id_exists)
                {
                    $blog_info = new stdClass();
                    $blog_info->blog_id = $blog_id;
                    $blog_list_array[] = $blog_info;
                }
                $blog_category_info = array(
                    'id' => $blog_category_info['id'],
                    'blog_list' => json_encode($blog_list_array)
                );
                $blog_category_list[] = $blog_category_info;
            }            
        }
        if(!empty($blog_category_list))
        {
            return $this->blog_app_model->update_blog_categories($blog_category_list);
        }    
        return false;
    }
    
    /*
     * This method will remove blog id from all locations of blog category table
     * @param $blog_id, blog id
     * @Author Nazmul on 10th November 2014
     */
    public function remove_blog_from_blog_category($blog_id)
    {
        $blog_category_list = array();
        $blog_category_list_array = $this->blog_app_model->get_all_blog_categories()->result_array();
        foreach ($blog_category_list_array as $blog_category_info) {            
            $new_blog_list = array();
            $blog_list_array = json_decode($blog_category_info['blog_list']);
            foreach ($blog_list_array as $blog_info) {
                if($blog_info->blog_id != $blog_id){
                    $new_blog_list[] = $blog_info;
                }
            }
            $blog_category_info = array(
                'id' => $blog_category_info['id'],
                'blog_list' => json_encode($new_blog_list)
            );
            $blog_category_list[] = $blog_category_info;           
        }
        if(!empty($blog_category_list))
        {
            return $this->blog_app_model->update_blog_categories($blog_category_list);
        }    
        return false;
    }
    
    // written by omar faruk
    public function get_all_category_of_this_blog($blog_id) {
        $all_blog_category = $this->blog_app_model->get_all_blog_category()->result_array();
        $blog_list_array_map = array();
        $blog_list_array = array();
        foreach ($all_blog_category as $key => $blog_category) {
            if(!empty($blog_category['blog_list'])) {
                $blog_list_array = json_decode($blog_category['blog_list']);
                if(!empty($blog_list_array)){
                    foreach ($blog_list_array as $key => $blog_id_value) {
                        if($blog_id_value->blog_id == $blog_id){
                            $blog_id_object = new stdClass();
                            $blog_id_object->blog_id = $blog_category['id'];
                            $blog_list_array_map[] = $blog_id_object;
                        }
                    }
                }
                
            }
        }
        return $blog_list_array_map;
    }
    
    //written by omar faruk
    public function blog_category_list_update_by_remove($blog_category_id, $blog_id)
    {
        $new_blog_list_array = array();
        $blog_category_info_array = $this->blog_app_model->get_blog_category_info($blog_category_id)->result_array();
        if(!empty($blog_category_info_array)){
             $blog_category_info_array = $blog_category_info_array[0];
             $blog_list = $blog_category_info_array['blog_list'];
        }
        if($blog_list != '' && $blog_list != NULL)
        {
            $blog_list_array = json_decode($blog_list);
            foreach($blog_list_array as $blog_info)
            {
                 if($blog_info->blog_id != $blog_id){
                    $blog_list_object = new stdClass();
                    $blog_list_object->blog_id = $blog_info->blog_id;
                    $new_blog_list_array[] = $blog_list_object;
                 }
            }
        }
        
        $additional_data = array(
            'blog_list' => json_encode($new_blog_list_array)
        );
        $this->blog_app_model->update_blog_categroy($blog_category_id, $additional_data);
        return true;
    }
    
    public function get_all_blog_by_category($category_id) {
        $blog_list_array = array();
        $all_blogs_info = array();
        $blog_category_array = $this->blog_app_model->get_blog_category_info($category_id)->result_array();
        $pupulated_blog_id_array = array();

        if(!empty($blog_category_array))
        {
            $blog_category_array = $blog_category_array[0];
            $blog_list_array = json_decode($blog_category_array['blog_list']);
            if(!empty($blog_list_array)) {
                foreach ($blog_list_array as $key => $blog_list) {
                    array_push($pupulated_blog_id_array,$blog_list->blog_id);
                }
            }
        }
        $all_blogs_info = $this->blog_app_model->get_all_blogs_by_category($pupulated_blog_id_array);
        
        if(!empty($all_blogs_info)) {
            $all_blogs_info = $all_blogs_info->result_array();
        }
        //echo '<pre/>'; print_r($all_blogs_info);exit('jeeee');
        return $all_blogs_info;
    }
    
    /*
     * This method will return blog category list and selected blog category list
     * @param $blog_id, blog id
     * @Author Nazmul on 3rd November 2014
     */
    public function get_category_info_of_blog($blog_id)
    {
        $result = array();
        $blog_category_list = array();
        $selected_blog_category_list = array();
        $blog_category_id_list = array();
        $blog_category_list_array = $this->blog_app_model->get_all_blog_category()->result_array();
        foreach ($blog_category_list_array as $blog_category_info) {
            $category_info = array(
                'id' => $blog_category_info['id'],
                'title' => $blog_category_info['title']
            );
            $blog_category_list[] = $category_info;
            
            $blog_category_id = $blog_category_info['id'];
            $blog_list_array = json_decode($blog_category_info['blog_list']);
            foreach ($blog_list_array as $blog_id_info) {
                if($blog_id_info->blog_id == $blog_id && !in_array($blog_category_id, $blog_category_id_list)){
                    $blog_category_id_list[] = $blog_category_id;
                    $selected_blog_category_list[] = $category_info;
                }
            }
        }
        $result['blog_category_list'] = $blog_category_list;
        $result['selected_blog_category_list'] = $selected_blog_category_list;
        return $result;
    }
}

?>



