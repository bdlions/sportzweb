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

class Admin_blog{
    
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
        $all_blogs_array = $this->admin_blog_model->get_blog_list()->result_array();
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
        $this->admin_blog_model->update_blog_categroy($blog_category_id, $additional_data);
        return true;
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
    

}

?>
 