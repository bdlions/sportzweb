<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Admin blog
 * Author: Nazmul
 * Requirements: PHP5 or above
 */
class Admin_blog{
    
    public function __construct() {
        $this->load->config('ion_auth',TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('basic_profile');
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
                        $this->load->model('org/admin/application/admin_blog_model');

        $this->admin_blog_model->trigger_events('library_constructor');
    }
    
   /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_blog_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_blog_model');
        }

        return call_user_func_array(array($this->admin_blog_model, $method), $arguments);
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
     * This method will add blog info under blog category
     * @param $blog_category_id, blog category id
     * @param $blog_id, blog id
     * @Author Nazmul on 15th December 2014
     */
    public function add_blog_in_blog_category($blog_category_id, $blog_id)
    {
        $blogs_array = array();
        $new_blog_info = new stdClass();
        $new_blog_info->blog_id = $blog_id;
        $blog_category_info_array = $this->admin_blog_model->get_blog_category_info($blog_category_id)->result_array();
        if(!empty($blog_category_info_array)){
            $blog_list = $blog_category_info_array[0]['blog_list'];
            if($blog_list != '' && $blog_list != NULL)
            {
                $blog_list_array = json_decode($blog_list);
                foreach($blog_list_array as $blog_info)
                {
                    if($blog_info->blog_id != $blog_id){
                        $blogs_array[] = $blog_info;
                    }
                }
            }
        }
        $blogs_array[] = $new_blog_info;
        $additional_data = array(
            'blog_list' => json_encode($blogs_array)
        );
        $this->admin_blog_model->update_blog_categroy($blog_category_id, $additional_data);
    }
    
    /*
     * This method will return blog category id list of a blog
     * @param $blog_id, blog id
     * @Author Nazmul on 15th December 2014
     */
    public function get_category_id_list_of_blog($blog_id) {
        $blog_category_id_list = array();
        $blog_category_info_array = $this->admin_blog_model->get_all_blog_category()->result_array();
        foreach($blog_category_info_array as $blog_category_info){
            $blog_category_id = $blog_category_info['blog_category_id'];
            $blog_list = $blog_category_info['blog_list'];
            if($blog_list != '' && $blog_list != NULL)
            {
                $blog_list_array = json_decode($blog_list);
                foreach($blog_list_array as $blog_info)
                {
                    if($blog_info->blog_id == $blog_id && !in_array($blog_category_id, $blog_category_id_list)){
                        $blog_category_id_list[] = $blog_category_id;
                    }
                }
            }
        }
        return $blog_category_id_list;
    }
    
    /*
     * This method will update blog reference in category based to given blog category list
     * @param $blog_id, blog id
     * @Author Nazmul on 15th December 2014
     */
    public function update_blog_in_blog_categories($blog_id, $selected_blog_category_id_list)
    {
        $blog_categories_array = $this->admin_blog_model->get_all_blog_category()->result_array();
        foreach ($blog_categories_array as $blog_category_info) {
            $blog_list = $blog_category_info['blog_list'];
            $blog_category_id = $blog_category_info['blog_category_id'];
            $blog_info = new stdClass();
            $blog_info->blog_id = $blog_id;
            $blogs_array = array();  
            $is_update_required = 0;
            $is_blog_exist = 0;                
            if($blog_list != '' && $blog_list != NULL)
            {
                $blog_list_array = json_decode($blog_list);
                foreach($blog_list_array as $blog_info)
                {
                    if($blog_info->blog_id != $blog_id){
                        $blogs_array[] = $blog_info;
                    }
                    else
                    {
                        if(!in_array($blog_category_id, $selected_blog_category_id_list))
                        {
                            //remove the blog from blog category
                            $is_update_required = 1;
                        }
                        else
                        {
                            //no change
                            $blogs_array[] = $blog_info;
                        }
                        $is_blog_exist = 1;
                    }
                }
                if(!$is_blog_exist && in_array($blog_category_id, $selected_blog_category_id_list))
                {
                    //add the blog in blog category                    
                    $blogs_array[] = $blog_info;
                    $is_update_required = 1;                    
                }                
            }
            else
            {
                //add the blog in blog category 
                if(in_array($blog_category_id, $selected_blog_category_id_list))
                {
                    $blogs_array[] = $blog_info;
                    $is_update_required = 1;
                }
            }
            if($is_update_required)
            {
                $additional_data = array(
                    'blog_list' => json_encode($blogs_array)
                );
                $this->admin_blog_model->update_blog_categroy($blog_category_id, $additional_data);
            }
        }
    }
    
