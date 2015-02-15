<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin news library
 * Requirements: PHP5 or above
 *
 */

class Admin_news{
    
    public function __construct() {
        $this->load->config('ion_auth',TRUE);
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
                        $this->load->model('org/admin/application/admin_news_model');

        $this->admin_news_model->trigger_events('library_constructor');
    }
    
    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_news_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_news_model');
        }

        return call_user_func_array(array($this->admin_news_model, $method), $arguments);
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
     * This method will return news list converting news data to user displayed format
     * @param $news_id_list, news id list
     * @Author Nazmul on 4th February 2015
     */
    public function get_news_list($news_id_list = array())
    {
        $news_list = array();
        $news_list_array = $this->admin_news_model->get_news_list()->result_array($news_id_list);
        foreach($news_list_array as $news_info)
        {
            $news_info['news_date'] = $this->utils->convert_date_from_db_to_user($news_info['news_date']);
            $news_list[] = $news_info;
        }
        return $news_list;
    }
    
    public function get_news_category_info_for_update($news_category_id,$news_id)
    {
        $news_category = $this->admin_news_model->get_news_category_info($news_category_id)->result_array();
        if(count($news_category)>0) {
            $news_category = $news_category[0]; 
            $news = json_decode($news_category['news_list']);
            $encoded_value;
            if(count($news) > 0) {
                array_push($news,$news_id."");
                $encoded_value = json_encode($news);
            } else {
                $news = array(0 => $news_id."");
                $encoded_value = json_encode($news);
            }
            $value = $this->admin_news_model->update_news_category_for_news($news_category_id,$encoded_value);
        }
        return $value;
    }
    
