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

class Admin_blog_model extends Ion_auth_model
{
    protected $blog_category_identity_column;
    
    public function __construct() {
        parent::__construct();
    
        $this->blog_category_identity_column = $this->config->item('blog_category_identity_column', 'ion_auth');
        
    }
    
    /*
     * This method will return all blog categories 
     * @Author Nazmul on 9th September 2014
     */
    public function get_all_blog_categoties()
    {
        return $this->db->select($this->tables['blog_category'].".id as blog_category_id, ".$this->tables['blog_category'].".*")
                    ->from($this->tables['blog_category'])
                    ->get();
    }
    
    public function get_all_custom_blog_category()
    {
        return $this->db->select($this->tables['blog_custom_category'].".id as blog_custom_category_id, ".$this->tables['blog_custom_category'].".*")
                    ->from($this->tables['blog_custom_category'])
                    ->get();
    }
    
    public function get_all_blog_category()
    {
        return $this->db->select($this->tables['blog_category'].".id as blog_category_id, ".$this->tables['blog_category'].".*")
                    ->from($this->tables['blog_category'])
                    ->get();
    }
    
    public function get_blog_category_info($id)
    {
        $this->db->where('id',$id);
        return $this->db->select("*")
                    ->from($this->tables['blog_category'])
                    ->get();
    }
    
    public function get_custom_blog_category_info($id)
    {
        $this->db->where('id',$id);
        return $this->db->select("*")
                    ->from($this->tables['blog_custom_category'])
                    ->get();
    }
    
    //written by omar faruk
    public function get_blog_category_info_by_name($blog_category_name)
    {
        $this->db->where($this->tables['blog_category'].'.title',$blog_category_name);
        return $this->db->select("*")
                ->from($this->tables['blog_category'])
                ->get();
    }
    
