<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Service Directory Model
 *
 * Author:  Nazmul Hasan
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Service_directory_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return all service categories
     * @Author Nazmul Hasan
     * @Created on 10 November 2014
     */
    public function get_all_service_categories()
    {
        return $this->db->select("*")
                    ->from($this->tables['service_category'])
                    ->get();
    }
    /*
     * This method will return services of a category or all services if there is no assigned service category
     * @param $$service_category_id, service category id
     * @Author Nazmul on 23rd November 2014
     */
    public function get_all_services($service_category_id_list = array()){
        if(!empty($service_category_id_list)){
            $this->db->where_in($this->tables['services'].'.service_category_id',$service_category_id_list);
        }
        return  $this->db->select($this->tables['services'].".*, ".$this->tables['service_category'].".id as service_category_id, ".$this->tables['service_category'].".picture as picture")
                ->from($this->tables['services'])
                ->join( $this->tables['service_category'], $this->tables['service_category']. ".id=".$this->tables['services'].".service_category_id", "left" )
                ->get();
    }
    
    /*
     * This method will return service info including business profile name if exists
     * @param $service_id, service id
     * @Author Nazmul on 10th January 2015
     */
    public function get_service_info($service_id)
    {
        $this->db->where($this->tables['services'].'.id',$service_id);
        return $this->db->select($this->tables['services'].'.*,'.$this->tables['services'].'.id as service_id,'.$this->tables['business_profile'].'.business_name as business_name')
                    ->from($this->tables['services'])
                    ->join($this->tables['business_profile'],  $this->tables['business_profile'].'.id='.$this->tables['services'].'.business_profile_id', 'left outer')
                    ->get();
    }
    
    public function get_all_service_comments($service_id)
    {
        $this->db->where($this->tables['service_comments'].'.service_id',$service_id);
        return $this->db->select($this->tables['service_comments'].'.*,'.$this->tables['users'].'.username,'.$this->tables['basic_profile'].'.photo')
                    ->from($this->tables['service_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['service_comments'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();
    }
    
    //written by omar faruk to save service comment from front end
    public function create_comment($data)
    {
        $this->trigger_events('pre create comment');
        $data = $this->_filter_data($this->tables['service_comments'],$data);
        
        $this->db->insert($this->tables['service_comments'],$data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post create comment');
        return (isset($id))? $id : FALSE;
    }
    
    public function get_comment_info($id)
    {
        $this->db->where($this->tables['service_comments'].'.id',$id);
        return $this->db->select($this->tables['service_comments'].'.*,'.$this->tables['users'].'.username as username')
                    ->from($this->tables['service_comments'])
                    ->join($this->tables['users'],  $this->tables['service_comments'].'.user_id='.$this->tables['users'].'.id')
                    ->get();
    }
    
    public function update_comment($id,$data)
    {
        $this->trigger_events('pre update comment');
        $this->db->where('id',$id);
        $this->db->update($this->tables['service_comments'],$data);
        
        if($this->db->affected_rows()==0)
        {
            return FALSE;
        }
        
        return True;
    }
    
    public function remove_comment($id)
    {
        $this->db->trans_begin();
        
        $this->db->where('id',$id);
        $this->db->delete($this->tables['service_comments']);
        if($this->db->affected_rows() == 0)
        {
            return FALSE;
        }
        
        if($this->db->trans_status() === FALSE)
        {
            
            $this->db->trans_rollback();
            return FALSE;
        }
        
        $this->db->trans_commit();
        return True;
    }
    
    public function get_all_comments($service_id,$sorted=0,$limit_no=0, $comment_id = 0)
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
                if($sorted==1){ $this->db->order_by($this->tables['service_comments'].'.id','desc');}
                else{ $this->db->order_by($this->tables['service_comments'].'.id','asc');}
            }

            $this->db->where($this->tables['service_comments'].'.service_id',$service_id);
        }  
        else
        {
            $this->db->where($this->tables['service_comments'].'.id',$comment_id);
        }
        return $this->db->select($this->tables['service_comments'].'.*,'.$this->tables['service_comments'].'.id as comment_id,'.$this->tables['service_comments'].'.created_on as comment_created_on,'.$this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['service_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['service_comments'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();
    }
}
