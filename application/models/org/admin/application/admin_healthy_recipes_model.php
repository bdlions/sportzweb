<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  dataprovider Model
 *
 * Author:  alamgir kabir
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Admin_healthy_recipes_model extends Ion_auth_model {
    
    protected $recipe_category_identity_column;
    protected $recipe_identity_column;

    public function __construct() {
        parent::__construct();
        $this->recipe_category_identity_column = $this->config->item('recipe_category_identity_column', 'ion_auth');
        $this->recipe_identity_column = $this->config->item('recipe_identity_column', 'ion_auth');
        
    }   
    
    /******************Recipe Category-----------------------*/
    public function get_all_category()
    {
        $query = $this->db->select("*")
                   ->from($this->tables['recipe_category'])
                   ->get();
        return $query;
    }
    
    // written by omar
    public function create_recipe_category($recipe_category_name, $additional_data)
    {
        $this->trigger_events('pre_create_recipe_category');
        if ($this->recipe_category_identity_column == 'description' && $this->recipe_category_identity_check($recipe_category_name)) 
        {
            $this->set_error('recipe_category_creation_duplicate_recipe_category_name');
            return FALSE;
        }
        $data = array(
            'description' => $recipe_category_name
        );
        
        $additional_data = $this->_filter_data($this->tables['recipe_category'], $data);
        
        $this->db->insert($this->tables['recipe_category'], $additional_data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post_create_recipe_category');
        return (isset($id)) ? $id : FALSE;
    }
    
    /*-------------------------Recipe written by Omar-----------*/
    public function recipe_category_identity_check($identity = '') {
        $this->trigger_events('recipe_category_identity_check');
        
        if (empty($identity)) {
            return FALSE;
        }
        $this->db->where($this->recipe_category_identity_column, $identity);
        return $this->db->count_all_results($this->tables['recipe_category']) > 0;
    }
    
    public function get_recipe_category($recipe_category_id)
    {        
        $this->db->where($this->tables['recipe_category'].'.id',$recipe_category_id);
        return $this->db->select("*")
                ->from($this->tables['recipe_category'])
                ->get();
    }
    
    //written by omar faruk
    public function get_recipe_category_info_by_name($recipe_category_name)
    {     
        $this->db->where($this->tables['recipe_category'].'.description',$recipe_category_name);
        return $this->db->select("*")
                ->from($this->tables['recipe_category'])
                ->get();
    }
    
    public function update_recipe_category($id,$data)
    {
        
        $recipe_category_info = $this->get_recipe_category($id)->row();
        if (array_key_exists($this->recipe_category_identity_column, $data) && $this->recipe_category_identity_check($data[$this->recipe_category_identity_column]) && $recipe_category_info->description == $data[$this->recipe_category_identity_column])
        {
            $this->set_error('recipe_category_update_duplicate_category');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['recipe_category'], $data);
        $this->db->update($this->tables['recipe_category'], $data, array('id' => $id));
        $this->set_message('recipe_category_update_successful');
        return true;
    }
    /*-----------------------------Recipe------------------------*/
    /*-------------------------Recipe written by Omar-----------*/
    public function get_all_recipes($recipe_category_id = 0)
    {
        if($recipe_category_id != 0)
        {
            $this->db->where('recipe_category_id', $recipe_category_id);
        }
        return $this->db->select($this->tables['recipe_category'].'.description as categoty_description,'.$this->tables['recipes'].'.*')
                    ->from($this->tables['recipes'])
                    ->join($this->tables['recipe_category'], $this->tables['recipe_category'].'.id='.$this->tables['recipes'].'.recipe_category_id','left')
                    ->get();
    }
    
    public function get_recipe($recipe_id)
    {
        
        $this->db->where($this->tables['recipes'].'.id',$recipe_id);
        return $this->db->select("*")
                ->from($this->tables['recipes'])
                ->get();
    }
    
    public function create_recipe($recipe_name,$additional_data)
    {
        $this->trigger_events('pre_create_recipe');
        if ($this->recipe_identity_column == 'title' && $this->recipe_identity_check($recipe_name)) 
        {
            $this->set_error('recipe_creation_duplicate_recipe_name');
            return FALSE;
        }
        $data = array(
            'title' => $recipe_name
        );
        
        $additional_data = array_merge($this->_filter_data($this->tables['recipes'], $additional_data), $data);
        $this->db->insert($this->tables['recipes'], $additional_data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post_create_recipe');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function recipe_identity_check($identity)
    {
        $this->trigger_events('recipe_identity_check');
        
        if (empty($identity)) {
            return FALSE;
        }
        $this->db->where($this->recipe_identity_column, $identity);
        return $this->db->count_all_results($this->tables['recipes']) > 0;
    }
    
    public function update_recipe($id,$data)
    {
        $recipe_info = $this->get_recipe($id)->row();
        if(array_key_exists($this->recipe_identity_column, $data) && $this->recipe_identity_check($data[$this->recipe_identity_column]) && $recipe_info->title !== $data[$this->recipe_identity_column])
        {
            $this->set_error('recipe_update_duplicate_recipe');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['recipes'], $data);
        $this->db->update($this->tables['recipes'], $data, array('id' => $id));
        $this->set_message('recipe_update_successful');
        return true;
        
    }

    public function create_recipe_selection($data)
    {

        $data = $this->_filter_data($this->tables['recipe_selection'],$data);
        $this->db->insert($this->tables['recipe_selection'],$data);
        $id = $this->db->insert_id();

        return isset($id)? $id: FALSE;
    }


    public function get_recipe_selection($date = 0)
    {
        if($date != 0) {
           $this->db->where($this->tables['recipe_selection'].'.selected_date',$date);
        }
        $this->db->order_by('id', 'desc');
        
        return $this->db->select("*")
                    ->from($this->tables['recipe_selection'])
                    ->get();
    }

    public function update_recipe_selection($data)
    {

        $this->db->where($this->tables['recipe_selection'].'.id',1);
        $data = $this->_filter_data($this->tables['recipe_selection'],$data);
        $this->db->update($this->tables['recipe_selection'],$data);

    }
    
    /*****Search Recipe********/
    
    public function search_recipe($keyword)
    {
        $this->db->like('title',$keyword);
        
        return $this->db->select("*")
                ->from($this->tables['recipes'])
                ->get();
    }
    
     /*-------------------------written by Omar-----------*/
   //this function is to retrive specific recipes or only four recipes
    public function get_all_recipes_for_home($recipes_id = null)
    {
        //echo '<pre/>';print_r($recipes_id);exit;
        if(count($recipes_id)>0) {
            $list = implode (", ", array_filter($recipes_id));
            $this->db->_protect_identifiers = FALSE;
            $this->db->where_in($this->tables['recipes'].'.id', $recipes_id);
            $this->db->order_by("FIELD (recipes.id, " . $list . ")");
            $this->db->_protect_identifiers = TRUE;
        } else {
            $all_recipies = $this->get_all_recipes()->result_array();
            $total_no_of_record = count($all_recipies);
            if($total_no_of_record > 14) {
                $random_no = rand(0,$total_no_of_record-7);
                $this->db->limit(7, $random_no);
            } else {
                $this->db->limit(7, 0);
            }
            
        }
          return $this->db->select($this->tables['recipe_category'].'.description as categoty_description,'.$this->tables['recipes'].'.*')
                    ->from($this->tables['recipes'])
                    ->join($this->tables['recipe_category'], $this->tables['recipe_category'].'.id='.$this->tables['recipes'].'.recipe_category_id','left')
                    ->get();
    }
    
    public function get_all_comments($recipe_id,$sorted=0,$limit_no=0, $comment_id = 0)
    {
        //if we have a comment id then we are skipping constraints
        if($comment_id == 0)
        {
            if($limit_no!=0)
            {
                $this->db->limit($limit_no);
            }

            if($sorted!=0)
            {
                if($sorted==1){ $this->db->order_by($this->tables['recipe_comments'].'.id','desc');}
                else{ $this->db->order_by($this->tables['recipe_comments'].'.id','asc');}
            }

            $this->db->where($this->tables['recipe_comments'].'.recipe_id',$recipe_id);
        }  
        else
        {
            $this->db->where($this->tables['recipe_comments'].'.id',$comment_id);
        }
        return $this->db->select($this->tables['recipe_comments'].'.*,'.$this->tables['recipe_comments'].'.id as comment_id,'.$this->tables['recipe_comments'].'.created_on as comment_created_on,'.$this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['recipe_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['recipe_comments'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();
    }
    
    public function get_desserts_recipes($recipes_id = array())
    {
        if(count($recipes_id)>0) {
            $this->db->where_in($this->tables['recipes'].'.id', $recipes_id);
        }
        
        return $this->db->select("*")
                ->from($this->tables['recipes'])
                ->get();
    }
    
    /*
     * This method will store recipe info imported by xlsx file
     * @param $data, any array with content of all columns of a row
     * @Author Nazmul on 14 June 2014
     */
    public function add_imported_recipe_info($data)
    {
        
        $this->db->trans_begin();
        $recipe_category_name = $data['recipe_category_name'];
        $recipe_category_info_array = $this->get_recipe_category_info_by_name($recipe_category_name)->result_array();
        if(!empty($recipe_category_info_array))
        {
            $recipe_category_info_array = $recipe_category_info_array[0];
        }
        else
        {
            $id = $this->create_recipe_category($recipe_category_name, $additional_data = array());
            
            if($id == FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            
            if($id !== FALSE)
            {
                $recipe_category_info_array = $this->get_recipe_category($id)->result_array();
                if(!empty($recipe_category_info_array))
                {
                    $recipe_category_info_array = $recipe_category_info_array[0];
                }             
            }
        }
        $title = $data['title'];
        $data['recipe_category_id'] = $recipe_category_info_array['id'];
        unset($data['recipe_category_name']);
        unset($data['title']);
        $flag = $this->create_recipe($title, $data);
        
        if($flag == FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        
        $this->db->trans_commit();
        
        return TRUE;
    }
    
}