//    public function get_news_sub_category_info($id)
//    {
//        $sub_category = $this->admin_news_model->get_news_sub_category_info($id)->result_array();
//        $sub_category = $sub_category[0];
//        
//        $news = json_decode($sub_category['news_list']);
//        
//        for($i=0;$i<count($news);$i++)
//        {
//            $news[$i] = $this->admin_news_model->get_news_info($news[$i])->result_array();
//        }
//        $sub_category['news_list'] = $news;
//        return $sub_category;
//    }
    
    public function get_news_sub_category_info_for_update($news_sub_category_id,$news_id)
    {
        $news_sub_category = $this->admin_news_model->get_news_sub_category_info($news_sub_category_id)->result_array();
        if(count($news_sub_category)>0) {
            $news_sub_category = $news_sub_category[0]; 
            $news = json_decode($news_sub_category['news_list']);
            $encoded_value;
            if(count($news) > 0) {
                array_push($news,$news_id."");
                $encoded_value = json_encode($news);
            } else {
                $news = array(0 => $news_id."");
                $encoded_value = json_encode($news);
            }
            $value = $this->admin_news_model->update_news_sub_category_for_news($news_sub_category_id,$encoded_value);
        }
        return $value;
    }
    
    public function config_news($news_list = 0)
    {
        
        if($news_list == 0){
            $news_list = $this->admin_news_model->get_all_news()->result_array();
        }

        return $news_list;
    }
    
    /*
     * This method will return news list to be displayed on home page
     * @Author Nazmul
     * @Created on 30 April 2014
     * modifoed by Omar faRUK
     */
    public function get_home_page_news_list()
    {
        $present_date = $this->utils->get_current_date();
        $news_id_list = array();
        $result = $this->admin_news_model->get_news_home_page_configuration($present_date)->result_array();
        if(count($result)> 0) {
            $result = $result[0];
            $news_id_list = json_decode($result['news_list']);
            $news_list_array = $this->admin_news_model->get_news_list($news_id_list)->result_array();
        } else {
            
            
            $news_list_array = $this->admin_news_model->get_news_list_initial_configuration()->result_array();
        }
        return $news_list_array;
    }
    
    public function get_news_for_category($news_category_id)
    {
        $region_id_news_info_map = array();
        $news_id_news_info_map = array();
        $news_id_list = array();
        $news_list = array();
        $news_config_list = array();
        $date = $this->utils->get_current_date();
        $news_category_info_array = $this->admin_news_model->get_news_category_configuration($news_category_id,$date)->result_array();
        if(!empty($news_category_info_array) && $news_category_info_array[0]['news_list'] != NULL && $news_category_info_array[0]['news_list'] != '' )
        {
            $news_config_list = json_decode($news_category_info_array[0]['news_list']);
            foreach($news_config_list as $news)
            {
                if($news->news_id!=0)
                {
                    array_push($news_id_list,$news->news_id);
                }
            }
            $news_list = $this->admin_news_model->get_news_list_info($news_id_list)->result_array();
        }
        else
        {
            $news_list = $this->get_home_page_news_list();
            if(empty($news_list)){
                $news_list = $this->admin_news_model->get_news_list()->result_array();
            }
        }
        
        foreach($news_list as $news_info)
        {
            $news_id_news_info_map[$news_info['id']] = $news_info;
        }
        
        if(!empty($news_config_list) && $news_config_list != NULL)
        {
            foreach($news_config_list as $news)
            {
                if($news->news_id!=0){
                    $region_id_news_info_map[$news->region_id] = $news_id_news_info_map[$news->news_id];
                }else{
                    $region_id_news_info_map[$news->region_id] = array();
                }
            }
        }
        else
        {
            for($region_counter = 0; $region_counter < NEWS_CONFIGURATION_COUNTER ; $region_counter++)
            {
                $region_id_news_info_map[$region_counter] = $news_list[$region_counter];
            }
        }   
        
        return $region_id_news_info_map;
    }
    
    /*
     * This method will return news home page configuration info
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
        $result = $this->admin_news_model->get_news_home_page_configuration($present_date)->result_array();
        
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
            $news_list_array = $this->admin_news_model->get_news_list($news_id_list)->result_array();
        }
        else 
        {
            $news_list_array = $this->admin_news_model->get_news_list_initial_configuration()->result_array();
            
            for($region_counter = 0; $region_counter < NEWS_CONFIGURATION_COUNTER ; $region_counter++)
            {
                if(isset($news_list_array[$region_counter])){
                $region_id_news_id_map[$region_counter] = $news_list_array[$region_counter]['news_id'];
                }  else {
                    $region_id_news_id_map[$region_counter]=null;
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
     * This method will return news category configuration info
     * @param $news_category_id, news category id
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_category_configuration($news_category_id)
    {
        $show_advertise = true;
        $region_id_news_id_map = array();
        $region_id_is_news_ignored_map = array();
        $news_id_news_info_map = array();
        //read news_category_configuration table
        //if not then read news_home_page_configuration table
        //if not then get first NEWS_CONFIGURATION_COUNTER number of entries
        //fill up $result array based on any one from the above 3 points
        
        $present_date = $this->utils->get_current_date();
        $news_id_list = array();
        $result = $this->admin_news_model->get_news_category_configuration($news_category_id,$present_date)->result_array();
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
            $news_list_array = $this->admin_news_model->get_news_list($news_id_list)->result_array();
        }
        else 
        {
            $news_list_array = $this->admin_news_model->get_news_home_page_configuration($present_date)->result_array();
            if(!empty($news_list_array))
            {
                $news_list_array = $news_list_array[0];
                
                $show_advertise = $news_list_array['show_advertise'];
                $news_list = json_decode($news_list_array['news_list']);
            
                foreach($news_list as $news)
                {
                    if(!in_array($news->news_id, $news_id_list))
                    {
                        $news_id_list[] = $news->news_id;
                    }                
                    $region_id_news_id_map[$news->region_id] = $news->news_id;
                }
                $news_list_array = $this->admin_news_model->get_news_list($news_id_list)->result_array();
                
            }
            else
            {
                $news_list_array = $this->admin_news_model->get_news_list_initial_configuration()->result_array();
            }

            for($region_counter = 0; $region_counter < NEWS_CONFIGURATION_COUNTER ; $region_counter++)
            {
                $region_id_news_id_map[$region_counter] = $news_list_array[$region_counter]['news_id'];
                $region_id_is_news_ignored_map[$region_counter] = 0;
            }
        }
        
        foreach($news_list_array as $news_info)
        {
             $news_id_news_info_map[$news_info['news_id']] = $news_info;
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
     * This method will return news sub category configuration info
     * @param $news_sub_category_id, news sub category id
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_sub_category_configuration($news_sub_category_id)
    {
        $show_advertise = true;
        $region_id_news_id_map = array();
        $region_id_is_news_ignored_map = array();
        $news_id_news_info_map = array();
        //read news_category_configuration table
        //if not then read news_home_page_configuration table
        //if not then get first NEWS_CONFIGURATION_COUNTER number of entries
        //fill up $result array based on any one from the above 3 points
        
        $present_date = $this->utils->get_current_date();
        $news_id_list = array();
        $result = $this->admin_news_model->get_news_sub_category_configuration($news_sub_category_id,$present_date)->result_array();
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
            $news_list_array = $this->admin_news_model->get_news_list($news_id_list)->result_array();
        }
        else 
        {
            $news_list_array = $this->admin_news_model->get_news_home_page_configuration($present_date)->result_array();
            if(!empty($news_list_array))
            {
                $news_list_array = $news_list_array[0];
                
                $show_advertise = $news_list_array['show_advertise'];
                $news_list = json_decode($news_list_array['news_list']);
            
                foreach($news_list as $news)
                {
                    if(!in_array($news->news_id, $news_id_list))
                    {
                        $news_id_list[] = $news->news_id;
                    }                
                    $region_id_news_id_map[$news->region_id] = $news->news_id;
                }
                $news_list_array = $this->admin_news_model->get_news_list($news_id_list)->result_array();
                
            }
            else
            {
                $news_list_array = $this->admin_news_model->get_news_list_initial_configuration()->result_array();
            }

            for($region_counter = 0; $region_counter < NEWS_CONFIGURATION_COUNTER ; $region_counter++)
            {
                $region_id_news_id_map[$region_counter] = $news_list_array[$region_counter]['news_id'];
                $region_id_is_news_ignored_map[$region_counter] = 0;
            }
        }
        
        foreach($news_list_array as $news_info)
        {
             $news_id_news_info_map[$news_info['news_id']] = $news_info;
        }

        $result = array(
            'region_id_news_id_map' => $region_id_news_id_map,
            'region_id_is_news_ignored_map' => $region_id_is_news_ignored_map,
            'news_id_news_info_map' => $news_id_news_info_map,
            'show_advertise' => $show_advertise
        );
        return $result;
    }
    
    public function get_news_for_sub_category($sub_category_id){
        $region_id_news_info_map = array();
        $news_id_news_info_map = array();
        $news_id_list = array();
        $news_list = array();
        $news_config_list = array();
        $news_sub_category_info_array = $this->admin_news_model->get_news_sub_category_info($sub_category_id)->result_array();
        if(!empty($news_sub_category_info_array) && $news_sub_category_info_array[0]['news_list'] != NULL && $news_sub_category_info_array[0]['news_list'] != '' )
        {
            $news_config_list = json_decode($news_sub_category_info_array[0]['news_list']);
            foreach($news_config_list as $news)
            {
                if($news->news_id!=0)
                {
                    array_push($news_id_list,$news->news_id);
                }
            }
            $news_list = $this->admin_news_model->get_news_list_info($news_id_list)->result_array();
        }
        else
        {
            $news_list = $this->get_home_page_news_list();
            if(empty($news_list)){
                $news_list = $this->admin_news_model->get_news_list()->result_array();
            }
        }
        
        foreach($news_list as $news_info)
        {
            $news_id_news_info_map[$news_info['id']] = $news_info;
        }
        if(!empty($news_config_list) && $news_config_list != NULL)
        {
            foreach($news_config_list as $news)
            {
                if($news->news_id!=0){
                    $region_id_news_info_map[$news->region_id] = $news_id_news_info_map[$news->news_id];
                }else{
                    $region_id_news_info_map[$news->region_id] = array();
                }
            }
        }
        else
        {
            for($region_counter = 0; $region_counter < 13 ; $region_counter++)
            {
                $region_id_news_info_map[$region_counter] = $news_list[$region_counter];
            }
        }   
        
        return $region_id_news_info_map;
    }
}

?>