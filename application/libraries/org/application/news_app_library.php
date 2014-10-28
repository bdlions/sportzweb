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
class News_app_library {

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
        
        $this->load->library('org/utility/utils');
        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('org/application/news_app_model');

        $this->news_app_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->news_app_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in news_app_model');
        }

        return call_user_func_array(array($this->news_app_model, $method), $arguments);
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
     * This method will return news list to be displayed on home page
     * @Author Nazmul
     * @Created on 30 April 2014
     * modifoed by Omar faRUK
     */
    public function get_home_page_news_list()
    {
        $present_date = date("d-m-Y");
        $news_id_list = array();
        $result = $this->news_app_model->get_configed_news($present_date)->result_array();
        if(count($result)> 0) {
            $result = $result[0];
            $news_id_list = json_decode($result['news_list']);
            $news_list_array = $this->news_app_model->get_news_list($news_id_list)->result_array();
        } else {
            //exit('here');
            //$this->news_app_model->get_all_news();
            //$news_id_list = array(1,2,3,4,5,6,7,8,9,10,11,12,13);
            $news_list_array = $this->news_app_model->get_news_list($news_id_list)->result_array();
        }
        
        return $news_list_array;
    }
    
//    public function get_news_category_info($news_category_id)
//    {
//        $region_id_news_info_map = array();
//        $news_id_news_info_map = array();
//        $news_id_list = array();
//        $news_list = array();
//        $news_config_list = array();
//        $news_category_info_array = $this->news_app_model->get_news_category_info($news_category_id)->result_array();
//        if(!empty($news_category_info_array) && $news_category_info_array[0]['news_list'] != NULL && $news_category_info_array[0]['news_list'] != '' )
//        {
//            $news_config_list = json_decode($news_category_info_array[0]['news_list']);
//            foreach($news_config_list as $news)
//            {
//                if($news->news_id!=0)
//                {
//                    array_push($news_id_list,$news->news_id);
//                }
//            }
//            $news_list = $this->news_app_model->get_news_list_info($news_id_list)->result_array();
//        }
//        
//        foreach($news_list as $news_info)
//        {
//            $news_id_news_info_map[$news_info['id']] = $news_info;
//        }
//        
//        if(!empty($news_config_list) && $news_config_list != NULL)
//        {
//            foreach($news_config_list as $news)
//            {
//                if($news->news_id!=0){
//                    $region_id_news_info_map[$news->region_id] = $news_id_news_info_map[$news->news_id];
//                }else{
//                    $region_id_news_info_map[$news->region_id] = array();
//                }
//            }
//        }   
//        
//        $data['news_category_info'] = $news_category_info_array;
//        $data['region_id_news_info_map'] = $region_id_news_info_map;
//        return $data;
//    }
    
