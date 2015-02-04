<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  News app Model
 * Author:  Nazmul Hasan
 * Requirements: PHP5 or above
 */

class News_app_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return news list
     * @param $news_id_list, list of news ids
     * @Author Nazmul
     * @Created on 30 April 2014
     */
    public function get_news_list($news_id_list = array())
    {
        if(!empty($news_id_list)){
            $this->db->where_in('id',$news_id_list);
        }
        return $this->db->select($this->tables['news'].'.id as news_id,'.$this->tables['news'].'.*')
                    ->from($this->tables['news'])
                    ->get();
    }
    
    /*
     * This method will return breaking news configuration list
     * @Author Nazmul on 4th February 2015
     */
    public function get_breaking_news_configuration_list()
    {
       return $this->db->select("*")
                    ->from($this->tables['app_news_breaking_news_configuration'])
                    ->order_by($this->tables['app_news_breaking_news_configuration'].'.id','desc')
                    ->get();
    }
    
    /*
     * This method will return latest news configuration list
     * @Author Nazmul on 4th February 2015
     */
    public function get_latest_news_configuration_list()
    {
       return $this->db->select("*")
                    ->from($this->tables['app_news_latest_news_configuration'])
                    ->order_by($this->tables['app_news_latest_news_configuration'].'.id','desc')
                    ->get();
    }
    
    /*
     * This method will return all service categories
     * @Author Redwan Khaled
     * @Created on 27th April 2014
     */
    
    public function get_all_news_category()
    {
        return $this->db->select("*")
                    ->from($this->tables['news_category'])
                    ->get();
    }
    
    public function get_news_info($news_id)
    {
        $this->db->where($this->tables['news'].'.id',$news_id);
        return $this->db->select($this->tables['news'].'.*,'.$this->tables['news'].'.id as news_id')
                    ->from($this->tables['news'])
                    ->get();
    }
    
    public function get_news_category_info($news_category_id)
    {
        $this->db->where($this->tables['news_category'].'.id',$news_category_id);
        
        return $this->db->select('*')
                    ->from($this->tables['news_category'])
                    ->get();   
    }
    
    public function get_news_sub_category_info($news_sub_category_id)
    {
        $this->db->where($this->tables['news_sub_category'].'.id',$news_sub_category_id);
        
        return $this->db->select('*')
                    ->from($this->tables['news_sub_category'])
                    ->get();
    }
    
    /*public function get_all_comments($news_id)
    {
        $this->db->where($this->tables['news_comments'].'.news_id',$news_id);
        return $this->db->select($this->tables['news_comments'].'.*,'.$this->tables['news_comments'].'.id as comment_id,'.$this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['news_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['news_comments'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();
    }*/
    
    public function get_username($id)
    {
        $this->db->where($this->tables['users'].'.id',$id);
        return $this->db->select($this->tables['users'].'.username as username')
                    ->from($this->tables['users'])
                    ->get();
    }

    
    /*-----------------------------News related query for front end------------------------*/
    /*-------------------------written by Omar-----------*/
    public function get_configed_news($date = 0)
    {
        if($date != 0) {
           $this->db->where($this->tables['news_home_page'].'.date',$date);
           $this->db->order_by('id', 'desc');
        }
        return $this->db->select("*")
                    ->from($this->tables['news_home_page'])
                    ->get();
    }
    
    public function get_news_list_info($news_id_list)
    {
        $this->db->where_in($this->tables['news'].'.id', $news_id_list);
        return $this->db->select('*')
                    ->from($this->tables['news'])
                    ->get();
    }
    
    public function create_comment($data)
    {
        $data = $this->_filter_data($this->tables['news_comments'], $data);
        $this->db->insert($this->tables['news_comments'],$data);
        $id = $this->db->insert_id();
        return isset($id)?$id:False;
    }
    
    public function get_comment_info($id)
    {
        $this->db->where($this->tables['news_comments'].'.id',$id);
        return $this->db->select("*")
                    ->from($this->tables['news_comments'])
                    ->get();
    }
    
    public function update_comment($id,$data)
    {
        $data = $this->_filter_data($this->tables['news_comments'], $data);
        $this->db->where($this->tables['news_comments'].'.id',$id);
        $this->db->update($this->tables['news_comments'],$data);
        
        return true;
    }
    
    public function remove_comment($id)
    {
        $this->db->where($this->tables['news_comments'].'.id',$id);
        $this->db->delete($this->tables['news_comments']);
        if($this->db->affected_rows()>0)
        {
            return True;
        }else{
            return False;
        }
    }
    
    public function get_all_news_sub_category($news_category_id = 0)
    {
        if($news_category_id != 0)
        {
            $this->db->where($this->tables['news_sub_category'].'.news_category_id',$news_category_id);
        }
        
        return $this->db->select($this->tables['news_sub_category'].'.*,'.$this->tables['news_category'].'.title as news_category_title')
                    ->from($this->tables['news_sub_category'])
                    ->join($this->tables['news_category'],  $this->tables['news_sub_category'].'.news_category_id='.$this->tables['news_category'].'.id')
                    ->get();
        
    }
    
    public function get_all_news($date=0)
    {
        
        if($date!=0)
        {
            $this->db->where($this->tables['news'].'.news_date',$date);
        }
        return $this->db->select('*')
                    ->from($this->tables['news'])
                    ->get();
    }
    
    public function get_all_comments($news_id,$sorted=0,$limit_no=0, $comment_id = 0)
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
                if($sorted==1){ $this->db->order_by($this->tables['news_comments'].'.id','desc');}
                else{ $this->db->order_by($this->tables['news_comments'].'.id','asc');}
            }

            $this->db->where($this->tables['news_comments'].'.news_id',$news_id);
        }  
        else
        {
            $this->db->where($this->tables['news_comments'].'.id',$comment_id);
        }
        return $this->db->select($this->tables['news_comments'].'.*,'.$this->tables['news_comments'].'.id as comment_id,'.$this->tables['news_comments'].'.created_on as comment_created_on,'.$this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['news_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['news_comments'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();
    }
    
    /*
     * This method will return last inserted news home page configuration of a date
     * If the entry doesnot exist then it will return latest entry of previous date if exists
     * @param $date, news home page configuration date
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_home_page_configuration($date)
    {
        $this->db->where('selected_date <=',$date);
        $result = $this->db->select('*')
                        ->from($this->tables['news_home_page_configuration'])
                        ->order_by('id', 'desc')
                        ->limit(1)
                        ->get();
        return $result;
    }
    
    /*
     * This method will return last inserted news sub category configuration of a date
     * If the entry doesnot exist then it will return latest entry of previous date if exists
     * @parameter $news_sub_category_id, news sub category id
     * @param $date, news sub category configuration date of news sub category id
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_sub_category_configuration($news_sub_category_id, $date)
    {
        $this->db->where('selected_date <=',$date);
        $this->db->where('news_sub_category_id',$news_sub_category_id);
        
        return $this->db->select('*')
                    ->from($this->tables['news_sub_category_configuration'])
                    ->order_by('id','desc')
                    ->limit(1)
                    ->get();
    }
    
    /*
     * This method will return last inserted news category configuration of a date
     * If the entry doesnot exist then it will return latest entry of previous date if exists
     * @parameter $news_category_id, news category id
     * @param $date, news category configuration date of news category id
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_category_configuration($news_category_id, $date)
    {
        $this->db->where('selected_date <=',$date);
        $this->db->where('news_category_id',$news_category_id);
        
        return $this->db->select('*')
                    ->from($this->tables['news_category_configuration'])
                    ->order_by('id','desc')
                    ->limit(1)
                    ->get();
    }
    
    
    /*
     * This method will return first NEWS_CONFIGURATION_COUNTER number of news
     * @Author Nazmul on 14th June 2014
     */
    public function get_news_list_initial_configuration()
    {
        return $this->db->select($this->tables['news'].'.id as news_id, '.$this->tables['news'].'.*')
                    ->from($this->tables['news'])
                    ->limit(NEWS_CONFIGURATION_COUNTER)
                    ->get();
    }
    
    
//    public function get_news_sub_category_info($sub_category_id)
//    {
//        $this->db->where('id',$sub_category_id);
//        return $this->db->select('*')
//                    ->from($this->tables['news_sub_category'])
//                    ->get();
//    }
}