     /*
     * This method will return blog list to be displayed on home page
     * @Omar faRUK
     * @Created on 12 May 2014
     */
    public function get_configed_blog_for_home_page()
    {
        $related_blogs_list = array();
        $present_date = date("d-m-Y");
        $results = $this->admin_blog_model->get_configed_blog($present_date)->result_array();
        
        if(count($results)>0) {
            $related_blogs_id = json_decode($results[0]['blog_list']);
            $related_blogs_list = $this->admin_blog_model->get_config_blog_list($related_blogs_id)->result_array();
            $show_advertise = $results[0]['show_advertise_home_page'];
        } else {
            $related_blogs_list = $this->admin_blog_model->get_config_blog_list()->result_array();
            $show_advertise = 0;
        }
        
        for($i=0;$i<count($related_blogs_list);$i++)
        {
            $related_blogs_list[$i]['counted_comment'] = count($this->admin_blog_model->get_all_comments($related_blogs_list[$i]['id'])->result_array());
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
        //$all_blogs_array = $this->admin_blog_model->get_blog_list()->result_array();
        $all_blogs_array = $this->admin_blog_model->all_blogs()->result_array();
        //blog_list will contain all blogs of the application
        $show_advertise = true;
        $region_id_blog_id_map = array();
        $blog_id_blog_info_map = array();
        //read blog_configure_homepage table
        $present_date = $this->utils->get_current_date();
        $blog_id_list = array();
        $blog_configuration_array = $this->admin_blog_model->get_home_page_blog_configuration($present_date)->result_array();        
        if(!empty($blog_configuration_array)) {
            $blog_configuration_info = $blog_configuration_array[0];
            $show_advertise = $blog_configuration_info['show_advertise_home_page'];
            $blog_list = json_decode($blog_configuration_info['blog_list']);
            
            foreach($blog_list as $blog_info)
            {
                $blog_id_list[] = $blog_info->blog_id;
                $region_id_blog_id_map[$blog_info->region_id] = $blog_info->blog_id;
            }
            $blog_list_array = $this->admin_blog_model->get_blog_list($blog_id_list)->result_array();
        }
        else 
        {
            $blog_list_array = $this->admin_blog_model->get_blog_list_initial_configuration()->result_array();
            for($region_counter = 0; $region_counter < BLOG_CONFIGURATION_COUNTER ; $region_counter++)
            {
                $region_id_blog_id_map[$region_counter] = $blog_list_array[$region_counter]['blog_id'];
            }
        }
        
        foreach($blog_list_array as $blog_info)
        {
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
    
    /**
     * 
     * @param type $region_id_blog_id_map array()
     * @param type $selected_date date
     * @param type $show_advertise boolian
     */
    public function add_home_page_blog_configuration($region_id_blog_id_map, $selected_date, $show_advertise)
    {
       
        $blog_list_array = array();
        foreach ($region_id_blog_id_map as $key => $value) {
            $blog_info_object = new stdClass();
            $blog_info_object->region_id = $key;
            $blog_info_object->blog_id = $value;
            $blog_list_array[] = $blog_info_object;
        }
        
        $data = array(
            'blog_list' => json_encode($blog_list_array),
            'selected_date' => $selected_date,
            'show_advertise_home_page' => $show_advertise,
            'created_on' => now(),
        );
        
        return $this->admin_blog_model->add_home_page_blog_configuration($data);
    }
    
    //this function is used to check the blog is set to present and feture date
    public function check_blog_before_delete_confirm($reference_id,$present_date) {
        $has_present_future_configuration = 0;
        $set_present_future = array();
        $set_present_future = $this->admin_blog_model->get_configed_blog_by_date($present_date)->result_array();
        $date_array = array();
        if(!empty($set_present_future)) {
            foreach ($set_present_future as $key => $present_future_blog_info) {
                $blog_list = json_decode($present_future_blog_info['blog_list']);
                foreach($blog_list as $blog_info)
                {
                    if($blog_info->blog_id == $reference_id) {
                        $date_array[] = $present_future_blog_info['selected_date'];
                    }
                }   
            }
        }
        $date_array = array_unique($date_array);
        return $date_array;
        //echo "<pre/>"; print_r($set_present_future); exit('in libery ddd');
    }
    
    // written by omar faruk
    public function get_all_category_of_this_blog($blog_id) {
        $all_blog_category = $this->admin_blog_model->get_all_blog_category()->result_array();
        $blog_list_array_map = array();
        $blog_list_array = array();
        foreach ($all_blog_category as $key => $blog_category) {
            if(!empty($blog_category['blog_list'])) {
                $blog_list_array = json_decode($blog_category['blog_list']);
                if(!empty($blog_list_array)){
                    foreach ($blog_list_array as $key => $blog_id_value) {
                        if($blog_id_value->blog_id == $blog_id){
                            $blog_id_object = new stdClass();
                            $blog_id_object->blog_id = $blog_category['blog_category_id'];
                            $blog_list_array_map[] = $blog_id_object;
                        }
                    }
                }
                
            }
        }
        return $blog_list_array_map;
    }
    
    //written by omar faruk
    public function blog_category_list_update($blog_category_id, $blog_id)
    {
        $new_blog_list_array = array();
        $blog_list_object = new stdClass();
        $blog_list_object->blog_id = $blog_id;
        $new_blog_list_array[] = $blog_list_object;
        
        $blog_category_info_array = $this->admin_blog_model->get_blog_category_info($blog_category_id)->result_array();
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
                    $new_blog_list_array[] = $blog_info;
                }
            }
        }
        
        $additional_data = array(
            'blog_list' => json_encode($new_blog_list_array)
        );
        $this->admin_blog_model->update_blog_categroy($blog_category_id, $additional_data);
    }
    
