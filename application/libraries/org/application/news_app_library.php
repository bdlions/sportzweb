<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  News app library
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
     * This method will return breaking news configuration for home page
     * @Author Nazmul on 4th February 2015
     */
    public function get_breaking_news_list()
    {
        $result = array();
        $breaking_news_list_array = $this->news_app_model->get_breaking_news_configuration_list()->result_array();
        if(!empty($breaking_news_list_array)) {
            $breaking_news_list = $breaking_news_list_array[0];
            $news_id_list = json_decode($breaking_news_list['news_list']);
            $news_list = $this->news_app_model->get_news_list($news_id_list)->result_array();
            foreach ($news_list as $news_info) {
                $temp_news_info = array(
                    'news_id' => $news_info['news_id'],
                    'headline' => $news_info['headline']
                );
                $result[] = $temp_news_info;
            }
        }
        return $result;
    }
    /*
     * This method will return latest news configuration for home page
     * @Author Nazmul on 4th February 2015
     */
    public function get_latest_news_list()
    {
        $result = array();
        $latest_news_list_array = $this->news_app_model->get_latest_news_configuration_list()->result_array();
        if(!empty($latest_news_list_array)) {
            $latest_news_list = $latest_news_list_array[0];
            $news_id_list = json_decode($latest_news_list['news_list']);
            $news_list = $this->news_app_model->get_news_list($news_id_list)->result_array();
            foreach ($news_list as $news_info) {
                $temp_news_info = array(
                    'news_id' => $news_info['news_id'],
                    'headline' => $news_info['headline']
                );
                $result[] = $temp_news_info;
            }
        }
        return $result;
    }
    /*
     * This method will return news application menu items
     * @Author Nazmul on 20th February 2015
     */
    public function get_menu_items()
    {
        $result = array();
        $news_categories_array = $this->news_app_model->get_news_categories()->result_array();
        foreach ($news_categories_array as $news_category_info) {
            $news_sub_categories_array = $this->news_app_model->get_news_sub_categories($news_category_info['news_category_id'])->result_array();
            $result[$news_category_info['news_category_id']] = array("news_category_title"=> $news_category_info['title'], 'sub_category_list'=>$news_sub_categories_array);            
        }
        return $result;
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
        $present_date = $this->utils->get_current_date_db();
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
                if(isset($news_list_array[$region_counter])){
                    $region_id_news_id_map[$region_counter] = $news_list_array[$region_counter]['news_id'];
                }  else {
                    $region_id_news_id_map[$region_counter] = null;
                }
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
        $present_date = $this->utils->get_current_date_db();
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
        $present_date = $this->utils->get_current_date_db();
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
        $result = array(
            'region_id_news_id_map' => $region_id_news_id_map,
            'region_id_is_news_ignored_map' => $region_id_is_news_ignored_map,
            'news_id_news_info_map' => $news_id_news_info_map,
            'show_advertise' => $show_advertise,
        );
        return $result;
    }
    /*
     * This method will return news info converting the news date
     * @param @news_id, news id
     * @Author Nazmul on 20th February 2015
     */
    public function get_news_info($news_id)
    {
        $news_info = array();
        $news_info_array = $this->news_app_model->get_news_info($news_id)->result_array();
        if(!empty($news_info_array))
        {
            $news_info = $news_info_array[0];
            $news_info['created_on'] = $this->utils->convert_unix_to_news_application($news_info['created_on']);
        }
        return $news_info;
    }
    
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



