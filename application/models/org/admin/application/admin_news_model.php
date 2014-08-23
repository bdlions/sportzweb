<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Dataprovider Model
 * 
 * Author: Redwan
 * 
 * Requirement: PHP 5 and more
 */

class Admin_news_model extends Ion_auth_model
{
    protected $news_category_identity_column;
    protected $news_sub_category_identity_column;
    
    public function __construct() {
        parent::__construct();
    
        $this->news_category_identity_column = $this->config->item('news_category_identity_column', 'ion_auth');
        $this->news_sub_category_identity_column = $this->config->item('news_sub_category_identity_column','ion_auth');
        
    }
    
    
    /*----------------------------------*/
    
    public function create_news_category($news_category_name,$data)
    {
        $this->trigger_events('pre_create_news_category');
        if ($this->news_category_identity_column == 'title' && $this->news_category_identity_check($news_category_name)) 
        {
            $this->set_error('news_category_creation_duplicate_news_category_name');
            return FALSE;
        }
        $additional_data = array(
            'title' => $news_category_name
        );
        
        $additional_data = $this->_filter_data($this->tables['news_category'], $additional_data);
        
        $this->db->insert($this->tables['news_category'], $additional_data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post_create_news_category');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function update_news_category($id,$data)
    {
        $news_category_info = $this->get_news_category_info($id)->row();
        if (array_key_exists($this->news_category_identity_column, $data) && $this->news_category_identity_check($data[$this->news_category_identity_column]) && $news_category_info->title !== $data[$this->news_category_identity_column])
        {
            $this->set_error('news_category_duplicate');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['news_category'], $data);
        $this->db->update($this->tables['news_category'], $data, array('id' => $id));
        $this->set_message('news_category_update_successful');
        return true;
    }
    
    public function update_news_category_for_news($news_category_id, $encoded_value)
    {
        $data = array('news_list' => $encoded_value);
        $this->db->update($this->tables['news_category'], $data, array('id' => $news_category_id));
        $this->set_message('news_category_update_successful');
        return true;
    }

    public function news_category_identity_check($identity)
    {
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->news_category_identity_column,$identity);
        return $this->db->count_all_results($this->tables['news_category']) > 0;
    }

    public function remove_news_category($id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$id);
        $this->db->delete($this->tables['news_category']);
        
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;
    }
    
    public function get_all_news_category()
    {
        return $this->db->select("*")
                ->from( $this->tables['news_category'])
                ->get();
    }
    
    public function get_news_category_info($id)
    {
        $this->db->where($this->tables['news_category'].'.id',$id);
        
        return $this->db->select("*")
                    ->from($this->tables['news_category'])
                    ->get();
    }
    
    //written by omar faruk
    public function get_news_category_info_by_name($news_category_name)
    {   
        $this->db->where($this->tables['news_category'].'.title',$news_category_name);
        return $this->db->select("*")
                ->from($this->tables['news_category'])
                ->get();
    }
    
    /*--------------News Sub Category--------------------*/
    