    //written by omar faruk 
    public function blog_category_list_update_by_remove($blog_category_id, $blog_id)
    {
        $new_blog_list_array = array();
        $blog_category_info_array = $this->admin_blog_model->get_blog_category_info($blog_category_id)->result_array();
        if(!empty($blog_category_info_array)){
             $blog_category_info_array = $blog_category_info_array[0];
             $blog_list = $blog_category_info_array['blog_list'];
             if(!empty($blog_list))
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
            $this->admin_blog_model->update_blog_categroy($blog_category_id, $additional_data);
            return TRUE;
        } else {
            return FALSE;
        }
        
    }
    
    public function get_all_blog_by_category($category_id) {
        $blog_list_array = array();
        $all_blogs_info = array();
        $blog_category_array = $this->admin_blog_model->get_blog_category_info($category_id)->result_array();
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

        $all_blogs_info = $this->admin_blog_model->get_all_blogs_by_category($pupulated_blog_id_array);
        if(!empty($all_blogs_info)) {
            $all_blogs_info = $all_blogs_info->result_array();
        }
        return $all_blogs_info;
    }
    

    public function remove_reference_blog_update_replica($reference_blog_id, $replica_blog_id) {
        
        $populated_blog_category_array = array();
        $category_list = $this->admin_blog->get_all_blog_category()->result_array();
        $blog_category_list_array_map = $this->get_all_category_of_this_blog($reference_blog_id);
        if(!empty($blog_category_list_array_map)){
           foreach ($blog_category_list_array_map as $key => $blog_category){
               //here $blog_category->blog_id is blog_category_id
                $this->remove_reference_update_replica($blog_category->blog_id,$reference_blog_id,$replica_blog_id);
            }
            
            /*$data = array(
                'blog_status_id' => APPROVED,
                'modified_on' => now()
            );
            $this->admin_blog_model->update_blog($replica_blog_id,$data);*/
            return true;
        }else {
            return false;
        }
    }
    
