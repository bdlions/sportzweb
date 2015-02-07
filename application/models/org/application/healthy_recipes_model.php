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
class Healthy_recipes_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*-----------------------------Recipe related query for front end------------------------*/
    
    /*
     * @Author Rashida on 7th February
     * this method return selected recipes less then or equal to current date 
     */
    
   public function get_recipe_selection($date = 0)
    {
        $this->db->where($this->tables['recipe_selection'].'.selected_date <=',$date);
        return $this->db->select("*")
                    ->from($this->tables['recipe_selection'])
                    ->get();
    }

    /* 
     * written by Rashida Sultana 2nd february
     *this function is to retrive specific recipes or only seven recipes
     */
    
    public function get_all_recipes_for_home($recipe_id_list = array())
    {
        if(!empty($recipe_id_list)>0) {
            $list = implode (", ", array_filter($recipe_id_list));
            $this->db->_protect_identifiers = FALSE;
            $this->db->where_in($this->tables['recipes'].'.id', $recipe_id_list);
            $this->db->order_by("FIELD (recipes.id, " . $list . ")");
            $this->db->_protect_identifiers = TRUE;
        } else {
                $this->db->limit(DEFAULT_VIEW_PER_PAGE, 0);
        }
          return $this->db->select($this->tables['recipe_category'].'.description as categoty_description,'.$this->tables['recipes'].'.*')
                    ->from($this->tables['recipes'])
                    ->join($this->tables['recipe_category'], $this->tables['recipe_category'].'.id='.$this->tables['recipes'].'.recipe_category_id','left')
                    ->get();
    }
    
    public function get_all_recipes_by_letter()
    {
        return $this->db->select($this->tables['recipe_category'].'.description as categoty_description,'.$this->tables['recipes'].'.*')
                    ->from($this->tables['recipes'])
                    ->join($this->tables['recipe_category'], $this->tables['recipe_category'].'.id='.$this->tables['recipes'].'.recipe_category_id','left')
                    ->get();
    }
    
    /*-------------------------Recipe written by Omar-----------*/
    public function get_total_recipes($recipe_category_id = 0)
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
    
    /*-------------------------Recipe written by Omar-----------*/
    public function get_recipe($recipe_id)
    {
        $this->db->where($this->tables['recipes'].'.id',$recipe_id);
        return $this->db->select("*")
                ->from($this->tables['recipes'])
                ->get();
    }
    
    /*-------------------------Recipe written by Omar-----------*/
    public function get_desserts_recipes($recipes_id = array())
    {
        if(count($recipes_id)>0) {
            $this->db->where_in($this->tables['recipes'].'.id', $recipes_id);
        }
        
        return $this->db->select("*")
                ->from($this->tables['recipes'])
                ->get();
    }
    
    public function get_recipe_category_for_menu()
    {
        /*$all_recipies_category = $this->get_all_recipe_category()->result_array();
        $total_no_of_records = count($all_recipies_category);
        if($total_no_of_records > 6) {
            $random_no = rand(0,$total_no_of_records-6);
            $this->db->limit(6, $random_no);
        }*/
        $this->db->limit(8, 0);
        return $this->db->select("*")
                ->from($this->tables['recipe_category'])
                ->get();
    }
    
    public function get_all_recipe_category()
    {
        return $this->db->select("*")
                ->from($this->tables['recipe_category'])
                ->get();
    }
    
    public function get_recipe_category_info($id)
    {
        $this->db->where($this->tables['recipe_category'].'.id' ,$id);
        return $this->db->select("*")
                ->from($this->tables['recipe_category'])
                ->get();
    }

    public function get_recipe_by_alphabet($alphabet)
    {
        
        //$this->db->like($this->tables['recipes'].'.title', $alphabet);
        $this->db->like($this->tables['recipes'].'.title', $alphabet, 'after'); 
        return $this->db->select($this->tables['recipe_category'].'.description as categoty_description,'.$this->tables['recipes'].'.*')
                   ->from($this->tables['recipes'])
                   ->join($this->tables['recipe_category'], $this->tables['recipe_category'].'.id='.$this->tables['recipes'].'.recipe_category_id','left')
                   ->get();
         //echo $this->db->last_query();exit;
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
    
    public function create_comment($data)
    {
        $data = $this->_filter_data($this->tables['recipe_comments'], $data);        
        $this->db->insert($this->tables['recipe_comments'],$data);        
        $id = $this->db->insert_id();        
        return isset($id)?$id:False;
    }
    
    public function get_comment_info($id)
    {
        $this->db->where($this->tables['recipe_comments'].'.id',$id);
        return $this->db->select("*")
                    ->from($this->tables['recipe_comments'])
                    ->get();
    }
    
    public function update_comment($id,$data)
    {
        $data = $this->_filter_data($this->tables['recipe_comments'], $data);
        $this->db->where($this->tables['recipe_comments'].'.id',$id);
        $this->db->update($this->tables['recipe_comments'],$data);        
        return TRUE;
    }
    
    public function remove_comment($id)
    {
        $this->db->where($this->tables['recipe_comments'].'.id',$id);
        $this->db->delete($this->tables['recipe_comments']);
        if($this->db->affected_rows()>0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    
    // ---------------------------- Mobile Application Module ---------------------
    /*
     * This method will return all recipe categories
     * @Author Nazmul on 28th October 2014
     */
    public function get_all_recipe_categories()
    {
        return $this->db->select($this->tables['recipe_category'].'.id as recipe_category_id,'.$this->tables['recipe_category'].'.*')
                ->from($this->tables['recipe_category'])
                ->get();
    }
    /*
     * This method will return all recipe list under a recipe category
     * @param $recipe_category_id, recipe category id
     * @Author Nazmul on 28th October 2014
     */
    public function get_recipe_list_by_category($recipe_category_id = 0)
    {
        if($recipe_category_id != 0)
        {
            $this->db->where('recipe_category_id', $recipe_category_id);
        }
        return $this->db->select($this->tables['recipes'].'.id as recipe_id,'.$this->tables['recipes'].'.*')
                    ->from($this->tables['recipes'])
                    ->get();
    }
    
    /*
     * This method will return recipe info of a recipe
     * @param $recipe_id, recipe id
     * @Author Nazmul on 28th October 2014
     */
    public function get_recipe_info($recipe_id)
    {
        $this->db->where($this->tables['recipes'].'.id',$recipe_id);
        return $this->db->select($this->tables['recipes'].'.id as recipe_id,'.$this->tables['recipes'].'.main_picture as picture,'.$this->tables['recipes'].'.*')
                ->from($this->tables['recipes'])
                ->get();
    }
}