    public function create_news_sub_category($sub_category_name,$data)
    {
        $this->trigger_events('pre_create_news_sub_category');
        if ($this->news_sub_category_identity_column == 'title' && $this->news_sub_category_identity_check($sub_category_name)) 
        {
            $this->set_error('news_sub_category_creation_duplicate_news_sub_category_name');
            return FALSE;
        }
        $additional_data = array(
            'title' => $sub_category_name
        );
        
        $additional_data = array_merge($this->_filter_data($this->tables['news_sub_category'], $data), $additional_data);
        
        $this->db->insert($this->tables['news_sub_category'], $additional_data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post_create_news_sub_category');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function news_sub_category_identity_check($identity)
    {
        if(empty($identity))
        {
            return False;
        }
        
        $this->db->where($this->news_sub_category_identity_column,$identity);
        return $this->db->count_all_results($this->tables['news_sub_category']) > 0;
    }

    public function update_news_sub_category($id,$data)
    {
        $news_sub_category_info = $this->get_news_sub_category_info($id)->row();
        if (array_key_exists($this->news_sub_category_identity_column, $data) && $this->news_sub_category_identity_check($data[$this->news_sub_category_identity_column]) && $news_sub_category_info->title !== $data[$this->news_sub_category_identity_column])
        {
            $this->set_error('news_sub_category_duplicate');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['news_sub_category'], $data);
        $this->db->update($this->tables['news_sub_category'], $data, array('id' => $id));
        $this->set_message('news_sub_category_update_successful');
        return true;
    }
    
    public function update_news_sub_category_for_news($news_sub_category_id,$encoded_value)
    {
        $data = array( 'news_list' => $encoded_value);
        $this->db->update($this->tables['news_sub_category'],$data,array('id'=>$news_sub_category_id));
        $this->set_message('News_sub_category_update_successful');
        
        return True;
    }
    
    public function remove_news_sub_category($sub_category_id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$sub_category_id);
        $this->db->delete($this->tables['news_sub_category']);
        
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;
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
    
    public function get_news_sub_category_info($sub_category_id)
    {
        $this->db->where($this->tables['news_sub_category'].'.id',$sub_category_id);
        return $this->db->select($this->tables['news_sub_category'].'.*,'.$this->tables['news_category'].'.title as news_category_title')
                    ->from($this->tables['news_sub_category'])
                    ->join($this->tables['news_category'],  $this->tables['news_sub_category'].'.news_category_id='.$this->tables['news_category'].'.id')
                    ->get();
    }
    
    /******News********/
    
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
    
    public function get_news_info($id)
    {
        $this->db->where($this->tables['news'].'.id',$id);
        return $this->db->select("*")
                    ->from($this->tables['news'])
                    ->get();
    }
    
    public function create_news($data)
    {
        $data = $this->_filter_data($this->tables['news'], $data);
        
        $this->db->insert($this->tables['news'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)? $id: False;
    }
    
    public function update_news($id,$data)
    {
        $this->db->trans_begin();
        
        $data = $this->_filter_data($this->tables['news'], $data);
        
        $this->db->where('id',$id);
        $this->db->update($this->tables['news'],$data);
        
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;
    }
    
    public function remove_news($id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$id);
        $this->db->delete($this->tables['news']);
        
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        return TRUE;
    }
    
    /****************************/
    
    public function create_comment($data)
    {
        $data = $this->_filter_data($this->tables['news_comments'], $data);
        
        $this->db->insert($this->tables['news_comments'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)? $id: False;
    }
    
    public function remove_comment($id)
    {
        
        $this->db->where('id',$id);
        $id = $this->db->delete($this->tables['news_comments']);
        if($id==False) return False;
        return TRUE;
        
    }
    
    public function update_comment($id,$data)
    {
        $data = $this->_filter_data($this->tables['news_comments'], $data);
        
        $this->db->where($this->tables['news_comments'].'.id',$id);
        
        $this->db->update($this->tables['news_comments'],$data);
        
        if($this->db->affected_rows() == 0)
        {
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function get_comment_info($id)
    {
        $this->db->where($this->tables['news_comments'].'.id',$id);
        
        return $this->db->select($this->tables['news_comments'].'.*,'.$this->tables['users'].'.username as username')
                    ->from($this->tables['news_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['news_comments'].'.user_id')
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
    
    public function create_latest_news($data)
    {
        $data = $this->_filter_data($this->tables['latest_news'], $data);
        
        $this->db->insert($this->tables['latest_news'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)? $id: False;
    }
    
    public function create_breaking_news($data)
    {
        $data = $this->_filter_data($this->tables['breaking_news'], $data);
        
        $this->db->insert($this->tables['breaking_news'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)? $id: False;
    }
    
    public function get_all_latest_news()
    {
        return $this->db->select("*")
                    ->from($this->tables['latest_news'])
                    ->get();
   
    }
    
    public function get_all_breaking_news()
    {
        return $this->db->select($this->tables['breaking_news'].'.*,'.$this->tables['news'].'.headline as headline')
                    ->from($this->tables['breaking_news'])
                    ->join($this->tables['news'],  $this->tables['news'].'.id='.$this->tables['breaking_news'].'.news_id')
                    ->get();
    }
    
    public function get_latest_news()
    {
        return $this->db->select("*")
                    ->from($this->tables['latest_news'])
                    ->order_by($this->tables['latest_news'].'.id','desc')
                    ->get();
    }
    
    public function get_breaking_news()
    {
       return $this->db->select("*")
                    ->from($this->tables['breaking_news'])
                    ->order_by($this->tables['breaking_news'].'.id','desc')
                    ->get();
    }
    
    public function config_news_for_home_page($data)
    {
        $data = $this->_filter_data($this->tables['news_home_page'],$data);
        $this->db->insert($this->tables['news_home_page'],$data);
        $id = $this->db->insert_id();
        return isset($id)? $id: FALSE;
    }
    
    //after modification news for home page
    
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
    
    public function get_news_list($news_id_list = array())
    {
        if(!empty($news_id_list)){
            $this->db->where_in('id',$news_id_list);
        }
        return $this->db->select($this->tables['news'].'.id as news_id,'.$this->tables['news'].'.*')
                    ->from($this->tables['news'])
                    ->get();
    }
    
    public function get_news_list_info($news_id_list)
    {
        $this->db->where_in('id',$news_id_list);
        
        return $this->db->select($this->tables['news'].'.id as news_id,'.$this->tables['news'].'.*')
                    ->from($this->tables['news'])
                    ->get();
    }
    
    /*
     * This method will add configuration of a news category
     * @Author Nazmul on 14th June 2014
     * news_list column of news_category_configuration table is a json object with the following attributes
     * region_id, id of a region
     * news_id, id of a news
     * is_ignored, a flag indicating whether that news is ignored or not for that region
     */
    public function add_news_category_configuration($data)
    {
        $data = $this->_filter_data($this->tables['news_category_configuration'], $data);
        
        $this->db->insert($this->tables['news_category_configuration'],$data);
        
        $id = $this->db->insert_id();
        
        return isset($id)?$id:FALSE;
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
     * This method will add configuration of a news sub category
     * @Author Nazmul on 14th June 2014
     * news_list column of news_category_configuration table is a json object with the following attributes
     * region_id, id of a region
     * news_id, id of a news
     * is_ignored, a flag indicating whether that news is ignored or not for that region
     */
    public function add_news_sub_category_configuration($data)
    {
        $data = $this->_filter_data($this->tables['news_sub_category_configuration'], $data);
        
        $this->db->insert($this->tables['news_sub_category_configuration'],$data);
        
        $id = $this->db->insert_id();
        
        return isset($id)?$id:FALSE;
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
    
    /*
     * This method will add configuration of a news home page
     * @Author Nazmul on 14th June 2014
     * news_list column of news_category_configuration table is a json object with the following attributes
     * region_id, id of a region
     * news_id, id of a news
     */
    public function add_news_home_page_configuration($data)
    {
        $data = $this->_filter_data($this->tables['news_home_page_configuration'], $data);
        
        $this->db->insert($this->tables['news_home_page_configuration'],$data);
        
        $id = $this->db->insert_id();
        
        return isset($id)?$id:FALSE;
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
     * This method will store news info imported by xlsx file
     * @param $data, any array with content of all columns of a row
     * @Author Nazmul on 14 June 2014
     */
    public function add_imported_news_info($data)
    {
        $this->db->trans_begin();
        $news_category_name = $data['news_category_name'];
        $news_category_info_array = $this->get_news_category_info_by_name($news_category_name)->result_array();

        if (!empty($news_category_info_array)) {
            $news_category_info_array = $news_category_info_array[0];
        } else {
            $id = $this->create_news_category($news_category_name, $additional_data = array());
            
            if($id == FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            
            $news_category_info_array = $this->get_news_category_info($id)->result_array();
            if(!empty($news_category_info_array))
            {
                $news_category_info_array = $news_category_info_array[0];
            }
            
        }

        $news_category_id = $news_category_info_array['id'];
        
        unset($data['news_category_name']);
        $news_id = $this->create_news($data);
        
        if($news_id == FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
                
        $this->db->trans_commit();
        
        return TRUE;
    }
    
}