//    public function get_news_sub_category_info($news_sub_category_id)
//    {
//        $region_id_news_info_map = array();
//        $news_id_news_info_map = array();
//        $news_id_list = array();
//        $news_list = array();
//        $news_config_list = array();
//        $news_sub_category_info_array = $this->news_app_model->get_news_sub_category_info($news_sub_category_id)->result_array();
//        
//        if(!empty($news_sub_category_info_array) && $news_sub_category_info_array[0]['news_list'] != NULL && $news_sub_category_info_array[0]['news_list'] != '' )
//        {
//            $news_config_list = json_decode($news_sub_category_info_array[0]['news_list']);
//            foreach($news_config_list as $news)
//            {
//                if($news->news_id!=0)
//                {
//                    array_push($news_id_list,$news->news_id);
//                }
//            }
//            $news_list = $this->news_app_model->get_news_list_info($news_id_list)->result_array();
//        }
//        foreach($news_list as $news_info)
//        {
//            $news_id_news_info_map[$news_info['id']] = $news_info;
//        }
//        
//        if(!empty($news_config_list) && $news_config_list != NULL)
//        {
//            foreach($news_config_list as $news)
//            {
//                if($news->news_id!=0){
//                    $region_id_news_info_map[$news->region_id] = $news_id_news_info_map[$news->news_id];
//                }else{
//                    $region_id_news_info_map[$news->region_id] = array();
//                }
//            }
//        }
//        
//        $data['news_category_info'] = $news_sub_category_info_array;
//        $data['region_id_news_info_map'] = $region_id_news_info_map;
//        
//        return $data;
//    }
    
    /*public function get_all_comments($news_id)
    {
        $comment_list = $this->news_app_model->get_all_comments($news_id)->result_array();
        
        $length = count($comment_list);
        
        for($i=0;$i<$length;$i++)
        {
            if(!empty($comment_list[$i]['liked_user_list']))
            {
                
                $comment_list[$i]['liked_user_list'] = json_decode($comment_list[$i]['liked_user_list']);
            
                    for($j=0;$j<count($comment_list[$i]['liked_user_list']);$j++)
                    {
                        $value = $comment_list[$i]['liked_user_list'][$j];
                        $value = $this->news_app_model->get_username($value)->result_array();
                        $comment_list[$i]['liked_user_list'][$j] = $value[0];
                    }
            }
        }
        
        return $comment_list;
    }*/
    
    //written by omar faruk
    public function get_breaking_news()
    {
        $result = array();
        $populated_array = array();
        $breaking_news_list = $this->news_app_model->get_breaking_news()->result_array();
        if(count($breaking_news_list)>0) {
            $breaking_news_list = $breaking_news_list[0];
            $breaking_news_lists_id = json_decode($breaking_news_list['news_list']);
            $results = $this->news_app_model->get_news_list_info($breaking_news_lists_id)->result_array();
            foreach ($results as $key => $value) {
                $data_array = array(
                    'id' => $value['id'],
                    'headline' => html_entity_decode(html_entity_decode($value['headline'])),
                    'summary' => html_entity_decode(html_entity_decode($value['summary'])),
                    'description' => html_entity_decode(html_entity_decode($value['description']))
                );
               $populated_array[$key] = $data_array;
            }
            return $populated_array;
        }
        return $populated_array;
    }
    
    //written by omar faruk
    public function get_latest_news()
    {
        $results = array();
        $populated_array = array();
        $latest_news_list = $this->news_app_model->get_latest_news()->result_array();
        if(count($latest_news_list)>0) {
            $latest_news_list = $latest_news_list[0];
            $latest_news_lists_id = json_decode($latest_news_list['news_list']);
            $results = $this->news_app_model->get_news_list_info($latest_news_lists_id)->result_array();
            foreach ($results as $key => $value) {
                $data_array = array(
                    'id' => $value['id'],
                    'headline' => html_entity_decode(html_entity_decode($value['headline'])),
                    'summary' => html_entity_decode(html_entity_decode($value['summary'])),
                    'description' => html_entity_decode(html_entity_decode($value['description']))
                );
               $populated_array[$key] = $data_array;
            }
            return $populated_array;
        }
        return $populated_array;
    }
    
    public function get_all_sub_category()
    {
        $category_lists = $this->news_app_model->get_all_news_category()->result_array();
        $sub_categorys_of_a_categoty = array();

        $sub_categorys_of_a_categoty = array();
            foreach ($category_lists as $key => $category_list) {
                $id = $category_list['id'];
                $category_title = $category_list['title'];
                $sub_categorys_result = $this->news_app_model->get_all_news_sub_category($id)->result_array();
                $sub_categorys_of_a_categoty[$category_list['title']] = array("category_id"=> $id, 'sub_list'=>$sub_categorys_result);
            }
        return $sub_categorys_of_a_categoty;
    }
    
    public function get_all_comments($news_id,$sorted=0,$limit_no=0, $comment_id = 0)
    {
        $recipe_comment_list = array();
        $comment_list = $this->news_app_model->get_all_comments($news_id,$sorted,$limit_no, $comment_id)->result_array();
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
        $comment_info_array = $this->news_app_model->get_comment_info($comment_id)->result_array();
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
            $this->news_app_model->update_comment($comment_id, $additional_data);
        }
    }
    
    public function remove_like($comment_id, $user_id)
    {
        $comment_info_array = $this->news_app_model->get_comment_info($comment_id)->result_array();
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
            $this->news_app_model->update_comment($comment_id, $additional_data);
        }
    }
    
    
    /*
     * This method will return news home page configuration info to be displayed at user end
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_home_page_configuration()
    {
        $show_advertise = 0;
        $region_id_news_id_map = array();
        $news_id_news_info_map = array();
        //read news_home_page_configuration table
        //if not then get first NEWS_CONFIGURATION_COUNTER number of entries
        //fill up $result array based on any one from the above 2 points
        $present_date = $this->utils->get_current_date();
        $news_id_list = array();
        $result = $this->news_app_model->get_news_home_page_configuration($present_date)->result_array();
        
        if(!empty($result)) {
            $result = $result[0];
            
            $show_advertise = $result['show_advertise'];
            $news_list = json_decode($result['news_list']);
            
            foreach($news_list as $news)
            {
                if(!in_array($news->news_id, $news_id_list))
                {
                    $news_id_list[] = $news->news_id;
                }
                $region_id_news_id_map[$news->region_id] = $news->news_id;
            }
            $news_list_array = $this->news_app_model->get_news_list($news_id_list)->result_array();
        }
        else
        {
            $news_list_array = $this->news_app_model->get_news_list_initial_configuration()->result_array();
            
            for($region_counter = 0; $region_counter < NEWS_CONFIGURATION_COUNTER ; $region_counter++)
            {
                $region_id_news_id_map[$region_counter] = $news_list_array[$region_counter]['news_id'];
            }
        }
        
        foreach($news_list_array as $news_info)
        {
             $news_id_news_info_map[$news_info['news_id']] = $news_info;
        }
        
        $result = array(
            'region_id_news_id_map' => $region_id_news_id_map,
            'news_id_news_info_map' => $news_id_news_info_map,
            'show_advertise' => $show_advertise
        );
        return $result;
    }
    
    /*
     * This method will return news category configuration info to be dispalyed at user end
     * @param $news_category_id, news category id
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_category_configuration($news_category_id)
    {
        $show_advertise = 0;
        $region_id_news_id_map = array();
        $region_id_is_news_ignored_map = array();
        $news_id_news_info_map = array();
        //read news_category_configuration table
        //fill up $result array based on above query
        $present_date = $this->utils->get_current_date();
        $news_id_list = array();
        $result = $this->news_app_model->get_news_category_configuration($news_category_id,$present_date)->result_array();
        if(!empty($result)) {
            $result = $result[0];
            
            $show_advertise = $result['show_advertise'];
            $news_list = json_decode($result['news_list']);
            
            foreach($news_list as $news)
            {
                if(!in_array($news->news_id, $news_id_list))
                {
                    $news_id_list[] = $news->news_id;
                }                
                $region_id_news_id_map[$news->region_id] = $news->news_id;
                $region_id_is_news_ignored_map[$news->region_id] = $news->is_ignored;
            }
            $news_list_array = $this->news_app_model->get_news_list($news_id_list)->result_array();
            foreach($news_list_array as $news_info)
            {
                 $news_id_news_info_map[$news_info['news_id']] = $news_info;
            }
        }
//        else 
//        {
//            $news_list_array = $this->news_app_model->get_news_home_page_configuration($present_date)->result_array();
//            if(!empty($news_list_array))
//            {
//                $news_list_array = $news_list_array[0];
//                
//                $show_advertise = $news_list_array['show_advertise'];
//                $news_list = json_decode($news_list_array['news_list']);
//            
//                foreach($news_list as $news)
//                {
//                    if(!in_array($news->news_id, $news_id_list))
//                    {
//                        $news_id_list[] = $news->news_id;
//                    }                
//                    $region_id_news_id_map[$news->region_id] = $news->news_id;
//                }
//                $news_list_array = $this->news_app_model->get_news_list($news_id_list)->result_array();
//                
//            }
//            else
//            {
//                $news_list_array = $this->news_app_model->get_news_list_initial_configuration()->result_array();
//            }
//
//            for($region_counter = 0; $region_counter < NEWS_CONFIGURATION_COUNTER ; $region_counter++)
//            {
//                $region_id_news_id_map[$region_counter] = $news_list_array[$region_counter]['news_id'];
//                $region_id_is_news_ignored_map[$region_counter] = 0;
//            }
//        }
        
        

        
        $result = array(
            'region_id_news_id_map' => $region_id_news_id_map,
            'region_id_is_news_ignored_map' => $region_id_is_news_ignored_map,
            'news_id_news_info_map' => $news_id_news_info_map,
            'show_advertise' => $show_advertise
        );
        return $result;
    }
    
    /*
     * This method will return news sub category configuration info to be displayed at user end
     * @param $news_sub_category_id, news sub category id
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_sub_category_configuration($news_sub_category_id)
    {
        $show_advertise = 0;
        $region_id_news_id_map = array();
        $region_id_is_news_ignored_map = array();
        $news_id_news_info_map = array();
        //read news_category_configuration table
        //fill up $result array based on above query
        $present_date = $this->utils->get_current_date();
        $news_id_list = array();
        $result = $this->news_app_model->get_news_sub_category_configuration($news_sub_category_id,$present_date)->result_array();
        if(!empty($result)) {
            $result = $result[0];
            
            $show_advertise = $result['show_advertise'];
            $news_list = json_decode($result['news_list']);
            
            foreach($news_list as $news)
            {
                if(!in_array($news->news_id, $news_id_list))
                {
                    $news_id_list[] = $news->news_id;
                }                
                $region_id_news_id_map[$news->region_id] = $news->news_id;
                $region_id_is_news_ignored_map[$news->region_id] = $news->is_ignored;
            }
            $news_list_array = $this->news_app_model->get_news_list($news_id_list)->result_array();
            foreach($news_list_array as $news_info)
            {
                 $news_id_news_info_map[$news_info['news_id']] = $news_info;
            }
        }
//        else 
//        {
//            $news_list_array = $this->news_app_model->get_news_home_page_configuration($present_date)->result_array();
//            if(!empty($news_list_array))
//            {
//                $news_list_array = $news_list_array[0];
//                
//                $show_advertise = $news_list_array['show_advertise'];
//                $news_list = json_decode($news_list_array['news_list']);
//            
//                foreach($news_list as $news)
//                {
//                    if(!in_array($news->news_id, $news_id_list))
//                    {
//                        $news_id_list[] = $news->news_id;
//                    }                
//                    $region_id_news_id_map[$news->region_id] = $news->news_id;
//                }
//                $news_list_array = $this->news_app_model->get_news_list($news_id_list)->result_array();
//                
//            }
//            else
//            {
//                $news_list_array = $this->news_app_model->get_news_list_initial_configuration()->result_array();
//            }
//
//            for($region_counter = 0; $region_counter < NEWS_CONFIGURATION_COUNTER ; $region_counter++)
//            {
//                $region_id_news_id_map[$region_counter] = $news_list_array[$region_counter]['news_id'];
//                $region_id_is_news_ignored_map[$region_counter] = 0;
//            }
//        }
        
        
        
        $result = array(
            'region_id_news_id_map' => $region_id_news_id_map,
            'region_id_is_news_ignored_map' => $region_id_is_news_ignored_map,
            'news_id_news_info_map' => $news_id_news_info_map,
            'show_advertise' => $show_advertise,
        );
        return $result;
    }
    
    public function get_news_info($news_id)
    {
        $news_info = array();
        $news_info_array = $this->news_app_model->get_news_info($news_id)->result_array();
        if(!empty($news_info_array))
        {
            $news_info = $news_info_array[0];
            $news_info['created_on'] = $this->utils->get_unix_to_human_date($news_info['created_on'], 1);
        }
        return $news_info;
    }
    
    // ------------------------------------ Mobile App module -----------------------
    public function get_sub_category_list($news_category_id)
    {
        $news_subcategory_list_array = $this->news_app_model->get_all_news_sub_category($news_category_id)->result_array();
        
        
        $category_lists = $this->news_app_model->get_all_news_category()->result_array();
        $sub_categorys_of_a_categoty = array();

        $sub_categorys_of_a_categoty = array();
            foreach ($category_lists as $key => $category_list) {
                $id = $category_list['id'];
                $category_title = $category_list['title'];
                $sub_categorys_result = $this->news_app_model->get_all_news_sub_category($id)->result_array();
                $sub_categorys_of_a_categoty[$category_list['title']] = array("category_id"=> $id, 'sub_list'=>$sub_categorys_result);
            }
        return $sub_categorys_of_a_categoty;
    }
}

?>