    public function create_blog_category($blog_category_name, $data = array())
    {
        $this->trigger_events('pre_create_blog_category');
        if ($this->blog_category_identity_column == 'title' && $this->blog_category_identity_check($blog_category_name)) 
        {
            $this->set_error('blog_category_creation_duplicate_blog_category_name');
            return FALSE;
        }
        $additional_data = array(
            'title' => $blog_category_name,
            'created_on' => now()
        );
        
        $additional_data = $this->_filter_data($this->tables['blog_category'], $additional_data);
        
        $this->db->insert($this->tables['blog_category'], $additional_data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post_create_blog_category');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function blog_category_identity_check($identity)
    {
        
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->blog_category_identity_column,$identity);
        return $this->db->count_all_results($this->tables['blog_category']) > 0;
    }
    
    
    public function remove_blog_categroy($id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$id);
        $this->db->delete($this->tables['blog_category']);
        
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
    
    public function update_blog_categroy($id,$data)
    {
        if (array_key_exists($this->blog_category_identity_column, $data) && $this->blog_category_identity_check($data[$this->blog_category_identity_column]))
        {
            $this->set_error('blog_category_duplicate');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['blog_category'], $data);
        $this->db->update($this->tables['blog_category'], $data, array('id' => $id));
        $this->set_message('blog_category_update_successful');
        return true;
    }
    
     public function update_custom_blog_categroy($id,$data)
    {
        $blog_category_info = $this->get_blog_category_info($id)->row();
        if (array_key_exists($this->blog_category_identity_column, $data) && $this->blog_category_identity_check($data[$this->blog_category_identity_column]) && $blog_category_info->title == $data[$this->blog_category_identity_column])
        {
            $this->set_error('blog_category_duplicate');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['blog_custom_category'], $data);
        $this->db->update($this->tables['blog_custom_category'], $data, array('id' => $id));
        $this->set_message('blog_category_update_successful');
        return true;
    }
    
    //written by omar faruk
    public function delete_blog_categroy($id)
    {
        $blog_category_info = $this->get_blog_category_info($id)->row();
        if (empty($blog_category_info))
        {
            $this->set_error('blog_category_can_not_delete');
            return FALSE;
        }else {
            $this->db->trans_begin();
            $this->db->where('blog_category_id',$id);
            $this->db->delete($this->tables['blogs']);

            if ($this->db->affected_rows() == 0 || $this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->set_error('blog_category_can_not_delete');
                return FALSE;
            } else {
                $this->db->trans_commit();
                $this->db->where('id',$id);
                $this->db->delete($this->tables['blog_category']);
                $this->set_message('blog_category_delete_successful');
                return true;
            }
        }
    }
    
    /*
     * This method will return entire blog list
     * @author nazmul hasan
     * @modified on 12th september 2015
     */
    public function get_all_blogs($category_id=0)
    {
        if($category_id!=0)
        {
            $this->db->where($this->tables['blogs'].'.blog_category_id',$category_id);
        }
        $this->db->where($this->tables['blogs'].'.blog_status_id',APPROVED);
        $this->db->order_by('created_on','desc');
        return $this->db->select($this->tables['blogs'].'.*')
                    ->from($this->tables['blogs'])
                    ->get();
    }
    
    public function get_all_blogs_by_category($category_ids=array())
    {
        if(!empty($category_ids))
        {
            $this->db->where_in($this->tables['blogs'].'.id', $category_ids);
        } else{
            return array();
        }
        $this->db->where($this->tables['blogs'].'.blog_status_id',2);
        return $this->db->select($this->tables['blogs'].'.*')
                    ->from($this->tables['blogs'])
                    ->get();
    }
    
    /*public function get_blog_info($blog_id)
    {
        $this->db->where($this->tables['blogs'].'.id',$blog_id);
        
        return $this->db->select($this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }*/
    
    public function get_blog_info($blog_id)
    {
        $this->db->where($this->tables['blogs'].'.id',$blog_id);
        
        return $this->db->select($this->tables['blogs'].'.id as blog_id,'.$this->tables['blogs'].'.*,'.$this->tables['users'].'.*')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blogs'].'.user_id')
                    ->get();
    }
    
    public function create_blog($data)
    {
        $data = $this->_filter_data($this->tables['blogs'], $data);
        
        $this->db->insert($this->tables['blogs'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)? $id: False;
    }
    
    public function remove_blog($id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$id);
        $this->db->delete($this->tables['blogs']);
        
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
    
    public function update_blog($id,$data)
    {
        $this->db->trans_begin();
        
        $data = $this->_filter_data($this->tables['blogs'], $data);
        
        $this->db->where('id',$id);
        $this->db->update($this->tables['blogs'],$data);
        
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
    
    public function create_blog_comment($data)
    {
        $data = $this->_filter_data($this->tables['blog_comments'], $data);
        
        $this->db->insert($this->tables['blog_comments'],$data);
        $id = $this->db->insert_id();
        
        return isset($id)? $id: False;
    }
    
    public function get_all_blog_comments($blog_id=0)
    {
        if($blog_id!=0)
        {
            $this->db->where($this->tables['blog_comments'].'.blog_id',$blog_id);
        }
        
        return $this->db->select($this->tables['blog_comments'].'.*,'.$this->tables['users'].'.username as username')
                    ->from($this->tables['blog_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blog_comments'].'.user_id')
                    ->get();
    }
    
    public function get_blog_comment_info($comment_id)
    {
        
        $this->db->where($this->tables['blog_comments'].'id',$comment_id);
        
        
        return $this->db->select($this->tables['blog_comments'].'.*,'.$this->tables['users'].'username as username')
                    ->from($this->tables['blog_comments'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blog_comments'].'.user_id')
                    ->get();
    }
    
    public function remove_blog_comment($id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$id);
        $this->db->delete($this->tables['blog_comments']);
        
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
    
    public function create_blog_for_homepage($data)
    {
        $data = $this->_filter_data($this->tables['blog_configure_homepage'], $data);
        
        $this->db->insert($this->tables['blog_configure_homepage'],$data);
        
        $id= $this->db->insert_id();
        
        return isset($id)?$id:False;
    }
    
    public function get_all_blogs_for_homepage()
    {
        return $this->db->select("*")
                    ->from($this->tables['blog_congure_homepage'])
                    ->get();
    }
    
    public function get_all_pending_blogs($blog_status_list)
    {
        $this->db->where_in($this->tables['blogs'].'.blog_status_id',$blog_status_list);
        
        return $this->db->select($this->tables['blogs'].'.*,'.$this->tables['users'].'.username,'.$this->tables['blog_status'].'.title as blog_status_title')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['users'],  $this->tables['users'].'.id='.$this->tables['blogs'].'.user_id')
                    ->join($this->tables['blog_status'],  $this->tables['blog_status'].'.id='.$this->tables['blogs'].'.blog_status_id')
                    ->get();
    }
    
    /*
     * This method will return blog list to be displayed on home page which is config from admin panel
     * otherwise it will return 6 random blog if only the total no of blog is gretter then 11
     * or it will return 1 to 6 blog
     * @Omar faRUK
     * @Created on 12 May 2014
     */
    
    public function get_config_blog_list($blogs_id = array())
    {
        if(count($blogs_id)==8) {
            //echo '<pre/>';print_r($blogs_id);exit('model');
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
    
    public function get_configed_blog($date = 0)
    {
        if($date != 0) {
           $this->db->where($this->tables['blog_configure_homepage'].'.selected_date',$date);
           $this->db->order_by('id', 'desc');
        }
        return $this->db->select("*")
                    ->from($this->tables['blog_configure_homepage'])
                    ->get();
    }
    
    public function get_all_comments($blog_id,$sorted=0)
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

    }
    
    public function update_blog_list($blog_list)
    {
        $this->db->trans_begin();
        
        $this->db->update_batch($this->tables['blogs'],$blog_list,'id');
        
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        
        $this->db->trans_commit();
        
        return TRUE;
    }
    
    public function get_relate_blog_list($blogs_id = array())
    {
        if(count($blogs_id)!= 0) {
            $this->db->where_in($this->tables['blogs'].'.id',$blogs_id);
        }
        return $this->db->select($this->tables['blogs'].'.*')
                    ->from($this->tables['blogs'])
                    ->get();
    }
    
    /*
     * This method will return blog list
     * @param, $blog_id_list, blog id list
     * @Author Nazmul on 14th June 2014
     */
    // old
    /*public function get_blog_list($blog_id_list = array())
    {
        if(!empty($blog_id_list))
        {
            $list = implode (", ", array_filter($blog_id_list));
            $this->db->_protect_identifiers = FALSE;
            $this->db->where_in($this->tables['blogs'].'.id',$blog_id_list);
            $this->db->order_by("FIELD (blogs.id, " . $list . ")");
            $this->db->_protect_identifiers = TRUE;
            //$this->db->where_in($this->tables['blogs'].'.id', $blog_id_list);
        }
        $this->db->where($this->tables['blogs'].'.blog_status_id',APPROVED);
        return $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }*/
    
    public function get_blog_list($blog_id_list = array())
    {
        if(!empty($blog_id_list))
        {
            $list = implode (", ", array_filter($blog_id_list));
            $this->db->_protect_identifiers = FALSE;
            $this->db->where_in($this->tables['blogs'].'.id',$blog_id_list);
            $this->db->order_by("FIELD (blogs.id, " . $list . ")");
            $this->db->_protect_identifiers = TRUE;
            //$this->db->where_in($this->tables['blogs'].'.id', $blog_id_list);
        }
        $this->db->where($this->tables['blogs'].'.blog_status_id',APPROVED);
        return $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*')
                    ->from($this->tables['blogs'])
                    ->get();
    }
    
    public function all_blogs()
    {
        $this->db->where($this->tables['blogs'].'.blog_status_id',APPROVED);
        return $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*')
                    ->from($this->tables['blogs'])
                    ->get();
    }
    
     /*
     * This method will return  all blogs without delete requested one
     * @Author omar on 14th June 2014
     */
    public function get_blog_list_without_one($blog_id)
    {
        $this->db->where($this->tables['blogs'].'.id !=',$blog_id);
        $this->db->where($this->tables['blogs'].'.blog_status_id',APPROVED);
        $query = $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
        
        return $query;
    }
    
    /*
     * This method will return  all blogs without delete requested one
     * @Author omar on 14th June 2014
     */
    /*public function get_blog_list_initial_configuration()
    {
        $this->db->limit(BLOG_CONFIGURATION_COUNTER);
        return $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*,'.$this->tables['blog_category'].'.title as blog_category_name')
                    ->from($this->tables['blogs'])
                    ->join($this->tables['blog_category'],  $this->tables['blog_category'].'.id='.$this->tables['blogs'].'.blog_category_id')
                    ->get();
    }*/
    
    public function get_blog_list_initial_configuration()
    {
        $this->db->limit(BLOG_CONFIGURATION_COUNTER);
        $this->db->where($this->tables['blogs'].'.blog_status_id',APPROVED);
        return $this->db->select($this->tables['blogs'].'.id as blog_id, '.$this->tables['blogs'].'.*')
                    ->from($this->tables['blogs'])
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
    
    /*
     * This method will add configuration of a blog home page
     * @Author Nazmul on 14th June 2014
     * blog_list column of blog_configure_homepage table is a json object with the following attributes
     * region_id, id of a region
     * blog_id, id of a blog
     */
    public function add_home_page_blog_configuration($data)
    {
        $data = $this->_filter_data($this->tables['blog_configure_homepage'], $data);
        $this->db->insert($this->tables['blog_configure_homepage'],$data);
        
        $id= $this->db->insert_id();
        return isset($id)?$id:False;
    }
    
    /*
     * This method will store blog info imported by xlsx file
     * @param $data, any array with content of all columns of a row
     * @Author Nazmul on 14 June 2014
     */
    public function add_imported_blog_info($data)
    {
        $this->db->trans_begin();
        $blog_category_name_id_map = array();
        $blog_category_list_array = $this->get_all_blog_category()->result_array();
        foreach($blog_category_list_array as $blog_category_info)
        {
            $blog_category_name_id_map[$blog_category_info['title']] = $blog_category_info['blog_category_id'];
        }
        $blog_category_id = 0;
        $blog_category_name = $data['blog_category_name'];
        if(array_key_exists($blog_category_name, $blog_category_name_id_map))
        {
            $blog_category_id = $blog_category_name_id_map[$blog_category_name];
        }
        else
        {
            $blog_category_id = $this->create_blog_category($blog_category_name);
        
            if($blog_category_id!=FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }
        
        $data['blog_category_id'] = $blog_category_id;
        unset($data['blog_category_name']);
        
        $flag = $this->create_blog($data);
        if($flag==FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        
        $this->db->trans_commit();
        
        return TRUE;
    }
    
    public function get_configed_blog_by_date($date)
    {
        if($date != 0) {
           //$this->db->where($this->tables['blog_configure_homepage'].'.selected_date'>=$date);
           $this->db->where('selected_date >=',$date);
           $this->db->order_by('id', 'desc');
           $query = $this->db->select("*")
                    ->from($this->tables['blog_configure_homepage'])
                    ->get();
           return $query;
        }
    }
    
    public function remove_homepage_configeration($date_array)
    {
        $this->db->trans_begin();
        $this->db->where_in('selected_date',$date_array);
        
        $this->db->delete($this->tables['blog_configure_homepage']);
        
        if($this->db->affected_rows()==0)
            return FALSE;
        
        $this->db->trans_commit();
        
        return TRUE;
    }
    
}