    public function remove_reference_update_replica($blog_category_id,$reference_blog_id,$replica_blog_id){
        $new_blog_list_array = array();
        $blog_list = array();
        $blog_category_info_array = $this->admin_blog_model->get_blog_category_info($blog_category_id)->result_array();
        if(!empty($blog_category_info_array)){
             $blog_category_info_array = $blog_category_info_array[0];
             $blog_list = $blog_category_info_array['blog_list'];
        }
        if($blog_list != '' && $blog_list != NULL)
        {
            $blog_list_array = json_decode($blog_list);
            foreach($blog_list_array as $blog_info)
            {
                if($blog_info->blog_id != $reference_blog_id){
                    $blog_list_object = new stdClass();
                    $blog_list_object->blog_id = $blog_info->blog_id;
                    $new_blog_list_array[] = $blog_list_object;
                }
            }
            
            $additional_data = array(
                'blog_list' => json_encode($new_blog_list_array)
            ); 

            $this->admin_blog_model->update_blog_categroy($blog_category_id, $additional_data);

            /*$data = array(
                'blog_status_id' => MODIFIED,
                'modified_on' => now()
            );
            $this->admin_blog_model->update_blog($reference_blog_id, $data);*/

            return true;
        }
        
        return false;
    }
    /*
     * This method will remove blog id from blog category table 
     * @param $blog_id, id of a blog
     * @Author Nazmul on 9th September 2014
     */
    public function remove_blog_id_from_blog_category($blog_id)
    {
        $blog_categories_array = $this->admin_blog_model->get_all_blog_categoties()->result_array();
        foreach($blog_categories_array as $blog_category_info){
            $blog_list = $blog_category_info['blog_list'];
            $blog_category_id = $blog_category_info['blog_category_id'];
            $blog_list_array = json_decode($blog_list);
            $blog_id_exists = false;
            $new_blog_list_array = array();
            foreach($blog_list_array as $blog_info)
            {
                 if($blog_info->blog_id != $blog_id){
                     $new_blog_list_array[] = $blog_info;
                 }
                 else
                 {
                     $blog_id_exists = true;
                 }
            }
            if($blog_id_exists)
            {
                $data = array( 
                    'blog_list' => json_encode($new_blog_list_array)
                );
                $this->admin_blog_model->update_blog_categroy($blog_category_id, $data);
            }
        }
    }
    
    /*
     * This method will add blog id in blog category table based on blog_category_ids
     * @param $blog_id, id of a blog
     * @param $blog_category_ids, blog category ids
     * @Author Nazmul on 9th September 2014
     */
    public function add_blog_id_in_blog_category($blog_id, $blog_category_ids = array())
    {
        $new_blog_info = new stdClass();
        $new_blog_info->blog_id = $blog_id;
        $blog_categories_array = $this->admin_blog_model->get_all_blog_categoties()->result_array();
        foreach($blog_categories_array as $blog_category_info){            
            $blog_category_id = $blog_category_info['blog_category_id'];
            if(in_array($blog_category_id, $blog_category_ids))
            {
                $blog_list = $blog_category_info['blog_list'];
                $blog_list_array = json_decode($blog_list);
                $new_blog_list_array = array();
                foreach($blog_list_array as $blog_info)
                {
                     $new_blog_list_array[] = $blog_info;
                }
                $new_blog_list_array[] = $new_blog_info;
                $additional_data = array( 
                    'blog_list' => json_encode($new_blog_list_array)
                );
                $this->admin_blog_model->update_blog_categroy($blog_category_id, $additional_data);
            }
        }
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
        $blog_info_array = $this->admin_blog_model->get_blog_info($blog_id)->result_array();
        if(!empty($blog_info_array))
        {
            $blog_info = $blog_info_array[0];
            if($this->basic_profile->is_basic_profile_exist($blog_info['user_id']))
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
}
?>
 