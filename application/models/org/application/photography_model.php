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
class Photography_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
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
    
    
    public function get_all_images()
    {
        return $this->db->select('*')
                    ->from($this->tables['photography'])
                    ->get();
    }
    
}
