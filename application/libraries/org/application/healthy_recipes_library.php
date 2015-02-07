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
class Healthy_recipes_library {

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

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('org/application/healthy_recipes_model');

        $this->healthy_recipes_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->healthy_recipes_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in healthy_recipes_model');
        }

        return call_user_func_array(array($this->healthy_recipes_model, $method), $arguments);
    }

 /*
  * @author rashida on 7th february
  * this method return selected recipe for latest date in database
  */
    public function get_selected_recipe_for_home_page($present_date) {
        $result = $this->healthy_recipes_model->get_recipe_selection($present_date)->result_array();
        $arranged_select_recipe_list;
        if (!empty($result)) {
            foreach($result as $result_array){
                $arranged_select_recipe_list[ $result_array['selected_date'] ][] = $result_array;
            }
            ksort($arranged_select_recipe_list);
            $selected_recipe_list = end($arranged_select_recipe_list);
            $selected_recipe_list = end($selected_recipe_list);
            $selected_recipe_view_list = json_decode($selected_recipe_list['recipe_view_list']);
            $selected_recipe_item_list = json_decode($selected_recipe_list['recipe_list']);
            $recipe_view_list_item = $this->healthy_recipes_model->get_all_recipes_for_home($selected_recipe_view_list)->result_array();
            $recipe_list_item = $this->healthy_recipes_model->get_all_recipes_for_home($selected_recipe_item_list)->result_array();

            $data_array = array(
                'recipe_view_list_item' => $recipe_view_list_item,
                'recipe_list_item' => $recipe_list_item,
                 'show_advertise' => $selected_recipe_list['show_advertise_home_page']
            );

            return $data_array;
        } else {
            return $data_array = array();
        }
    }

   /*
    * @Author Rashida Sultana on 7th February
    * This method return Random 7 recipes for home page
    */
    
    public function get_random_recipe_for_home_page() {
        $recipe_view_list_item = $this->healthy_recipes_model->get_all_recipes_for_home()->result_array();
        if (!empty($recipe_view_list_item)) {
            $data_array = array(
                'recipe_view_list_item' => $recipe_view_list_item,
                'recipe_list_item' => $recipe_view_list_item
            );
            return $data_array;
        } else {
            return $data_array = array();
        }
    }

    /*
     * Writen by Omar faruk
     */

    public function get_recipe_item($recipe_id) {
        $recipe_item = $this->healthy_recipes_model->get_recipe($recipe_id)->result_array();
        
        if (count($recipe_item) > 0) {
            $recipe_item = $recipe_item[0];
            
            //here i collect recommended recipe list
            $recommend_desserts_item = array();
            $recommend_desserts = $recipe_item['recommend_desserts'];
            if(!empty($recommend_desserts)) {
              $recommend_desserts_item = $this->healthy_recipes_model->get_desserts_recipes(json_decode($recommend_desserts))->result_array();  
            }
            
            //here i collect alternative recipe list
            $alternative_recipes_item = array();
            $alternative_recipes = $recipe_item['alternative_recipes'];
            if(!empty($alternative_recipes)) {
               $alternative_recipes_item = $this->healthy_recipes_model->get_desserts_recipes(json_decode($alternative_recipes))->result_array(); 
            }
            
            $recipe_and_recommend_desserts_item = array(
                'recipe_item' => $recipe_item,
                'recommend_desserts_item' => $recommend_desserts_item,
                'alternative_recipes_item' => $alternative_recipes_item
            );

            return $recipe_and_recommend_desserts_item;
        } else {
            return $recipe_and_recommend_desserts_item = array();
        }
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
    
    public function get_all_comments($recipe_id,$sorted=0,$limit_no=0, $comment_id = 0)
    {
        $recipe_comment_list = array();
        $comment_list = $this->healthy_recipes_model->get_all_comments($recipe_id,$sorted,$limit_no, $comment_id)->result_array();
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
        $comment_info_array = $this->healthy_recipes_model->get_comment_info($comment_id)->result_array();
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
            $this->healthy_recipes_model->update_comment($comment_id, $additional_data);
        }
    }
    
    public function remove_like($comment_id, $user_id)
    {
        $comment_info_array = $this->healthy_recipes_model->get_comment_info($comment_id)->result_array();
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
            $this->healthy_recipes_model->update_comment($comment_id, $additional_data);
        }
    }

}

?>
