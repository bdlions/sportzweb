<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Blog App Model
 *
 * Author:  Redwan Khaled
 *
 *
 * Requirements: PHP5 or above
 *
 */

class Blog_app_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * This method will return blog list
     * @param $blog_id_list, list of blog ids
     * @Author Nazmul
     * @Created on 30 April 2014
     */
    public function get_all_blog_category()
    {
        return $this->db->select("*")
                    ->from($this->tables['blog_category'])
                    ->get();
    }
    
    public function update_blog_categroy($id,$data)
    {
        $blog_category_info = $this->get_blog_category_info($id)->row();
        
        $data = $this->_filter_data($this->tables['blog_category'], $data);
        $this->db->update($this->tables['blog_category'], $data, array('id' => $id));
        $this->set_message('blog_category_update_successful');
        return true;
    }
    
    public function get_blog_info($blog_id)
    {
        $this->db->where($this->tables['blogs'].'.id',$blog_id);
        return $this->db->select($this->tables['blogs'].'.*,'.$this->tables['blogs'].'.id as blog_id,'.$this->tables['users'].'.first_name,'.$this->tables['users'].'.last_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blogs'].'.user_id')
                    ->get();
    }
    
    public function get_blog_category_info($id)
    {
        $this->db->where('id',$id);
        return $this->db->select("*")
                    ->from($this->tables['blog_category'])
                    ->get();
    }
    
    public function create_blog($data)
    {
        $data = $this->_filter_data($this->tables['blogs'], $data);
        $this->db->insert($this->tables['blogs'],$data);
    
        $id = $this->db->insert_id();
        
        return isset($id)?$id:False;
    }
    
    /*********Comments***********/
    
    /*public function get_all_comments($blog_id,$sorted=0)
    {
        if($sorted!=0)
        {
            if($sorted==1){ $this->db->order_by($this->tables['blog_comments'].'.id','asc');}
            else{ $this->db->order_by($this->tables['blog_comments'].'.id','desc');}
        }
        
        $this->db->where($this->tables['blog_comments'].'.blog_id',$blog_id);
        return $this->db->select($this->tables['blog_comments'].'.*,'.$this->tables['blog_comments'].'.id as comment_id,'.$this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['blog_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blog_comments'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();

    }*/
    
    public function create_comment($data)
    {
        $data = $this->_filter_data($this->tables['blog_comments'], $data);
        $this->db->insert($this->tables['blog_comments'],$data);
        $id = $this->db->insert_id();
        return isset($id)?$id:False;
    }
    
    public function get_comment_info($id)
    {
        $this->db->where($this->tables['blog_comments'].'.id',$id);
        return $this->db->select("*")
                    ->from($this->tables['blog_comments'])
                    ->get();
    }
    
    public function update_comment($id,$data)
    {
        $data = $this->_filter_data($this->tables['blog_comments'], $data);
        $this->db->where($this->tables['blog_comments'].'.id',$id);
        $this->db->update($this->tables['blog_comments'],$data);
        
        return true;
    }
    
    public function remove_comment($id)
    {
        $this->db->where($this->tables['blog_comments'].'.id',$id);
        $this->db->delete($this->tables['blog_comments']);
        if($this->db->affected_rows()>0)
        {
            return True;
        }
        else
        {
            return False;
        }
    }
    
    public function get_configed_blog($date = 0)
    {
        if($date != 0) {
           $this->db->where($this->tables['blog_configure_homepage'].'.selected_date',$date);           
        }
        $this->db->order_by('id', 'desc');
        return $this->db->select("*")
                    ->from($this->tables['blog_configure_homepage'])
                    ->get();
    }
    
    public function get_all_blogs($category_id=0)
    {
        if($category_id!=0)
        {
            $this->db->where($this->tables['blogs'].'.blog_category_id',$category_id);
        }
        $this->db->order_by($this->tables['blogs'].'.order_no','asc');
        $this->db->where($this->tables['blogs'].'.blog_status_id',2);
        return $this->db->select($this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }
    
    /*
     * This method will return blog list to be displayed on home page which is config from admin panel
     * otherwise it will return 6 random blog if only the total no of blog is gretter then 11
     * or it will return 1 to 6 blog
     * @Omar faRUK
     * @Created on 05 May 2014
     */
    
    public function get_config_blog_list($blogs_id = array())
    {
        if(count($blogs_id)==8) {
            $list = implode (", ", array_filter($blogs_id));
            $this->db->_protect_identifiers = FALSE;
            $this->db->where_in($this->tables['blogs'].'.id',$blogs_id);
            $this->db->order_by("FIELD (blogs.id, " . $list . ")");
            $this->db->_protect_identifiers = TRUE;
        } else {
            $total_no_of_record = $this->get_all_blogs()->result_array();
            if(count($total_no_of_record)>13) {
                $random_no = rand(0,count($total_no_of_record)-8);
                $this->db->limit(8, $random_no);
            } else {
                $this->db->limit(8, 0);
            }
        }
        
        return $this->db->select($this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }
    
    //
    
    /*
     * This method will return blog list
     * @param, $blog_id_list, blog id list
     * @Author Omar on 15th June 2014
     */
    public function get_blog_list($blog_id_list = array())
    {
        if(!empty($blog_id_list))
        {
            $list = implode (", ", array_filter($blog_id_list));
            $this->db->_protect_identifiers = FALSE;
            $this->db->where_in($this->tables['blogs'].'.id',$blog_id_list);
            $this->db->order_by("FIELD (blogs.id, " . $list . ")");
            $this->db->_protect_identifiers = TRUE;

        }
        $this->db->where($this->tables['blogs'].'.blog_status_id',APPROVED);
        return $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }
    
    /*
     * This method will return first BLOG_CONFIGURATION_COUNTER number of blogs
     * @Author Nazmul on 14th June 2014
     */
    public function get_blog_list_initial_configuration()
    {
        $this->db->limit(BLOG_CONFIGURATION_COUNTER);
        return $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }
    
    /*
     * This method will return last inserted blog home page configuration of a date
     * If the entry doesnot exist then it will return latest entry of previous date if exists
     * @param $date, blog home page configuration date
     * @Author Nazmul on 14th June 2014
     */
    public function get_home_page_blog_configuration($date)
    {
        $this->db->where('selected_date <=',$date);
        $result = $this->db->select('*')
                        ->from($this->tables['blog_configure_homepage'])
                        ->order_by('id', 'desc')
                        ->limit(1)
                        ->get();
        return $result;
    }
    
    
    public function get_relate_blog_list($blogs_id = array())
    {
        if(count($blogs_id)!= 0) {
            $this->db->where_in($this->tables['blogs'].'.id',$blogs_id);
        }
        return $this->db->select($this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }
    
    public function get_all_blogs_for_home_page()
    {
        $this->db->limit(10, 0);
        
        return $this->db->select("*")
                    ->from($this->tables['blog_category'])
                    ->get(); 
    }
    
    public function get_all_custom_blogs_for_home_page()
    {
        return $this->db->select("*")
                    ->from($this->tables['blog_custom_category'])
                    ->get(); 
    }
    
    public function get_all_comments($blog_id,$sorted=0,$limit_no=0, $comment_id = 0)
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
                if($sorted==1){ $this->db->order_by($this->tables['blog_comments'].'.id','desc');}
                else{ $this->db->order_by($this->tables['blog_comments'].'.id','asc');}
            }

            $this->db->where($this->tables['blog_comments'].'.blog_id',$blog_id);
        }  
        else
        {
            $this->db->where($this->tables['blog_comments'].'.id',$comment_id);
        }
        return $this->db->select($this->tables['blog_comments'].'.*,'.$this->tables['blog_comments'].'.id as comment_id,'.$this->tables['blog_comments'].'.created_on as comment_created_on,'.$this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*,'.$this->tables['basic_profile'].'.*')
                    ->from($this->tables['blog_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blog_comments'].'.user_id')
                    ->join($this->tables['basic_profile'],  $this->tables['users'].'.id='.$this->tables['basic_profile'].'.user_id')
                    ->get();
    }
    
    public function get_all_blogs_by_user($user_id=0, $status_id_list = array())
    {
        if($user_id==0)
        {
            $user_id = $this->session->userdata('user_id');
        }        
        $this->db->where($this->tables['blogs'].'.user_id',$user_id);
        if(!empty($status_id_list))
        {
            $this->db->where_in($this->tables['blogs'].'.blog_status_id',$status_id_list);
        }
        return $this->db->select($this->tables['blogs'].'.id as blog_id,'.$this->tables['blogs'].'.*,'.$this->tables['blog_status'].'.title as status_title')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_status'],  $this->tables['blogs'].'.blog_status_id='.$this->tables['blog_status'].'.id')
                    ->get();
    }
    
    public function update_blog($blog_id,$data)
    {
        $data = $this->_filter_data($this->tables['blogs'], $data);
        
        $this->db->update($this->tables['blogs'],$data,array('id' => $blog_id));
        
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /*
     * This method will return latest blog
     * @param  $user_id_list, user id list
     * @param $status_id_list, blog status id list
     * @Author Nazmul on 14th June 2014
     */
    public function get_blog_for_recent_activity($user_id_list = array(), $status_id_list = array())
    {
        if(!empty($user_id_list))
        {
            $this->db->where_in($this->tables['blogs'].'.user_id',$user_id_list);
        }
        if(!empty($status_id_list))
        {
            $this->db->where_in($this->tables['blogs'].'.blog_status_id',$status_id_list);
        }
        return $this->db->select($this->tables['blogs'].'.id as blog_id,'.$this->tables['blogs'].'.*,'.$this->tables['users'].'.id as user_id,'.$this->tables['users'].'.*')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blogs'].'.user_id')
                    ->get();
    }
    
    public function blog_category_list_update()
    {
        
    }
     
}
