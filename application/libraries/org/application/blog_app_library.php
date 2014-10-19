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
class Blog_app_library {

    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
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
    
    /*
     * This method will return home page blog configuration
     * @Author Nazmul on 14 June 2014
     */
    public function get_home_page_blog_configuration()
    {
        //$all_blogs_array = $this->blog_app_model->get_blog_list()->result_array();
        $all_blogs_array = $this->blog_app_model->all_blogs()->result_array();
        
        //blog_list will contain all blogs of the application
        $show_advertise = true;
        $region_id_blog_id_map = array();
        $blog_id_blog_info_map = array();
        
        //read blog_configure_homepage table
        $present_date =  date("d-m-Y");
        $blog_id_list = array();
        $blog_configuration_array = $this->blog_app_model->get_home_page_blog_configuration($present_date)->result_array();
        if(!empty($blog_configuration_array)) {
            $blog_configuration_info = $blog_configuration_array[0];
            
            $show_advertise = $blog_configuration_info['show_advertise_home_page'];
            $blog_list = json_decode($blog_configuration_info['blog_list']);
            
            foreach($blog_list as $blog_info)
            {
                $blog_id_list[] = $blog_info->blog_id;
                $region_id_blog_id_map[$blog_info->region_id] = $blog_info->blog_id;
            }
            
            $blog_list_array = $this->blog_app_model->get_blog_list($blog_id_list)->result_array();
        }
        else 
        {
            $blog_list_array = $this->blog_app_model->get_blog_list_initial_configuration()->result_array();
            
            for($region_counter = 0; $region_counter < BLOG_CONFIGURATION_COUNTER ; $region_counter++)
            {
                $region_id_blog_id_map[$region_counter] = $blog_list_array[$region_counter]['blog_id'];
            }
        }
        
        foreach($blog_list_array as $blog_info)
        {
            $blog_info['created_on'] = $this->utils->get_unix_to_human_date($blog_info['created_on'], 1); 
            $blog_id_blog_info_map[$blog_info['blog_id']] = $blog_info;
        }
        $result = array(
            'blog_list' => $all_blogs_array,
            'region_id_blog_id_map' => $region_id_blog_id_map,
            'blog_id_blog_info_map' => $blog_id_blog_info_map,
            'show_advertise' => $show_advertise
        );
        return $result;
    }
    
    public function get_all_comments($blog_id,$sorted=0,$limit_no=0, $comment_id = 0)
    {
        $recipe_comment_list = array();
        $comment_list = $this->blog_app_model->get_all_comments($blog_id,$sorted,$limit_no, $comment_id)->result_array();
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
    
    /*public function get_all_blogs_by_user($user_id=0){
        
        if($user_id==0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        
        $status_id_list = array(PENDING,APPROVED,RE_APPROVAL,DELETION_PENDING);
        $blog_list_array = $this->blog_app_model->get_all_blogs_by_user($user_id,$status_id_list)->result_array();
//        var_dump($blog_list_array);
        $reference_id_list = array();
        
        foreach($blog_list_array as $blog)
        {
            //error found:  Undefined index: reference_id; isset added.
            if(isset($blog['reference_id'])!=NULL)
            {
                array_push($reference_id_list,$blog['reference_id']);
            }
        }
        //echo '<pre/>';print_r($reference_id_list);print_r($blog_list_array);exit;
        for($i=0;$i<count($reference_id_list);$i++)
        {
            $length = count($blog_list_array);
            foreach($blog_list_array as $key => $blog)
            {
                if($reference_id_list[$i] == $blog['id'])
                {
                    unset($blog_list_array[$key]);
                    break;
                }
            }
        }
        
        return $blog_list_array;
    }*/
    
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
     
    
}

?>



