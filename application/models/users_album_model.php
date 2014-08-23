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
class Users_album_model extends Ion_auth_model {

    var $current_user_id = 0;
    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->current_user_id = $this->ion_auth->get_user_id();
    }

    public function get_users_albums_cover_photo($user_id = 0, $album_type = 1){
        if($user_id <= 0){
            $user_id = $this->current_user_id;
        }
        $query = $this->db->select('*')
                        ->where('user_id', $user_id)
                        ->where('type', $album_type)
                        ->where('creation_complete', TRUE)
                        ->join('album_photos', 'users_albums.id=album_photos.album_id')
                        ->distinct()
                        ->order_by("album_photos.upload_date ASC")
                        ->order_by("album_photos.album_id", "ASC")
                        ->group_by("album_photos.album_id")
                        ->get("users_albums");
        if($query->num_rows() <= 0){
            return array();
        }
        else{
            return $query -> result();
        }
    }
    
    public function get_users_albums($user_id = 0, $album_type = 1){
        if($user_id <= 0){
            $user_id = $this->current_user_id;
        }
        $query = $this->db->select('*')
                        ->where('type', $album_type)
                        ->where('user_id', $user_id)
                        ->join('album_photos', 'users_albums.id=album_photos.album_id')
                        ->get("users_albums");
        if($query->num_rows() <= 0){
            return array();
        }
        else{
            return $query -> result();
        }
    }
    
    public function get_album($album_id, $album_type = 1){
        $query = $this->db->select('*')
                        ->where('type', $album_type)
                        ->where('id', $album_id)
                        ->join('album_photos', 'users_albums.id=album_photos.album_id')
                        ->get("users_albums");
        if($query->num_rows() <= 0){
            return array();
        }
        else{
            return $query -> result();
        }
    }
    
    public function update_album($album_id, $album_data){
        $this->db->trans_begin();
        $additional_data = array('creation_complete' => TRUE, 'update_date' => time());
        $descriptions = array();
        
        foreach ($album_data as $key => $value) {
            if(strrpos($key, "cription_")){
                $descriptions[] = array('id' => str_replace("description_", "", $key) ,'description' => $value, 'upload_date' => time());
            }
        }

        
        $data = array_merge($this->_filter_data("users_albums", $album_data), $additional_data);
        $this->db->update("users_albums", $data, array('id' => $album_id));
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->update_batch("album_photos", $descriptions, 'id');
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }
        }
        
        $this->db->trans_commit();
        
    }
    
    public function add_photo_in_album($album_id, $photo_data){
        $addition_data = array("album_id" => $album_id, 'upload_date' => time());
        $photo_data = array_merge($addition_data, $photo_data);
        
        $this->db->insert('album_photos', $photo_data);
        return $this->db->insert_id();        
    }
    
    public function add_my_photos($photo_data, $album_type = 1){
        $query = $this->db->select("*")
                          ->where("users_albums.user_id", $this->current_user_id)
                          ->join('users_albums', 'users_albums.id=users_my_photos.album_id AND users_albums.type='.$album_type)
                          ->get("users_my_photos");
        $album_id = 0;
        if($query->num_rows() <= 0){
            
            $album_id = $this->create_album($album_type);
            if($album_id > 0){
                $data = array('album_id' => $album_id, 'user_id' => $this->current_user_id);
                $this->db->insert('users_my_photos', $data);
            }
        }
        else{
            $result = $query -> row();
            $album_id = $result -> album_id;
        }
        return $this->add_photo_in_album($album_id, $photo_data, $album_type);
    }
    
    public function get_my_photos($album_type = 1){
        $query = $this->db->select($this->tables['album_photos'].'.id as photo_id,'.$this->tables['album_photos'].'.*,'.$this->tables['users_albums'].'.*')
                ->where('users_my_photos.user_id', $this->current_user_id)
                ->where('creation_complete',FALSE)
                ->distinct()
                ->join('users_albums', 'users_albums.user_id = users_my_photos.user_id AND users_albums.type='.$album_type)
                ->join('album_photos', 'album_photos.album_id = users_albums.id')
                ->order_by("album_photos.upload_date ASC")
                ->group_by("album_photos.id")
                ->get("users_my_photos");
                
        return $query -> result();
    }
    
    public function get_album_photos($album_id){
        $query = $this->db->select($this->tables['album_photos'].'.id as photo_id,'.$this->tables['album_photos'].'.*,'.$this->tables['users_albums'].'.*')
                ->where('album_photos.album_id', $album_id)
                ->where('creation_complete', TRUE)
                ->join('users_albums', 'users_albums.id = album_photos.album_id')
                ->order_by("album_photos.upload_date ASC")
                ->get("album_photos");
                
        return $query -> result();
    }
    public function create_album($album_type = 1){
        $data = array('user_id' => $this->current_user_id, 'create_date' => time(), 'type' => $album_type);
        $this->db->insert('users_albums', $data);
        return $this->db->insert_id(); 
    }
    
    public function get_last_uploaded_photo($album_type = 1, $user_id = 0){
        if(!$user_id){
            $user_id = $this->current_user_id;
        }
        $query = $this->db->select('*')
                        ->where('type', $album_type)
                        ->where('user_id', $user_id)
                        ->join('album_photos', 'users_albums.id=album_photos.album_id')
                        ->order_by("album_photos.upload_date DESC")
                        ->limit(1)
                        ->get("users_albums");
        $photo = "";
        if($query -> num_rows() > 0)
        {
            $photo = $query ->row()->photo;
        }
        return $photo;
    }
    
    public function get_latest_photo($user_id_list)
    {
        $this->db->where_in($this->tables['users_albums'].'.user_id', $user_id_list);
        $this->db->order_by($this->tables['album_photos'].'.upload_date','desc');
        $result = $this->db->select('*')
                ->from($this->tables['album_photos'])
                ->join($this->tables['users_albums'], $this->tables['users_albums'].'.id='.$this->tables['album_photos'].'.album_id')
                ->limit(1)
                ->get();
        return $result;
    }
    
    /*
     * This method will return album photo info
     * @param $photo_id, photo id
     * @Author Nazmul on 17th June 2014 
     */
    public function get_album_photos_info($photo_id)
    {
        $this->db->where($this->tables['album_photos'].'.id', $photo_id);
        $result = $this->db->select('*')
                ->from($this->tables['album_photos'])
                ->get();
        return $result;
    }
    
    /*
     * This method will update album photo
     * @param $photo_id, photo id
     * @param $additional_data, photo data to be updated
     * @Author Nazmul on 17th June 2014 
     */
    public function update_album_photo($photo_id, $additional_data)
    {
        $photo_data = $this->_filter_data($this->tables['album_photos'], $additional_data);
        $this->db->where('id', $photo_id);
        $this->db->update($this->tables['album_photos'], $photo_data);
    }
}
?>
