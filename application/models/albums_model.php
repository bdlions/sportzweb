<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Album Model
 *
 * Author:  Nazmul on 27th July 2014
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Albums_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }
    
    public function get_album_info($album_id)
    {
        $this->db->where('id', $album_id);
        return $this->db->select($this->tables['albums'].'.id as album_id, '.$this->tables['albums'].".*")
                    ->from($this->tables['albums'])
                    ->get();
    }
    
    /*
     * This method will return album info
     * @param $album_type_id, album type id
     * @param $reference_id, reference id
     * @Author Nazmul on 30th September 2014
     */
    public function get_reference_album_info($album_type_id, $reference_id)
    {
        $this->db->where('album_type_id', $album_type_id);
        $this->db->where('reference_id', $reference_id);
        return $this->db->select($this->tables['albums'].'.id as album_id, '.$this->tables['albums'].".*")
                    ->from($this->tables['albums'])
                    ->limit(1)
                    ->get();
    }
    
    public function get_user_album_info($album_type_id, $user_id)
    {
        $this->db->where('album_type_id', $album_type_id);
        $this->db->where('reference_id', $user_id);
        return $this->db->select($this->tables['albums'].'.id as album_id, '.$this->tables['albums'].".*")
                    ->from($this->tables['albums'])
                    ->limit(1)
                    ->get();
    }
    
    public function create_album($additional_data)
    {
        $this->trigger_events('pre_create_album');
        $album_data = $this->_filter_data($this->tables['albums'], $additional_data);        
        $this->db->insert($this->tables['albums'], $album_data);
        $id = $this->db->insert_id();        
        $this->trigger_events('post_create_album');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function add_photo($additional_data)
    {
        $this->trigger_events('pre_add_photo');
        $photo_data = $this->_filter_data($this->tables['albums_photos'], $additional_data);        
        $this->db->insert($this->tables['albums_photos'], $photo_data);
        $id = $this->db->insert_id();        
        $this->trigger_events('post_add_photo');
        return (isset($id)) ? $id : FALSE;
    }
    
    public function get_user_album_photos($album_type_id, $user_id)
    {
        $this->db->where($this->tables['albums'].'.album_type_id', $album_type_id);
        $this->db->where($this->tables['albums'].'.reference_id', $user_id);
        return $this->db->select($this->tables['albums'].'.id as album_id, '.$this->tables['albums'].".*,".$this->tables['albums_photos'].'.id as photo_id, '.$this->tables['albums_photos'].".*")
                    ->from($this->tables['albums'])
                    ->join($this->tables['albums_photos'], $this->tables['albums_photos'] . '.album_id' . '=' . $this->tables['albums'] . '.id')
                    ->get();
    }
    
    public function get_photo_info($photo_id)
    {
        $this->db->where($this->tables['albums_photos'].'.id', $photo_id);
        $result = $this->db->select($this->tables['albums_photos'].'.id as photo_id, '.$this->tables['albums_photos'].".*")
                ->from($this->tables['albums_photos'])
                ->get();
        return $result;
    }
    
    public function update_photo_info($photo_id, $additional_data)
    {
        $photo_data = $this->_filter_data($this->tables['albums_photos'], $additional_data);
        $this->db->where('id', $photo_id);
        $this->db->update($this->tables['albums_photos'], $photo_data);
    }
    
    public function get_user_albums_cover_photo($user_id = 0, $album_type = array(ALBUM_TYPE_USER_PROFILE_PHOTOS, ALBUM_TYPE_USER_ALBUM_PHOTOS)){
        if($user_id <= 0){
            $user_id = $this->session->userdata('user_id');
        }
        return $this->db->select('*')
                        ->where('reference_id', $user_id)
                        ->where_in('album_type_id', $album_type)
                        ->where('creation_complete', TRUE)
                        ->join('albums_photos', 'albums.id=albums_photos.album_id')
                        ->distinct()
                        ->order_by("albums_photos.created_on ASC")
                        ->order_by("albums_photos.album_id", "ASC")
                        ->group_by("albums_photos.album_id")
                        ->get("albums");
    }
    
    public function get_album_photos($album_id){
        return $this->db->select($this->tables['albums_photos'].'.id as photo_id,'.$this->tables['albums_photos'].'.*,'.$this->tables['albums'].'.*')
                ->where('albums_photos.album_id', $album_id)
                ->join('albums', 'albums.id = albums_photos.album_id')
                ->order_by("albums_photos.created_on ASC")
                ->get("albums_photos");
    }
    
    public function update_album($album_id, $album_data){
        $current_time = now();
        $this->db->trans_begin();
        $additional_data = array('creation_complete' => TRUE, 'modified_on' => $current_time);
        $descriptions = array();
        
        foreach ($album_data as $key => $value) {
            if(strrpos($key, "cription_")){
                $descriptions[] = array('id' => str_replace("description_", "", $key) ,'description' => $value, 'modified_on' => $current_time);
            }
        }

        
        $data = array_merge($this->_filter_data("albums", $album_data), $additional_data);
        $this->db->update("albums", $data, array('id' => $album_id));
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->update_batch("albums_photos", $descriptions, 'id');
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }
        }        
        $this->db->trans_commit();        
    }
    
}
?>
