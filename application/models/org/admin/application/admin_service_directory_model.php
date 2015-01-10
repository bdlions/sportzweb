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
class Admin_service_directory_model extends Ion_auth_model {
    
    protected $service_category_identity_column;
    protected $service_identity_column;


    public function __construct() {
        parent::__construct();        
    
        $this->service_category_identity_column = $this->config->item('service_category_identity_column', 'ion_auth');
        $this->service_identity_column = $this->config->item('service_identity_column','ion_auth');
    }


    /*--------------------Service_Category-----------------------*/
    /*
    *
	* Author: Redwan
	* Date: 4/19/2014
    */

    public function get_all_service_category()
    {
    	return $this->db->select($this->tables['service_category'].".id as service_category_id, ".$this->tables['service_category'].".*")
                    ->from($this->tables['service_category'])
                    ->get();
    }

    public function create_service_category($service_category_name, $data = array() )
    {
        $this->trigger_events('pre_create_service_category');
        if ($this->service_category_identity_column == 'description' && $this->service_category_identity_check($service_category_name)) 
        {
            $this->set_error('service_category_creation_duplicate_service_category_name');
            return FALSE;
        }
        $additional_data = array(
            'description' => $service_category_name,
            'created_on' => now()
        );
        if(!empty($data))
        {
            $additional_data = array_merge($this->_filter_data($this->tables['service_category'], $data), $additional_data);
        }        
        
        $this->db->insert($this->tables['service_category'], $additional_data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post_create_service_category');
        return (isset($id)) ? $id : FALSE;
    	
    }
    
    public function service_category_identity_check($identity)
    {
        $this->trigger_events('service_category_identity_check');
        if(empty($identity))
        {
            return FALSE;
        }
        $this->db->where($this->service_category_identity_column,$identity);
        return $this->db->count_all_results($this->tables['service_category']) > 0;
    }

    public function update_service_category($id,$data)
    {
        $service_category_info = $this->get_service_category_info($id)->row();
        if (array_key_exists($this->service_category_identity_column, $data) && $this->service_category_identity_check($data[$this->service_category_identity_column]) && $service_category_info->description !== $data[$this->service_category_identity_column])
        {
            $this->set_error('service_category_duplicate');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['service_category'], $data);
        $this->db->update($this->tables['service_category'], $data, array('id' => $id));
        $this->set_message('service_category_update_successful');
        return true;
    }

    public function get_service_category_info($id)
    {

    	$this->db->where($this->tables['service_category'].'.id',$id);
    	return $this->db->select("*")
                    ->from($this->tables['service_category'])
                    ->get();
    }
    
    public function remove_service_category($id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$id);
        $this->db->delete($this->tables['service_category']);
        
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
    
    
    /*-------------Services------------------*/
    /*
     *Author: Redwan
     * Date: 4/19/2014
     */
    
    public function get_all_services($service_category_id=0)
    {
        if($service_category_id!=0)
        {
            $this->db->where($this->tables['services'].'.service_category_id',$service_category_id);
        }
        return $this->db->select($this->tables['services'].'.*,'.$this->tables['service_category'].'.description as category_description')
                ->from($this->tables['services'])
                ->join($this->tables['service_category'], $this->tables['services'].'.service_category_id='.$this->tables['service_category'].'.id','full outer')
                ->get();
        
    }
    
    public function get_service_info($id)
    {
         $this->db->where($this->tables['services'].'.id',$id);
         return $this->db->select($this->tables['services'].".*,".$this->tables['countries'].'.country_name as country_name,'.$this->tables['business_profile'].'.business_name as business_name')
                    ->from($this->tables['services'])
                    ->join($this->tables['countries'],  $this->tables['services'].'.country_id='.$this->tables['countries'].'.id')
                    ->join($this->tables['business_profile'],  $this->tables['services'].'.business_profile_id='.$this->tables['business_profile'].'.id','left outer')
                    ->get();
    }
    
    //written by omar faruk
    public function get_service_category_info_by_name($service_category_name)
    {
        $this->db->where($this->tables['service_category'].'.description',$service_category_name);
        return $this->db->select("*")
                ->from($this->tables['service_category'])
                ->get();
    }
     
    public function create_service($service_name,$data)
    {
        $this->trigger_events('pre_create_service');
        if ($this->service_identity_column == 'title' && $this->service_identity_check($service_name)) 
        {
            $this->set_error('service_creation_duplicate_service_category_name');
            return FALSE;
        }
        $additional_data = array(
            'title' => $service_name
        );
        
        $additional_data = array_merge($this->_filter_data($this->tables['services'], $data), $additional_data);
        
        $this->db->insert($this->tables['services'], $additional_data);
        $id = $this->db->insert_id();
        
        $this->trigger_events('post_create_service');
        return (isset($id)) ? $id : FALSE;
    }
    

    public function service_identity_check($identity)
    {
        $this->trigger_events('pre_service_identity_check');
        
        if(empty($identity))
        {
            return FALSE;
        }
        
        $this->db->where($this->service_identity_column,$identity);
        return $this->db->count_all_results($this->tables['services']) > 0;
    }
    
    public function update_service($id,$data)
    {
        $service_info = $this->get_service_info($id)->row();
        if (array_key_exists($this->service_identity_column, $data) && $this->service_identity_check($data[$this->service_identity_column]) && $service_info->title !== $data[$this->service_identity_column])
        {
            $this->set_error('service_update_duplicate_category');
            return FALSE;
        }
        $data = $this->_filter_data($this->tables['services'], $data);
        $this->db->update($this->tables['services'], $data, array('id' => $id));
        $this->set_message('service_update_successful');
        return true;
    }
    
    public function remove_service($id)
    {
        $this->db->trans_begin();
        
        $this->db->where('id',$id);
        $this->db->delete($this->tables['services']);
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
    
    /*

     *Service_comment 
     *Author: Redwan
     *Date: 4/20/2014
     */
    
    public function get_all_comments($service_id)
    {
        $this->db->where('service_id',$service_id);
        
        return $this->db->select($this->tables['service_comments'].'.*,'.$this->tables['users'].'.username as username')
                    ->from($this->tables['service_comments'])
                    ->join($this->tables['users'],  $this->tables['service_comments'].'.user_id='.$this->tables['users'].'.id')
                    ->get();
    }
    
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
    
    /**
     * written by omar
     * @return type
     */
    public function get_all_country()
    {
        return $this->db->select("*")
                    ->from($this->tables['countries'])
                    ->get();
    }
    
    /**
     * written by omar
     * @return type
     */
    public function get_all_business_profile()
    {
        return $this->db->select("*")
                    ->from($this->tables['business_profile'])
                    ->get();
    }
    
    /*
     * This method will store service info imported by xlsx file
     * @param $data, any array with content of all columns of a row
     * @Author Nazmul on 14 June 2014
     */
    public function add_imported_service_info($data)
    {
        $service_category_name_id_map = array();
        
        $service_category_name = $data['service_category_name'];
        $service_category_list_array = $this->get_all_service_category()->result_array();
        foreach($service_category_list_array as $service_category_info)
        {
            $service_category_name_id_map[$service_category_info['description']] = $service_category_info['service_category_id'];
        }
        
        $service_category_id = 0;
        if(array_key_exists($service_category_name, $service_category_name_id_map))
        {
            $service_category_id = $service_category_name_id_map[$service_category_name];
        }
        else
        {
            $service_category_id = $this->create_service_category($service_category_name);
            
            if($service_category_id == FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
        }
        $data['service_category_id'] = $service_category_id;
        $title = $data['name'];
        unset($data['service_category_name']);
        $flag = $this->create_service($title,$data);
        
        if($flag == FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        
        $this->db->trans_commit();
        
        return TRUE;
        
    }
}

