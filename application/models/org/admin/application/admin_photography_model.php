<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Admin Photography Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Admin_photography_model extends Ion_auth_model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function add_image($additional_data)
    {
        $this->trigger_events('pre_add_image');
        $data = $this->_filter_data($this->tables['photography'], $additional_data);
        $this->db->insert($this->tables['photography'], $data);
        $id = $this->db->insert_id();        
        $this->trigger_events('post_add_image');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_image_info($image_id)
    {
        $this->db->where($this->tables['photography'].'.id',$image_id);
        
        return $this->db->select("*")
                    ->from($this->tables['photography'])
                    ->get();
    }
    
    public function update_image($image_id, $data)
    {
        $this->db->update($this->tables['photography'], $data, array('id' => $image_id));
        return true;
    }
    
    /*
     * This method will delete photo
     * @param $image_id, photo id
     * @Author Nazmul on 14th January 2015
     */
    public function delete_image($image_id)
    {
        if(!isset($image_id) || $image_id <= 0)
        {
            $this->set_error('delete_photo_fail');
            return FALSE;
        }
        $this->db->where('id', $image_id);
        $this->db->delete($this->tables['photography']);
        
        if ($this->db->affected_rows() == 0) {
            $this->set_error('delete_photo_fail');
            return FALSE;
        }
        $this->set_message('delete_photo_successful');
        return TRUE;
    }
}