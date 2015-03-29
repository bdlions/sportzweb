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
class Searches_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This function takes user id and tells if 
     * he is PT Pro professionsal or not.
     * @author Tanveer Ahmed 29 march '15
     */
    public function is_gympro_user($user_id = 0){
        if($user_id == 0){
            return FALSE;
        }
        $this->db->where('user_id', $user_id);
        $this->db->where('account_type_id !=', APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT);
        $this->db->where('account_type_id !=', APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL);
        return $this->db->count_all_results($this->tables['app_gympro_users']) > 0;
    }
    
    
     /* this method return users info
     *@Rashida on 18th march
     */
    
    public function get_users($search_value)
    {
        $like = "(username LIKE '%".$search_value."%' OR first_name LIKE '%".$search_value."%' OR last_name LIKE '%".$search_value."%')";
        $this->db->where($like);        
        $this->db->limit(3);        
        $query = $this->db->select("username, first_name, last_name, " . $this->tables['users']. ".id as user_id, ". $this->tables['basic_profile']. ".photo,home_town,country_name")
                ->join($this->tables['basic_profile'], $this->tables['users'] . '.id = ' . $this->tables['basic_profile'] . '.user_id')
                ->join($this->tables['countries'], $this->tables['basic_profile'] . '.' . $this->join['countries'] . '=' . $this->tables['countries'] . '.id')
                ->get($this->tables['users']);
            return $query->result();
       
    }
    
    /* this method return business profile info  
    *@Rashida on 18th march
    */
    
    public function get_all_business_profile($search_value){
        $like = "(business_name LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->db->limit(3); 
        $query = $this->db->select("business_name, id, logo, ")
                        ->from($this->tables['business_profile'])
                        ->get();
        return $query->result();
    }
    
    /* this method return healthy recipes info  
    *@Rashida on 18th march
    */
    
    public function get_healthy_recipes($search_value)
    {
        $like = "(title LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->db->limit(3); 
        $query = $this->db->select("title, main_picture, id, ")
                        ->from($this->tables['recipes'])
                        ->get();
        return $query;
    }
    
    /* this method return services info  
    *@Rashida on 18th march
    */
    
    public function get_services($search_value)
    {
        $like = "(title LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->db->limit(3); 
        $query = $this->db->select("title, picture, id, ")
                        ->from($this->tables['services'])
                        ->get();
        return $query;
    }
    
   /* this method return news info  
    *@Rashida on 18th march
    */ 
    
    public function get_news($search_value)
    {
        $like = "(headline LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->db->limit(3); 
        $query = $this->db->select("headline, picture, id, ")
                        ->from($this->tables['news'])
                        ->get();
        return $query;
    }
    
    /* this method return blogs info  
    *@Rashida on 18th march
    */
    
    public function get_blogs($search_value)
    {
        $like = "(title LIKE '%".$search_value."%')";
        $this->db->where($like);
        $this->db->limit(3); 
        $query = $this->db->select("title, picture, id, ")
                        ->from($this->tables['blogs'])
                        ->get();
        return $query;
    }
}
?>
